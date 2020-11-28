
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font: 16px Arial;
    }

    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    option, select {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }


    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style><?php


?>
<?php
require_once "controller/db_connection.php";
require_once "class/User.php";
require_once "class/System.php";
require_once "class/Bank.php";
require_once "class/Create.php";
?>

<h2><p>Zlecenie przelewu</p></h2>


<!--Make sure the form has the autocomplete function switched off:-->
<?php
if (!isset($_POST['title']) and !isset($_POST['value']) and !isset($_POST['to_id']) and !isset($_POST['from_id'])) {
    ?>
    <form class="w3-container" action="<? echo _URL; ?>/bank/przelew" method="post">

        <label class="w3-text-teal"><b>Wybierz rachunek</b></label><br>
        <select name="from_id" style="width:500px;"><?
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $profil_info = System::getInfo($row['owner_id']);
                $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
            }


            $sql1 = "SELECT * FROM `up_countries` WHERE `leader_id` = '$id'";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }


            $sql1 = "SELECT * FROM `up_cities` WHERE `leader_id` = '$id'";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }

            $sql12 = "SELECT * FROM `up_countries` WHERE `leader_id` = '$id' ";
            $sth12 = $conn->query($sql12);
            while ($row12 = $sth12->fetch()) {
                $sql1 = "SELECT * FROM `up_cities` WHERE `state_id` = '$row12[id]' ";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
                    $sth = $conn->query($sql);
                    while ($row = $sth->fetch()) {
                        $profil_info = System::getInfo($row1['id']);
                        $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                        echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                    }
                }
            }


            $sql1 = "SELECT * FROM `up_organizations` WHERE `leader_id` = '$id' OR `owner_id` = '$id'";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }


            $sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_countries_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['state_id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }

            $sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_cities_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['state_id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }


            $sql1 = "SELECT distinct `user_id`, `organizations_id`, `until_date`, `from_date` FROM `up_organizations_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[organizations_id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $profil_info = System::getInfo($row1['organizations_id']);
                    $balance = number_format(($row['balance'] - $row['debit']), 0, ',', ' ');
                    echo '<option value="' . $row['id'] . '">#' . $row['id'] . ' (' . $profil_info['id'] . ') ' . $profil_info['name'] . ' [ ' . $balance . ' kr ]</option>';
                }
            }


            ?>
        </select><br><br>
        <label class="w3-text-teal"><b>Podaj kwotę przelewu</b></label><br>
        <input type="number" name="value" style="width:500px;"><br><br>
        <label class="w3-text-teal" style="width:500px;"><b>Podaj tytuł przelewu</b></label><br>
        <input type="text" name="title" style="width:500px;"><br>
        <label class="w3-text-teal"><b>Podaj numer rachunku odbiorcy</b></label><br>
        <div class="autocomplete" method="post" style="width:550px;">
            <input id="myInputBank" type="text" name="to_id" placeholder="#Wprowadz nr rachunku"
                   style="width:500px;"><br><br></div>
        <button class="w3-btn w3-blue-grey">Wykonaj przelew</button>
    </form>
    <hr>
    <?php
} else {
    if (!is_null($_POST['title']) and !is_null($_POST['value']) and !is_null($_POST['to_id']) and !is_null($_POST['from_id'])) {
        if (isset($_POST['to_id'])) {

            $from_id = $_POST['from_id'];
            $id = explode("#", $_POST['to_id']);
            $to_id = $id[1];
            $title = (string)$_POST['title'];
            $value = (int)$_POST['value'];
            if (substr($to_id, 0, 1) != '0') $to_id = $id[0]; else $to_id = $id[1];

            $transfer = Bank::transfer($from_id, $to_id, $value, $title);
            $link = _URL;
            header("Location: $link/bank/$transfer");


        } else echo ' <p>Wszystkie dane muszą zostać uzupełnione<br><hr></p>';
    }


}


?>
<script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    /*An array containing all the country names in the world:*/
    var countries1 = [<?
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `bank_account`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $id_f_lider = substr($row['owner_id'], 0, 1);
            if($id_f_lider!='I') {
                $user = System::getInfo($row['owner_id']);
                $nazwa =  preg_replace('/(\s{2,})/', ' ', $user['name']);
                echo '"' . $row['id'] . ' #' . $nazwa . '#",';
                echo '"' . $nazwa . ' #' . $row['id'] . '",';
            } else if($id_f_lider=='I') {
                $user = System::organization_info($row['owner_id']);
                $nazwa =  preg_replace('/(\s{2,})/', ' ', $user['name']);
                echo '"' . $row['id'] . ' #' . $nazwa . '#",';
                echo '"' . $nazwa . ' #' . $row['id'] . '",';
            }
        }
        ?>
    ];


    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInputBank"), countries1);

</script>