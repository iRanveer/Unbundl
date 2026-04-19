<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
include '../include/config.php'; 

if(isset($_GET['id'])) {
       $stmt1 = $conn->prepare("SELECT car_image FROM cars WHERE id=?");
    $stmt1->bind_param("i", $_GET['id']);  
    $stmt1->execute();
    $result = $stmt1->get_result();
    $car = $result->fetch_assoc();
    if($car['car_image'] != ""){
        unlink("images/cars/".$car['car_image']);
    } 
    $stmt = $conn->prepare("DELETE FROM cars WHERE id=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    header("Location: add_car.php");
    exit();
}            

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    if(isset($_FILES['car_image'])){
        $image = $_FILES['car_image']['name'];
        $tmp_name = $_FILES['car_image']['tmp_name'];
        $image_ex = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $new_image_name = uniqid("Img-", true) . '.' . $image_ex;
        $target = "images/cars/" . $new_image_name;
        move_uploaded_file($tmp_name, $target);
    }

    $stmt = $conn->prepare("INSERT INTO cars (car_title, car_subtitle, car_image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $subtitle, $new_image_name);
    $stmt->execute();
    header("Location: add_car.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Car</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        background: #f4f6f9;
        color: #333;
    }

    .header {
        background: #4e73df;
        padding: 15px 30px;
    }

    .header a {
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        background: rgba(255,255,255,0.15);
        padding: 8px 12px;
        border-radius: 4px;
    }

    .container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .card {
        background: #fff;
        padding: 20px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    h2 {
        margin-top: 0;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    form label {
        display: block;
        margin-top: 12px;
        font-size: 14px;
    }

    form input[type="text"],
    form input[type="file"] {
        width: 98%;
        padding: 10px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form button {
        margin-top: 15px;
        background: #1cc88a;
        border: none;
        padding: 10px 15px;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
    }

    form button:hover {
        background: #17a673;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    table th, table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
    }

    table th {
        background: #f1f3f6;
    }

    table tr:hover {
        background: #f9fafb;
    }

    img {
        border-radius: 4px;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-update {
        background: #36b9cc;
    }

    .btn-delete {
        background: #e74a3b;
    }

    .btn-update:hover {
        background: #2c9faf;
    }

    .btn-delete:hover {
        background: #c0392b;
    }

</style>
</head>
<body>

<div class="header">
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<div class="container">

    <div class="card">
        <h2>Add New Car</h2>
        <form method="post" enctype="multipart/form-data">
            <label>Title</label>
            <input type="text" name="title" required>

            <label>Subtitle</label>
            <input type="text" name="subtitle">

            <label>Image</label>
            <input type="file" name="car_image" accept="image/png, image/jpeg, image/jpg" required>

            <button type="submit">Add Car</button>
        </form>
    </div>

    <div class="card">
        <h2>Cars List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            $cars = $conn->query("SELECT * FROM cars");
            if($cars->num_rows > 0){
                while($row = $cars->fetch_assoc()){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['car_title'] ?></td>
                <td><?= $row['car_subtitle'] ?></td>
                <td><img src="images/cars/<?= $row['car_image'] ?>" width="80"></td>
                <td style="width: 160px; text-align: center;">
                    <a class="btn btn-update" href="update_car.php?id=<?= $row['id'] ?>">Update</a>
                    <a class="btn btn-delete" href="add_car.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this car?')">Delete</a>
                </td>
            </tr>
            <?php }} else { ?>
            <tr>
                <td colspan="5" style="text-align:center;">No cars found.</td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>
