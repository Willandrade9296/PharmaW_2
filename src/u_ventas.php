<?php
session_start();
include_once "includes/header.php";

if (!empty($_SESSION['idUser'])){ 
$id_user = $_SESSION['idUser'];
$permiso = "uti_ventas";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    
    mysqli_close($conexion);
}

?>
<div class="card">

                            <div class="card-header card-header-primary ">
									<h4 class="card-title">Utilitario Ventas</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#divVentas" aria-expanded="false" aria-controls="divVentas">Ver Ventas</button>
                    
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#divVentasE" aria-expanded="false" aria-controls="divVentasE">Ver Eliminadas</button>
                    
                            </div>
                </div>
           </div>
            

            <div class="col-md-12">
                <div class="collapse multi-collapse show " id="divVentas">
                    <div class="card">
                        <div class="card-header">
                           <h4> Ventas </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tbldowngen" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID venta</th>
                                            <th>ID Producto</th>
                                            <th>Producto</th>
                                            <th>Tipo prod.</th>
                                            <th>Cant.</th>
                                            <th>Precio PVP</th>
                                            <th>Precio Total</th>
                                            <th>Fecha Venta</th>
                                            <th>Tipo Trans.</th>
                                            <th>Usuario</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "../conexion.php";

                                        $query = mysqli_query($conexion, "SELECT * FROM viventas_uti ORDER BY fecha desc");
                                        $result = mysqli_num_rows($query);
                                        if ($result > 0) {
                                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                                <tr>
                                                    <td><?php echo $data['id_venta']; ?></td>
                                                    <td><?php echo $data['id_producto']; ?></td>
                                                    <td><?php echo $data['descripcion']; ?></td>
                                                    <td><?php echo $data['tipo_prod']; ?></td>
                                                    <td >
                                                          <input 
                                                                class="form-control" 
                                                                id="cantUti_<?php echo $data['id_venta']; ?>_<?php echo $data['id_producto']; ?>" 
                                                                placeholder="Cant." 
                                                                type="number" 
                                                                min="0" 
                                                                max="<?php echo $data['cantidad']; ?>"  
                                                                step="1" 
                                                                value="<?php echo $data['cantidad']; ?>"
                                                            >    
                                                    </td>
                                                   
                                                    <td><?php echo $data['precioPVP']; ?></td>
                                                    <td><?php echo $data['total']; ?></td>
                                                    <td><?php echo $data['fecha']; ?></td>
                                                    <td><?php echo $data['tipo_trans']; ?></td>
                                                    <td><?php echo $data['nombre']; ?></td>
                                                    <td style="width: 200px;">
                                                                  <form 
                                                                    action="eliminar_venta.php" 
                                                                    method="get" 
                                                                    class="confirmar d-inline"
                                                                    onsubmit="return actualizarCantidad(this, 'cantUti_<?php echo $data['id_venta']; ?>_<?php echo $data['id_producto']; ?>')"
                                                                >
                                                                    <input type="hidden" name="id_venta" value="<?php echo $data['id_venta']; ?>">
                                                                    <input type="hidden" name="id_prod" value="<?php echo $data['id_producto']; ?>">
                                                                    <input type="hidden" name="tipo_prod" value="<?php echo $data['tipo_prod']; ?>">
                                                                    <input type="hidden" name="cant" id="cantidadEnviar_<?php echo $data['id_venta']; ?>">
                                                                    <button class="btn btn-danger btn-sm" type="submit">
                                                                        <i class='fas fa-trash-alt'></i>
                                                                    </button>
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

                <div class="collapse multi-collapse " id="divVentasE">

                <div class="card">
                        <div class="card-header">
                          <h4>  Eliminadas </h4>
                        </div>
                     <div class="card-body">
                     <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover tbldowngen" >
                        <thead class="thead-light">
                            <tr>
                                <th>ID venta</th>
                                <th>ID Producto</th>
                                <th>Producto</th>
                                <th>Tipo prod.</th>
                                <th>Cant.</th>
                                <th>Precio PVP</th>
                                <th>Precio Total</th>
                                <th>Fecha Venta</th>
                                <th>Tipo Trans.</th>
                                <th>Usuario</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM ventas_eliminadas ORDER BY fecha desc");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id_venta']; ?></td>
                                        <td><?php echo $data['id_producto']; ?></td>
                                        <td><?php echo $data['descripcion']; ?></td>
                                        <td><?php echo $data['tipo_prod']; ?></td>
                                        <td><?php echo $data['cantidad']; ?></td>
                                        <td><?php echo $data['precioPVP']; ?></td>
                                        <td><?php echo $data['total']; ?></td>
                                        <td><?php echo $data['fecha']; ?></td>
                                        <td><?php echo $data['tipo_trans']; ?></td>
                                        <td><?php echo $data['usuario']; ?></td>
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

           
             
                       
                       
        </div>
    </div>
</div>

<script>
function actualizarCantidad(form, idInputCant) {
    // Obtiene el input de cantidad por su ID único
    const inputCant = document.getElementById(idInputCant);
    // Asigna su valor al campo oculto 'cant' del formulario
    form.querySelector('input[name="cant"]').value = inputCant.value;
    return true; // Permite el envío del formulario
}

</script>



<?php  } 
}else{
    header("Location: ../index.php");
    
}?>
<?php include_once "includes/footer.php"; ?>