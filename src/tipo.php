<?php
session_start();
include_once "includes/header.php";
if(!empty($_SESSION['idUser'])){


$id_user = $_SESSION['idUser'];
$permiso = "tipos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre'])) {
       

                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
                    
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM tipos WHERE tipo = '$nombre'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
             

                    $alert = mostrarMensaje('El tipo ya existe','w');
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO tipos(tipo) values ('$nombre')");
                if ($query_insert) {
                    
                    $alert = mostrarMensaje('Tipo registrado','i');
                } else {

                    $alert = mostrarMensaje('Error al registrar','e');
                   
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE tipos SET tipo = '$nombre' WHERE id = $id");
            if ($sql_update) {
                
                    $alert = mostrarMensaje('Tipo modificado','i');
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
									<h4 class="card-title">Tipos</h4>
									
								</div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control" required>
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="tbl">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM tipos");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['tipo']; ?></td>
                                        <td style="width: 200px;">
                                            <a href="#" onclick="editarTipo(<?php echo $data['id']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_tipo.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
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
<?php }
}else{
    header("Location:../index.php");
}  ?>
<?php include_once "includes/footer.php"; ?>