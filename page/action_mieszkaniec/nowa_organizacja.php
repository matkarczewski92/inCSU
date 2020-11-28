<style>.alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
    }

    .alert.success {
        background-color: #4CAF50;
    }

    .alert.info {
        background-color: #2196F3;
    }

    .alert.warning {
        background-color: #f44336;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }</style><?php
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
$cost = System::config_info();
$cost_org = $cost['org_open_charge'];

$conn = pdo_connect_mysql_up();
$sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'  LIMIT 0,1";
$sth12 = $conn->query($sql12);
$licznik = 0;
while ($row12 = $sth12->fetch()) {
    $bank_to = $row12['id'];
}
$bank = Bank::account_info($bank_to);
?>

<div class="hero">
    <div class="hero-content">
        <h2>Rejestr organizacji</h2>
        <hr width="800"/>
        <p>
            W tym miejscu mozesz otworzyc nową organizaję.
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Rejestr organizacji</h2></div>
</div>

<div class="main">
    <div class="content">
        <div class="card"><?
            if (isset($_POST['org_name'])) {
                echo $_POST['type_id'];
                $transfer = Bank::transfer($bank_to, _KIBANK, $cost_org, 'Opłata za otwarcie organizacji');
                if ($transfer == 'OK') {
                    $x = Create::Organization($_POST['type_id'], $_POST['org_name'], ' ', $_COOKIE['id'], ' ', '0', '0', $_COOKIE['id'], $user->getStateId(), '1', '0');
                    $url = _URL;
                    header("Location: $url/profil/$x");
                }

            } else {

                echo '<label class="w3-text-teal"><b><br>Otwarcie organizacji</b></label><br>
                    <p align="justify" style="margin-left: 1%">Aktualnie koszt otwarcia organizacji prywatnej wynosi ' . $cost_org . ' kr. Po otwarciu organizacji znajdziesz ją w zakładce MOJE ORGANIZACJE, w profilu organizacji będzie mógł zmienić wszelkie dane dotyczące swojej nowej organizacji.</p>';
                echo ($cost_org <= $bank['balance']) ? '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
  <label class="w3-text-teal"><b>Nazwa organizacji </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="org_name"><br>
  <label class="w3-text-teal"><b>Typ organizacji </b></label><br>
  <select name="type_id" style="width: 50%">
  <option value="2"> Przedsiębiorstwo prywatne</option>
  <option value="4"> Przedsiębiorstwo budowlane</option>
</select>
  
  
                <button class="w3-btn w3-blue-grey">Otwórz organizacje</button>' : '<div class="alert warning">  <span  class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>BRAK ŚRODKÓW NA KONCIE
</div>';
                echo '</table>';
            }
            echo '<br>';
            ?></div>
    </div>

