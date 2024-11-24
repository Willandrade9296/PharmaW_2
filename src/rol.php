<?php
session_start();

include_once "includes/header.php";

$id = $_GET['id'];
if (!empty ($id)){


$sqlpermisos = mysqli_query($conexion, "SELECT * FROM permisos");
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $id");
$consulta = mysqli_query($conexion, "SELECT * FROM detalle_permisos WHERE id_usuario = $id");


$resultUsuario = mysqli_num_rows($usuarios);
if (empty($resultUsuario)) {
    header("Location: usuarios.php");
}else{ 
$datos = array();
foreach ($consulta as $asignado) {
    $datos[$asignado['id_permiso']] = true;
}
if (isset($_POST['permisos'])) {
    $id_user = $_GET['id'];
    $permisos = $_POST['permisos'];
    mysqli_query($conexion, "DELETE FROM detalle_permisos WHERE id_usuario = $id_user");
    if ($permisos != "") {
        foreach ($permisos as $permiso) {
            $sql = mysqli_query($conexion, "INSERT INTO detalle_permisos(id_usuario, id_permiso) VALUES ($id_user,$permiso)");
        }

        $alert = mostrarMensaje('Permisos Asignado','i');
      
    }
}

?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-lg">
                              <div class="card-header card-header-primary ">
									<h4 class="card-title">Permisos</h4>
									
								</div>
            <div class="card-body">
                <form method="post" action="">
                    <?php echo (isset($alert)) ? $alert : '' ; ?>
                    <?php while ($row = mysqli_fetch_assoc($sqlpermisos)) { ?>
                        <div class="form-check form-check-inline m-4">
                            <label for="permisos" class="p-2 text-uppercase"><?php echo $row['nombre']; ?></label>
                            <input id="permisos" type="checkbox" name="permisos[]" value="<?php echo $row['id']; ?>" <?php
                                                                                                                        if (isset($datos[$row['id']])) {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?>>
                        </div>
                    <?php } ?>
                    <br>
                    <button class="btn btn-primary btn-block" type="submit">Modificar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php   } 
}else{
    header("Location: ../index.php");
} ?>
<?php include_once "includes/footer.php"; ?>