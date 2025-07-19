<?php
include("../conexion.php");
if ($_POST['action'] == 'sales') {
    $arreglo = array();
    $query = mysqli_query($conexion, "SELECT descripcion, existencia FROM producto WHERE existencia>0 and existencia <= 3 ORDER BY existencia ASC LIMIT 20");
    while ($data = mysqli_fetch_array($query)) {
        $arreglo[] = $data;
    }
    echo json_encode($arreglo);
    die();
}
if ($_POST['action'] == 'polarChart') {
    $arreglo = array();
    $query = mysqli_query($conexion, "SELECT p.codproducto, p.descripcion, d.id_producto, d.cantidad, SUM(d.cantidad) as total FROM producto p INNER JOIN detalle_venta d WHERE p.codproducto = d.id_producto group by d.id_producto,p.codproducto, p.descripcion, d.cantidad ORDER BY d.cantidad DESC LIMIT 20");
    while ($data = mysqli_fetch_array($query)) {
        $arreglo[] = $data;
    }
    echo json_encode($arreglo);
    die();
}

if ($_POST['action'] == 'fecCad') {
    $arreglo = array();
    $query = mysqli_query($conexion, "SELECT p.*, t.tipo, pr.nombre,TIMESTAMPDIFF(MONTH, CURDATE() ,  p.vencimiento  ) as mesesVenc FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id WHERE p.vencimiento != '0000-00-00' AND  TIMESTAMPDIFF(MONTH, CURDATE() ,  p.vencimiento  )>=0 AND TIMESTAMPDIFF(MONTH, CURDATE() ,  p.vencimiento  ) <= 3 AND YEAR(p.vencimiento)<=YEAR(CURDATE()) ORDER BY p.vencimiento desc");
    while ($data = mysqli_fetch_array($query)) {
        $arreglo[] = $data;
    }
    echo json_encode($arreglo);
    die();
}
//
?>
