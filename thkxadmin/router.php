<?php

if (isset($_GET['page']) AND $_GET['page']!='thkxadmin') {
    $page = 'page/' . $_GET['page'] . '.php';
    if (file_exists($page)) include $page; else require 'page/error_no_page.php';
} else {
    require_once 'page/stats.php';
}




?>


