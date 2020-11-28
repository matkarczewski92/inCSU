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
        background-color: #ff9800;
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
$id = $_COOKIE['id'];
$data_time_actual = time();
if ($_COOKIE['id'] != ''){
?>


<div class="hero">
    <div class="hero-content">
        <h2>Bank Unii Państw Niepodległych</h2>
        <hr width="800"/>
        <p>
            Witaj w Banku Unii, w tym miejscu masz dostęp do wszystkich rachunków bankowych,<br> których jesteś
            właścicielem lub zarządcą.
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Bank Unii Państw Niepodległych</h2></div>
</div>
<div class="main">
    <div class="content">
        <div class="card"><?
            $transfer = $_GET['typ'];
            if ($transfer == 'OK') echo '
<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Przelew został wykonany pomyślnie:
</div>';
            if ($transfer == 'MONEY') echo '
<div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak środków na koncie
</div>';
            if ($transfer == 'ACCOUNT') echo '
<div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Nieprawidłowy nr. rachunku odbiorcy bądź konto odbiorcy jest zablokowane
</div>';
            if ($transfer == 'OWN') echo '
<div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak możliwości wykonywania przelewów pomiędzy tymi samymi rachunkami
</div>';


            if ($_GET['typ'] == 'wyciag') {
                require_once 'action_bank/wyciag.php';
            } else if ($_GET['typ'] == 'przelew') {
                require_once 'action_bank/przelew.php';
            } else if ($_GET['typ'] == 'nowekonto') {
                require_once 'action_bank/nowekonto.php';
            } else {
                require_once 'action_bank/home_bank.php';
            }
            echo '       </div>
    </div>';

            echo '<div class="menu">
        <div class="card menucard sticky">
            <p class=""><a href="' . _URL . '/bank" style="text-decoration: none; color: #1d4e85">Podsumowanie</a></p>
            <p class=""><a href="' . _URL . '/bank/przelew" style="text-decoration: none; color: #1d4e85">Wyślij przelew</a></p>
            <p class=""><a href="' . _URL . '/bank/wyciag" style="text-decoration: none; color: #1d4e85">Wyciągi</a></p>
            <p class="">Nowe konto</p>

 
    </div>
 </div>   ';

            } else header('Location: ' . _URL);
            ?>
