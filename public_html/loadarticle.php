<?php
/**
 * Copyright (c) 2017 Netixy Development
 */
session_start();
include('core/functions.php');
include('core/ini.php');
include('core/feed-api.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
if(isset($_GET['feed'])) {
    loadArticles($_GET['feed'], $_SESSION['id']);
}
exit;
?>