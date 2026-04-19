<?php
include 'include/config.php';

// Fetch banners
$banners = $conn->query("SELECT * FROM banners limit 5");

// Fetch most searched cars
$most_searched = $conn->query("SELECT * FROM cars");

// Fetch latest cars
$latest_cars = $conn->query("SELECT * FROM cars");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CarsDekho Clone</title>
<style>
    * { box-sizing: border-box; margin:0; padding:0; }
    body { background: #f4f6f9; color: #333; }
    /* Header */
    header {
        background: #4e73df;
        color: #fff;
        padding: 15px 30px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    header h1 { font-size: 28px; }
    nav a {
        color: #fff;
        text-decoration: none;
        margin-left: 20px;
        font-weight: bold;
        transition: color 0.3s;
    }
    nav a:hover { color: #1cc88a; }

    /* Banner Slider */
    .banners {
        position: relative;
        max-width: 98%;
        margin: 20px auto;
        overflow: hidden;
        border-radius: 10px;
    }
    .banner {
        display: none;
        position: relative;
        text-align: center;
        transition: opacity 1s ease-in-out;
    }
    .banner img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 10px;
    }
    .banner h2, .banner p {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        background: rgba(0,0,0,0.6);
        padding: 10px 20px;
        border-radius: 5px;
    }
    .banner h2 { top: 25%; font-size: 26px; }
    .banner p { top: 50%; font-size: 18px; }

    /* Slider dots */
    .dots {
        text-align: center;
        margin-top: -15px;
    }
    .dot {
        height: 12px;
        width: 12px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s;
        cursor: pointer;
    }
    .active-dot { background-color: #4e73df; }

    /* Cars Section */
    h2 { text-align: center; margin: 30px 0 15px; font-size: 26px; color: #4e73df; }
    .cars {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        max-width: 90%;
        margin: 0 auto 40px;
        padding: 0 10px;
    }
    .car {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        text-align: center;
        padding: 10px;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #ddd;
    }
    .car:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    }
    .car img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }
    .car p {
        margin-top: 5px;
        font-weight: bold;
        color: #4e73df;
        font-size: 16px;
    }
    .car small { font-weight: normal; color: #555; display:block; margin-top: 5px; }

    /* Footer */
    footer {
        background: #4e73df;
        color: #fff;
        text-align: center;
        padding: 25px 10px;
        margin-top: 40px;
        border-top: 4px solid #2e59d9;
    }
    footer p { margin-bottom: 10px; }
    footer a {
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
        transition: color 0.3s;
    }
    footer a:hover { color: #1cc88a; }

    /* Responsive */
    @media (max-width: 768px){
        .banner img { height: 250px; }
        .banner h2, .banner p { font-size: 16px; padding: 6px 12px; }
        .car img { height: 120px; }
    }
</style>
</head>
<body>

<header>
    <h1>CarsDekho Clone</h1>
    <nav>
        <a href="#">Home</a>
        <a href="#">Most Searched</a>
        <a href="#">Latest Cars</a>
        <a href="#">Contact</a>
    </nav>
</header>

<!-- Banner Slider -->
<div class="banners">
    <?php while($banner = $banners->fetch_assoc()){ ?>
        <div class="banner">
            <img src="admin/images/banner/<?php echo $banner['banner_image']; ?>" alt="">
            <div class="banner-text">
                <h2><?php echo $banner['banner_title']; ?></h2>
                <p><?php echo $banner['banner_subtitle']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>
<div class="dots"></div>

<!-- Most Searched Cars -->
<h2>Most Searched Cars</h2>
<div class="cars">
    <?php while($car = $most_searched->fetch_assoc()){ ?>
        <div class="car">
            <img src="admin/images/cars/<?php echo $car['car_image']; ?>" alt="">
            <p><?php echo $car['car_title']; ?></p>
            <small><?php echo $car['car_subtitle']; ?></small>
        </div>
    <?php } ?>
</div>

<!-- Latest Cars -->
<h2>Latest Cars</h2>
<div class="cars">
    <?php while($car = $latest_cars->fetch_assoc()){ ?>
        <div class="car">
            <img src="admin/images/cars/<?php echo $car['car_image']; ?>" alt="">
            <p><?php echo $car['car_title']; ?></p>
            <small><?php echo $car['car_subtitle']; ?></small>
        </div>
    <?php } ?>
</div>

<footer>
    <p>© 2025 CarsDekho Clone</p>
    <p>
        <a href="#">About Us</a> | 
        <a href="#">Contact</a> | 
        <a href="#">Privacy Policy</a>
    </p>
</footer>

<script>
    // Banner slider with dots
    const slides = document.querySelectorAll('.banner');
    const dotsContainer = document.querySelector('.dots');
    let currentSlide = 0;

    if(slides.length > 0){
        slides[currentSlide].style.display = "block";

        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if(index === 0) dot.classList.add('active-dot');
            dot.addEventListener('click', () => { goToSlide(index); });
            dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.dot');

        function goToSlide(index){
            slides[currentSlide].style.display = 'none';
            dots[currentSlide].classList.remove('active-dot');
            currentSlide = index;
            slides[currentSlide].style.display = 'block';
            dots[currentSlide].classList.add('active-dot');
        }

        setInterval(() => {
            let nextSlide = (currentSlide + 1) % slides.length;
            goToSlide(nextSlide);
        }, 4000);
    }
</script>

</body>
</html>

