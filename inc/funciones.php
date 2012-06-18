<?php

if (!defined('ACCESS')) {
    define('ACCESS','1');
}
include('inc/config.php');


/* Includes */
function conecta() {
    global $config;
    $host = $config['database']['host'];
    $user = $config['database']['user'];
    $pass = $config['database']['pass'];
    $db   = $config['database']['db'];
    $conexion = @new mysqli($host, $user, $pass, $db);
    /* Si existe algún error en la conexión, se crea variable de sesión para
     *  tratarlo con error.php */
    if ($conexion->connect_errno) { 
        $_SESSION['error'] = array(
            'errno' => $conexion->connect_errno,
            'error' => $conexion->connect_error
        );
        return FALSE;
    }
    $conexion->query("SET NAMES 'utf8';");
    return $conexion;
}

function consulta($sql) {
    if (!($conexion = conecta())) {
        return FALSE;
    }

    $resql = $conexion->query($sql);
    $conexion->close();

    $res = FALSE;
    while ($row = mysqli_fetch_assoc($resql)) {
        $res[] = $row;
    }
    return $res;
}

function getCategorias() {
    $conexion = conecta();
    if (!$conexion) {
        return FALSE;
    }
    
    $sql = "SELECT * FROM categorias";
    $resql = $conexion->query($sql);
    $conexion->close();
    
    while ($row = mysqli_fetch_assoc($resql)) {
        $res[] = $row;
    }
    return $res;
}

function getEstados() {
    $conexion = conecta();
    if (!$conexion) {
        return FALSE;
    }
    
    $sql = "SELECT * FROM estados";
    $resql = $conexion->query($sql);
    $conexion->close();
    
    while ($row = mysqli_fetch_assoc($resql)) {
        $res[] = $row;
    }
    return $res;
}

function getIncidenciasAbiertasUsuarioCount($id_usu) {
    $res = FALSE;
    $conexion = conecta();
    if (!$conexion) {
        return $res;
    }

    $sql = "SELECT COUNT(*) AS count ".
           "FROM categorias AS c, estados AS e, incidencias AS i ".
           "WHERE c.id_cat = i.id_cat " .
           "AND e.id_est = i.id_est " .
           "AND e.estado != 'cerrada' " .
           "AND id_usu = '" . $id_usu . "'";
    $resql = $conexion->query($sql);
    $conexion->close();

    while ($row = mysqli_fetch_assoc($resql)) {
        $res = $row;
    }
    return $res;
}

function getUsuario($usuario) {
    $res = FALSE;
    $conexion = conecta();
    if (!$conexion) {
        return $res;
    }

    $sql = "SELECT *, CONCAT(`nombre`, ' ', `apellidos`) AS fullname " .
            "FROM departamentos AS d, servicios AS s, usuarios AS u " .
            "WHERE d.id_ser = s.id_ser " .
            "AND d.id_dep = u.id_dep " .
            "AND u.usuario = '" . $usuario . "'";
    $resql = $conexion->query($sql);
    $conexion->close();
    
    while ($row = mysqli_fetch_assoc($resql)) {
        $res = $row;
    }
    return $res;
}

?>