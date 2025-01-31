<?php
session_start();
include_once "includes/header.php";



function  precioFraccion($PprecioPVP,$numeroFracciones){
     
   
            if($numeroFracciones > 0){
            
                     return round(($PprecioPVP/$numeroFracciones),2);

            }else{

            return 0;

            }
    

}



 if (!empty($_SESSION['idUser'])){ 
    
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);

if (empty($existe) && $id_user != 1) {

   // header('Location: permisos.php');
   include "permisos.php";
}else{


if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $precioPVP=$_POST['precioPVP'];
    $cantidad = $_POST['cantidad'];
    $fraccion = $_POST['fraccion'];
    $precioFr= $_POST['PrecioFr'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $laboratorio = $_POST['laboratorio'];
    $grupoC= $_POST['grupoC'];
    $vencimiento = '';
    $precioIVA= $_POST['precioIva'];
    $iva=$_POST['iva'];
    $infor=$_POST['inform'];
   /* if (!empty($_POST['accion'])) {  */
        $vencimiento = $_POST['vencimiento'];
   //   }

    if (empty($codigo) || empty($producto) || empty($tipo) || empty($presentacion) || empty($laboratorio) || empty($grupoC)   || empty($precio) || $precio <  0  || empty($precioPVP) || $precioPVP <  0 || empty($cantidad) || $cantidad <  0 ||
    $tipo=="*" || $presentacion=="*" || $laboratorio=="*" ) {
     
                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
    } else {

        if(empty($precioFr)){
            $precioFr="0";
        }

        if (empty($iva)) {
            $iva="0";
        }

        $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codigo = '$codigo'");
        $result = mysqli_fetch_array($query);

        

        
        if (empty($id)) {
            

            if ($result > 0) {
              
                    $alert = mostrarMensaje('El codigo ya existe','w');
            } else {
               
                            if($presentacion == '4' ){ 
                                                   
                                                        $existencia_fr= $fraccion*$cantidad;
                                                      

                                        $precioCalcFr= precioFraccion($precioPVP,$fraccion);
                                        $precioCalcFr_C=precioFraccion($precio,$fraccion);
                                        if ($precioFr==0){

                                            $precioFr= precioFraccion($precioPVP,$fraccion);
                                            $precioFr_C=precioFraccion($precio,$fraccion);
                                        }
                            }else{
                                $existencia_fr="0";
                                $fraccion="0";
                                $precioFr="0";
                                $precioFr_C="0";
                                $precioCalcFr="0";
                                $precioCalcFr_C="0";

                            }

                $query_insert = mysqli_query($conexion, "INSERT INTO producto(codigo,descripcion,precio,precioIVA,precioPVP,existencia,fraccion,existencia_fr,precioFr,precioFr_o,precioFr_c,id_lab,id_presentacion,id_tipo, id_grupo, vencimiento,iva,info_prod) values ('$codigo', '$producto', $precio,$precioIVA,$precioPVP, $cantidad,$fraccion,$existencia_fr,$precioCalcFr,$precioFr,$precioFr_C, $laboratorio, $presentacion, $tipo, $grupoC , '$vencimiento',$iva,'$infor')");
                if ($query_insert) {
                 
                    $alert = mostrarMensaje('Producto registrado','i');
                } else {
                  
                     $alert = mostrarMensaje('Error al registrar el producto','e');
                }



            }
        } else {
            $cantidad_actual=$result["existencia"];
            $existencia_fr_actual=$result["existencia_fr"];

            if($presentacion == '4' ){ 


                            if ($existencia_fr_actual > 0){ 
                                

                                     if ( ($fraccion * $cantidad) >= $existencia_fr_actual)
                                     {

                                         $cantidad_temp= $cantidad - $cantidad_actual;

                                         $existencia_fr=$existencia_fr_actual + ($fraccion * $cantidad_temp) ;
                                         
                                     }
                                     else{
                                         
     

                                          $existencia_fr=$existencia_fr_actual - ($existencia_fr_actual - ($fraccion * $cantidad));


                                     } 





                            }else{
                                $existencia_fr= $fraccion*$cantidad;
                            } 


                            $precioCalcFr= precioFraccion($precioPVP,$fraccion,$precioFr);
                            $precioCalcFr_C=precioFraccion($precio,$fraccion);

                            if ($precioFr==0){

                                $precioFr= precioFraccion($precioPVP,$fraccion,$precioFr);
                                $precioFr_C=precioFraccion($precio,$fraccion);
                            }


                            
                        }else{
                                $existencia_fr="0";
                                $fraccion="0";
                                $precioFr="0";
                                $precioFr_C="0";
                                $precioCalcFr="0";
                                $precioCalcFr_C="0";
                        }



            $query_update = mysqli_query($conexion, "UPDATE producto SET codigo = '$codigo', descripcion = '$producto', precio= $precio, precioIVA= $precioIVA,precioPVP=$precioPVP, existencia = $cantidad, fraccion= $fraccion, existencia_fr= $existencia_fr,precioFr= $precioFr ,precioFr_o= $precioCalcFr,precioFr_c= $precioCalcFr_C, id_lab = $laboratorio,id_presentacion= $presentacion,id_tipo= $tipo , id_grupo=$grupoC ,vencimiento = '$vencimiento', iva = $iva, info_prod='$infor' WHERE codproducto = $id");
            if ($query_update) {
             
                    $alert = mostrarMensaje('Producto Modificado','i');
            } else {
              
                   $alert = mostrarMensaje('Error al modificar','w');
            }
        }
    }
}




?>
<div class="card shadow-lg">
                            <div class="card-header card-header-primary ">
									<h4 class="card-title">Productos</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                            Ingreso de Productos
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off" id="formulario">
                            <?php echo isset($alert) ? $alert : ''; ?>
                            <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="codigo" class=" text-dark font-weight-bold"><i class="fas fa-barcode"></i> Código de Barras</label>
                                                            <input type="text" placeholder="Ingrese código de barras" name="codigo" id="codigo" class="form-control" autofocus required>
                                                            <input type="hidden" id="id" name="id">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="producto" class=" text-dark font-weight-bold">Producto</label>
                                                            <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control" required>
                                                        </div>
                                                    </div>
                                             </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="precio" class=" text-dark font-weight-bold" style="font-size:12px;">Precio Costo</label>
                                                    <input type="number" placeholder="Costo" class="form-control" name="precio" id="precio" min="0" step="0.01" onkeyup="calcularIVA()" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="iva" class=" text-dark font-weight-bold" style="font-size:12px;">IVA:</label>
                                                    <input type="number" placeholder="IVA" class="form-control" name="iva" id="iva" min="0" max="1" step="0.01" value="0.00" onkeyup="calcularIVA(event)"  required>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="precioIva" class=" text-dark font-weight-bold" style="font-size:12px;">Precio IVA:</label>
                                                    <input type="number" placeholder="Ingrese IVA" class="form-control" name="precioIva" id="precioIva" min="0"  step="0.01" value="0.00" readonly  required>
                                                </div>
                                            </div>

                                            <div class="col-md-3  col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <label for="precioPVP" class=" text-dark font-weight-bold" style="font-size:12px;">Precio PVP</label>
                                                    <input type="number" placeholder="PVP" class="form-control" name="precioPVP" id="precioPVP" min="0" step="0.01" onkeyup="calcularIVA(event)"  required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                

                                
                            </div>

                            
                            <div class="row">
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipo" class="text-dark font-weight-bold">Tipo</label>
                                        <select id="tipo" class="form-control" name="tipo" required>
                                            <option value="*">Seleccionar</option>
                                            <?php
                                            $query_tipo = mysqli_query($conexion, "SELECT * FROM tipos order by tipo");
                                            while ($datos = mysqli_fetch_assoc($query_tipo)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['tipo'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="presentacion" class=" text-dark font-weight-bold">Presentación</label>
                                        <select id="presentacion" class="form-control" name="presentacion" onchange="presentacion_caja(event)" required>
                                        <option value="*">Seleccionar</option>
                                            <?php
                                            $query_pre = mysqli_query($conexion, "SELECT * FROM presentacion order by nombre");
                                            while ($datos = mysqli_fetch_assoc($query_pre)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                       
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="laboratorio" class="text-dark font-weight-bold">Laboratorio</label>
                                        <select id="laboratorio" class="form-control" name="laboratorio" required>
                                        <option value="*">Seleccionar</option>
                                            <?php
                                            $query_lab = mysqli_query($conexion, "SELECT * FROM laboratorios order by laboratorio");
                                            while ($datos = mysqli_fetch_assoc($query_lab)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['laboratorio'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="grupoC" class="text-dark font-weight-bold">Grupo Corporal</label>
                                        <select id="grupoC" class="form-control" name="grupoC" required>
                                        <option value="*">Seleccionar</option>
                                            <?php
                                            $query_lab = mysqli_query($conexion, "SELECT * FROM grupo_cuerpo order by nombre");
                                            while ($datos = mysqli_fetch_assoc($query_lab)) { ?>
                                                <option value="<?php echo $datos['id_grupo'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       
                                        <label for="vencimiento">Vencimiento</label>
                                        <input id="vencimiento" class="form-control" type="date" name="vencimiento" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div class="form-group">

                                  

                                        <label for="cantidad" class=" text-dark font-weight-bold">Unidades</label>
                                        <input type="number" placeholder="Unidades" class="form-control" name="cantidad" id="cantidad" required>
                                    </div>
                                </div>
                                <div class="col-md-2 ">



                                        <div   id="areaFraccion" style="margin-top:6px; display:none;">
                                            
                                              <div class="form-group">
                                                    <label for="fraccion" class="text-dark font-weight-bold">Fracciones por U:</label>
                                                    <input type="number" placeholder="Fracciones" class="form-control" name="fraccion" id="fraccion" min="0" step="1">
                                             </div>
                                            
                                            
                                               <div class="form-group">
                                                    <label for="PrecioFr" class="text-dark font-weight-bold">Precio por Fr.:</label>
                                                    <input type="number" placeholder="Precio Fracción" class="form-control" name="PrecioFr" id="PrecioFr" min="0" step="0.01">
                                              </div>
                                           
                                        </div>
                                            </div>
                                <div class="col-md-8 ">

                                          <div class="form-group">
                                               <label for="inform" class="text-dark font-weight-bold">Información:</label>
                                               <textarea placeholder="Información" class="form-control" name="inform" id="inform" rows="4" ></textarea>


                                            </div>

                                            </div>



                             
                          

                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <input type="submit" value="Grabar" class="btn btn-primary" id="btnAccion">
                                    <input type="button" value="Limpiar" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                                </div>
                            </div>



                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
                                            </div>
                                            </div>
  <div class="card shadow-lg">
        <div class="card-body">
                 <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm  table-bordered table-hover" id="tbl">
                                    <thead class="thead-light">
                                        <tr>
                                            <th><b>#</b></th>
                                            <th><b>Código</b></th>
                                            <th><b>Producto</b></th>
                                            <th><b>F. Vencimiento</b></th>
                                            <th><b>Tipo</b></th>
                                            <th><b>Presentacion</b></th>
                                            <th><b>Precio Costo</b></th>
                                            <th><b>Precio PVP</b></th>
                                            <th><b>Unidades</b></th>
                                            <th><b>Frac./Unid.</b></th>
                                            <th><b>Prec./Frac.</b></th>
                                            <th><b>IVA</b></th>
                                            <th><b>Acciones</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    //  include "../conexion.php";

                                        $query = mysqli_query($conexion, "SELECT p.*, t.id, t.tipo, pr.id, pr.nombre FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id");
                                        $result = mysqli_num_rows($query);
                                        if ($result > 0) {
                                            while ($data = mysqli_fetch_assoc($query)) { 
                                            
                                                ?>
                                                <tr>
                                                    <td><?php echo $data['codproducto']; ?></td>
                                                    <td><?php echo $data['codigo']; ?></td>
                                                    <td><?php echo $data['descripcion']; ?></td>
                                                    <td><?php echo $data['vencimiento']; ?></td>
                                                    <td><?php echo $data['tipo']; ?></td>
                                                    <td><?php echo $data['nombre']; ?></td>
                                                    <td><?php echo $data['precio']; ?></td>
                                                    <td><?php echo $data['precioPVP']; ?></td>
                                                    <td><?php echo $data['existencia']; ?></td>
                                                    <td><?php echo $data['fraccion']; ?></td>
                                                    <td><?php echo $data['precioFr']; ?></td>
                                                    <td><?php echo $data['iva']; ?></td>
                                                    <td>
                                                        <a href="#" onclick="editarProducto(event,<?php echo $data['codproducto']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>

                                                        <form action="eliminar_producto.php?id=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
                                                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
    </div>
</div>
<?php  } 
 }else{

    header("Location: ../index.php");
 }
?>
<?php include_once "includes/footer.php"; ?>