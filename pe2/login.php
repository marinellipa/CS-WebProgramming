<?php
require_once 'usuarios.class.inc.php';

$username = $_POST['username'] ?? '';
$user_password = $_POST['password'] ?? '';

Usuarios::loginUsuario($username, $user_password);
?>