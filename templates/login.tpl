<!DOCTYPE html>
<html>
<head>
    <title>{$titulo}</title>
    <meta charset='utf-8'> 
    <link href="/css/general.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        h1 {
            text-align: center;
        }
        #login {
            background-color: #F4F4F4;
            border: 1px solid #CCCCCC;
            border-radius: 10px;
            padding: 10px;
            margin: 0 auto;
            width: 340px;
        }
        #login fieldset {
            border: 0 none;
            width: auto;
        }
        #login label {
            display: block;
            clear: left;
            float: left;
            margin: 5px 15px 16px 0;
        }
        #login input {
            clear: right;
            float: right;
        }
        #login button {
            clear: right;
            float: right;
            margin-top: 16px;
        }
    </style>
</head>
<body>
<div id="contenedor">
    <div id="cabecera">
        <h1>{$titulo}</h1>
    </div>
    <div id="login">
        <form id="form-login" action="{$action}" method="post" autocomplete="off" >
            <fieldset>
                <label for="usuario">Usuario:</label>
                <input name="usuario" id="usuario" type="text" placeholder="Usuario" title="Introduzca su nombre de usuario" autofocus />
                <label for="contrasena">Contrase&ntilde;a:</label>
                <input name="contrasena" id="contrasena" type="password" placeholder="Contrase&ntilde;a" title="Introduzca su contrase&ntilde;a" />
                <button name="" id="" value="">Enviar</button>
            </fieldset>
        </form>
    </div>
    <div style="width: 62px; margin: 0px auto;"><a href="index.php">index.php</a></div>
</div>
</body>
</html>