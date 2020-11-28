

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
  <h2><br>Wystaw działkę na sprzedaż</h2>
</div>';

if (isset($_POST['name']) AND is_numeric($_POST['name'])) {

    $plot = new Plot($id);
    $plot->setPrice($_POST['name']);


} else {
    $acc_info = Bank::account_info($info['main_bank_acc']);
    echo '<center><form class="w3-container" method="post">

  <label class="w3-text-teal"><b>Podaj cene sprzedaży </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 60%" name="name" value="'.$info['name'].'"><br>
  

  ';





    echo'<p> </p>
  <button class="w3-btn w3-blue-grey">Wystaw na sprzedaż</button>

</form>';
}
echo '</div></div>';

?>

