
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

$law_info = System::getLaw($_GET['ods']);
$data_dot = date("Y-m-d",$law_info['date']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Edycja materiału prasowego</h2>
</div>';
if(isset($_GET['ods'])){
    $law_info_s = System::getMediaArcitleInfo($_GET['ods']);
    if($law_info_s['organizations_id']==$_GET['ptyp']){
        if (isset($_POST['title'])) {
            $text = $_POST['text'];
            echo'<p>Edytowano pomyślnie <Br><hr></p>';
            update('up_media_article','id',$_GET['ods'],'title',$_POST['title']);
            update('up_media_article','id',$_GET['ods'],'text',$_POST['text']);

        } else {
            $law_id_cat = System::getMediaArcitleInfo($_GET['ods']);

            echo '<form class="w3-container" method="post">

    <label class="w3-text-teal"><b>Tytuł</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 750px" name="title" value="'.$law_id_cat['title'].'"><br>
    
      <label class="w3-text-teal"><b>Treść</b></label><br>
  <textarea id="myTextarea" name="text" rows="44" cols="20"> '.$law_id_cat['text'].'</textarea><br>

  
  <button class="w3-btn w3-blue-grey">Edytuj</button><hr>'; ?>

            <?php echo'
</form>';
        }
    } else echo '<p>Brak uprawnien do edycji prawa innego kraju <hr></p>';
} else {
    echo '<form class="w3-container" method="post">
<br>
    <label class="w3-text-teal"><b>Wprowadz tytuł artykułu</b></label><br>
       <div class="autocomplete" method="post" style="width:550pxpx; ">
  <input class="w3-input w3-border w3-light-grey" id="myInput" type="text" style="width: 500px" name="id_art">   </div>
  <button class="w3-btn w3-blue-grey">Szukaj</button></form>';

    if(isset($_POST['id_art'])){
        $idz = explode("#", $_POST['id_art']);
        $to_id = $idz[0];
        if (!is_string($to_id)) $to_id = $idz[0]; else $to_id = $idz[1];
        $law_info_s = System::getMediaArcitleInfo($to_id);

        if($law_info_s['title']!='' AND $law_info_s['organizations_id']==$id) {
            echo '<a href="'._URL.'/profil/adm_media_edytuj/'.$id.'/'.$to_id.'" style="text-decoration: none; color: #1d4e85">'.$law_info_s['title'] . ' - kliknij by edytować</a>';
        } else if($law_info_s['title']!='' AND $law_info_s['organizations_id']!=$id) {
            echo '<b>Brak możliwości artykułu nie należącego do organizacji</b>';
        } else echo '<b>Nie znaleziono takiego materiału '.$to_id.'</b><hr>';
    }
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
        $sql = "SELECT * FROM `up_media_article` WHERE organizations_id = '$id'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo '"' . $row['title'] . ' #' . $row['id'] . '",';
        }



        ?>


    ];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), countries);
</script>
</html>