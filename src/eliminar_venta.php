<?php
session_start();

require("../conexion.php");

function devolucion_productos($conn,$id_producto,$tipo_prod,$cantidad){

  if ($tipo_prod == "U"){ 
  $ventas = mysqli_query($conn, "UPDATE producto SET existencia=existencia+$cantidad WHERE codproducto=$id_producto");
  }else if($tipo_prod == "F"){
  $ventas = mysqli_query($conn, "UPDATE producto SET existencia_fr=existencia_fr+$cantidad  WHERE codproducto=$id_producto");
  }

}

$id_user = $_SESSION['idUser'];
$permiso = 'uti_ventas';
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_GET['id_venta']) && !empty($_GET['id_prod'])) {
     $id = $_GET['id_venta'];
     $id_prod= $_GET['id_prod'];
     $id_tipo_prod= $_GET['tipo_prod'];
     $cantidad_elim=$_GET['cant'];
    
    $query_copy= mysqli_query($conexion, "INSERT INTO ventas_eliminadas (descripcion,id_detalle,id_producto,id_venta,tipo_prod,cantidad,descuento,precio,iva,precioPVP,total,fecha,tipo_trans,id_usuario,usuario,usuario_mod,fecha_mod) 
    SELECT descripcion,id,id_producto,id_venta,tipo_prod,'$cantidad_elim',descuento,precio,iva,precioPVP,total,fecha,tipo_trans,id_usuario,nombre,'$id_user',now() FROM viventas_uti WHERE id_venta = $id and id_producto= $id_prod and tipo_prod='$id_tipo_prod'");
    
    if($query_copy == true){

            $detalle_ventas = mysqli_query($conexion, "SELECT * FROM detalle_venta WHERE id_venta=$id AND id_producto=$id_prod AND tipo_prod='$id_tipo_prod'");
            $result1 = mysqli_num_rows($detalle_ventas);
            while ($data1 = mysqli_fetch_assoc($detalle_ventas)) { 
              $cantidad= $data1['cantidad'];
              $total= $data1['total'];

            }


                                if($result1 > 1){ 
                               // $ventas = mysqli_query($conexion, "UPDATE ventas SET total= total - $total  WHERE id=$id");
                                

                                   if($cantidad == $cantidad_elim){ 
                                    devolucion_productos($conexion,$id_prod,$id_tipo_prod,$cantidad);
                                     $detalle_eliminadi=  mysqli_query($conexion, "DELETE FROM detalle_venta  WHERE id_venta=$id AND id_producto=$id_prod AND tipo_prod='$id_tipo_prod'");
                                   }else{
                                    devolucion_productos($conexion,$id_prod,$id_tipo_prod,$cantidad_elim);
                                     $detalle_eliminadi=  mysqli_query($conexion, "UPDATE detalle_venta set cantidad=cantidad-$cantidad_elim, total=precioPVP*$cantidad_elim WHERE id_venta=$id AND id_producto=$id_prod AND tipo_prod='$id_tipo_prod'");
                                
                                   }
                                }else{
                                 //$ventas = mysqli_query($conexion, "DELETE FROM ventas  WHERE id=$id");
                               
                                
                                     if($cantidad == $cantidad_elim){ 
                                       devolucion_productos($conexion,$id_prod,$id_tipo_prod,$cantidad);
                                     $detalle_eliminadi=  mysqli_query($conexion, "DELETE FROM detalle_venta  WHERE id_venta=$id AND id_producto=$id_prod AND tipo_prod='$id_tipo_prod'");
                                   }else{
                                    devolucion_productos($conexion,$id_prod,$id_tipo_prod,$cantidad_elim);
                                     $detalle_eliminadi=  mysqli_query($conexion, "UPDATE detalle_venta set cantidad=cantidad-$cantidad_elim, total=precioPVP*$cantidad_elim WHERE id_venta=$id AND id_producto=$id_prod AND tipo_prod='$id_tipo_prod'");
                                
                                   }
                                }
         
                           
    
    }
   
   mysqli_close($conexion);

    
    header("Location: u_ventas.php");
 
    



}
