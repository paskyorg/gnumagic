<?php

/* Inicio de sesión */
session_start(); 

/* Si no existe la variable de sesión, redirige a login.php */
if (!isset($_SESSION['usuario']['id_usu'])) {
    header('Location: ../login.php');
    exit;
}

/*Comentamos este bloque porque es para búsquedas simples 

 //array to translate the search type
 $ops = array(
    'eq'=>'=', //equal
    'ne'=>'<>',//not equal
    'lt'=>'<', //less than
    'le'=>'<=',//less than or equal
    'gt'=>'>', //greater than
    'ge'=>'>=',//greater than or equal
    'bw'=>'LIKE', //begins with
    'bn'=>'NOT LIKE', //doesn't begin with
    'in'=>'LIKE', //is in
    'ni'=>'NOT LIKE', //is not in
    'ew'=>'LIKE', //ends with
    'en'=>'NOT LIKE', //doesn't end with
    'cn'=>'LIKE', // contains
    'nc'=>'NOT LIKE'  //doesn't contain
);
function getWhereClause($col, $oper, $val){
    global $ops;
    if($oper == 'bw' || $oper == 'bn') $val .= '%';
    if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
    if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
    return " AND $col {$ops[$oper]} '$val' ";
}
$where = ""; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
    $where = getWhereClause($searchField,$searchOper,$searchString);
}
*/

/* Comprobamos si es una petición de un técnico */
$tecnico = FALSE;
if (isset($_GET['tecnico']) && isset($_SESSION['usuario']['id_tec'])) {
    $tecnico = TRUE;
} 

/* Obtenemos el resto de variables */
$id_inc = isset($_GET['id_inc']) ? $_GET['id_inc'] : false;
$id_est = isset($_GET['id_est']) ? $_GET['id_est'] : false;
//$estado = isset($_GET['estado']) ? $_GET['estado'] : false;
$id_cat = isset($_GET['id_cat']) ? $_GET['id_cat'] : false;
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : false;
$desc_incidencia = isset($_GET['desc_incidencia']) ? $_GET['desc_incidencia'] : false;
$observaciones = isset($_GET['observaciones']) ? $_GET['observaciones'] : false;
$fecha_apertura = isset($_GET['fecha_apertura']) ? $_GET['fecha_apertura'] : false;
$fecha_cierre = isset($_GET['fecha_cierre']) ? $_GET['fecha_cierre'] : false;

$where = "";

if ($_GET['_search'] == 'true') {
    if ($id_inc) {
        //Si queremos buscar una incidencia exacta
        //$where .= " AND i.id_inc = '" . $id_inc . "'";
        //Si queremos buscar una incidencia que contenga la búsqueda
        $where .= " AND i.id_inc LIKE '%" . $id_inc . "%'";
    }
    if ($id_est) {
        $where .= " AND e.id_est = '" . $id_est . "'";
    }
//    if ($estado) {
//        $where .= " AND e.estado = '" . $estado . "'";
//    }
    if ($id_cat) {
        $where .= " AND c.id_cat = '" . $id_cat . "'";
    }
    if ($usuario) {
        $where .= " AND u.usuario LIKE '%" . $usuario . "%'";
    }
    if ($desc_incidencia) {
        $where .= " AND i.desc_incidencia LIKE '%" . $desc_incidencia . "%'";
    }
    if ($observaciones) {
        $where .= " AND i.observaciones LIKE '%" . $observaciones . "%'";
    }
    if ($fecha_apertura) {
        $where .= " AND DATE_FORMAT(i.fecha_apertura, '%d-%m-%Y') = '" . $fecha_apertura . "'";
    }
    if ($fecha_cierre) {
        $where .= " AND DATE_FORMAT(i.fecha_cierre, '%d-%m-%Y') = '" . $fecha_cierre . "'";
    }
}


$page = $_GET['page'];// get the requested page 
$limit = $_GET['rows']; // get how many rows we want to have into the grid 
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx = 1;

include('funciones.php');

$id_usu  = $_SESSION['usuario']['id_usu'];
$count = getIncidenciasAbiertasUsuarioCount($id_usu);
$count = $count['count'];


if ($count > 0) { 
    $total_pages = ceil($count/$limit);
} else { 
    $total_pages = 0;
}

if ($page > $total_pages) $page = $total_pages;

//$start = $limit*$page - $limit; // do not put $limit*($page - 1)
if (($start = $limit*$page - $limit) < 0) {
    $start = 0;
}

if ($tecnico) {
    $sql = "SELECT * FROM categorias AS c, estados AS e, incidencias AS i, usuarios AS u " .
       "WHERE c.id_cat = i.id_cat AND e.id_est = i.id_est AND i.id_usu = u.id_usu " . $where .
       "ORDER BY $sidx $sord LIMIT $start, $limit";
} else {
    $sql = "SELECT *, (SELECT COUNT(*) FROM archivos AS a WHERE a.id_inc = i.id_inc) archivos " .
       "FROM categorias AS c, estados AS e, incidencias AS i " .
       "WHERE c.id_cat = i.id_cat AND e.id_est = i.id_est " .
       "AND id_usu = '" . $id_usu . "' " . $where . " ORDER BY $sidx $sord LIMIT $start, $limit";
}

$result = consulta($sql); //var_dump($result);

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

if ($result) {
    foreach ($result as $key => $value) {
        $responce->rows[$key]['id'] = $value['id_inc'];
        if ($tecnico) {
            $responce->rows[$key]['cell'] = array(
                $value['id_inc'],
                $value['estado'],
                $value['categoria'],
                $value['usuario'],
                $value['desc_incidencia'],
                $value['observaciones'],
                $value['fecha_apertura']
            );
        } else {
            $responce->rows[$key]['cell'] = array(
                $value['id_inc'],
                $value['estado'],
                $value['categoria'],
                $value['desc_incidencia'],
                $value['observaciones'],
                $value['fecha_apertura']
            );
        }
    }
}

echo json_encode($responce);

?>
