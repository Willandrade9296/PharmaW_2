<?php
session_start();
include_once "includes/header.php";

if (!empty($_SESSION['idUser'])){ 
$id_user = $_SESSION['idUser'];
$permiso = "presentacion";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['nombre_corto'])) {
       
                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $nombre_corto = $_POST['nombre_corto'];
        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM presentacion WHERE nombre = '$nombre'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
               
                    $alert = mostrarMensaje('La Presentación ya existe','w');
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO presentacion(nombre, nombre_corto) values ('$nombre', '$nombre_corto')");
                if ($query_insert) {
                    
                    $alert = mostrarMensaje('Presentación registrado','i');
                } else {
                    
                    $alert = mostrarMensaje('Error al registrar','e');
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE presentacion SET nombre = '$nombre', nombre_corto = '$nombre_corto' WHERE id = $id");
            if ($sql_update) {
             
                    $alert = mostrarMensaje('Presentación modificado','i');
            } else {
               
                    $alert = mostrarMensaje('Error al modificar','e');
            }
        }
    }
    mysqli_close($conexion);
}

?>
<div class="card">

                            <div class="card-header card-header-primary ">
									<h4 class="card-title">Presentación</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control" required>
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre Corto</label>
                                <input type="text" placeholder="Ingrese Nombre Corto" name="nombre_corto" id="nombre_corto" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tbl">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Nombre Corto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM presentacion");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td><?php echo $data['nombre_corto']; ?></td>
                                        <td style="width: 200px;">
                                            <a href="#" onclick="editarPresent(<?php echo $data['id']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_present.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
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
    
}?>
<?php include_once "includes/footer.php"; ?>