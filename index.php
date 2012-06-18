<?php

/* session */
session_start();

/* include */
include('inc/funciones.php');

/* Si no existe la variable 'REMOTE_USER', redirige a login.php */
if (!isset($_SERVER['REMOTE_USER'])) {
    header('Location: login.php');
}

/* Comprobamos usuario */
$usuario = getUsuario($_SERVER['REMOTE_USER']);

/* Si existe algún error */
if (!$usuario) {
    header('Location: error.php');
} else { /* Si existe el usuario, guardamos sus datos en $_SESSION */
    $_SESSION['usuario'] = $usuario; //var_dump($_SESSION);
    $nombre = $usuario['fullname'];
    header('refresh:1;url=inicio.php');
    echo "Bienvenido $nombre";
}

?>