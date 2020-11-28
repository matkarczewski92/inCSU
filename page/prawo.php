<?php
$id = $_COOKIE['id'];

?>

    <div class="hero">
        <div class="hero-content">
            <h2>Dziennik ustaw</h2>
            <hr width="800"/>
            <p>

            </p>
        </div>
        <div class="hero-content-mobile"><h2>Dziennik ustaw</h2></div>
    </div>

    <div class="main">
        <div class="content">
            <div class="card">
<?php

if(isset($_GET['typ']) && $_GET['typ']!='pokaz' AND $_GET['typ']!='teu' AND $_GET['typ']!='scl' AND $_GET['typ']!='bar' AND $_GET['typ']!='dre' AND $_GET['typ']!='uni'){
    $info = System::getLawCatLow($_GET['typ']);
    echo '<p>Akty prawne - '.$info['name'].' </p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `law_article` WHERE id_cat_low = '$_GET[typ]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if ($row['actual'] == 0) {
            echo ' <p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></li>';
        } else {
            echo ' <s><p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></s> (<B>UCHYLONY</B>)</li>';
        }
    }

} else if(isset($_GET['typ']) && $_GET['typ']!='pokaz' AND $_GET['typ']=='teu' OR $_GET['typ']=='scl' OR $_GET['typ']=='bar' OR $_GET['typ']=='dre' OR $_GET['typ']=='uni') {
    if ($_GET['typ']=='teu') $id = 'L0001';
    if ($_GET['typ']=='dre') $id = 'L0002';
    if ($_GET['typ']=='bar') $id = 'L0003';
    if ($_GET['typ']=='scl') $id = 'L0004';
    if ($_GET['typ']=='uni') $id = 'I00001';
    $info = System::getInfo($id);
    echo '<p>Akty prawne - ' . $info['name'] . ' </p>';
    $conn = pdo_connect_mysql_up();

            $sql = "SELECT * FROM `law_article` WHERE state_id = '$id' ORDER BY `date` DESC  ";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                if ($row['actual'] == 0) {
                    echo ' <p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></li>';
                } else {
                    echo ' <s><p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></s> (<B>UCHYLONY</B>)</li>';
                }


    }

} else if($_GET['typ']=='pokaz'){
    $article = System::getLaw($_GET['ptyp']);
    $user_a = System::user_info($article['id_user']);
    echo '<table border="0" width="80%" align="center">
  <tr>
        <td width="80%" colspan="3"> &nbsp</td>
    <tr>
        <td width="80%" colspan="3"><b>'.$article['name'].' ';
    if ($article['actual']==1) echo '(UCHYLONY)';
    echo '</b><br> z dnia '.timeToDate($article['date']).'</td>
  <tr>
        <td width="80%" colspan="3"> &nbsp</td>
    <tr>
    </tr>
    <tr>
        <td width="80%" colspan="3" align="left">'.$article['text'].'</td>
    </tr>
      <tr>
        <td width="80%" colspan="3"> <hr></td>
    <tr>
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td width="50%">Opublikowane przez <br> (-) '.$user_a['name'].'<br>Za zgodnością z oryginałem<br><a href="'._URL.'/profil/adm_prawo_edycja/'.$article['state_id'].'/'.$article['id'].'" style="text-decoration: none; color: #1d4e85">#'.$article['id'].'</a></td>
    </tr>
</table>
<p><hr></p>';




} else {
    echo '<p><br>Akty prawne </p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `law_article` ORDER BY date DESC LIMIT 0,30";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if($row['actual']==0) {
            echo '<p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></li>';
        } else {
            echo ' <s><p align="left">&nbsp;&nbsp;&nbsp; <b><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></s> (<B>UCHYLONY</B>)</li>';
        }
    }
}












echo ' </div></div>
    <div class="menu">        <div class="card-body">';

echo '<div class="card menucard sticky">';
echo ' <p class=""><a href="' . _URL . '/prawo/uni" style="text-decoration: none; color: #1d4e85">Prawo Unijne</p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `law_category_main` WHERE state_id = 'I00001'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<p align="left">' . $row['name'] . '</p>';
    $sql1 = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]' ORDER BY `order` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        echo '<p align="left"><a href="' . _URL . '/prawo/' . $row1['id'] . '" style="text-decoration: none; color: #1d4e85">
        &nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</a></p>';
    }
}


echo '</div></div><p><hr></p>        <div class="card-body">';
echo '<div class="card menucard sticky">';
echo ' <p class=""><a href="' . _URL . '/prawo/bar" style="text-decoration: none; color: #1d4e85">Baridas</p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `law_category_main` WHERE state_id = 'L0003'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<p align="left">' . $row['name'] . '</p>';
    $sql1 = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]' ORDER BY `order` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        echo '<p align="left"><a href="' . _URL . '/prawo/' . $row1['id'] . '" style="text-decoration: none; color: #1d4e85">
        &nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</a></p>';

    }
}



echo '</div></div><p><hr></p><div class="card-body">';
echo '<div class="card menucard sticky">';
echo ' <p class=""><a href="' . _URL . '/prawo/dre" style="text-decoration: none; color: #1d4e85">Dreamland</a></p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `law_category_main` WHERE state_id = 'L0002'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<p align="left">' . $row['name'] . '</p>';
    $sql1 = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]' ORDER BY `order` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        echo '<p align="left"><a href="' . _URL . '/prawo/' . $row1['id'] . '" style="text-decoration: none; color: #1d4e85">
        &nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</a></p>';
    }
}


echo '</div></div><p><hr></p><div class="card-body">';
echo '<div class="card menucard sticky">';
echo ' <p class=""><a href="' . _URL . '/prawo/scl" style="text-decoration: none; color: #1d4e85">Sclavinia</a></p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `law_category_main` WHERE state_id = 'L0004'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<p align="left">' . $row['name'] . '</p>';
    $sql1 = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]' ORDER BY `order` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        echo '<p align="left"><a href="' . _URL . '/prawo/' . $row1['id'] . '" style="text-decoration: none; color: #1d4e85">
        &nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</a></p>';
    }
}



echo '</div></div><p><hr></p><div class="card-body">';
echo '<div class="card menucard sticky">';
echo ' <p class=""><a href="' . _URL . '/prawo/teu" style="text-decoration: none; color: #1d4e85">Teutonia</a></p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `law_category_main` WHERE state_id = 'L0001'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<p align="left">' . $row['name'] . '</p>';
    $sql = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]' ORDER BY `order` ";
    $sth = $conn->query($sql);
    while ($row1 = $sth->fetch()) {
        echo '<p align="left"><a href="' . _URL . '/prawo/' . $row1['id'] . '" style="text-decoration: none; color: #1d4e85">
        &nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</a></p>';
    }
}



echo '</div><p><hr></p>';


echo ' </div></div>
</div>';
            
