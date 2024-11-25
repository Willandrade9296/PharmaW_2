<?php
session_start();
include_once "includes/header.php";



function  precioFraccion($PprecioPVP,$numeroFracciones,$precioFraccion){
     
    if($precioFraccion == 0){
            if($numeroFracciones > 0){

            return round(($PprecioPVP/$numeroFracciones),2);

            }else{

            return 0;

            }
        }else{

            return $precioFraccion;
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
    $vencimiento = '';
    $iva=$_POST['iva'];
    if (!empty($_POST['accion'])) {
        $vencimiento = $_POST['vencimiento'];
    }
    if (empty($codigo) || empty($producto) || empty($tipo) || empty($presentacion) || empty($laboratorio)  || empty($precio) || $precio <  0  || empty($precioPVP) || $precioPVP <  0 || empty($cantidad) || $cantidad <  0 || empty($iva) ||
    $tipo=="*" || $presentacion=="*" || $laboratorio=="*") {
     
                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
    } else {
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codigo = '$codigo'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
              
                    $alert = mostrarMensaje('El codigo ya existe','w');
            } else {
               
                 $precioCalcFr= precioFraccion($precioPVP,$fraccion,$precioFr);

                $query_insert = mysqli_query($conexion, "INSERT INTO producto(codigo,descripcion,precio,precioPVP,existencia,fraccion,precioFr,id_lab,id_presentacion,id_tipo, vencimiento,iva) values ('$codigo', '$producto', '$precio','$precioPVP', '$cantidad','$fraccion',$precioCalcFr, $laboratorio, $presentacion, $tipo, '$vencimiento','$iva')");
                if ($query_insert) {
                 
                    $alert = mostrarMensaje('Producto registrado','i');
                } else {
                  
                     $alert = mostrarMensaje('Error al registrar el producto','e');
                }



            }
        } else {

            $precioCalcFr= precioFraccion($precioPVP,$fraccion,$precioFr);

            $query_update = mysqli_query($conexion, "UPDATE producto SET codigo = '$codigo', descripcion = '$producto', precio= $precio, precioPVP=$precioPVP, existencia = $cantidad, fraccion= $fraccion, precioFr= $precioCalcFr,id_lab = $laboratorio,id_presentacion=$presentacion,id_tipo=$tipo ,vencimiento = '$vencimiento', iva = $iva WHERE codproducto = $id");
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="codigo" class=" text-dark font-weight-bold"><i class="fas fa-barcode"></i> Código de Barras</label>
                                        <input type="text" placeholder="Ingrese código de barras" name="codigo" id="codigo" class="form-control" autofocus required>
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="producto" class=" text-dark font-weight-bold">Producto</label>
                                        <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="precio" class=" text-dark font-weight-bold" style="font-size:12px;">Precio Costo</label>
                                        <input type="number" placeholder="Costo" class="form-control" name="precio" id="precio" min="0" step="0.01" onkeyup="calcularIVA()" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="iva" class=" text-dark font-weight-bold">IVA:</label>
                                        <input type="number" placeholder="IVA" class="form-control" name="iva" id="iva" min="0" max="1" step="0.01" value="0.00" onkeyup="calcularIVA()"  required>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="precioIva" class=" text-dark font-weight-bold">Precio IVA:</label>
                                        <input type="number" placeholder="Ingrese IVA" class="form-control" name="precioIva" id="precioIva" min="0"  step="0.01" value="0.00" disabled  required>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="precioPVP" class=" text-dark font-weight-bold" style="font-size:12px;">Precio PVP</label>
                                        <input type="number" placeholder="PVP" class="form-control" name="precioPVP" id="precioPVP" min="0" step="0.01" required>
                                    </div>
                                </div>

                                

                                
                            </div>

                            
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipo" class="text-dark font-weight-bold">Tipo</label>
                                        <select id="tipo" class="form-control" name="tipo" required>
                                            <option value="*">Seleccionar</option>
                                            <?php
                                            $query_tipo = mysqli_query($conexion, "SELECT * FROM tipos");
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
                                            $query_pre = mysqli_query($conexion, "SELECT * FROM presentacion");
                                            while ($datos = mysqli_fetch_assoc($query_pre)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                       
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="laboratorio" class="text-dark font-weight-bold">Laboratorio</label>
                                        <select id="laboratorio" class="form-control" name="laboratorio" required>
                                        <option value="*">Seleccionar</option>
                                            <?php
                                            $query_lab = mysqli_query($conexion, "SELECT * FROM laboratorios");
                                            while ($datos = mysqli_fetch_assoc($query_lab)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['laboratorio'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input id="accion" class="form-check-input text-dark font-weight-bold" type="checkbox" name="accion" value="si" checked>
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

                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <input type="submit" value="Grabar" class="btn btn-primary" id="btnAccion">
                                    <input type="button" value="Ingresar Nuevo" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                                </div>
                            </div>



                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Presentacion</th>
                            <th>Precio Costo</th>
                            <th>Precio PVP</th>
                            <th>Unidades</th>
                            <th>Frac./Unid.</th>
                            <th>Prec./Frac.</th>
                            <th>IVA</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT p.*, t.id, t.tipo, pr.id, pr.nombre FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['codproducto']; ?></td>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
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
<?php  } 
 }else{

    header("Location: ../index.php");
 }
?>
<?php include_once "includes/footer.php"; ?>