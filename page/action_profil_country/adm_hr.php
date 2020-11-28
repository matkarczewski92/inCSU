
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


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie pracownika</h2>
</div>';
if (isset($_POST['id'])) {
    $id_msc = strtoupper($_POST['id_city']);
    $id_ui = strtoupper($_POST['id']);
    $id_f_lider = substr($id_ui, 0, 1);

    $idz = explode("#", $_POST['id']);
    $to_id = $idz[1];
    if (substr($to_id, 0, 2)!='U0') $to_id = $idz[0]; else $to_id = $idz[1];

    if (substr($to_id, 0, 2) == 'U0' or $to_id == '') {
        $ui_info = System::user_info($to_id);
        if ($ui_info['name'] != '') {
            echo '<p>Pracownik zosta dodany</p>'.$to_id.'<br>';
            if ($_POST['law'] == 'on') $law = 1; else $law = 0;
            if ($_POST['proposal'] == 'on') $proposal = 1; else $proposal = 0;
            if ($_POST['edit'] == 'on') $edit = 1; else $edit = 0;
            if ($_POST['cities'] == 'on') $cities = 1; else $cities = 0;
            if ($_POST['workers'] == 'on') $workers = 1; else $workers = 0;
            if ($_POST['users'] == 'on') $users = 1; else $users = 0;
            if ($_POST['bank'] == 'on') $bank = 1; else $bank = 0;
            if ($_POST['org'] == 'on') $org = 1; else $org = 0;
            $id_to = $to_id;
            Create::WorkerCountry($id_to, $id, $_POST['until_date'], $_POST['name'], $_POST['salary'], $_POST['period'], $law, $bank, $users, $cities, $proposal, $edit, $workers, $org, $_POST['org_id']);
        } else {
            echo '<p>Brak mieszkańca o podanym ID</p>'.$_POST['until_date'].'<br>';

        }

    } else echo '<p>Liderm może zostać wyłącznie osoba</p><br>';

} else {

    echo '<form class="w3-container" method="post">
  
    <label class="w3-text-teal"><b>Podaj id pracownika</b></label><br>
   <div class="autocomplete" method="post" style="width:550pxpx; ">
  <input class="w3-input w3-border w3-light-grey" id="myInput" type="text" style="width: 500px" name="id"">   </div>
  
  
    <br><br><label class="w3-text-teal"><b>Podaj nazwę stanowiska</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name""><br>
 
    <label class="w3-text-teal"><b>Długość stosunku pracy od dziś (w dniach)</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="number" style="width: 350px" name="until_date" value="30"><br>
    
    <label class="w3-text-teal"><b>Wysokość wynagrodzenia</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="number" style="width: 350px" name="salary" value="0"><br>  
    
    <label class="w3-text-teal"><b>Częstotliwość wynagrodzenia (w dniach)</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="number" style="width: 350px" name="period" value="7"><br>  
    
    <table border="1" align="center" width="40">
    <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie i dodawanie aktów prawnych">gavel</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="law""></td>
    </tr>
        <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie rach. bankowymi">account_balance</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="bank""></td>
    </tr>
        <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie mieszkańcami">group</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="users""></td>
    </tr>
            <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie miastami">business</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="cities""></td>
    </tr>
            <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie wnioskami">description</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="proposal""></td>
    </tr>
            <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie profilem">create</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox"  name="edit""></td>
    </tr>
            <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie pracownikami">engineering</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="workers""></td>
    </tr>
                <tr>
        <td width="20" align="center" valign="top"><span class="material-icons" title="Zarządzanie organizacjami">shop</span></td>
        <td width="20" align="center" valign="top"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="org""></td>
    </tr>
    <br></table><br>
     <label class="w3-text-teal"><b>ID zarządzanej organizacji (jeżeli wszystkich zostaw puste)</b></label><br>
   <select name="org_id"><option value="">Wszystkie</option>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_organizations` WHERE owner_id='$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<option value="'.$row['id'].'">'.$row['id'].' - '.$row['name'].'</option>';
    }

    echo'</select>
    


  <p>Uwaga, jeżeli aktualnie obowiązuje umowa z danym pracownikiem, nowa rozpocznie obowiązywać w momencie ustania poprzedniej. 
  <br>Jeżeli chcesz zmienić uprawnienia pracownika, w profilu głównym kraju usuń pracownika z listy urzędników</p>
  
  
  <button class="w3-btn w3-blue-grey">Edytuj lidera miasta</button>
</form>';
}
echo '</div></div>';
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
    var countries = [<?
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_users`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $user = System::user_info($row['id']);
            echo '"' . $row['name'] . ' #' . $row['id'] . '",';
            echo '"' . $row['id'] . ' #' . $row['name'] . '",';
        }



        ?>


    ];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), countries);
</script>