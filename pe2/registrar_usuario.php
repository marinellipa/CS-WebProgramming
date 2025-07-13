<?php
require_once 'usuarios.class.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Usuarios::registrarUsuario($_POST);
}