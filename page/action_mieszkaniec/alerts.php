<style>
    a {
        text-decoration: none;
        color: #1d4e85;
    }
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
  <h2><br>Powiadomienia</h2>
</div>';



echo '<table width="60%" align="center">';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_alerts` WHERE user_id = '$_COOKIE[id]' ORDER BY `data` DESC LIMIT 0,30";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $b_s = ($row['read']=='0')? '<b>' : '';
    $b_e = ($row['read']=='0')? '</b>' : '';
    echo ' <tr>
        <td width="70%" align="left" style="border-bottom-width:1px; border-bottom-style:solid;">'.$b_s.'  '.$row['title'].' '.$b_e.'</td>
        <td width="30%" style="border-bottom-width:1px; border-bottom-style:solid;">'.timeToDateTime($row['data']).'</td>
    </tr>';
    update('up_alerts','id', $row['id'],'`read`','1');
}
echo '</table><hr>';

echo '</div></div>';
