<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
include '../include/config.php';

$banners = $conn->query("SELECT * FROM banners");
$cars = $conn->query("SELECT * FROM cars");

if(isset($_GET['bid'])) {
    $stmt1 = $conn->prepare("SELECT banner_image FROM banners WHERE id=?");
    $stmt1->bind_param("i", $_GET['bid']);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $banner = $result->fetch_assoc();
    if($banner['banner_image'] != ""){
        unlink("images/banner/".$banner['banner_image']);
    }   
    $stmt = $conn->prepare("DELETE FROM banners WHERE id=?");
    $stmt->bind_param("i", $_GET['bid']);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

if(isset($_GET['cid'])) {
    $stmt1 = $conn->prepare("SELECT car_image FROM cars WHERE id=?");
    $stmt1->bind_param("i", $_GET['cid']);  
    $stmt1->execute();
    $result = $stmt1->get_result();
    $car = $result->fetch_assoc();
    if($car['car_image'] != ""){
        unlink("images/cars/".$car['car_image']);
    }   
    $stmt = $conn->prepare("DELETE FROM cars WHERE id=?");
    $stmt->bind_param("i", $_GET['cid']);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        background: #f4f6f9;
        color: #333;
    }
    /* Header */
    .header {
        background: #4e73df;
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header h1 {
        font-size: 20px;
        margin: 0;
    }

    .header a {
        color: #fff;
        text-decoration: none;
        margin-left: 15px;
        font-size: 14px;
    }

    /* Container */
    .container {
        padding: 30px;
    }

    .card {
        background: #fff;
        padding: 20px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .card h2 {
        margin-top: 0;
        font-size: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    /* Table */
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

    /* Buttons */
    .btn {
        padding: 6px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        color: #fff;
        margin-right: 5px;
    }

    .btn-update {
        background: #1cc88a;
    }

    .btn-delete {
        background: #e74a3b;
    }

    .btn-update:hover {
        background: #17a673;
    }

    .btn-delete:hover {
        background: #c0392b;
    }

    /* Top actions */
    .actions a {
        background: #36b9cc;
        padding: 8px 12px;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        margin-right: 10px;
        font-size: 14px;
    }

    .actions a:hover {
        background: #2c9faf;
    }

   .btn-danger {
    background: #e74a3b;
}

.btn-danger:hover {
    background: #c0392b;
}
</style>
</head>
<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <div>
        <a href="add_banner.php">Add Banner</a>
        <a href="add_car.php">Add Car</a>
        <a href="logout.php"><button class="btn btn-danger";>Logout</button></a>
    </div>
</div>

<div class="container">

    <!-- Banners -->
    <div class="card">
        <h2>Banners</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
           <?php if($banners->num_rows > 0){
            while($row = $banners->fetch_assoc()){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['banner_title'] ?></td>
                <td><?= $row['banner_subtitle'] ?></td>
                <td><img src="images/banner/<?= $row['banner_image'] ?>" width="90"></td>
                <td style="width: 160px; text-align: center;">
                    <a class="btn btn-update" href="update_banner.php?id=<?= $row['id'] ?>">Update</a>
                    <a class="btn btn-delete" href="dashboard.php?bid=<?= $row['id'] ?>" onclick="return confirm('Delete this banner?')">Delete</a>
                </td>
            </tr>
            <?php }}
            else { ?>
            <tr><td colspan="5">No banners found.</td></tr>
            <?php } ?>
        </table>
    </div>

    <!-- Cars -->
    <div class="card">
        <h2>Cars List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subtitle</th>
                <th>Image</th>
                <th style="width: 160px; text-align: center;">Actions</th>
            </tr>
            <?php 
            if($cars->num_rows > 0){
            while($row = $cars->fetch_assoc()){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['car_title'] ?></td>
                <td><?= $row['car_subtitle'] ?></td>
                <td><img src="images/cars/<?= $row['car_image'] ?>" width="90"></td>
                <td>
                    <a class="btn btn-update" href="update_car.php?id=<?= $row['id'] ?>">Update</a>
                    <a class="btn btn-delete" href="dashboard.php?cid=<?= $row['id'] ?>" onclick="return confirm('Delete this car?')">Delete</a>
                </td>
            </tr>
            <?php }}
            else{ ?>
            <tr><td colspan="5">No Cars found.</td></tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>
