<?php
session_start();
include_once "includes/header.php";
$permiso = 'usuarios';

if(!empty($_SESSION['idUser'])){ 

$id_user = $_SESSION['idUser'];

$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
    include "permisos.php";
}
else
{ 
if (!empty($_POST)) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $alert = "";
    if (empty($nombre) || empty($email) || empty($user)) {
       

                $alert = mostrarMensaje('Todos los campos son obligatorios','w');
    } else {
        if (empty($id)) {
            $clave = $_POST['clave'];
            if (empty($clave)) {
               

                $alert = mostrarMensaje('La contraseña es requerida','w');
            } else {
                $clave = md5($_POST['clave']);
                $query = mysqli_query($conexion, "SELECT * FROM usuario where correo = '$email'");
                $result = mysqli_fetch_array($query);
                if ($result > 0) {

                    $alert = mostrarMensaje('El correo ya existe','e');

                    
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave) values ('$nombre', '$email', '$user', '$clave')");
                    if ($query_insert) {
              

                        $alert = mostrarMensaje('Usuario registrado ','i');
                    } else {
               

                          $alert = mostrarMensaje('Error al registrar ','e'); 
                    }
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$email' , usuario = '$user' WHERE idusuario = $id");
            if ($sql_update) {
               

                $alert = mostrarMensaje('Usuario Modificado','i');
            } else {
               
                $alert = mostrarMensaje('Error al modificar usuario','e');
            }
        }
    }
}


?>
<div class="card">

                           <div class="card-header card-header-primary ">
									<h4 class="card-title">Usuarios</h4>
									
								</div>
    <div class="card-body">
        <form action="" method="post" autocomplete="off" id="formulario">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                        <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                        <input type="hidden" id="id" name="id">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="correo" class="text-dark font-weight-bold">Correo</label>
                        <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="usuario" class="text-dark font-weight-bold">Usuario</label>
                        <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" id="usuario">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clave" class="text-dark font-weight-bold">Contraseña</label>
                        <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave">
                    </div>
                </div>
            </div>
            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
        </form>
    </div>
</div>

<div class="card">
   <div class="card-body">
       <div class="table-responsive">

    <table class="table table-bordered table-hover table-sm" id="tbl">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM usuario order by nombre");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>

                        <td><?php echo $data['idusuario']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['correo']; ?></td>
                        <td><?php echo $data['usuario']; ?></td>
                        <td>
                            <a href="rol.php?id=<?php echo $data['idusuario']; ?>&nombre=<?php echo $data['nombre']; ?>" class="btn btn-warning "><i class='fas fa-key'></i></a>
                            <a href="#" onclick="editarUsuario(<?php echo $data['idusuario']; ?>,<?php echo $data['nombre']; ?>)" class="btn btn-success "><i class='fas fa-edit'></i></a>
                            <form action="eliminar_usuario.php?id=<?php echo $data['idusuario']; ?>" method="post" class="confirmar d-inline">
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
<?php  }
}else{
    header("Location: ../index.php");
}  ?>
<?php include_once "includes/footer.php"; ?>