    <div id="menu">
        {if isset($m_buscar)}
        <div id="m_buscar">
            <input type="text" placeholder="Buscar..." name="buscar" id="buscar" />
            <script>$('#buscar').datepicker();</script>
            <input type="button" value="Buscar" />
        </div>
        {/if}
        <ul class="nav">
            <li><a href="inicio.php">Inicio</a></li>
            <li><a id="nueva_incidencia">A&ntilde;adir incidencia</a></li>
            <li><a href="desconectar.php">Desconectar</a></li>
        </ul>
    </div>

