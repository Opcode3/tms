<?php
$page = "projects";
$path = "../";

include '../vendor/autoload.php';

use app\controller\ProjectController;
use app\utils\Helper;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = "";
$images = [];
$location = "";

if (isset($_GET["slug"]) && strlen(trim($_GET["slug"])) > 6) {
    $slug = $_GET["slug"];
    $controller = new ProjectController();

    $res =  json_decode($controller->getSingleProject($slug), true);

    if (count($res["message"]) > 6) {
        $title = $res["message"]["project_name"];
        $location = $res["message"]["project_location"];
        $images = Helper::getImages($res["message"]["project_media_url"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Best Solar Energy</title>

    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../assets/styles/front.css" />
    <link rel="stylesheet" href="../assets/libraries/sliderjs/swiper-bundle.min.css" />
</head>

<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <div class="container">
        <?php include_once("../includes/header.php"); ?>
        <main>
            <div class="page-title">
                <img src="../assets/images/slider/1.jpg" alt="" style="width: 100%;">
                <div class="overlay">
                    <h2><?php echo $title; ?></h2>
                </div>
            </div>
            <div class="view-container">



                <?php
                if (strlen(trim($title)) > 4) {
                ?>
                    <div id="hbse-page-title-2">
                        <h1><?php echo $title; ?></h1>
                        <a href="">Enquire More</a>
                    </div>

                    <section id="project-view">


                        <?php
                        if (count($images) > 0) {
                        ?>
                            <div id="gallery">
                                <div class="swiper productSwip">
                                    <div class="swiper-wrapper">
                                        <?php
                                        foreach ($images as $key => $image) {
                                        ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo "path/" . $image; ?>" alt="<?php echo $title; ?>" />
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="swiper-button-next" style="color:#ea3137;"></div>
                                    <div class="swiper-button-prev" style="color:#ea3137;"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </section>
                <?php
                } else {
                ?>
                    <div id="no-data">
                        <img src="../assets/images/nodata.svg" alt="">
                        <p>Oooops, looks like something is broken. </p>
                        <a href="<?php echo $path . "projects.php"; ?>">Let start again</a>
                    </div>
                <?php
                }
                ?>

            </div>


            <!-- Later Add More Product List -->
        </main>
        <?php include_once("../includes/footer.php"); ?>

    </div>
</body>

<script src="../assets/libraries/sliderjs/swiper-bundle.min.js"></script>
<script src="../assets/libraries/jQuery/jquery-3.6.0.min.js"></script>

<script>
    var swiper = new Swiper(".productSwip", {
        // effect: "cube",
        // grabCursor: true,
        slidesPerView: "auto",
        // speed: 4000,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        }
    });
    jQuery(window).on('load', function() {
        jQuery(".loader").fadeOut();
        jQuery(".preloader").delay(150).fadeOut("slow");
    });

    const handburgermenu = document.getElementById("handburgermenu");
    const mobileNav = document.querySelector(".mobile");

    handburgermenu.addEventListener("click", function() {
        mobileNav.classList.toggle("toggle");
    });
</script>

</html>