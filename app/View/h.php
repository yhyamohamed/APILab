<?php
   require_once '../../vendor/autoload.php';
use App\MYSQLHandler;



$db = new MYSQLHandler();
$db->connect();
$singleRowData =  $db->get_record_by_id($_POST['num']);
header('Content-Type: application/json');
exit(json_encode($singleRowData));
// print_r($singleRowData) ;
