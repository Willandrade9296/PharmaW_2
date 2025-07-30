
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
    foreach ($data['datos'] as $registro) {
        // Determinar el tipo de traslado basado en los checkboxes
        $tipoTraslado = '';
        if ($registro['general']) $tipoTraslado = 'General';
        if ($registro['reserva']){
                        $tipoTraslado = 'Reserva';
                        $sql = "INSERT INTO paso_reserva
                                (id_venta, id_producto, tipo_traslado, fecha_traslado,tipo_prod,cantidad) 
                                SELECT id_venta, id_producto, ?, NOW() ,tipo_prod,cantidad
                                FROM viventas_uti 
                                WHERE id_venta = ? AND id_producto = ? AND tipo_prod= ?" ;
                        
                        $stmt = mysqli_prepare($conexion, $sql);
                        mysqli_stmt_bind_param($stmt, "siis", $tipoTraslado, $registro['id_venta'], $registro['id_producto'],$registro['tipo_prod']);
                        
                        if (!mysqli_stmt_execute($stmt)) {
                            throw new Exception("Error al insertar registro en Reserva: " . mysqli_error($conexion));
                        }
                        

                 }
        if ($registro['cparo']) $tipoTraslado = 'C. Paro';
        
        // Insertar en la tabla destino (ajusta los nombres de campos según tu estructura)
       
        // Opcional: marcar como trasladado en la tabla origen
       /* $sqlUpdate = "UPDATE viventas_uti SET trasladado = 1 WHERE id_venta = ? AND id_producto = ?";
        $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ii", $registro['id_venta'], $registro['id_producto']);
        mysqli_stmt_execute($stmtUpdate);*/
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
    echo json_encode(['success' => true, 'message' => 'Traslado completado']);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>