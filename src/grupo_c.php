<?php
session_start();
include_once "includes/header.php";
if(!empty($_SESSION['idUser'])){


$id_user = $_SESSION['idUser'];
$permiso = "grupo_c";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) ) {
       

                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
                    
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $detalle= $_POST['detalle'];
        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM grupo_cuerpo WHERE nombre = '$nombre'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                
                $alert = mostrarMensaje('El Grupo Corporal ya existe','w');
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO grupo_cuerpo(nombre,detalle) values ('$nombre','$detalle')");
                if ($query_insert) {
                    
                    $alert = mostrarMensaje('Grupo Corporal registrado','i');
                } else {

                    $alert = mostrarMensaje('Error al registrar','e');
                   
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE grupo_cuerpo SET nombre = '$nombre', detalle= '$detalle' WHERE id_grupo = $id");
            if ($sql_update) {
                
                    $alert = mostrarMensaje('Grupo Corporal modificado','i');
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
									<h4 class="card-title">Grupos Corporales</h4>
									
								</div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control" required>
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                             <label for="detalle" class="text-dark font-weight-bold">Detalle</label>
                               <textarea id="detalle" class="form-control"   placeholder="Ingrese Detalle" name="detalle"  rows="2"></textarea>
                            </div>

                        </div>
                       
                    </div>
                    <div class="row">
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

                            $query = mysqli_query($conexion, "SELECT * FROM grupo_cuerpo order by nombre");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id_grupo']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td style="width: 200px;">
                                            <a href="#" onclick="editarGrupoC(<?php echo $data['id_grupo']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_grupoC.php?id=<?php echo $data['id_grupo']; ?>" method="post" class="confirmar d-inline">
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