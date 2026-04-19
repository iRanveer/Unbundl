<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
include '../include/config.php';  

if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    if(!empty($_FILES['car_image']['name'])){
        $image = $_FILES['car_image']['name'];
        $tmp_name = $_FILES['car_image']['tmp_name'];
        $image_ex = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $new_image_name = uniqid("Img-", true) . '.' . $image_ex;
        $target = "images/cars/" . $new_image_name;

        if($car['car_image'] != ""){
            unlink("images/cars/".$car['car_image']);
        }
        move_uploaded_file($tmp_name, $target);
    } else {
        $new_image_name = $car['car_image'];
    }

    $stmt = $conn->prepare("UPDATE cars SET car_title=?, car_subtitle=?, car_image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $subtitle, $new_image_name, $_GET['id']);
    $stmt->execute();
    header("Location: add_car.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Car</title>
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
        background: rgba(255,255,255,0.15);
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
    }

    .container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .card {
        background: #fff;
        padding: 25px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
        margin-top: 0;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        font-size: 18px;
    }

    label {
        display: block;
        margin-top: 15px;
        font-size: 14px;
    }

    input[type="text"],
    input[type="file"] {
        width: 95%;
        padding: 10px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .preview {
        margin-top: 10px;
    }

    .preview img {
        max-width: 120px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    button {
        margin-top: 20px;
        background: #1cc88a;
        border: none;
        padding: 10px 15px;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
    }

    button:hover {
        background: #17a673;
    }
</style>
</head>
<body>

<div class="header">
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<div class="container">
    <div class="card">
        <h2>Update Car</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($car['car_title']) ?>" required>

            <label>Subtitle</label>
            <input type="text" name="subtitle" value="<?= htmlspecialchars($car['car_subtitle']) ?>">

            <label>Current Image</label>
            <div class="preview">
                <img src="images/cars/<?= $car['car_image'] ?>" alt="Car Image">
            </div>

            <label>Change Image (optional)</label>
            <input type="file" name="car_image" accept="image/png, image/jpeg, image/jpg" >

            <button type="submit">Update Car</button>
        </form>
    </div>
</div>

</body>
</html>
