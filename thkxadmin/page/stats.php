<script>
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","page/stats_st.php?q="+str,true);
            xmlhttp.send();
        }
    }
</script><?php
$time = time();
$sql = "SELECT COUNT(*) FROM `up_users` WHERE active=  0";
$stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_media_article`";
$stmt_article = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_organizations`";
$stmt_org = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_media_article_coment`";
$stmt_com = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `bank_account`";
$stmt_acc = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_plot` WHERE owner_id != ''";
$stmt_plot = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_user_investments`";
$stmt_inv = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_organizations_workers` WHERE until_date > '$time'";
$stmt_work_o = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_countries_workers` WHERE until_date > '$time'";
$stmt_work_c = $conn->query($sql)->fetch(PDO::FETCH_NUM);


$bank = 0;
$sql = "SELECT * FROM `bank_account`";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $bank+=$row['balance'];
}
$bank1 = 0;
$sql = "SELECT * FROM `bank_account` WHERE id = '00118 ' OR id = '00014' OR id = '00108' OR id = '00093' OR id = '00094' OR id = '00141'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $bank1+=$row['balance'];
}
$inwest = 0;
$sql = "SELECT * FROM `up_user_investments`";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $inwest+=$row['money'];
}
$salary = 0;
$sql = "SELECT * FROM `up_organizations_workers` WHERE until_date > '$time'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $salary+=$row['salary'];
}
$sql = "SELECT * FROM `up_countries_workers` WHERE until_date > '$time'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $salary+=$row['salary'];
}
$rSalary =  $salary/($stmt_work_o[0]+$stmt_work_c[0]);


$user_info = new User($_COOKIE['id']);
$avatar = $user_info->getAvatarUrl();
$name = ($_COOKIE['id']!='')? $user_info->getName() : 'Nieznajomy';
if ($admin == '0' or $admin == '') {
    $user_op = new User($_COOKIE['id']);
    ?>
    <!DOCTYPE html>
    <html>
    <head>

    </head>
    <title>CSU STATYSTYKI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="<? echo _URL.'/thkxadmin/style.css';?>">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="<? echo $user_op->getAvatarUrl(); ?>" class="w3-circle w3-margin-right" style="max-width:46px">
            </div>
            <div class="w3-col s8 w3-bar">
                <span>Witaj, <strong><? echo $name ?></strong></span><br>
            </div>
        </div>
        <hr>
        <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  HOME</a>
        </div>
    </nav>


    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
         title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <?php
}


?>
    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Panel statystyk</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo number_format($bank, 0, ',', ' '); ?> kr</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Pieniędzy w systemie</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo number_format($bank1, 0, ',', ' '); ?> kr</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Pieniędzy w centrali</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo number_format(($bank-$bank1)/$stmt_users[0], 0, ',', ' '); ?> kr</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Kr na mieszkańca</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo number_format($rSalary, 0, ',', ' '); ?> kr</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Średnie wynagrodzenie</h4>
            </div>
        </div><br>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-blue w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-globe w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_org[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Organizacji</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-teal w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-newspaper-o w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_article[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Artykułów prasowych</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-orange w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_users[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Mieszkańców</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-lime w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-address-book w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_acc[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Rachunków bankowych</h4>
            </div>
        </div><br>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-green w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_plot[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Kupionych działek</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-blue-gray w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-comment-o w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_com[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Komentarzy</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-dark-gray w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo $stmt_inv[0]; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Założonych inwestycji</h4>
            </div>
        </div>
        <div class="w3-quarter" style="margin-top: 30px;">
            <div class="w3-container w3-dark-gray w3-text-white w3-padding-16" style="min-height: 175px">
                <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><? echo number_format($inwest/$stmt_inv[0], 2, ',', ' '); ?> kr</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Średni dochód z inwestycji</h4>
            </div>
        </div>
    </div>


    <div class="w3-container">
        <form>
            <select name="users" onchange="showUser(this.value)" id="stats" class="search">
                <option value="">Wybierz miesiąc</option>
                <?
                $sql = "SELECT * FROM `stats` GROUP BY `month`";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    switch ($row['month']) {
                        case '1' :
                            $month = 'Styczeń';
                            break;
                        case '2' :
                            $month = 'Luty';
                            break;
                        case '3' :
                            $month = 'Marzec';
                            break;
                        case '4' :
                            $month = 'Kwiecień';
                            break;
                        case '5' :
                            $month = 'Maj';
                            break;
                        case '6' :
                            $month = 'Czerwic';
                            break;
                        case '7' :
                            $month = 'Lipiec';
                            break;
                        case '8' :
                            $month = 'Sierpień';
                            break;
                        case '9' :
                            $month = 'Wrzesień';
                            break;
                        case '10' :
                            $month = 'Październik';
                            break;
                        case '11' :
                            $month = 'Listopad';
                            break;
                        case '12' :
                            $month = 'Grudzień';
                            break;
                    }
                    echo '<option value="'.$row['month'].'">Dane szczegółowe za: '.$month.' '.$row['year'].'</option>';
                }
                ?>
            </select>
        </form>
        <div id="txtHint"><b>Wybierz miesiąc aby zobaczyć dane</b></div>


    </div>

    <hr>
    <div class="w3-container">
        <h5>Administracja</h5>
        <ul class="w3-ul w3-card-4 w3-white">
            <?php

            $sql = "SELECT * FROM `up_admin`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $sql1 = "SELECT * FROM `up_admin_type` WHERE id = '$row[type_id]'";
                $data1 = $conn->query($sql1)->fetch();

                $user_info = System::user_info($row['user_id']);
                echo'<li class="w3-padding-16">
                <img src="'.$user_info['avatar_url'].'" class="w3-left w3-circle w3-margin-right" style="width:40px">
                <span class="w3-xlarge"><b>'.$user_info['name'].'</b> - '.$data1['name'].'</span><br>
            </li>';
            }


            ?>
        </ul>
    </div>
    <hr>
<?php
if ($admin == '0' or $admin == '') {
    ?>

    <br>


    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">

    </footer>

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
}