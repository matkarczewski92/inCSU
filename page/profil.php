<?php
$id = $_GET['typ'];
$typ = substr($id, 0, 2);
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'X0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];


// profile
$idz = explode("-", $id);
switch (substr($id, 0, 2)) {
    case 'U0':
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `up_users` WHERE id = '$id'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        if ($stmt[0] == 1) {
            require_once 'profil_user.php';
            break;
        } else echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID </h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe ID</h2></div>
</div>';
        break;
    case 'C0':
        if($idz[1]=='') {
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT COUNT(*) FROM `up_cities` WHERE id = '$id'";
            $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
            echo $stmt[0];
            if ($stmt[0] == 1) {
                require_once 'profil_cities.php';
                break;
            } else echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID </h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe ID</h2></div>
</div>';
            break;
        } else {
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT COUNT(*) FROM `up_plot` WHERE id = '$id'";
            $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
            echo $stmt[0];
            if ($stmt[0] == 1) {
                require_once 'profil_plot.php';
                break;
            } else echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID 2</h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe </h2></div>
</div>';
            break;
        }
    case 'L0':
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `up_countries` WHERE id = '$id'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        echo $stmt[0];
        if ($stmt[0] == 1) {
            require_once 'profil_county.php';
            break;
        } else echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID </h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe ID</h2></div>
</div>';
        break;
    case 'I0':
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `up_organizations` WHERE id = '$id'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        echo $stmt[0];
        if ($stmt[0] == 1) {
            require_once 'profil_organizations.php';
            break;
        } else echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID </h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe ID</h2></div>
</div>';
        break;
    default:
        echo '<div class="hero">
    <div class="hero-content">
        <h2>Nieprawidłowe ID '.$_GET['typ'].'</h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Nieprawidłowe ID1</h2></div>
</div>';
        break;
}


?>

