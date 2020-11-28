
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
  <h2><br>Wysyłanie wiadomości</h2>
</div>';

if (isset($_POST['text'])) {

    Create::Post($_COOKIE['id'],$id ,$_POST['title'],$_POST['text']);
    echo'<p>Wiadomość wysłana pomyślnie<hr></p>';

} else {
    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">

  <label class="w3-text-teal"><b>Tytuł wiadomości </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 500px" name="title"><br>
  
  <label class="w3-text-teal"><b>Treść wiadomości <br></b></label><br><centeR>
  <textarea id="myTextarea" style="width: 1000px"  name="text" class="w3-input w3-border w3-light-grey" rows="25" cols="100"></textarea><br>
    <p> </p>
  <button class="w3-btn w3-blue-grey">Wyślij</button>
</form>';
}
echo '</div></div>';
