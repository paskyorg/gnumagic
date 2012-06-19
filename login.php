<?php

/* Inicio de sesión */
session_start();

/* Eliminamos los datos de la sesión */
if (isset($_SESSION['usuario'])) {
    unset($_SESSION['usuario']);
}

/* Includes */
require('inc/MySmarty.php');
include('inc/funciones.php');

/* Si recibimos la variable $_POST del formulario */
if (isset($_POST['usuario'])) {
    
    /* Guardamos las variables */
    $usuario = getUsuario($_POST['usuario']);   //var_dump($usuario);
    $contrasena = $_POST['contrasena'];
    
    if (!$usuario) { /* Si no existe el usuario, recargamos la página */
        header('refresh: 5; url=' . $_SERVER['PHP_SELF']);
        echo "El usuario no existe."; /* Algún error al obtener el usuario */
            
    } else { /* Si es usuario */
        
        /* Validamos contra el Directorio Activo */
        /* Incluímos la clase adLDAP */
	include('inc/adldap/adLDAP.php' );

        /* Creamos objeto adLDAP */
	try {
            $adldap = new adLDAP();
	} catch (adLDAPException $e) {
            echo $e;
            exit;
	}
        /* Autenticamos */
	if ($adldap->authenticate($usuario['usuario'], $contrasena)) {
            /* Autenticación correcta */
            /* Guardamos información de usuario en variable SESSION */
            $_SESSION['usuario'] = $usuario;
            /* Si el usuario es técnico, obtenemos su id_tec y guardamos */
            if ($tecnico = getTecnicoByIdUsu($usuario['id_usu'])) {
                $_SESSION['usuario']['id_tec'] = $tecnico['id_tec'];
            }
            header('refresh: 2; url=inicio.php');
            echo "Contraseña Correcta. Ingresando en el sistema."; /* Autenticación correcta */
	} else {
            /* Autenticación incorrecta */
            header('refresh: 2; url=login.php');
            echo "Contraseña Incorrecta"; /* Autenticación incorrecta */
	}
    }
} else {
    /* Smarty */
    $smarty = new MySmarty();
    $smarty->assign('action', $_SERVER['PHP_SELF']);
    $smarty->assign('titulo', 'GnuMagic - Autenticaci&oacute;n');
    $smarty->display('login.tpl');
}

?>