<?php

try{ 
require "../conexion.php";
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$total['usuarios'] = mysqli_num_rows($usuarios);
$clientes = mysqli_query($conexion, "SELECT * FROM cliente");
$total['clientes'] = mysqli_num_rows($clientes);
$productos = mysqli_query($conexion, "SELECT * FROM producto");
$total['productos'] = mysqli_num_rows($productos);
$ventas = mysqli_query($conexion, "SELECT * FROM ventas WHERE fecha > CURDATE()");
$total['ventas'] = mysqli_num_rows($ventas);
session_start();
include_once "includes/header.php";
?>
<!-- Content Row -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <a href="usuarios.php" class="card-category text-warning font-weight-bold">
                    Usuarios
                </a>
                <h3 class="card-title"><?php echo $total['usuarios']; ?></h3>
            </div>
            <div class="card-footer bg-warning text-white">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <a href="clientes.php" class="card-category text-success font-weight-bold">
                    Clientes
                </a>
                <h3 class="card-title"><?php echo $total['clientes']; ?></h3>
            </div>
            <div class="card-footer bg-secondary text-white">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fab fa-product-hunt fa-2x"></i>
                </div>
                <a href="productos.php" class="card-category text-danger font-weight-bold">
                    Productos
                </a>
                <h3 class="card-title"><?php echo $total['productos']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-cash-register fa-2x"></i>
                </div>
                <a href="ventas.php" class="card-category text-info font-weight-bold">
                    Ventas
                </a>
                <h3 class="card-title"><?php echo $total['ventas']; ?></h3>
            </div>
            <div class="card-footer bg-danger text-white">
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Productos por Vencer
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover" id="tblfechav">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Presentacion</th>
                            <th>Fecha Venc.</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";
                       
//                        $query = mysqli_query($conexion, "SELECT p.*, t.tipo, pr.nombre FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id WHERE p.vencimiento != '0000-00-00' AND p.vencimiento < '$hoy'");
                        $query = mysqli_query($conexion, "SELECT p.*, t.tipo, pr.nombre FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id WHERE p.vencimiento != '0000-00-00' AND  TIMESTAMPDIFF(MONTH, CURDATE() ,  p.vencimiento  ) <= 3 AND YEAR(p.vencimiento)<=YEAR(CURDATE()) ORDER BY p.vencimiento desc");
                  

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['codproducto']; ?></td>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['tipo']; ?></td>
                                    <td><?php echo $data['nombre']; ?></td>
                                    
                                    <td><?php echo $data['vencimiento']; ?></td>
                                   
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Productos Stock mínimo
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover" id="tblstockmin">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Presentacion</th>
                            <th>Stock</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";
                       
                        $query2 = mysqli_query($conexion, "SELECT p.*, t.tipo, pr.nombre FROM producto p INNER JOIN tipos t ON p.id_tipo = t.id INNER JOIN presentacion pr ON p.id_presentacion = pr.id WHERE p.existencia <= 3");
                        $result2 = mysqli_num_rows($query2);
                        if ($result2 > 0) {
                            while ($data = mysqli_fetch_assoc($query2)) { ?>
                                <tr>
                                    <td><?php echo $data['codproducto']; ?></td>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['tipo']; ?></td>
                                    <td><?php echo $data['nombre']; ?></td>
                                    
                                    <td><?php echo $data['existencia']; ?></td>
                                    
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="title-2 m-b-40">Productos con stock mínimo</h3>
            </div>
            <div class="card-body">
                <canvas id="stockMinimo"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="title-2 m-b-40">Productos más vendidos</h3>
            </div>
            <div class="card-body">
                <canvas id="ProductosVendidos"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php";
}catch(Exception $e){

    echo "Error: ".$e->getMessage();
}

?>
