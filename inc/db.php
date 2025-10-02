<?php
$DB_HOST='localhost'; $DB_NAME='rki_company'; $DB_USER='root'; $DB_PASS='';
try{$pdo=new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",$DB_USER,$DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);}
catch(Exception $e){exit('DB error: '.$e->getMessage());}
function is_logged_in(){session_start();return isset($_SESSION['admin_id']);}
