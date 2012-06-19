<!DOCTYPE HTML>
<html>
<head>
    <title>{$titulo}</title>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="{$cssfile}" type="text/css" rel="stylesheet" />{* css/general.css *}
    <link type="text/css" href="/css/redmond/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
    <link type="text/css" href="/css/ui.jqgrid.css" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            /* font-size: 75%; */
        }
</style>
    <!-- <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> -->
    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
    <!-- <script type="text/javascript" src="js/jquery.autocomplete.js"></script> -->
    <!-- <script type="text/javascript" src="/js/jquery-ui-1.8.21.custom.min.js"></script> -->
    <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.js"></script>
    <script type="text/javascript" src="js/i18n/grid.locale-es.js"></script>
    <!-- <script type="text/javascript" src="/js/jquery.jqGrid.min.js"></script> -->
    <script type="text/javascript" src="js/jquery.jqGrid.src.js"></script>
    <!-- jQuery-File-Upload on -->
    <script src="js/jquery.iframe-transport.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <!-- jQuery-File-Upload off -->
    {if isset($grid)}
    <script type="text/javascript" src="{$grid}"></script>
    {/if}
</head>
<body>
<div id="contenedor">
    <div id="cabecera">
        <h1>{$titulo}</h1>
        {*<h3>Bienvenido {$usuario.fullname}</h3>*}
    </div>