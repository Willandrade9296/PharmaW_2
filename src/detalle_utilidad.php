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
                                            <input id="fecha_utilidad" class="form-control" type="date" name="fecha_utilidad" >
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
                                                                                    <th colspan="7" style="text-align:right">Totales:</th>
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

 <?php
 }
}else{
    header("Location: ../index.php");
 } 
 ?>
 <?php include_once "includes/footer.php"; ?>