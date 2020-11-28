<?php
session_start();
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";
require_once dirname(dirname(__FILE__)) . "/class/User.php";
require_once dirname(dirname(__FILE__)) . "/class/Bank.php";
require_once dirname(dirname(__FILE__)) . "/class/Organizations.php";
require_once dirname(dirname(__FILE__)) . "/class/Create.php";
require_once dirname(dirname(__FILE__)) . "/class/Investments.php";
require_once dirname(dirname(__FILE__)) . "/class/Probe.php";
require_once dirname(dirname(__FILE__)) . "/class/Plot.php";
require_once dirname(dirname(__FILE__)) . "/class/PlotBuilding.php";
require_once "config/admin_check.php";


if ($admin == '1') {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <title>CSU ADMIN PANEL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="<? echo _URL.'/thkxadmin/style.css';?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html, body, h1, h2, h3, h4, h5 {
            font-family: "Raleway", sans-serif
        }
    </style>
    <body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();">
            <i class="fa fa-bars"></i> Menu
        </button>
        <span class="w3-bar-item w3-right">#CSU</span>
    </div>

    <!-- Sidebar/menu -->
    <?php
    require_once 'config/menu.php'
    ?>


    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
         title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">

        <!-- Header -->

        <?php
        require_once 'router.php';
        ?>

        <!-- Footer -->
<!--        <footer class="w3-container w3-padding-16 w3-light-grey">-->
<!--            <h4>PANEL ADMINISTRACYJNY CSU v0.1</h4>-->
<!---->
<!--        </footer>-->

        <!-- End page content -->
    </div>

    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");

        // Get the DIV with overlay effect
        var overlayBg = document.getElementById("myOverlay");

        // Toggle between showing and hiding the sidebar, and add overlay effect
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }
    </script>

    </body>
    </html>

    <?php
} else require_once 'page/stats.php';


?>

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function () {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function () {
                div.style.display = "none";
            }, 800);
        }
    }
</script>
