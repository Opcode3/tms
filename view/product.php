<?php
$page = "products";
$path = "../";

include '../vendor/autoload.php';

use app\controller\ContactController;
use app\controller\ProductController;
use app\utils\Helper;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = "";
$description = "";
$images = [];

$controllerCon = new ContactController();

$resCon =  json_decode($controllerCon->getAllContacts(), true);

if (isset($_GET["slug"]) && strlen(trim($_GET["slug"])) > 6) {
    $slug = $_GET["slug"];
    $controller = new ProductController();

    $res =  json_decode($controller->getSingleProduct($slug), true);
    if (count($res["message"]) > 6) {
        $title = $res["message"]["product_name"];
        $description = $res["message"]["product_desc"];
        $images = Helper::getImages($res["message"]["product_media_url"]);
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

                    <section id="product-view">


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
                                </div>
                            </div>
                        <?php
                        }

                        if (strlen(trim($description)) > 5) {
                        ?>
                            <div id="info">
                                <h2><?php echo $title; ?></h2>
                                <?php echo Helper::setDesc(explode(", ", $description)); ?>
                                <p>
                                    Do you need this product?
                                    <a href="https://api.whatsapp.com/send?phone=<?php echo Helper::getContactItems('contact_whatsapp', $resCon["data"]); ?>">contact us let's transact!</a>
                                </p>
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
                        <a href="<?php echo $path . "products.php"; ?>">Let start again</a>
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
        slidesPerView: 1,
        speed: 4000,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        // cubeEffect: {
        //     shadow: true,
        //     slideShadows: true,
        //     shadowOffset: 20,
        //     shadowScale: 0.94,
        // }
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