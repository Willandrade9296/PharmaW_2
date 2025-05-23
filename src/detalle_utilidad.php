<?php

session_start();
include_once "includes/header.php";


if (!empty($_SESSION['idUser'])){  

  

    $id_user = $_SESSION['idUser'];
    $permiso = "detalle_utilidad";
    
    $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso' ");
    $existe = mysqli_fetch_all($sql);
    if (empty($existe) && $id_user != 1) {
       // header('Location: permisos.php');
       include "permisos.php";
       
    }else{ 


        

       
?>

<div class="row">
    <div class="col-lg-12">
                <div class="card">
                     <div class="card-header card-header-primary ">  
                             <h4 class="card-title">Detalle de Utilidad</h4>
                     </div>
                     <div class="card-body">
                     <form action="" method="post" autocomplete="off" id="formDU">
                                <div class="row">
                                   <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="panelDiaUtilidad">
                                        <div class="form-group">
                                            <label for="fecha_utilidad" class=" text-dark font-weight-bold">Fecha:</label>
                                            <input id="fecha_utilidad" class="form-control" type="date" name="fecha_utilidad" value="<?php echo date('Y-m-d',strtotime('-1 day')) ?>" />
                                        </div>
                                     </div>


                                     <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="panelMesUtilidad" style="display:none">
                                        <div class="form-group">
                                            <label for="mes_utilidad" class=" text-dark font-weight-bold">Mes:</label>
                                            <input id="mes_utilidad" class="form-control" type="number" min="1" max="12" name="mes_utilidad" value="<?php echo date("m") ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="mes_a_utilidad" class=" text-dark font-weight-bold">Año:</label>
                                            <input id="mes_a_utilidad" class="form-control" type="number"  min="2010" max="<?php echo date("Y") ?>" value="<?php echo date("Y") ?>" name="mes_a_utilidad" >
                                        </div>
                                     </div>

                                     <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="panelPorFechasUtilidad" style="display:none">
                                        
                                                    <div class="form-group">
                                                        <label for="fecha_utilidad_i" class=" text-dark font-weight-bold">Fecha Desde:</label>
                                                        <input id="fecha_utilidad_i" class="form-control" type="date" name="fecha_utilidad_i" value="<?php echo date('Y-m-d',strtotime('-1 day')) ?>" />
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fecha_utilidad_f" class=" text-dark font-weight-bold">Fecha Hasta:</label>
                                                        <input id="fecha_utilidad_f" class="form-control" type="date" name="fecha_utilidad_f" value="<?php echo date('Y-m-d',strtotime('14 day')) ?>" />
                                                    </div>

                                     </div>

                                     <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="panelAnoUtilidad" style="display:none">
                                        <div class="form-group">
                                            <label for="anio_utilidad" class=" text-dark font-weight-bold">Año:</label>
                                            <input id="anio_utilidad" class="form-control" type="number" min="2010" max="<?php echo date("Y") ?>" value="<?php echo date("Y") ?>" >
                                        </div>
                                     </div>




                                     <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group" >
                                        <label for="tipoFecha" class="text-dark font-weight-bold" >Tipo fecha</label>
                                                <select id="tipoFecha" class="form-control" name="tipoFecha" onchange="cambiarTipoFechaUti(event)" required>
                                                         <option value="D">Diario</option>
                                                         <option value="M">Mensual</option>
                                                         <option value="A">Anual</option>
                                                         <option value="T">Rango Fechas</option>
                                                    
                                                </select>

                                         </div>
                                    </div>
                                </div>
                                   
                                <div class="row">
                                   <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                      <button  class="btn btn-primary" id="btnConsultaU" onclick="listar_utilidad(event)" >Consultar</button>
                                    </div>
                            </div>
                         </form>
                    </div>
                   
                </div>
    </div>
 </div>

 <div class="row">
       <div class="col-lg-12">
            <div class="card">
                    
                                  <div id="panelDia" style="display:none;">
                                        
                                        <div class="card-body">
                                            <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label  class="text-dark " style="font-size:23px; font-weight:bold; margin-right:20px;">Fecha Seleccionada: </label>
                                                    <label  class="text-dark font-weight-bold" id="fecha_sel" name="fecha_sel" style="font-size:23px;"></label>
                                                    </div>
                                             </div>


                                           
                                        </div>
                                          


                                    </div>

                                    <div class="card-body">
    
                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                        <table class="table table-sm  table-bordered table-hover" id="tblUtilidad" style="width:100%;">
                                                                        <thead class="thead-light">
                                                                            <tr>
                                                                                <th><b>ID Venta</b></th>
                                                                                <th><b>Cod. Prod.</b></th>
                                                                                <th><b>Nombre Producto</b></th>
                                                                                <th><b>Cant.</b></th>
                                                                                <th><b>Precio C./u</b></th>
                                                                                <th><b>Precio PVP/u</b></th>
                                                                                <th><b>Precio IVA</b></th>
                                                                                <th><b>Descuento</b></th>
                                                                                <th><b>Total Costo</b></th>
                                                                                <th><b>Total PVP</b></th>
                                                                                <th><b>Utilidad</b></th>
                                                                                <th><b>Fecha Venta</b></th>
                                                                                <th><b>Usuario</b></th>
                                                                                <th><b>Cliente</b></th>
                                                                                <th><b>Transacción</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="detalleUtilidad">
                                                                        </tbody>
                                                                        <tfoot>
                                                                                <tr>
                                                                                    <th colspan="8" style="text-align:right">Totales:</th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    
                                                                                    <th></th>
                                                                                    <th colspan="4"></th>
                                                                                   
                                                                                </tr>
                                                                            </tfoot>

                                                                        </table>
                                                                        
                                                                </div>

                                                        </div>
                                            </div>
                                    
                            </div>
                     </div>
             </div>
    </div>
</div>
<script>

const nombre_archivo_salida="Detalle de insumos"
 // DETALLE UTILIDAD


          function addDays(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
          } 

        function formatoFecha(dateObject) {
            var d = new addDays(dateObject,1).toLocaleDateString();
          
            let date=d;
            return date;
        };

 /* SELECCIONANDO TIPO DE FECHA CONSULTA EN DETALLE DE UTILIDAD */

        function cambiarTipoFechaUti(e){
            e.preventDefault();

            
            if ($("#tipoFecha").val() === "D" ){ 
            $("#panelDiaUtilidad").css('display','initial'); 
            $("#panelMesUtilidad").css('display','none'); 
            $("#panelAnoUtilidad").css('display','none');
            
            $("#panelPorFechasUtilidad").css('display','none');
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';


            }else if($("#tipoFecha").val() === "M"){ 
            $("#panelDiaUtilidad").css('display','none'); 
            $("#panelMesUtilidad").css('display','initial'); 
            $("#panelAnoUtilidad").css('display','none');
             $("#panelPorFechasUtilidad").css('display','none');
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';


            

            }
            else if($("#tipoFecha").val() === "A"){ 
                $("#panelDiaUtilidad").css('display','none'); 
                $("#panelMesUtilidad").css('display','none'); 
                $("#panelAnoUtilidad").css('display','initial'); 
                 $("#panelPorFechasUtilidad").css('display','none');
                $('#tblUtilidad').DataTable().destroy();
                document.querySelector("#detalleUtilidad").innerHTML = '';
    
    
              
    
                }
                
                else if($("#tipoFecha").val() === "T"){ 
                $("#panelDiaUtilidad").css('display','none'); 
                $("#panelMesUtilidad").css('display','none'); 
                $("#panelAnoUtilidad").css('display','none'); 
                 $("#panelPorFechasUtilidad").css('display','initial');
                $('#tblUtilidad').DataTable().destroy();
                document.querySelector("#detalleUtilidad").innerHTML = '';
    
    
              
    
                }else{
            $("#panelDiaUtilidad").css('display','none'); 
            $("#panelMesUtilidad").css('display','none'); 
            $("#panelAnoUtilidad").css('display','none'); 
            $("#panelPorFechasUtilidad").css('display','none');
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';




            }



        }

    /* CONSULTA DE DETALLE DE UTILIDAD */
          $('#btnConsultaU').click(function (e) {
            e.preventDefault();
            var tipoFecha= $('#tipoFecha').val();

                    if(tipoFecha === 'D'){ 
                        
                        
                        if($('#tblUtilidad').DataTable().data().any()){ 

                        $('#tblUtilidad').DataTable().destroy();

                        }
                       
                        fecha_u = $("#fecha_utilidad").val();

                        


                    }else if(tipoFecha === 'M'){ 
                        
                        if($('#tblUtilidad').DataTable().data().any()){ 
                        $('#tblUtilidad').DataTable().destroy();

                        }
                       
                    }else if(tipoFecha === 'T'){ 
                        
                        if($('#tblUtilidad').DataTable().data().any()){ 
                        $('#tblUtilidad').DataTable().destroy();

                        }
                       
                    }
                    
                    
                    else{

                     //   $('#panelDia').css('display','none');
                        if($('#tblUtilidad').DataTable().data().any()){ 
                         $('#tblUtilidad').DataTable().destroy();

                        }
                       
                    }

          });




 /* LISTAR UTILIDAD  */

          function listar_utilidad(e) {

            
            e.preventDefault();
            let html = '';
            let fechaU = 'fechaUtilidad';
            let mesU ='mesUtilidad';
            let anioU ='anioUtilidad';
            let rangoU ='RangoFechasUtilidad';

            var tipoFecha= $('#tipoFecha').val();
            let fecha=  formatoFecha($('#fecha_utilidad').val());
         
            //alert(fecha);
            if(tipoFecha === 'D'){ 
             var nombreArchivo=nombre_archivo_salida+' '+fecha;
                //Reiniciar Datatable
            $('#tblUtilidad').DataTable().destroy();
            
           
           var table = $('#tblUtilidad').DataTable({
              

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                },
                
                dom: 'lBfrtip',
               
                    buttons: [
                        {
                            extend:'print',
                            text:"Imprimir",
                            title:nombreArchivo,
                            titleAttr:'Imprimir Detalle'
                        }, 
                        {
                            extend:'excelHtml5',
                            text:"Excel",
                            title:nombreArchivo,
                            titleAttr:'Exportar a Excel'
                        },
                        {
                            extend:'pdfHtml5',
                            text:"PDF",
                            title:nombreArchivo,
                            titleAttr:'Exportar en PDF'
                            }
                        ]
                      
                    ,
                    initComplete: function () {
                        var btns = $('.dt-button');
                        btns.addClass('btn btn-success btn-sm');
                        btns.removeClass('dt-button');

                    },

                "processing": true,


                "ajax": {
                  "url": 'ajax.php',
                  
                  "data": {
                    fechaUtilidad: fechaU,
                    fecha: fecha
                  },
                      dataSrc:""
                },
                
                "columns": [{
                    "data": "id_venta"
                  },
                  {
                    "data": "codproducto"
                  },
                  {
                    "data": "descripcion"
                  },
                  {
                    "data": "cantidad"
                  },
                  {
                    "data": "precio"
                  },
                  {
                    "data": "precioPVP"
                  },
                  {
                    "data": "iva"
                  },
                  {
                    "data": "totalDescuento"
                  },
                  {
                    "data": "totalCosto"
                  },
                  {
                    "data": "totalPVP"
                  },
                  {
                    "data": "utilidad"
                  },
                  {
                    "data": "fecha_venta"
                  },
                  {
                    "data": "nombre_usuario"
                  },
                  {
                    "data": "nombre_cliente"
                  }
                  ,
                  {
                    "data": "transaccion"
                  }
                ],
                footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
       
        /******************* TOTAL Costo */
        // Total over all pages
        total = api
            .column(8)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(8, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';


        /******************* TOTAL PVP */
        // Total over all pages
        total = api
            .column(9)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(9, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';


        /******************* TOTAL UTILIDAD */
        // Total over all pages
        total = api
            .column(10)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(10, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
    },
                
                
                "order": [
                  [0, "asc"]
                ]
              });
              
            }else if (tipoFecha === 'M'){ 
                $('#tblUtilidad').DataTable().destroy();
                        document.querySelector("#detalleUtilidad").innerHTML = ''; 


                        
                var mes=$('#mes_utilidad').val();
                var anio=$('#mes_a_utilidad').val();

                var nombreArchivo=nombre_archivo_salida+' mes '+mes+' '+anio;

                var table = $('#tblUtilidad').DataTable({
              

                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                    },
                    
                    dom: 'lBfrtip',
                   
                        buttons: [
                            {
                                extend:'print',
                                text:"Imprimir",
                                title:nombreArchivo,
                                titleAttr:'Imprimir Detalle'
                            }, 
                            {
                                extend:'excelHtml5',
                                text:"Excel",
                                title:nombreArchivo,
                                titleAttr:'Exportar a Excel'
                            },
                            {
                                extend:'pdfHtml5',
                                text:"PDF",
                                title:nombreArchivo,
                                titleAttr:'Exportar en PDF'
                                }
                            ]
                          
                        ,
                        initComplete: function () {
                            var btns = $('.dt-button');
                            btns.addClass('btn btn-success btn-sm');
                            btns.removeClass('dt-button');
    
                        },
    
                    "processing": true,
    
    
                    "ajax": {
                      "url": 'ajax.php',
                      
                      "data": {
                        mesUtilidad: mesU,
                        mes: mes,
                        anio:anio
                      },
                          dataSrc:""
                    },
                    
                    "columns": [{
                        "data": "id_venta"
                      },
                      {
                        "data": "codproducto"
                      },
                      {
                        "data": "descripcion"
                      },
                      {
                        "data": "cantidad"
                      },
                      {
                        "data": "precio"
                      },
                      {
                        "data": "precioPVP"
                      },
                      {
                        "data": "iva"
                      },
                      {
                        "data": "totalDescuento"
                      },
                      {
                        "data": "totalCosto"
                      },
                      {
                        "data": "totalPVP"
                      },
                      {
                        "data": "utilidad"
                      },
                      {
                        "data": "fecha_venta"
                      },
                      {
                        "data": "nombre_usuario"
                      },
                      {
                        "data": "nombre_cliente"
                      },
                      {
                        "data": "transaccion"
                      }
                    ],

                    footerCallback: function (row, data, start, end, display) {
                        let api = this.api();
                 
                        // Remove the formatting to get integer data for summation
                        let intVal = function (i) {
                            return typeof i === 'string'
                                ? i.replace(/[\$,]/g, '') * 1
                                : typeof i === 'number'
                                ? i
                                : 0;
                        };
                 
                       
                        /******************* TOTAL Costo */
                        // Total over all pages
                        total = api
                            .column(8)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(8, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                
                
                        /******************* TOTAL PVP */
                        // Total over all pages
                        total = api
                            .column(9)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(9, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2)+ ' <span style="color:red">( Total: $' + total.toFixed(2)  + ')</span>';
                
                
                        /******************* TOTAL UTILIDAD */
                        // Total over all pages
                        total = api
                            .column(10)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(10, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                    },
                    
                    
                    "order": [
                      [0, "asc"]
                    ]
                  });
                  



                }else if(tipoFecha === 'A'){

                    $('#tblUtilidad').DataTable().destroy();
                    document.querySelector("#detalleUtilidad").innerHTML = '';

                    var anio=$('#anio_utilidad').val();
                    var nombreArchivo=nombre_archivo_salida+' anual '+anio;
                    var table = $('#tblUtilidad').DataTable({
              

                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                        },
                        
                        dom: 'lBfrtip',
                       
                            buttons: [
                                {
                                    extend:'print',
                                    text:"Imprimir",
                                    title:nombreArchivo,
                                    titleAttr:'Imprimir Detalle'
                                }, 
                                {
                                    extend:'excelHtml5',
                                    text:"Excel",
                                    title:nombreArchivo,
                                    titleAttr:'Exportar a Excel'
                                },
                                {
                                    extend:'pdfHtml5',
                                    text:"PDF",
                                    title:nombreArchivo,
                                    titleAttr:'Exportar en PDF'
                                    }
                                ]
                              
                            ,
                            initComplete: function () {
                                var btns = $('.dt-button');
                                btns.addClass('btn btn-success btn-sm');
                                btns.removeClass('dt-button');
        
                            },
        
                        "processing": true,
        
        
                        "ajax": {
                          "url": 'ajax.php',
                          
                          "data": {
                            anioUtilidad: anioU,
                            
                            anio:anio
                          },
                              dataSrc:""
                        },
                        
                        "columns": [{
                            "data": "id_venta"
                          },
                          {
                            "data": "codproducto"
                          },
                          {
                            "data": "descripcion"
                          },
                          {
                            "data": "cantidad"
                          },
                          {
                            "data": "precio"
                          },
                          {
                            "data": "precioPVP"
                          },
                          {
                            "data": "iva"
                          },
                          {
                            "data": "totalDescuento"
                          },
                          {
                            "data": "totalCosto"
                          },
                          {
                            "data": "totalPVP"
                          },
                          {
                            "data": "utilidad"
                          },
                          {
                            "data": "fecha_venta"
                          },
                          {
                            "data": "nombre_usuario"
                          },
                          {
                            "data": "nombre_cliente"
                          },
                          {
                            "data": "transaccion"
                          }
                        ],
    
                        footerCallback: function (row, data, start, end, display) {
                            let api = this.api();
                     
                            // Remove the formatting to get integer data for summation
                            let intVal = function (i) {
                                return typeof i === 'string'
                                    ? i.replace(/[\$,]/g, '') * 1
                                    : typeof i === 'number'
                                    ? i
                                    : 0;
                            };
                     
                           
                            /******************* TOTAL Costo */
                            // Total over all pages
                            total = api
                                .column(8)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(8, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                    
                    
                            /******************* TOTAL PVP */
                            // Total over all pages
                            total = api
                                .column(9)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(9, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2)+ ' <span style="color:red">( Total: $' + total.toFixed(2)  + ')</span>';
                    
                    
                            /******************* TOTAL UTILIDAD */
                            // Total over all pages
                            total = api
                                .column(10)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(10, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                        },
                        
                        
                        "order": [
                          [0, "asc"]
                        ]
                      });

                
                }else if(tipoFecha === 'T'){

                    $('#tblUtilidad').DataTable().destroy();
                    document.querySelector("#detalleUtilidad").innerHTML = '';
                    var nombreArchivo=nombre_archivo_salida+' Rango Fechas';
                    
                    let fecha_i=  formatoFecha($('#fecha_utilidad_i').val());
                    let fecha_f=  formatoFecha($('#fecha_utilidad_f').val());


                    var table = $('#tblUtilidad').DataTable({
              

                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                    },
                    
                    dom: 'lBfrtip',
                   
                        buttons: [
                            {
                                extend:'print',
                                text:"Imprimir",
                                title:nombreArchivo,
                                titleAttr:'Imprimir Detalle'
                            }, 
                            {
                                extend:'excelHtml5',
                                text:"Excel",
                                title:nombreArchivo,
                                titleAttr:'Exportar a Excel'
                            },
                            {
                                extend:'pdfHtml5',
                                text:"PDF",
                                title:nombreArchivo,
                                titleAttr:'Exportar en PDF'
                                }
                            ]
                          
                        ,
                        initComplete: function () {
                            var btns = $('.dt-button');
                            btns.addClass('btn btn-success btn-sm');
                            btns.removeClass('dt-button');
    
                        },
    
                    "processing": true,
    
    
                    "ajax": {
                      "url": 'ajax.php',
                      
                      "data": {
                        RangoFechasUtilidad: rangoU,
                        fecha_i: fecha_i,
                        fecha_f: fecha_f
                      },
                          dataSrc:""
                    },
                    
                    "columns": [{
                        "data": "id_venta"
                      },
                      {
                        "data": "codproducto"
                      },
                      {
                        "data": "descripcion"
                      },
                      {
                        "data": "cantidad"
                      },
                      {
                        "data": "precio"
                      },
                      {
                        "data": "precioPVP"
                      },
                      {
                        "data": "iva"
                      },
                      {
                        "data": "totalDescuento"
                      },
                      {
                        "data": "totalCosto"
                      },
                      {
                        "data": "totalPVP"
                      },
                      {
                        "data": "utilidad"
                      },
                      {
                        "data": "fecha_venta"
                      },
                      {
                        "data": "nombre_usuario"
                      },
                      {
                        "data": "nombre_cliente"
                      },
                      {
                        "data": "transaccion"
                      }
                    ],

                    footerCallback: function (row, data, start, end, display) {
                        let api = this.api();
                 
                        // Remove the formatting to get integer data for summation
                        let intVal = function (i) {
                            return typeof i === 'string'
                                ? i.replace(/[\$,]/g, '') * 1
                                : typeof i === 'number'
                                ? i
                                : 0;
                        };
                 
                       
                        /******************* TOTAL Costo */
                        // Total over all pages
                        total = api
                            .column(8)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(8, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                
                
                        /******************* TOTAL PVP */
                        // Total over all pages
                        total = api
                            .column(9)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(9, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2)+ ' <span style="color:red">( Total: $' + total.toFixed(2)  + ')</span>';
                
                
                        /******************* TOTAL UTILIDAD */
                        // Total over all pages
                        total = api
                            .column(10)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(10, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                    },
                    
                    
                    "order": [
                      [0, "asc"]
                    ]
                  });








                }else{

                    $('#tblUtilidad').DataTable().destroy();
                    document.querySelector("#detalleUtilidad").innerHTML = '';

                 }
        }



</script>
 <?php
 }
}else{
    header("Location: ../index.php");
 } 
 ?>
 <?php include_once "includes/footer.php"; ?>