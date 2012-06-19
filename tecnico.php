<?php

/* Inicio de sesión */
session_start(); //var_dump($_SESSION);

/* Si no existe la variable de sesión, redirige a login.php */
if (!isset($_SESSION['usuario']['id_tec'])) {
    header('Location: login.php');
}

/* Includes */
require('inc/MySmarty.php');
include('inc/funciones.php');


/* Obtenemos las categorías y estados, para pasarlas a json  */
$categorias = getCategorias();
$arrCategorias = "0:;";
$sep = "";
foreach ($categorias as $categoria) {
    $arrCategorias .= $sep . $categoria['id_cat']. ":" . $categoria['categoria'];
    $sep = ";";
}

$estados = getEstados(); //var_dump($temp_estados);
$arrEstados = "0:;";
$sep = "";
foreach ($estados as $estado) {
    //$arrEstados .= $sep . $estado['id_est'] . ":" . $estado['estado'];
    $arrEstados .= $sep . $estado['id_est'] . ":" . $estado['estado'];
    $sep = ";";
}


/* Smarty */
$smarty = new MySmarty();
$smarty->assign('titulo', 'Gnu Magic - Incidencias');
$smarty->assign('cssfile', 'css/general.css');
$smarty->assign('m_buscar', TRUE);
$smarty->assign('principal', 'tecnico.tpl');
$smarty->assign('usuario', $_SESSION['usuario']);
$smarty->assign('varjs', TRUE);
$smarty->assign('estados', $arrEstados);
$smarty->assign('categorias', $arrCategorias);
$smarty->assign('grid', 'js/gridtecnico.js');
$smarty->display('plantilla.tpl');

?>