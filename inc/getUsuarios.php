<?php

/* Inicio de sesión */
session_start(); 

/* Si no existe la variable de sesión, redirige a login.php */
if (!isset($_SESSION['usuario']['id_usu'])) {
    header('Location: ../login.php');
    exit;
}

/* Includes */
include('funciones.php');


if (isset($_GET['term'])) {
    $usuarios = getUsuarios($_GET['term']);
    foreach ($usuarios as $usuario) {
        $res[] = $usuario['usuario'];
    }
    
    echo json_encode($res);
}

?>
