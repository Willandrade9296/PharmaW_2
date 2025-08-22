
<?php
include "../conexion.php";

$data = json_decode(file_get_contents("php://input"), true);
//$data = json_decode($input, true);

if (!$data || !isset($data['datos'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$success = true;
$message = '';

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {

    $acum_repitencia=0;
    $acumcount=0;

    foreach ($data['datos'] as $registro) {
        // Determinar el tipo de traslado basado en los checkboxes
        $tipoTraslado = '';
        if ($registro['general'])
            
            { $tipoTraslado = 'General'; }

            /**INICIO de Reserva */
        if ($registro['reserva']){
                                    $tipoTraslado = 'Reserva';
                                 $count_repitencia=0;
                                 

                                         $sql_repitencia= "SELECT COUNT(*) as total
                                            FROM paso_reserva 
                                            WHERE id_venta = ? AND id_producto = ? AND tipo_prod= ?";
                                         $stmt_repitencia = mysqli_prepare($conexion, $sql_repitencia);

                                         if (!$stmt_repitencia) {
                                              throw new Exception("Error al validar registros en paso_reserva: " . mysqli_error($conexion));
                                           } 

                                        mysqli_stmt_bind_param(
                                            $stmt_repitencia, 
                                            "iis", 
                                            $registro['id_venta'], 
                                            $registro['id_producto'],
                                            $registro['tipo_prod']);

                                         if (!mysqli_stmt_execute($stmt_repitencia)) {
                                                                    throw new Exception("Error al validar registros en paso_reserva: " . mysqli_error($conexion));
                                                                }
                                          

                                           // Vincular y obtener el resultado
                                            mysqli_stmt_bind_result($stmt_repitencia, $count_repitencia);
                                            mysqli_stmt_fetch($stmt_repitencia);
                                            mysqli_stmt_close($stmt_repitencia);
                                    
                                   
                                              if($count_repitencia == 0){ 
                                                            $sql = "INSERT INTO paso_reserva
                                                                    (id_venta, id_producto, tipo_traslado, fecha_traslado,tipo_prod,cantidad) 
                                                                    SELECT id_venta, id_producto, ?, NOW() ,tipo_prod,cantidad
                                                                    FROM viventas_uti 
                                                                    WHERE id_venta = ? AND id_producto = ? AND tipo_prod= ?" ;
                                                            
                                                            $stmt = mysqli_prepare($conexion, $sql);
                                                            mysqli_stmt_bind_param($stmt, "siis", $tipoTraslado, $registro['id_venta'], $registro['id_producto'],$registro['tipo_prod']);
                                                            if (!mysqli_stmt_execute($stmt)) {
                                                                    throw new Exception("Error al insertar registro en paso_reserva: " . mysqli_error($conexion));
                                                                }
                                        
                                             }else{
                                                 
                                                 $acum_repitencia+=$count_repitencia;
                                             }

                                    

                                               $count=0;
                                               
                                             $sql1= "SELECT count(*) as total FROM v_clinica2.producto where descripcion=?";
                                                 $stmt1 = mysqli_prepare($conexion, $sql1);
                                                 mysqli_stmt_bind_param($stmt1, "s",$registro['descripcion']);
                                                 if (!mysqli_stmt_execute($stmt1)) { 
                                                    throw new Exception("Error al insertar registro en paso_reserva: " . mysqli_error($conexion));
                                                 }
                                                  
                                                 mysqli_stmt_bind_result($stmt1, $count);  
                                                 mysqli_stmt_fetch($stmt1);
                                                 
                                                 mysqli_stmt_close($stmt1);
 

                                                  /** Si no existe producto lo crea y asigna las cantidades correspondientes */
                                                 if($count==0){
                                                 

                                                       if($registro['tipo_prod'] == "U" ){ 
                                                           $sql2= " INSERT INTO v_clinica2.producto (codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,existencia,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod)   
                                                                     SELECT codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,?,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod FROM producto where descripcion=? ";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "is",$registro['cant'],$registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al insertar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }
                                                           $codPrueba=$registro['id_producto']."  ".$registro['descripcion'];
                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim); 

                                                        }else if($registro['tipo_prod'] == "F"){

                                                                 $fraccion=0;

                                                                 $sql_prev="SELECT fraccion FROM producto where  descripcion=?";
                                                                  $stmt_prev = mysqli_prepare($conexion, $sql_prev);
                                                                  mysqli_stmt_bind_param($stmt_prev, "s", $registro['descripcion']);
                                                                  mysqli_stmt_execute($stmt_prev);
                                                                    mysqli_stmt_bind_result($stmt_prev,$fraccion);  
                                                                     mysqli_stmt_fetch($stmt_prev);
                                                                   
                                                                  

                                                                    
                                                                    $existencia=0;
                                                                 
                                                                    if($fraccion>0){ 
                                                                     if($registro['cant']>=$fraccion){
                                                                          
                                                                          $existencia= ceil($registro['cant'] / $fraccion);
                                                                     }else if($registro['cant'] < $fraccion){
                                                                          $existencia=1;
                                                                     }
                                                                    }else{
                                                                        $fraccion=0;
                                                                    }
                                                                     mysqli_stmt_free_result($stmt_prev);
                                                                     mysqli_stmt_close($stmt_prev);


                                                                    $sql2= " INSERT INTO v_clinica2.producto (codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,existencia,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod)   
                                                                     SELECT codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,?,?,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod FROM producto where  descripcion=?";
                                                                        $stmt2 = mysqli_prepare($conexion, $sql2);
                                                                        mysqli_stmt_bind_param($stmt2, "iis",$existencia,$registro['cant'],$registro['descripcion']);
                                                                        if (!mysqli_stmt_execute($stmt2)) { 
                                                                            throw new Exception("Error al insertar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                                        }

                                                                     mysqli_stmt_free_result($stmt2);
                                                                     mysqli_stmt_close($stmt2);

                                                                     /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);


                                                                        


                                                        }

                                               /** Si existe producto aumenta las cantidades */
                                                 }else{

                                                        $acumcount+=$count;

                                                        if($registro['tipo_prod'] == "U" ){ 
                                                           $sql2= " UPDATE v_clinica2.producto SET existencia=existencia+?  where descripcion=? ";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "is",$registro['cant'], $registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al actualizar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }
                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);


                                                        }else if($registro['tipo_prod'] == 'F'){

                                                            
                                                            $fraccion=0;

                                                                 $sql_prev="SELECT fraccion FROM producto where descripcion=?";
                                                                  $stmt_prev = mysqli_prepare($conexion, $sql_prev);
                                                                  mysqli_stmt_bind_param($stmt_prev, "s",$registro['descripcion']);
                                                                   mysqli_stmt_execute($stmt_prev);
                                                                    mysqli_stmt_bind_result($stmt_prev,$fraccion);  
                                                                     mysqli_stmt_fetch($stmt_prev);
                                                                   
                                                                   

                                                                    
                                                                    $existencia=0;
                                                                 if($fraccion>0){ 
                                                                     if($registro['cant']>=$fraccion){
                                                                          
                                                                          $existencia= ceil($registro['cant'] / $fraccion);
                                                                     }else if($registro['cant'] < $fraccion){
                                                                          $existencia=1;   
                                                                     }
                                                                    }else{
                                                                        $fraccion=0;
                                                                    }

                                                                     mysqli_stmt_free_result($stmt_prev);
                                                                     mysqli_stmt_close($stmt_prev);


                                                            $sql2= " UPDATE v_clinica2.producto SET  existencia=existencia+?  ,existencia_fr=existencia_fr+?  where  descripcion=? ";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "iis",$existencia,$registro['cant'], $registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al actualizar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }
   
                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);

                                                        }

                                                 }


                                    


                                    
                        

                 }
                 /*FIN Reserva */
        if ($registro['cparo']) { 
            
            $tipoTraslado = 'C. Paro'; 
        
            
             $count_repitencia=0;
                                 

                                         $sql_repitencia= "SELECT COUNT(*) as total
                                            FROM paso_reserva 
                                            WHERE id_venta = ? AND id_producto = ? AND tipo_prod= ?";
                                         $stmt_repitencia = mysqli_prepare($conexion, $sql_repitencia);

                                         if (!$stmt_repitencia) {
                                              throw new Exception("Error al validar registros en paso_reserva: " . mysqli_error($conexion));
                                           } 

                                        mysqli_stmt_bind_param(
                                            $stmt_repitencia, 
                                            "iis", 
                                            $registro['id_venta'], 
                                            $registro['id_producto'],
                                            $registro['tipo_prod']);

                                         if (!mysqli_stmt_execute($stmt_repitencia)) {
                                                                    throw new Exception("Error al validar registros en paso_reserva: " . mysqli_error($conexion));
                                                                }
                                          

                                           // Vincular y obtener el resultado
                                            mysqli_stmt_bind_result($stmt_repitencia, $count_repitencia);
                                            mysqli_stmt_fetch($stmt_repitencia);
                                            mysqli_stmt_close($stmt_repitencia);
                                    
                                   
                                              if($count_repitencia == 0){ 
                                                            $sql = "INSERT INTO paso_reserva
                                                                    (id_venta, id_producto, tipo_traslado, fecha_traslado,tipo_prod,cantidad) 
                                                                    SELECT id_venta, id_producto, ?, NOW() ,tipo_prod,cantidad
                                                                    FROM viventas_uti 
                                                                    WHERE id_venta = ? AND id_producto = ? AND tipo_prod= ?" ;
                                                            
                                                            $stmt = mysqli_prepare($conexion, $sql);
                                                            mysqli_stmt_bind_param($stmt, "siis", $tipoTraslado, $registro['id_venta'], $registro['id_producto'],$registro['tipo_prod']);
                                                            if (!mysqli_stmt_execute($stmt)) {
                                                                    throw new Exception("Error al insertar registro en paso_reserva: " . mysqli_error($conexion));
                                                                }
                                        
                                             }else{
                                                 
                                                 $acum_repitencia+=$count_repitencia;
                                             }

                                    

                                               $count=0;
                                               
                                             $sql1= "SELECT count(*) as total FROM v_clinica3.producto where codproducto=? AND descripcion=?";
                                                 $stmt1 = mysqli_prepare($conexion, $sql1);
                                                 mysqli_stmt_bind_param($stmt1, "is", $registro['id_producto'],$registro['descripcion']);
                                                 if (!mysqli_stmt_execute($stmt1)) { 
                                                    throw new Exception("Error al insertar registro en paso_reserva: " . mysqli_error($conexion));
                                                 }
                                                  
                                                 mysqli_stmt_bind_result($stmt1, $count);  
                                                 mysqli_stmt_fetch($stmt1);
                                                 
                                                 mysqli_stmt_close($stmt1);
 

                                                  /** Si no existe producto lo crea y asigna las cantidades correspondientes */
                                                 if($count==0){
                                                 

                                                       if($registro['tipo_prod'] == 'U' ){ 
                                                           $sql2= " INSERT INTO v_clinica3.producto (codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,existencia,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod)   
                                                                     SELECT codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,?,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod FROM producto where  descripcion=?";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "is",$registro['cant'], $registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al insertar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }

                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);

                                                        }else if($registro['tipo_prod'] == "F"){

                                                                 $fraccion=0;

                                                                 $sql_prev="SELECT fraccion FROM producto where descripcion=?";
                                                                  $stmt_prev = mysqli_prepare($conexion, $sql_prev);
                                                                  mysqli_stmt_bind_param($stmt_prev, "s",$registro['descripcion']);
                                                                  mysqli_stmt_execute($stmt_prev);
                                                                    mysqli_stmt_bind_result($stmt_prev,$fraccion);  
                                                                     mysqli_stmt_fetch($stmt_prev);
                                                                   
                                                                  

                                                                    
                                                                    $existencia=0;
                                                                 
                                                                    if($fraccion>0){ 
                                                                     if($registro['cant']>=$fraccion){
                                                                          
                                                                          $existencia= ceil($registro['cant'] / $fraccion);
                                                                     }else if($registro['cant'] < $fraccion){
                                                                          $existencia=1;
                                                                     }
                                                                    }else{
                                                                        $fraccion=0;
                                                                    }
                                                                     mysqli_stmt_free_result($stmt_prev);
                                                                     mysqli_stmt_close($stmt_prev);


                                                                    $sql2= " INSERT INTO v_clinica3.producto (codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,existencia,existencia_fr,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod)   
                                                                     SELECT codigo,descripcion,precio,precioIVA,precioPVP,precioFr,precioFr_o,precioFr_c,?,?,fraccion,id_lab,id_presentacion,id_tipo,id_grupo,vencimiento,iva,info_prod FROM producto where descripcion=? ";
                                                                        $stmt2 = mysqli_prepare($conexion, $sql2);
                                                                        mysqli_stmt_bind_param($stmt2, "iis",$existencia,$registro['cant'], $registro['descripcion']);
                                                                        if (!mysqli_stmt_execute($stmt2)) { 
                                                                            throw new Exception("Error al insertar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                                        }

                                                                     mysqli_stmt_free_result($stmt2);
                                                                     mysqli_stmt_close($stmt2);

                                                                     /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);


                                                                        


                                                        }

                                               /** Si existe producto aumenta las cantidades */
                                                 }else{

                                                        $acumcount+=$count;

                                                        if($registro['tipo_prod'] == 'U' ){ 
                                                           $sql2= " UPDATE v_clinica3.producto SET existencia=existencia+?  where  descripcion=? ";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "is",$registro['cant'], $registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al actualizar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }
                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);


                                                        }else if($registro['tipo_prod'] == 'F'){

                                                            
                                                            $fraccion=0;

                                                                 $sql_prev="SELECT fraccion FROM producto where descripcion=?";
                                                                  $stmt_prev = mysqli_prepare($conexion, $sql_prev);
                                                                  mysqli_stmt_bind_param($stmt_prev, "s",$registro['descripcion']);
                                                                   mysqli_stmt_execute($stmt_prev);
                                                                    mysqli_stmt_bind_result($stmt_prev,$fraccion);  
                                                                     mysqli_stmt_fetch($stmt_prev);
                                                                   
                                                                   

                                                                    
                                                                    $existencia=0;
                                                                 if($fraccion>0){ 
                                                                     if($registro['cant']>=$fraccion){
                                                                          
                                                                          $existencia= ceil($registro['cant'] / $fraccion);
                                                                     }else if($registro['cant'] < $fraccion){
                                                                          $existencia=1;   
                                                                     }
                                                                    }else{
                                                                        $fraccion=0;
                                                                    }

                                                                     mysqli_stmt_free_result($stmt_prev);
                                                                     mysqli_stmt_close($stmt_prev);


                                                            $sql2= " UPDATE v_clinica3.producto SET  existencia=existencia+?  ,existencia_fr=existencia_fr+?  where descripcion=?  ";
                                                            $stmt2 = mysqli_prepare($conexion, $sql2);
                                                            mysqli_stmt_bind_param($stmt2, "iis",$existencia,$registro['cant'],$registro['descripcion']);
                                                            if (!mysqli_stmt_execute($stmt2)) { 
                                                                throw new Exception("Error al actualizar registro en productos en v_clinica2: " . mysqli_error($conexion));
                                                            }
   
                                                             mysqli_stmt_free_result($stmt2);
                                                            mysqli_stmt_close($stmt2);

                                                             /** ELIMINANDO VENTA */
                                                                    $sql_elim= "DELETE FROM detalle_venta WHERE id_venta=? AND id_producto=? AND tipo_prod=? ";
                                                                    $stmt_elim = mysqli_prepare($conexion, $sql_elim);

                                                                        mysqli_stmt_bind_param( $stmt_elim, "iis",$registro['id_venta'], $registro['id_producto'],  $registro['tipo_prod']);
                                                                        
                                           
                                           
                                                                        if (!mysqli_stmt_execute( $stmt_elim)) { 
                                                                            throw new Exception("Error al eliminar registro en productos en v_clinica: " . mysqli_error($conexion));
                                                                        }

                                                                        mysqli_stmt_free_result($stmt_elim);
                                                                        mysqli_stmt_close($stmt_elim);

                                                        }

                                                 }


                                    
        
        
        }
        
        // Insertar en la tabla destino (ajusta los nombres de campos según tu estructura)
       
        // Opcional: marcar como trasladado en la tabla origen
       /* $sqlUpdate = "UPDATE viventas_uti SET trasladado = 1 WHERE id_venta = ? AND id_producto = ?";
        $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ii", $registro['id_venta'], $registro['id_producto']);
        mysqli_stmt_execute($stmtUpdate);*/
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
   // echo json_encode(['success' => true, 'message' => 'Traslado completado ']);
   echo json_encode(['success' => true, 'message' => '; Pasos: '.$acum_repitencia.' ; productos existentes: '.$acumcount]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>