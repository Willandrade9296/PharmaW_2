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


        if (!empty($_POST)) {
            $alert = "";
            $fecha_dia=$_POST['fecha_utilidad'];
           
            
        }
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
                                   <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_utilidad" class=" text-dark font-weight-bold">Fecha</label>
                                            <input id="fecha_utilidad" class="form-control" type="date" name="fecha_utilidad" >
                                        </div>
                                     </div>
                                     <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                        <label for="tipoFecha" class="text-dark font-weight-bold" >Tipo fecha</label>
                                                <select id="tipoFecha" class="form-control" name="tipoFecha" required>
                                                         <option value="D">Diario</option>
                                                         <option value="M">Mensual</option>
                                                         <option value="A">Anual</option>
                                                    
                                                </select>

                                         </div>
                                    </div>
                                </div>
                                   
                                <div class="row">
                                   <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                      <input type="submit" value="Consultar" class="btn btn-primary" id="btnConsultaU" />
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
                                        <?php
                                         
                                        ?>
                                        <div class="card-body">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label  class="text-dark " style="font-size:23px; font-weight:bold; margin-right:20px;">Fecha Seleccionada: </label>
                                                    <label  class="text-dark font-weight-bold" id="fecha_sel" name="fecha_sel" style="font-size:23px;"></label>
                                                    </div>
                                        </div>
                                        <?php
                                          
                                        ?>
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