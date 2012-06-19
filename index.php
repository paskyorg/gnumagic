<?php

/* session */
session_start();

/* include */
include('inc/funciones.php');

/* Si no existe la variable 'REMOTE_USER', redirige a login.php */
if (!isset($_SERVER['REMOTE_USER'])) {
    header('Location: login.php');
    exit;
}

/* Comprobamos usuario */
$usuario = getUsuario($_SERVER['REMOTE_USER']);

/* Si existe algún error */
if (!$usuario) {
    header('Location: error.php');
    exit;
} else { /* Si existe el usuario, guardamos sus datos en $_SESSION */
    $_SESSION['usuario'] = $usuario; //var_dump($_SESSION);
    /* Si el usuario es técnico, obtenemos su id_tec y guardamos */
    if ($tecnico = getTecnicoByIdUsu($usuario['id_usu'])) {
        $_SESSION['usuario']['id_tec'] = $tecnico['id_tec'];
    }
    $nombre = $usuario['fullname'];
    header('refresh:1;url=inicio.php');
    echo "Bienvenido $nombre";
    exit;
}

?>