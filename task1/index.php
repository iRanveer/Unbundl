<?php
include 'include/config.php';
$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cars_option = isset($_POST['cars_option']) ? implode(", ", $_POST['cars_option']) : '';

    $stmt = $conn->prepare("INSERT INTO customer (name, number, email, address, cars_option) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $number, $email, $address, $cars_option);

    if ($stmt->execute()) {
        $message = "New record created successfully";
           echo'<script>
        setTimeout(function () {
            window.location.href = "index.php";
        }, 3000);
    </script>';
    } else {
        $message = "Error: " . $stmt->error;
              echo'<script>
        setTimeout(function () {
            window.location.href = "index.php";
        }, 3000);
    </script>';
       
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Selection</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            background: #fff;
            margin: 50px auto;
            padding: 25px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .checkbox-group {
            margin: 5px;
            display: flex;
        }

        .checkbox-group label {
            font-weight: normal;
            display: block;
            margin: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #280ed4ff;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .viewbtn {
            margin: 20px;
            padding: 10px 15px;
            background: #280ed4ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            width: auto;
        }
        a{
            color: white;
            text-decoration: none;
        }

        button:hover {
            background: #4762e8ff;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 15px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <button class="viewbtn"><a href="view.php">View Records</a></button>
    </div>

<div class="container">
    <h2>Choose Your Car</h2>

    <?php if (isset($message)) { ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <form action="" method="post">

        <label>Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Phone Number</label>
        <input type="tel" name="number" placeholder="Enter your number" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Address</label>
        <input type="text" name="address" placeholder="Enter your address" required>

        <label>Car Options</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="cars_option[]" value="Hatchback"> Hatchback</label>
            <label><input type="checkbox" name="cars_option[]" value="Sedan"> Sedan</label>
            <label><input type="checkbox" name="cars_option[]" value="SUV"> SUV</label>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>