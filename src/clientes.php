<?php
session_start();
include_once "includes/header.php";

if (!empty($_SESSION['idUser']))
{
$id_user = $_SESSION['idUser'];
$permiso = "clientes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}

if (!empty($_POST)) {
    $alert = "";
    if ( empty($_POST['cedula'])  || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']) ||  empty($_POST['email'])) {
       
                    $alert = mostrarMensaje('Todos los campos son obligatorios','w');
    } else {
        $id = $_POST['id'];
        $cedula= $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $email= $_POST['email'];
        $result = 0;

        if ( strlen($cedula) == 10 ){ 
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE cedula='$cedula' ");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
               
                  //  $alert = mostrarMensaje('El cliente ya existe','w');

                        $sql_update = mysqli_query($conexion, "UPDATE cliente SET   nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion', email= '$email' WHERE cedula='$cedula' ");
                        if ($sql_update) {
                            
                                $alert = mostrarMensaje('Cliente Modificado','i');
                        } else {
                        
                                $alert = mostrarMensaje('Error al modificar cliente','e');
                        }


            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO cliente(cedula,nombre,telefono,direccion,email) values ('$cedula','$nombre', '$telefono', '$direccion','$email')");
                if ($query_insert) {
                  
                    $alert = mostrarMensaje('Cliente registrado','i');
                } else {
                    
                    $alert = mostrarMensaje('Error al registrar cliente','e');
                }
            }
        }else{
            $sql_update = mysqli_query($conexion, "UPDATE cliente SET cedula='$cedula',  nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion', email='$email' WHERE idcliente = $id");
            if ($sql_update) {
                
                    $alert = mostrarMensaje('Cliente Modificado','i');
            } else {
               
                    $alert = mostrarMensaje('Error al modificar cliente','e');
            }
        }
        }else{
            $alert = mostrarMensaje('Cédula ingresada debe tener 10 dígitos','w');
        }



    }
    mysqli_close($conexion);
}

?>
<div class="card">

                             <div class="card-header card-header-primary ">
									<h4 class="card-title">Clientes</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : '' ; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">

                        <div class=" col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="cedula" class="text-dark font-weight-bold">Cédula</label>
                                    <input type="text" placeholder="Ingrese Cédula" name="cedula" id="cedula" size="10" pattern="[0-9]{10}" class="form-control" title="Cédula debe tener 10 dígitos" required>
                                    <input type="hidden" name="id" id="id">
                                </div>
                        </div>


                        <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control" required>
                            </div>
                        </div>


                        <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="telefono" class="text-dark font-weight-bold">Teléfono</label>
                                <input type="number" placeholder="Ingrese Teléfono" name="telefono" id="telefono" class="form-control">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="direccion" class="text-dark font-weight-bold">Dirección</label>
                                <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                       <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="email" class="text-dark font-weight-bold">E-mail</label>
                                <input type="email" placeholder="Ingrese E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" name="email" id="email" class="form-control" required>
                            </div>
                        </div>

                     </div>

                                 <div class="row">
                                        <div class="col-md-4 mt-3">
                                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                                            <input type="button" value="Limpiar" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                                        </div>
                                </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover" id="tbl">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>E-mail</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM cliente");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['idcliente']; ?></td>
                                        <td><?php echo $data['cedula']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td><?php echo $data['telefono']; ?></td>
                                        <td><?php echo $data['direccion']; ?></td>
                                        <td><?php echo $data['email']; ?></td>
                                        <td>
                                            <a href="#" onclick="editarCliente(<?php echo $data['idcliente']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_cliente.php?id=<?php echo $data['idcliente']; ?>" method="post" class="confirmar d-inline">
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
<?php
}else{

    header("Location: ../index.php");
}
?>
<?php include_once "includes/footer.php"; ?>