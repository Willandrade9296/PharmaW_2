<?php
require_once "../conexion.php";
session_start();




if (isset($_GET['q'])) {
    $datos = array();
    $nombre = $_GET['q'];
    $cliente = mysqli_query($conexion, "SELECT * FROM cliente WHERE cedula LIKE '%".$nombre."%'  OR   nombre LIKE '%$nombre%'");
    while ($row = mysqli_fetch_assoc($cliente)) {
        $data['id'] = $row['idcliente'];
        $data['idcedula'] = $row['cedula'];
        $data['label'] = $row['cedula'].' - '.$row['nombre'];
        $data['value'] = $row['nombre'];
        $data['direccion'] = $row['direccion'];
        $data['telefono'] = $row['telefono'];
        $data['email'] = $row['email'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['pro'])) {
    $datos = array();
    $nombre = $_GET['pro'];
    $hoy = date('Y-m-d');
    $producto = mysqli_query($conexion, "SELECT * FROM producto WHERE codigo LIKE '%" . $nombre . "%' OR descripcion LIKE '%" . $nombre . "%' AND vencimiento > '$hoy' OR vencimiento = '0000-00-00'");
    while ($row = mysqli_fetch_assoc($producto)) {
        $data['id'] = $row['codproducto'];
        $data['id_presentacion'] = $row['id_presentacion'];
        $data['label'] = $row['codigo'] . ' - ' .$row['descripcion'];
        $data['value'] = $row['descripcion'];
        $data['precioC'] = $row['precio'];
        $data['precioPVP'] = $row['precioPVP'];
        $data['cantidad'] = $row['existencia'];
        $data['fraccion'] = $row['fraccion'];
        $data['precioFr'] = $row['precioFr'];
        $data['precioFr_o'] = $row['precioFr_o'];
     //   $data['stockFr']= $row['existencia'] * $row['fraccion'];
        $data['stockFr'] = $row['existencia_fr'];
        $data['iva'] = $row['iva'];
        $data['info_prod'] = $row['info_prod'];
        
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['detalle'])) {
    $id = $_SESSION['idUser'];
    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.*, p.codproducto, p.descripcion FROM detalle_temp d INNER JOIN producto p ON d.id_producto = p.codproducto WHERE d.id_usuario = $id");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['descripcion'] = $row['descripcion'];
        $data['tipo_prod'] = $row['tipo_prod'];
        $data['cantidad'] = $row['cantidad'];
        $data['descuento'] = $row['descuento'];
        $data['precio_venta'] = $row['precio_venta'];
        $data['sub_total'] = $row['total'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
} else if (isset($_GET['procesarVenta'])) {
    $id_cliente = $_GET['id'];
   // $tipo_unidad= $_GET['tipoUnidad'];
    $id_user = $_SESSION['idUser'];
    

    if (comprobar_cliente($conexion,$id_cliente))
    { 
                    $consulta = mysqli_query($conexion, "SELECT total, SUM(total) AS total_pagar FROM detalle_temp WHERE id_usuario = $id_user GROUP BY id_usuario,total");
                    $result = mysqli_fetch_assoc($consulta);
                    $total = $result['total_pagar'];
                    $insertar = mysqli_query($conexion, "INSERT INTO ventas(id_cliente, total, id_usuario) VALUES ($id_cliente, '$total', $id_user)");
                    if ($insertar) {
                        $id_maximo = mysqli_query($conexion, "SELECT MAX(id) AS total FROM ventas");
                        $resultId = mysqli_fetch_assoc($id_maximo);
                        $ultimoId = $resultId['total'];
                        $consultaDetalle = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_usuario = $id_user");
                        while ($row = mysqli_fetch_assoc($consultaDetalle)) {
                            $id_producto = $row['id_producto'];
                            $tipo_unidad = $row['tipo_prod'];
                            $cantidad = $row['cantidad'];
                            $desc = $row['descuento'];
                            $precio = $row['precio_costo'];
                            $precioPVP = $row['precio_venta'];
                            $total = $row['total'];
                         /*   $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta, cantidad,precio, precioPVP, descuento, total) VALUES ($id_producto, $ultimoId, $cantidad,'$precio', '$precioPVP', '$desc', '$total')");  */
                            $stockActual = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $id_producto");
                            $stockNuevo = mysqli_fetch_assoc($stockActual); 

                            if($stockNuevo['id_presentacion'] == "4"){   //Se menora en caso de que se venda por fracciones


                                                                $existencia_fraccion = $stockNuevo['existencia_fr'];   // fracciones en stock
                                                                $fraccion_por_unidad = $stockNuevo['fraccion'];   // fracciones por unidad en stock


                                                        if ( $tipo_unidad == "F" )
                                                        { 
                                                                
                                                            

                                                                $obtener_residuo = (int)(  ($existencia_fraccion - $cantidad)  %   $fraccion_por_unidad  );


                                                                if($obtener_residuo == 0)
                                                                { 


                                                                                  $obtener_unidades= (int)( ($existencia_fraccion - $cantidad)  /  $fraccion_por_unidad );

                                                                            
                                                                                  $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta,tipo_prod, cantidad,precio, precioPVP, descuento, total) VALUES ($id_producto, $ultimoId,'F', $cantidad,'$precio', '$precioPVP', '$desc', '$total')");
                                                                            

                                                                            
                                                                                   // $stockTotal = $stockNuevo['existencia'] - $obtener_unidades;
                                                                                   $stockTotal = $obtener_unidades;
                                                                                    $stockTotalFr= $existencia_fraccion - $cantidad;




                                                                                    $stock = mysqli_query($conexion, "UPDATE producto SET existencia = $stockTotal , existencia_fr= $stockTotalFr WHERE codproducto = $id_producto");
                                                                                
                                                
                                                                } else{  // Se menora en caso que se venda por unidades
                                                                        
                                                                                                
                                                                              $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta,tipo_prod, cantidad,precio, precioPVP, descuento, total) VALUES ($id_producto, $ultimoId,'F', $cantidad,'$precio', '$precioPVP', '$desc', '$total')");
                                                                
                                                                                $stockTotalFr= $stockNuevo['existencia_fr'] - $cantidad;

                                                                            

                                                                                    $stock = mysqli_query($conexion, "UPDATE producto SET existencia_fr= $stockTotalFr  WHERE codproducto = $id_producto");
                                                

                                                                }  

                                                        }else {   // Se menora en caso que se venda por unidades por caja

                                                                $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta,tipo_prod, cantidad ,precio, precioPVP, descuento, total) VALUES ($id_producto, $ultimoId,'U', $cantidad,'$precio', '$precioPVP', '$desc', '$total')");
                              
                                                                $stockTotal = $stockNuevo['existencia'] - $cantidad;
                                                                
                                                                $stockTotalFr= $stockNuevo['existencia_fr'] - ($cantidad * $fraccion_por_unidad);
                                
                                                                 $stock = mysqli_query($conexion, "UPDATE producto SET existencia = $stockTotal , existencia_fr= $stockTotalFr WHERE codproducto = $id_producto");
                                
                                                              
                                                               



                                                         }
                                                                                
                             



                            }else{    // Se menora en caso que se venda por unidades
                              

                                $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta,tipo_prod, cantidad ,precio, precioPVP, descuento, total) VALUES ($id_producto, $ultimoId,'U', $cantidad,'$precio', '$precioPVP', '$desc', '$total')");
                              
                                $stockTotal = $stockNuevo['existencia'] - $cantidad;
                                

                                 $stock = mysqli_query($conexion, "UPDATE producto SET existencia = $stockTotal WHERE codproducto = $id_producto");

                            }
                        } 


                        if ($insertarDet) {
                            $eliminar = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id_usuario = $id_user");
                            $msg = array('id_cliente' => $id_cliente, 'id_venta' => $ultimoId);
                        } 
                            
                    }else{
                        $msg = array('mensaje' => 'error');
                    } 
                  
    }else{
        $msg = array('mensaje' => 'error');
    }





    echo json_encode($msg);
    die();


}else if (isset($_GET['descuento'])) {
    $id = $_GET['id'];
    $desc = $_GET['desc'];
    $consulta = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id = $id");
    $result = mysqli_fetch_assoc($consulta);
    $cantidad= $result['cantidad'];
    
    if($desc <= 0.50){ 
    $total_desc = ( $result['precio_venta'] * $desc );

    $total = ($result['precio_venta'] - $total_desc) * $cantidad;



    $insertar = mysqli_query($conexion, "UPDATE detalle_temp SET descuento = $total_desc, total = '$total'  WHERE id = $id");
    

    }
    if ($insertar) {
        $msg = array('mensaje' => 'descontado');
    }else{
        $msg = array('mensaje' => 'error');
    }
    echo json_encode($msg);
    die();
}else if(isset($_GET['editarCliente'])){
    $idcliente = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarUsuario'])) {
    $idusuario = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarProducto'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarTipo'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM tipos WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;

} else if (isset($_GET['editarGrupoC'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM grupo_cuerpo WHERE id_grupo = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;

} else if (isset($_GET['editarPresent'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM presentacion WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarLab'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM laboratorios WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
}
if (isset($_POST['regDetalle'])) {
    $id = $_POST['id'];
    $cant = $_POST['cant'];
    $precioC = $_POST['precioC'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $iva = $_POST['iva'];
    $tipo_unidad=$_POST['tipo_unidad'];
    $id_user = $_SESSION['idUser'];
    $total = $precio * $cant;
    $verificar = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_producto = $id AND id_usuario = $id_user AND tipo_prod= '$tipo_unidad' ");
    $result = mysqli_num_rows($verificar);
    $datos = mysqli_fetch_assoc($verificar);
    if ($result > 0) {
        $cantidad = $datos['cantidad'] + $cant;
        $total_precio = ($cantidad * $total);
        $query = mysqli_query($conexion, "UPDATE detalle_temp SET cantidad = $cantidad, precio_costo= '$precioC' , precio_venta='$precio'  , total = '$total_precio' WHERE id_producto = $id AND id_usuario = $id_user AND tipo_prod= '$tipo_unidad' ");
        if ($query) {
            $msg = "actualizado";
        } else {
            $msg = "Error al ingresar";
        }
    }else{
        $query = mysqli_query($conexion, "INSERT INTO detalle_temp(id_usuario, id_producto,tipo_prod, cantidad ,precio_costo,precio_venta,iva, total) VALUES ($id_user, $id,'$tipo_unidad', $cant,'$precioC','$precio', '$iva','$total')");
        if ($query) {
            $msg = "registrado";
        }else{
            $msg = "Error al ingresar";
        }
    }
    echo json_encode($msg);
    die();
}else if (isset($_POST['cambio'])) {
    if (empty($_POST['actual']) || empty($_POST['nueva'])) {
        $msg = 'Los campos estan vacios';
    } else {
        $id = $_SESSION['idUser'];
        $actual = md5($_POST['actual']);
        $nueva = md5($_POST['nueva']);
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE clave = '$actual' AND idusuario = $id");
        $result = mysqli_num_rows($consulta);
        if ($result == 1) {
            $query = mysqli_query($conexion, "UPDATE usuario SET clave = '$nueva' WHERE idusuario = $id");
            if ($query) {
                $msg = 'ok';
            }else{
                $msg = 'error';
            }
        } else {
            $msg = 'dif';
        }
        
    }
    echo $msg;
    die();
    
}



function comprobar_cliente($conexion,$id_cliente){

if (!empty($id_cliente) || $id_cliente>0){

        $consulta = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente='$id_cliente'");
        $result = mysqli_num_rows($consulta);
        if ($result > 0) {

            return true;
        }else{
            return false;
        }


        die();

}else{

return false;

}


}

