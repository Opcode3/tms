<?php
$page = "projects";
$path = "../";

include '../vendor/autoload.php';

use app\controller\ContactController;
use app\controller\ProjectController;
use app\utils\Helper;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = "";
$images = [];
$location = "";

$controllerCon = new ContactController();

$resCon =  json_decode($controllerCon->getAllContacts(), true);

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
    <link rel="stylesheet" href="../assets/d/css/tricky.css" />
</head>

<body>
    <div class="preloader">
        <div class="spinner"></div>
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

                    <section id="project-view">
                        <h2>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>

                            <?php echo $location; ?>
                        </h2>


                        <?php
                        if (count($images) > 0) {
                        ?>
                            <div id="gallery">
                                <?php
                                foreach ($images as $key => $image) {
                                ?>
                                    <img src="<?php echo "path/" . $image; ?>" alt="<?php echo $title; ?>" />
                                <?php
                                }
                                ?>
                            </div>
                            <p>Do you wish to work with us?
                                <a href="https://api.whatsapp.com/send?phone=<?php echo Helper::getContactItems('contact_whatsapp', $resCon["data"]); ?>">contact us let's transact!</a>
                            </p>

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
    const cancelBtn = document.getElementById("cancelBtn");
    const mobileNav = document.querySelector(".mobile");

    handburgermenu.addEventListener("click", function() {
        mobileNav.classList.toggle("toggle-mobile");
    });

    cancelBtn.addEventListener("click", function() {
        mobileNav.classList.toggle("toggle-mobile");
    });
</script>

</html>