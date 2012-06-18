	<div id="principal">
            <div id="datos_usuario" class="radius">
                <div class="row">
                    <div><span class="cell">Usuario:</span> {$usuario.usuario}</div>
                    <div><span class="cell">Nombre:</span> {$usuario.nombre}</div>
                    <div><span class="cell">Apellidos:</span> {$usuario.apellidos}</div>
                </div>
                <div class="row">
                    <div><span class="cell">&nbsp;</span> &nbsp;</div>
                    <div><span class="cell">Tel&eacute;fono:</span> {$usuario.telefono}</div>
                    <div><span class="cell">Correo:</span> {$usuario.correo}</div>
                </div>
                <div class="row">
                    <div><span class="cell">&nbsp;</span> &nbsp;</div>
                    <div><span class="cell">Servicio:</span> {$usuario.servicio}</div>
                    <div><span class="cell">Departamento:</span> {$usuario.departamento}</div>
                </div>
            </div>
            <table id="tabla_incidencias"></table>
            <div id="paginacion"></div>
	</div>