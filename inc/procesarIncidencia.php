<?php

/* Inicio de sesión */
session_start();

var_dump($_SESSION);
var_dump($_POST);


/* Si no existe la variable de sesión, redirige a login.php */
if (!isset($_SESSION['usuario']['id_usu'])){
    header('Location: login.php');
    exit;
}

/* Includes */
include('funciones.php');

/* Técnico (TRUE) o Usuario (FALSE) */
$esTecnico = (isset($_GET['tecnico']) && isset($_SESSION['usuario']['id_tec'])); 


/* Obtenemos las variables POST */
$desc_incidencia = isset($_POST['desc_incidencia']) ? $_POST['desc_incidencia'] : false;
$id_cat = isset($_POST['id_cat']) ? $_POST['id_cat'] : false;
$id_est = isset($_POST['id_est']) ? $_POST['id_est'] : false;
$id_inc = isset($_POST['id']) ? $_POST['id'] : false;
$id_tec = isset($_POST['id_tec']) ? $_POST['id_tec'] : false;
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : false;
$oper = isset($_POST['oper']) ? $_POST['oper'] : false;
$usuario = isset($_POST['usuario']) ? getUsuario($_POST['usuario']) : false;

// Si es técnico se toma el id del usuario recibido por parámetro POST,
// en caso contrario se toma el id del usuario activo que pone la incidencia.
$id_usu = $esTecnico ? $usuario['id_usu'] : $_SESSION['usuario']['id_usu'];


// Si la operación es add, añadimos la incidencia
if (($oper == 'add') && $id_cat && $desc_incidencia) {
    $id_inc = addIncidencia($id_usu, $id_cat, $desc_incidencia);
}

// Si la operación es edit y esTecnico, actualizamos la incidencia
else if ($oper == 'edit' && $esTecnico) {
    updateIncidencia($id_inc, $id_tec, $id_usu, $id_est, $id_cat, $desc_incidencia, $observaciones);
}

exit; /* Finalizamos el código aquí

/* Variables auxiliares */
$nueva = FALSE;
$id_usu = $_SESSION['usuario']['id_usu'];
if (isset($_SESSION['incidencia']['id_inc'])) {
    $id_inc = $_SESSION['incidencia']['id_inc'];
}

/* Si es una incidencia nueva */
if (isset($_POST['categoria']) && isset($_POST['desc_incidencia'])) {
    $id_cat = $_POST['categoria'];
    $desc_incidencia = $_POST['desc_incidencia'];
    $id_inc = addIncidencia($id_usu, $id_cat, $desc_incidencia);
    $nueva = TRUE;
}
/* Si es un comentario */
if (isset($_POST['comentario']) && isset($id_inc)) {
    $comentario = $_POST['comentario'];
    addComentario($id_inc, $id_usu, $comentario);
}
/* Si se sube archivo */    
if (isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    /* Si el archivo subido tiene tamaño 0, se crea un nuevo tipo de error 5 */
    if ($archivo['error'] == 0 && $archivo['size'] == 0) { /* Sin error y tamaño 0 */
        $archivo['error'] = 5;
    }
    /* Si no hay errores */
    if ($archivo['error'] == 0) {
        /* Procesamos el archivo */
        $uploaddir = 'archivos/';
        $timestamp = $_SERVER['REQUEST_TIME'];
        $md5 = md5_file($archivo['tmp_name']);
        $diskfile = $uploaddir . $timestamp . "-" . $md5; /* Nombre de fichero: timestamp-md5 */
        $filename = $archivo['name'];
        $filetype = $archivo['type'];
        $filesize = $archivo['size'];
        move_uploaded_file($archivo['tmp_name'], $diskfile);
    }
    /* Creamos variables de sesión de los errores producidos en la subida */
    $_SESSION['error'] = array(
        'errno' => $archivo['error'],
        'error' => "Error subiendo el archivo. http://es2.php.net/manual/es/features.file-upload.errors.php"
    );
    /* Si se ha producido algún error, redirigimos a error.php */
        if ($archivo['error'] != 0 && $archivo['error'] != 4) {
        header('Location: error.php');
    }
    /* Si error = 0, añadimos el archivo */
    if ($archivo['error'] == 0) {
        addArchivo($id_inc, $diskfile, $filename, $filetype, $filesize);
    }
}

if ($nueva) { /* Si la incidencia es nueva, se redirige a incidencas.php */
    header('refresh:2;url=inicio.php');
    echo "Se ha creado su incidencia con ID ".$id_inc.".<br />".
         "Compruebe que ésta aparece en su listado de incidencias.<br />".
         "Gracias.";
} else { /* Si la incidencia no es nueva, se redirige a la misma página */
    header('Location: incidencia.php?id_inc='.$id_inc);
}


/* Mensajes de error:
 *   0 UPLOAD_ERR_OK: No hay error, archivo con éxito.
 *   1 UPLOAD_ERR_INI_SIZE: El archivo subido excede la directiva upload_max_filesize en php.ini.
 *   2 UPLOAD_ERR_FORM_SIZE: El archivo subido excede la directiva MAX_FILE_SIZE que fue especificada en el formulario HTML.
 *   3 UPLOAD_ERR_PARTIAL: El archivo subido fue sólo parcialmente cargado.
 *   4 UPLOAD_ERR_NO_FILE: Ningún archivo fue subido.
 *   5 UPLOAD_ERR_FILE_ZERO: El archivo subido tiene tamaño 0 bytes.
 *   6 UPLOAD_ERR_NO_TMP_DIR: Falta la carpeta temporal.
 *   7 UPLOAD_ERR_CANT_WRITE: No se pudo escribir el archivo en el disco.
 *   8 UPLOAD_ERR_EXTENSION: Una extensión de PHP detuvo la carga de archivos.
 */

?>