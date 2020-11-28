

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
  <h2><br>Edycja danych profilu organizacji</h2>
</div>';

if (isset($_POST['text'])) {

    echo '<p>Dane zostały zmienione pomyślnie</p><br>';
    $text = $_POST['text'];
    $max_rozmiar = 1024*1024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext=strtolower(end(explode('.',$_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'avatar_'.$id.'.'.$file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo '<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'],'user_gfx/'.$_FILES['plik']['name']);
        }
    }
    $idz = explode("#", $_POST['to_id']);
    $to_id = $idz[1];
    if (substr($to_id, 0, 2)!='U0') $to_id = $idz[0]; else $to_id = $idz[1];

    $url_awatar = _URL.'/user_gfx/'.$file_name_sql;

    update('up_organizations', 'id', $id, 'text', $_POST['text']);
    update('up_organizations', 'id', $id, 'name', $_POST['name']);
    update('up_organizations', 'id', $id, 'leader_id', $to_id);
    update('up_organizations', 'id', $id, 'main_bank_acc', $_POST['main_bank_acc']);

    if ($_POST['percent']>=0 AND $_POST['percent']<=100) $percent = $_POST['percent']; else $percent = 0;
    update('up_organizations', 'id', $id, 'article_salary_user', $percent);
    if($file_name_sql!='') {
        update('up_organizations', 'id', $id, 'gfx_url', $url_awatar);
    }


} else {
    $acc_info = Bank::account_info($info['main_bank_acc']);
    echo '<center><form class="w3-container" method="post" ENCTYPE="multipart/form-data">

  <label class="w3-text-teal"><b>Nazwa organizacji </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 500px" name="name" value="'.$info['name'].'"><br>
  
  <label class="w3-text-teal"><b>Wybierz główny rachunek organizacji </b></label><br>
  <select name="main_bank_acc" style="width: 500px">
  <option value="'.$info['main_bank_acc'].'">#'.sprintf("%05d", $info['main_bank_acc']).'</option>';

    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$id' AND id != '$info[main_bank_acc]' ";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<option value="'.$row['id'].'">#'.sprintf("%05d", $row['id']).'</option>';
    }


echo '</select><br><br>

  <label class="w3-text-teal"><b>Treść profilu <br></b></label><br><centeR>
  <textarea id="myTextarea" style="width: 1000px"  name="text" class="w3-input w3-border w3-light-grey" rows="25" cols="100">' . $info['text'] . '</textarea><br>
   </centeR>
    <label class="w3-text-teal"><b>Wgraj avatar (proporcje 1:1 - 100x100, 200x200 itd)</b></label><br><br>
  <input type="file" class="custom-file-input"  name="plik" multiple=""><br><br>
  
      <label class="w3-text-teal"><b>Ile procent z tantiem i dotacji ma trafiać do autora artykułów (0-100%)</b></label><br>
  <input type="text" class="w3-input w3-border w3-light-grey"  name="percent" style="width:500px;" value="'.$info['article_salary_user'].'"><br><br>

      <label class="w3-text-teal"><b>Zmień zarządce organizacji</b></label><br>
        <div class="autocomplete" method="post" style="width:500px; ">
  <input class="w3-input w3-border w3-light-grey" id="myInput" type="text" style="width: 500px" name="to_id" value="'.$info['leader_id'].'"><br>
  </div>
  ';





  echo'<p> </p>
  <button class="w3-btn w3-blue-grey">Dokonaj edycji</button>

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
