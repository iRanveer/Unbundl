<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
include '../include/config.php';

if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM banners WHERE id=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $banner = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    if(!empty($_FILES['banner_image']['name'])){
        $image = $_FILES['banner_image']['name'];
        $tmp_name = $_FILES['banner_image']['tmp_name'];
        $image_ex = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $new_image_name = uniqid("Img-", true) . '.' . $image_ex;
        $target = "images/banner/" . $new_image_name;

        if($banner['banner_image'] != ""){
            unlink("images/banner/".$banner['banner_image']);
        }
        move_uploaded_file($tmp_name, $target);
    } else {
        $new_image_name = $banner['banner_image'];
    }

    $stmt = $conn->prepare("UPDATE banners SET banner_title=?, banner_subtitle=?, banner_image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $subtitle, $new_image_name, $_GET['id']);
    $stmt->execute();
    header("Location: add_banner.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Banner</title>
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
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .preview {
        margin-top: 10px;
    }

    .preview img {
        max-width: 140px;
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
        <h2>Update Banner</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($banner['banner_title']) ?>" required>

            <label>Subtitle</label>
            <input type="text" name="subtitle" value="<?= htmlspecialchars($banner['banner_subtitle']) ?>">

            <label>Current Image</label>
            <div class="preview">
                <img src="images/banner/<?= $banner['banner_image'] ?>" alt="Banner Image">
            </div>

            <label>Change Image (optional)</label>
            <input type="file" name="banner_image" accept="image/png, image/jpeg, image/jpg">

            <button type="submit">Update Banner</button>
        </form>
    </div>
</div>

</body>
</html>
