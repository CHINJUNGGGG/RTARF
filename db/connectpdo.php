<?php
$dsn = 'mysql:host=multiinnovation_db_1;dbname=rtarf';
$username = 'root';
$password = 'root';

// $dsn = 'mysql:host=localhost;dbname=rtarf';
// $username = 'rtarf';
// $password = '';

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
try {
    $db = new PDO($dsn, $username, $password, $options);
//echo 'ติดต่อฐานข้อมูลสำเร็จ';
} catch (Exception $e) {
//echo 'เชื่อมต่อไม่ได้'.$e->getMessage();
}
?>