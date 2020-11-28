<?php

if (isset($_GET['page'])) {
    $page = 'page/' . $_GET['page'] . '.php';
    if (file_exists($page)) include $page; else require 'page/error_no_page.php';
} else {
    require_once 'page/home.php';
  }

?>
