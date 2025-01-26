<?php
session_start();
include_once "includes/header.php";
if(!empty($_SESSION['idUser'])){ 
$id_user = $_SESSION['idUser'];
$permiso = "laboratorios";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['laboratorio']) || empty($_POST['direccion'])) {
        $alert = mostrarMensaje('Todos los campos son obligatorios','w');
       
    } else {
        $id = $_POST['id'];
        $laboratorio = $_POST['laboratorio'];
        $direccion = $_POST['direccion'];
        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM laboratorios WHERE laboratorio = '$laboratorio'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                

                    $alert = mostrarMensaje('Laboratoria ya existe','w');
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO laboratorios(laboratorio, direccion) values ('$laboratorio', '$direccion')");
                if ($query_insert) {
                 
                    $alert = mostrarMensaje('Laboratoria registrado','i');
                } else {
                  
                    $alert = mostrarMensaje('Error al registrar','e');
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE laboratorios SET laboratorio = '$laboratorio', direccion = '$direccion' WHERE id = $id");
            if ($sql_update) {
                
                    $alert = mostrarMensaje('Laboratoria modificado','i');
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
									<h4 class="card-title">Laboratorios</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="laboratorio" class="text-dark font-weight-bold">laboratorio</label>
                                <input type="text" placeholder="Ingrese laboratorio" name="laboratorio" id="laboratorio" class="form-control">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="direccion" class="text-dark font-weight-bold">Dirección</label>
                                <input type="text" placeholder="Ingrese Dirección" name="direccion" id="direccion" class="form-control">
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
                    <table class="table table-sm table-bordered" id="tbl">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>laboratorio</th>
                                <th>Dirección</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM laboratorios");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['laboratorio']; ?></td>
                                        <td><?php echo $data['direccion']; ?></td>
                                        <td style="width: 200px;">
                                            <a href="#" onclick="editarLab(<?php echo $data['id']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_lab.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
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
}  ?>
<?php include_once "includes/footer.php"; ?>