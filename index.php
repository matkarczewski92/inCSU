<?php
ob_start();
session_start();
date_default_timezone_set("Poland");
require_once "controller/db_connection.php";
require_once "class/System.php";
require_once "class/User.php";
require_once "class/Bank.php";
require_once "class/Organizations.php";
require_once "class/Create.php";
require_once "class/Investments.php";
require_once "class/Probe.php";
require_once "class/Plot.php";
require_once "class/PlotBuilding.php";

$id = $_COOKIE['id'];
$conn = pdo_connect_mysql_up();
$sql12 = "SELECT COUNT(*) FROM `up_post` WHERE `to_id` = '$_COOKIE[id]' AND `is_read` = '0'";
$stmt12 = $conn->query($sql12)->fetch(PDO::FETCH_NUM);
$sql123 = "SELECT COUNT(*) FROM `up_alerts` WHERE `user_id` = '$_COOKIE[id]' AND `read` = '0'";
$stmt123 = $conn->query($sql123)->fetch(PDO::FETCH_NUM);
if ($stmt12[0] == '0') {
    $msg12 = '';
    $icon = 'account_circle';
} else {
    $msg12 = '<span class="material-icons" style="color: #f44336; ">mark_email_unread</span>';
    $icon = 'mark_chat_unread';
}



$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr( $ip );
$actual_time = time();
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_user_login_data` WHERE user_id = '$id' ORDER BY `id` DESC LIMIT 0,1";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    if ($actual_time - $row['data'] > (60 * 60 * 12)) {
        $sql = "INSERT INTO `up_user_login_data` (user_id, data, ip, text, host) VALUES (:user_id, :data, :ip, :text, :host)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id' => $id,
                ':data' => time(),
                ':ip' => $_SERVER['REMOTE_ADDR'],
                ':text' => 'Aktualizacja sesji',
                ':host' => $host)
        ) or die(print_r($sth->errorInfo(), true));
    }
}












$under_construction = '0';
if ($under_construction == '1'){
    require_once 'under_construction.php';
} else {
?>




<!DOCTYPE html>
<html lang="pl">
<head>
    <script>
        $(document)
            .ready(function () {
                var cookies = document.cookie;
                $( '.message.cookies' ).each(function() {
                    if(!cookies.includes($( this ).attr('id'))) {
                        $( this ).removeClass('hidden');
                    }
                });

                $('.ui.sidebar').sidebar('attach events', '.toc.item');

                $('.popup-click').popup({
                    on: 'click',
                    inline: true,
                    hoverable: true,
                    position: 'bottom right',
                    delay: {
                        show: 300,
                        hide: 800
                    },
                    lastResort: 'bottom right'
                });

                $('.popup-click2').popup({
                    on: 'click',
                    inline: true,
                    hoverable: true,
                    position: 'bottom center',
                    delay: {
                        show: 300,
                        hide: 800
                    },
                    lastResort: 'bottom center'
                });

                $('.message .close').on('click', function () {
                    var msg = $(this).closest('.message');
                    msg.transition('fade');
                    if (msg.hasClass('cookies')) {
                        var d = new Date();
                        d.setTime(d.getTime() + (msg.attr('duration-time') * 1000));
                        var expires = "expires="+ d;
                        document.cookie = msg.attr('id') + "=1;" + expires + ";path=/";
                    }
                });

                $('.popup-focus').popup({
                    on: 'focus',
                    inline: true,
                    hoverable: true,
                    position: 'bottom right',
                    lastResort: 'bottom right'
                });

                $('.popup-hover').popup({
                    on: 'hover',
                    position: 'bottom right',
                    lastResort: 'bottom right',
                    hoverable: true,
                    addTouchEvents: true
                });

                $('.popup-hover-delayed').popup({
                    on: 'hover',
                    position: 'bottom right',
                    lastResort: 'bottom right',
                    hoverable: true,
                    addTouchEvents: true,
                    delay: {
                        show: 300,
                        hide: 800
                    }
                });
                $('.ui.accordion').accordion();
                $('.progress').progress();

                function gapMovement() {
                    $('div.gap > .content > p > a:first').transition({
                        animation  : 'fade',
                        duration   : '2s',
                        onComplete : function() {
                            var $me = $(this);
                            $me.parent().append($me);
                            $('div.gap > .content > p > a:not(:first)').hide();
                            $('div.gap > .content > p > a:first').transition('fade', '2s');
                            gapMovement();
                        }
                    })
                }
                gapMovement();
            });
    </script>


    <link rel="icon" type="image/png" sizes="16x16" href="favicon.ico">
    <script src="https://cdn.tiny.cloud/1/6q8o2267j1ft1aqjdepti8d0cgp2lj4eqlkv1y0c868hx5kf/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>tinymce.init({selector: 'myTextarea2'});</script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myTextarea',

            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor',
            menu: {},
            menubar: 'favs file edit view insert format',
            content_css: 'http://uniapanstw.pl/js/tinymce/css/content.css'
        });
    </script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myTextarea3',

            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor',
            menu: {},
            menubar: 'favs file edit view insert format',
            content_css: 'http://uniapanstw.pl/js/tinymce/css/content.css'
        });
    </script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myTextarea4',

            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor',
            menu: {},
            menubar: 'favs file edit view insert format',
            content_css: 'http://uniapanstw.pl/js/tinymce/css/content.css'
        });
    </script>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.8"/>

    <title>UNIA NIEPODLEGŁYCH PAŃSTW</title>

    <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap"
            rel="stylesheet"
    />
    <link
            href="https://fonts.googleapis.com/css2?family=Material+Icons"
            rel="stylesheet"
    />
    <?php
    if ($_GET['page']=='') {
        echo '<link rel="stylesheet" href="' . _URL . '/css/main.css" />';
    } else {
        echo '<link rel="stylesheet" href="' . _URL . '/css/profil.css" />';
    }
    ?>
</head>
<body>

<!--Changing the main dropdown menu-->
<nav>
    <div class="menuLewe">
        <!--<button class="dropdownButton" onclick="displayIt()">-->
        <i class="dropdownButton material-icons" onclick="displayIt()">menu</i>
        <!--</button>-->

        <div id="myDropdown_Left" class="dropdown-contenty">
            <li><a href="<? echo _URL; ?>/">Strona główna</a></li>
            <li><a href="<? echo _URL; ?>/">Władza</a></li>
            <li><a href="<? echo _URL; ?>/mieszkancy">Mieszkańcy</a></li>
            <li><a href="<? echo _URL; ?>/organizacje">Organizacje</a></li>
            <li><a href="<? echo _URL; ?>/kraje">Kraje</a></li>
            <li><a href="<? echo _URL; ?>/prawo">Prawo</a></li>
            <li><a href="<? echo _URL; ?>/profil/I00002">Komitet inżynieryjny</a></li>
            <li><a href="<? echo _URL; ?>/probe">Głosowania</a></li>
            <li><a href="<? echo _URL; ?>/thkxadmin">Statystyki</a></li>
            <li><a href="http://forum.uniapanstw.pl/" target="_blank">Forum</a></li>
        </div>
    </div>

    <div class="h4unia"><h4><a href="<?php echo _URL; ?>" style="text-decoration: none; color: white">UNIA
                 NIEPODLEGŁYCH PAŃSTW</a></h4></div>
    <div class="dropdown">
        <i class="material-icons">
            <?php
            $alert = ($stmt123[0]!=0)? 'notifications_active' : 'notifications_none';
            echo ($stmt123[0]!=0) ?
                '<a href=" '._URL.'/profil/alerts/'.$_COOKIE['id'].'" style="text-decoration: none; color: black"> <span class="material-icons">notifications_active</span></a>'
              :  '<a href=" '._URL.'/profil/alerts/'.$_COOKIE['id'].'" style="text-decoration: none; color: white"> <span class="material-icons">notifications_none</span></a>';

        ?>
        </i><i class="material-icons dropbtn" onclick="myFunction()"><?php echo $icon; ?></i>
        <div id="myDropdown" class="dropdown-content">
            <?php
            if (!isset($id)) {
                ?>
                <form action="<?php echo _URL; ?>/login" method="post">
                    <div class="container">
                        <label for="uname"><b>ID Mieszkańca</b></label>
                        <input type="text" placeholder="ID lub adres e-mail." name="id" required>

                        <label for="psw"><b>Hasło</b></label>
                        <input type="password" placeholder="Wpisz swoje hasło." name="password" required>

                        <button type="submit">Zaloguj się</button>
                        <p align="center"><a href="/mieszkancy">Jeżeli zapomniałeś swojego ID kliknij tutaj</a></p>
                    </div>

                    <div class="container" style="background-color:#f1f1f1">
                        <span class="psw_frgt"><a href="#">Zapomniałeś hasła?</a></span>
                    </div>
                    <a href="#about" onclick="document.getElementById('id01').style.display='block'">Zarejestruj się</a>
                    <a href="#about" onclick="document.getElementById('id01').style.display='block'">Logowanie</a>
                </form>
                <?php
            } else {
                $user = new User($id);

                echo '<table  width="100%" cellpadding="0" cellspacing="0" style="color:black; overflow:scroll;">
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><centeR><p><img src="' . $user->getAvatarUrl() . '" height="200" width="190" alt="Zdjęcie profilowe" class="profile-imgo" ></p></centeR></td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90%"><center>' . $user->getId() . '<br> <b>' . $user->getName() . '</b></center></td>
        <td width="5%">&nbsp;</td>
    </tr>

        <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><hr></td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/profil/' . $user->getId() . '">Mój Profil</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/bank">Bank</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
        <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/zatrudnienia/' . $id . '" style="text-decoration: none; color: #1d4e85">Miejsca zatrudnienia</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/organizacje/' . $id . '">Moje organizacje</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/investments/' . $id . '">Moje inwestycje</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
        <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/dzialki/' . $id . '">Moje nieruchomości</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
     <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/post">Poczta ' . $msg12 . '</a></td>
        <td width="5%">&nbsp;</td>
    </tr>    
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/profil/dodaj_organizacje/' . $id . '">Otwórz organizacje</a></td>
        <td width="5%">&nbsp;</td>
    </tr>
        <tr>
        <td width="5%">&nbsp;</td>
        <td width="90">&nbsp;</td>
        <td width="5%">&nbsp;</td>
    </tr>';

                echo ($user->getGlobalAdmin() == '1') ? '<tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/admins">GODMODE '.$actual.'</a></td>
        <td width="5%">&nbsp;</td>
    </tr>' : '';
                echo '<tr>
        <td width="5%">&nbsp;</td>
        <td width="90"><a href="' . _URL . '/logout">Wyloguj</a></td>
        <td width="5%">&nbsp;</td>
    </tr>

</table>';
            }
            ?>
        </div>
    </div>

    <!--REJESTRACJA -->
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close"
              title="Close Modal">&times;</span>
        <form class="modal-content" action="<? echo _URL; ?>/controller/register.php" method="post">
            <div class="container">
                <h1>Formularz rejstracji w Unii Państw Niepodległych</h1>
                <p>Wypełnij poni&#380sze pola, &#380eby zało&#380yc konto w naszych serwisach.</p>
                <hr>
                <label for="name"><b>Imię i nazwisko:</b></label>
                <input type="text" placeholder="Wpisz swoje imię i nazwisko." name="name" maxlength="45" required>

                <label for="email"><b>Adres e-mail:</b></label>
                <input type="text" placeholder="Wpisz swój adres e-mail." name="email" required>

                <label for="psw"><b>Hasło:</b></label>
                <input type="password" placeholder="Wpisz swoje hasło." name="password" required>

                <label for="state_id"><b>Kraj</b></label><br>
                <select name="state_id">
                    <option value="L0005">Ambasada</option>
                    <option value="L0003">Republika Baridas</option>
                    <option value="L0002">Królestwo Dreamlandu</option>
                    <option value="L0004">Konfederacja Sclavińska</option>
                    <option value="L0001">Królestwo Teutonii</option>
                    </select>

                <p>Rejestrując się na naszej stronie, zgadzasz się z <a href="#" style="color:dodgerblue">zasadami
                        u&#380ytkowania.</a>.</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'"
                            class="cancelbtn">Anuluj
                    </button>
                    <button type="submit" class="signupbtn">Zarejestruj się!</button>
                </div>
            </div>
        </form>
    </div>

</nav>
<?php
require_once('podstrona.php');

?>

<footer>

    <div class="some">
        <a href="https://www.facebook.com/uniapanstw/" target="_blank" style="color: white"> <i class="material-icons">facebook</i></a>

    </div>
    <div class="odnosniki">
        <h5><a href="/mieszkancy">MIESZKAŃCY</a></h5>
        <h5><a href="/organizacje">ORGANIZACJE</a></h5>
        <h5><a href="/kraje">KRAJE</a></h5>
        <h5><a href="http://forum.uniapanstw.pl/" target="_blank">FORUM</a></h5>
    </div>
    <a id="back2Top" title="Back to top" href="#"><i class="material-icons">arrow_upward</i></a>
</footer>
<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function () {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function () {
                div.style.display = "none";
            }, 600);
        }
    }
</script>
</body>
<script src="<?php echo _URL; ?>/main.js"></script>
</html>


<?php
}