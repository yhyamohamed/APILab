<?php
   require_once '../../vendor/autoload.php';
use App\MYSQLHandler;



$db = new MYSQLHandler();
$db->connect();
$singleRowData =  $db->search($_GET['word']);
header('Content-Type: application/json');
exit(json_encode($singleRowData));