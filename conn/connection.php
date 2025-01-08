<?php
$db_host = 'localhost';
$db_name = 'educacion';
$db_user = 'root';
$db_password = '';
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
$conexion = new mysqli($db_host, $db_user, $db_password, $db_name);
?>

