$(document).ready(function () {

    //Declaramos la variable rowid para evitar que dé un warning más adelante.
    var rowid;
    //Variable que tomamos del DIV #js_estados. Contiene los estados en formato:
    //0:;1:nueva;2:cerrada
    var usuario = $("#js_usuario").html();
    var estados = $("#js_estados").html();
    var categorias = $("#js_categorias").html();
    
    //Definimos el GRID
    jQuery("#tabla_incidencias").jqGrid({
        url:'inc/getIncidencias.php',
        datatype: "json", 
        colNames:['ID','Estado','Categoría','Descripción','Observaciones','Fecha Apertura','Fecha Cierre'], 
        colModel:[ 
            {name:'id', index:'id_inc', width:50, editable:false,
                editoptions: { }
            }, 
            {name:'id_est', index:'id_est', width:70, editable:false,
                stype:'select', searchoptions: {value: estados},
                edittype:'text',
                editoptions: { }
            },
            {name:'id_cat', index:'id_cat', width:70, editable:true,
                stype:'select', searchoptions: {value: categorias},
                edittype:'select',
                editoptions: {value: categorias}
            },
            {name:'desc_incidencia', index:'desc_incidencia',
                editable:true, sortable:false, edittype:'textarea',
                editoptions: {rows:'7', cols:'50'}
            }, 
            {name:'observaciones', index:'observaciones',
                editable:false, sortable:false, edittype:'textarea',
                editoptions: {rows:'7', cols:'50'}
            }, 
            {name:'fecha_apertura', index:'fecha_apertura', width:150,
                align:'right', searchoptions: { /* http://stackoverflow.com/a/1186727/1390555 */
                    dataInit: function(el){
                        $(el).datepicker({
                            dateFormat: "dd-mm-yy",
                            maxDate: "+0",
                            onSelect: function(dateText, inst){
                                $("#tabla_incidencias")[0].triggerToolbar();
                            }
                        })
                    }
                }, editable:true, editoptions: {readonly:true,
                    defaultValue: $.datepicker.formatDate("dd-mm-yy", new Date())}
            },
            {name:'fecha_cierre', index:'fecha_cierre', width:150, align:'right',
                searchoptions: {
                    dataInit: function(el){
                        $(el).datepicker({
                            dateFormat: "dd-mm-yy",
                            maxDate: "+0",
                            onSelect: function(dateText, inst){
                                $("#tabla_incidencias")[0].triggerToolbar();
                            }
                        })
                    }
                }, editable:false, editoptions: {readonly:true}
            },

        ],
        altRows: true,
        autowidth: true,
        forceFit:true,
        caption: 'Incidencias - ' + usuario,
        cellEdit: false, //Desactiva la opción de editar una celda cuando se selecciona
        height: '100%',
        rowNum: 10,
        rowList:[10,20,50], 
        pager: '#paginacion',     //No es necesario si se usa toppager
        rownumbers: true,   //Muestra la numeración de filas
        sortname: 'id_inc', 
        sortorder: 'desc', 
        emptyrecords: 'No tiene incidencias.',
        //gridview: true, //Hay que quitarlo para que funcione el afterInsertRow
        scrollOffset:0,
        toppager:true,   //Muestra el paginador en la parte de arriba
        viewrecords: true,
        
        //Esta función se ejecuta cuando el grid se ha cargado.
        loadComplete : function () {
            //Se comenta porque se fuerza mediante CSS en general.css:
            // --> .ui-jqgrid tr.jqgrow td { white-space: nowrap !important; }
            //Cambiamos el CSS white-space a nowrap para que se vea mejor el grid.
            //$(".ui-jqgrid tr.jqgrow td").css("white-space", "nowrap");
        },
        //Este método 'ondblClickRow': http://stackoverflow.com/a/4983690
        ondblClickRow: function(rowid) {
            jQuery(this).jqGrid('viewGridRow', rowid, {
            //jQuery(this).jqGrid('editGridRow', rowid, {
                //drag:true,
                navkeys: [true,37,39],
                width:500,
                //top:10,
                //left:10,
                closeOnEscape:true,
                viewPagerButtons:true //Botones Anterior - Siguiente Registro
            });
            //Navegamos en la consulta de registros con las teclas de cursor
            /* $(document).keypress(function(e) {
                if (e.keyCode == 39 || e.keyCode == 40) { //39 right, 40 down
                    $('#nData').click();    //Siguiente registro
                } else if (e.keyCode == 37 || e.keyCode == 38) { //37 left, 38 up
                    $('#pData').click();    //Anterior registro
                }
            }); */
            //Eliminamos los espacios en blanco &nbsp; en los TD
            $(".DataTD").each(function(index) {
                var $this = $(this);
                $this.html($this.html().replace(/&nbsp;<span/g, '<span'));
                //alert(index + ': ' + $(this).html() + ': ' + $(this).html().length );
            });

            //Se comenta porque se fuerza mediante CSS en general.css:
            //Mejoras CSS
            /*$(".ui-jqdialog-content .form-view-label").css("vertical-align", "top");
            $(".ui-jqdialog-content .form-view-data").css("white-space", "pre-line");
            $(".ui-jqdialog-content .form-view-data").css("border", "1px solid #A6C9E2");
            $(".ui-jqdialog-content .form-view-data").css("border-radius", "5px");
            $(".ui-jqdialog-content .form-view-data").css("padding", "5px");*/
        },

        afterInsertRow: function(rowid, aData){
            var cssnueva   = {
                'background':'#ffa0a0',
                'opacity':1
            };
            var cssabierta = {
                'background':'#c8c8ff',
                'opacity':1
            };
            var csscerrada = {
                'background-color':'#e8e8e8',
                'opacity':1
            }
            switch (aData.id_est) {
                case 'nueva':
                    //jQuery("#tabla_incidencias").jqGrid('setCell',rowid,'id','',{ color:'green' });
                    jQuery("#tabla_incidencias").jqGrid('setRowData',rowid,'',cssnueva);
                    break;
                case 'abierta':
                    //jQuery("#tabla_incidencias").jqGrid('setCell',rowid,'id','',cssabierta);
                    jQuery("#tabla_incidencias").jqGrid('setRowData',rowid,'',cssabierta);
                    break;
                case 'cerrada':
                    jQuery("#tabla_incidencias").jqGrid('setCell',rowid,'id','',csscerrada);
                    break;
            }
        }
    });

    //Barra de filtro
    jQuery("#tabla_incidencias").jqGrid('filterToolbar');


    /* INFO:
            http://www.trirand.com/blog/?page_id=393/help/positioning-navigator-pager-on-top-of-grid/
            http://stackoverflow.com/a/4402903
            http://stackoverflow.com/a/3557663 -> Añadir botones diferentes al top toolbar
            Da info sobre cómo usar el toppager, mostrar botones en él y clonarlo.
            Se pueden tener dos paginadores. */
    jQuery("#tabla_incidencias").jqGrid('navGrid','#paginacion', 
        {edit:false, //Botón Editar
            add:true, //Botón Añadir
            del:false, //Botón Borrar
            search:false, //Botón Buscar
            view:true, //Botón Ver
            cloneToTop:true}, //Parámetros
        { /* closeOnEscape:true, bottominfo:'Fields marked with (*) are required' */ }, //prmEdit
        {   //prmAdd
            addCaption: 'Nueva Incidencia',
            bottominfo:'Aquí el bottominfo 1', //Texto abajo
            checkOnUpdate:true, //Comprueba si se han realizado cambios
            closeAfterAdd:true, //Cierra después de añadir registro
            closeOnEscape:true, //Cerrar pulsando Esc
            url:'inc/procesarIncidencia.php', //URL para guardar la incidencia
            topinfo:'Aquí el topinfo 1', //Texto arriba
            width:'auto', //Ancho automático
            postData: {archivo:"archivo"},
            recreateForm: true,
            beforeShowForm: function (form) {
                var temp = $("#tr_fecha_cierre");
                temp.hide();
                $('<tr id="tr_archivos" class="FormData"><td class="CaptionTD">Archivos...</td><td class="DataTD">&nbsp;</td></tr>').insertAfter(temp);
                $('<tr id="tr_archivo" class="FormData"><td class="CaptionTD">Archivo</td><td class="DataTD"><form>&nbsp;<input id="archivo" type="file" name="archivo[]" data-url="pruebas/jQuery-File-Upload/server/php/" multiple></form></td></tr>').insertAfter(temp);
                var temp = $("#tr_archivos .DataTD");
                $(function () {
                    $('#archivo').fileupload({
                        dataType: 'json',
                        done: function (e, data) {
                            $.each(data.result, function (index, file) {
                                temp.append("<div />");
                                var tdiv = $("#tr_archivos .DataTD div").last();
                                tdiv.append('<div class="my-ui-icon-trash" data-type="' + file.delete_type + '" data-url="' + file.delete_url + '"></span>');
                                tdiv.append('<div class="my-file">' + file.name + '<br />(' + file.size + ' bytes)</div>');
                            });
                        }
                    });
                });
            }
            //El contenido de editData se envía por POST
            /*editData: {
                someStaticParameter: "Bla Bla",
                myDynamicParameter: function() {
                    return (new Date()).toString();
                }
            } */
        }, 
        {}, //prmDel
        {}, //prmSearch
        {   //prmView
            closeOnEscape:true,
            navkeys: [true,37,39],
            width:500,
            beforeShowForm: function (form) {
                $(".DataTD").each(function(index) {
                    var $this = $(this);
                    $this.html($this.html().replace(/&nbsp;<span/g, '<span'));
                    //alert(index + ': ' + $(this).html() + ': ' + $(this).html().length );
                });
            }
        }
    );

    //Botón Filtro - Toogle Toolbar
    jQuery("#tabla_incidencias").jqGrid('navButtonAdd','#paginacion',
    {
        caption:"Filtro",
        title:"Mostrar Filtro",
        buttonicon :'ui-icon-circle-zoomout',
        onClickButton:function(){
            var mygrid = $("#tabla_incidencias")
            mygrid[0].toggleToolbar()
        }
    }).jqGrid('navButtonAdd','#tabla_incidencias_toppager',
    {
        caption:"Filtro",
        title:"Mostrar Filtro",
        buttonicon :'ui-icon-circle-zoomout',
        onClickButton:function(){
            var mygrid = $("#tabla_incidencias")
            mygrid[0].toggleToolbar()
        }
    });
    

    //El botón Añadir Incidencia abre el formulario
    $('#nueva_incidencia').click(function() {
        jQuery("#tabla_incidencias").jqGrid('editGridRow', "new", {
            addCaption: 'Nueva Incidencia',
            addTitle: 'Crear nueva incidencia',
            bottominfo:'Aquí el bottominfo 2', //Texto abajo
            checkOnUpdate:true, //Comprueba si se han realizado cambios
            closeAfterAdd:true, //Cierra después de añadir registro
            closeOnEscape:true, //Cerrar pulsando Esc
            url:'inc/procesarIncidencia.php', //URL para guardar la incidencia
            topinfo:'Aquí el topinfo 2', //Texto arriba
            width:'auto', //Ancho automático
            postData: {archivo:"archivo"},
            recreateForm: true,
            beforeShowForm: function (form) {
                var temp = $("#tr_fecha_cierre");
                temp.hide();
                $('<tr id="tr_archivos" class="FormData"><td class="CaptionTD">Archivos...</td><td class="DataTD">&nbsp;</td></tr>').insertAfter(temp);
                $('<tr id="tr_archivo" class="FormData"><td class="CaptionTD">Archivo</td><td class="DataTD"><form>&nbsp;<input id="archivo" type="file" name="archivo[]" data-url="pruebas/jQuery-File-Upload/server/php/" multiple></form></td></tr>').insertAfter(temp);
                var temp = $("#tr_archivos .DataTD");
                $(function() {
                    $('#archivo').fileupload({
                        dataType: 'json',
                        done: function (e, data) {
                            $.each(data.result, function (index, file) {
                                temp.append("<div />");
                                var tdiv = $("#tr_archivos .DataTD div").last();
                                tdiv.append('<div class="my-ui-icon-trash" data-type="' + file.delete_type + '" data-url="' + file.delete_url + '"></span>');
                                tdiv.append('<div class="my-file">' + file.name + '<br />(' + file.size + ' bytes)</div>');
                            });
                        }
                    });
                });
            }
        });
    }).css('cursor','pointer');
    //Ponemos DatePicker a los campos de fecha:
    /*    $('#gs_fecha_apertura').datepicker({
        dateFormat: "dd-mm-yy",
        maxDate: "+0"
    });
    $('#gs_fecha_cierre').datepicker({
        dateFormat: "dd-mm-yy",
        maxDate: "+0"
    }); */
        
});

