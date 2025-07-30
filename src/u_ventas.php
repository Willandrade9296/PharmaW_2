<?php
session_start();
include_once "includes/header.php";

if (!empty($_SESSION['idUser'])){ 
$id_user = $_SESSION['idUser'];
$permiso = "uti_ventas";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
}else{ 

if (!empty($_POST)) {
    $alert = "";
    
    mysqli_close($conexion);
}

?>
<div class="card">

                            <div class="card-header card-header-primary ">
									<h4 class="card-title">Utilitario Ventas</h4>
									
								</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#divVentas" aria-expanded="false" aria-controls="divVentas">Movimientos</button>
                    
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#divVentasE" aria-expanded="false" aria-controls="divVentasE">Devoluciones</button>
                    
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#divPaso" aria-expanded="false" aria-controls="divPaso">Realizar Traslados</button>
                    
                            </div>
                </div>
           </div>
            

            <div class="col-md-12">
                <div class="collapse multi-collapse show " id="divVentas">
                    <div class="card">
                        <div class="card-header">
                           <h4> Movimientos </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tbldowngen" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID venta</th>
                                            <th>ID Producto</th>
                                            <th>Producto</th>
                                            <th>Tipo prod.</th>
                                            <th>Cant.</th>
                                            <th>Precio PVP</th>
                                            <th>Precio Total</th>
                                            <th>Fecha Venta</th>
                                            <th>Tipo Trans.</th>
                                            <th>Usuario</th>
                                            <th>Razon</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "../conexion.php";

                                        $query = mysqli_query($conexion, "SELECT * FROM viventas_uti ORDER BY fecha desc");
                                        $result = mysqli_num_rows($query);
                                        if ($result > 0) {
                                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                                <tr>
                                                    <td><?php echo $data['id_venta']; ?></td>
                                                    <td><?php echo $data['id_producto']; ?></td>
                                                    <td><?php echo $data['descripcion']; ?></td>
                                                    <td><?php echo $data['tipo_prod']; ?></td>
                                                    <td >
                                                          <input 
                                                                class="form-control" 
                                                                id="cantUti_<?php echo $data['id_venta']; ?>_<?php echo $data['id_producto']; ?>_<?php echo $data['tipo_prod']; ?>" 
                                                                placeholder="Cant." 
                                                                type="number" 
                                                                min="0" 
                                                                max="<?php echo $data['cantidad']; ?>"  
                                                                step="1" 
                                                                value="<?php echo $data['cantidad']; ?>"
                                                            >    
                                                    </td>
                                                   
                                                    <td><?php echo $data['precioPVP']; ?></td>
                                                    <td><?php echo $data['total']; ?></td>
                                                    <td><?php echo $data['fecha']; ?></td>
                                                    <td><?php echo $data['tipo_trans']; ?></td>
                                                    <td><?php echo $data['nombre']; ?></td>
                                                    <td> <input type="text" class="form-control" id="razon_<?php echo $data['id_venta']; ?>" name="razon"  /></td>
                                                    <td style="width: 200px;">
                                                                  <form 
                                                                    action="eliminar_venta.php" 
                                                                    method="get" 
                                                                    class="confirmar d-inline"
                                                                    onsubmit="return actualizarCantidad(this, 'cantUti_<?php echo $data['id_venta']; ?>_<?php echo $data['id_producto']; ?>_<?php echo $data['tipo_prod']; ?>')"
                                                                >
                                                                    <input type="hidden" name="id_venta" value="<?php echo $data['id_venta']; ?>">
                                                                    <input type="hidden" name="id_prod" value="<?php echo $data['id_producto']; ?>">
                                                                    <input type="hidden" name="tipo_prod" value="<?php echo $data['tipo_prod']; ?>">
                                                                    <input type="hidden" name="cant" id="cantidadEnviar_<?php echo $data['id_venta']; ?>" min="0" max="<?php echo $data['cantidad']; ?>">
                                                                    <input type="hidden" name="razon" value="">
                                                                    <button class="btn btn-danger btn-sm" type="submit">
                                                                        <i class='fas fa-trash-alt'></i>
                                                                    </button>
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

                <div class="collapse multi-collapse " id="divVentasE">

                                <div class="card">
                                        <div class="card-header">
                                        <h4>  Devoluciones </h4>
                                        </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover tbldowngen" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID venta</th>
                                                <th>ID Producto</th>
                                                <th>Producto</th>
                                                <th>Tipo prod.</th>
                                                <th>Cant.</th>
                                                <th>Precio PVP</th>
                                                <th>Precio Total</th>
                                                <th>Fecha Venta</th>
                                                <th>Tipo Trans.</th>
                                                <th>Usuario</th>
                                                <th>Razon</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conexion.php";

                                            $query = mysqli_query($conexion, "SELECT * FROM ventas_eliminadas ORDER BY fecha desc");
                                            $result = mysqli_num_rows($query);
                                            if ($result > 0) {
                                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                                    <tr>
                                                        <td><?php echo $data['id_venta']; ?></td>
                                                        <td><?php echo $data['id_producto']; ?></td>
                                                        <td><?php echo $data['descripcion']; ?></td>
                                                        <td><?php echo $data['tipo_prod']; ?></td>
                                                        <td><?php echo $data['cantidad']; ?></td>
                                                        <td><?php echo $data['precioPVP']; ?></td>
                                                        <td><?php echo $data['total']; ?></td>
                                                        <td><?php echo $data['fecha']; ?></td>
                                                        <td><?php echo $data['tipo_trans']; ?></td>
                                                        <td><?php echo $data['usuario']; ?></td>
                                                        <td><?php echo $data['razon']; ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>

                                    </table>
                                    </div>
                                    </div>

                                </div>

                    
                </div>

                 <div class="collapse multi-collapse " id="divPaso">
  


                 <div class="card">
                                        <div class="card-header">
                                        <h4> Realizar Traslados </h4>
                                        </div>
                                    <div class="card-body">
                <form id="trasladoForm" method="post">
                                    <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover tbldowngen" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID venta</th>
                                                <th>ID Producto</th>
                                                <th>Producto</th>
                                                <th>Tipo prod.</th>
                                                <th>Cant.</th>
                                                
                                                <th>Fecha Venta</th>
                                                <th>Tipo Trans.</th>
                                                <th>Usuario</th>
                                                <th>Cliente</th>
                                                <th style="cursor: pointer;">
                                                                <input type="checkbox" id="selectAllCol1" onclick="event.stopPropagation();  toggleCheckboxes('Col1')">
                                                                <b>General</b>
                                                </th>
                                                <th style="cursor: pointer;">
                                                                <input type="checkbox" id="selectAllCol2" onclick="event.stopPropagation();  toggleCheckboxes('Col2')">
                                                                <b>Reserva</b>
                                                </th>
                                                <th style="cursor: pointer;">
                                                                <input type="checkbox" id="selectAllCol3" onclick="event.stopPropagation();  toggleCheckboxes('Col3')">
                                                                <b>C. Paro</b>
                                                </th>
                                               
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conexion.php";

                                            $query = mysqli_query($conexion, "SELECT * FROM viventas_uti ORDER BY fecha desc");
                                            $result = mysqli_num_rows($query);
                                            if ($result > 0) {
                                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                                    <tr>
                                                        <td><?php echo $data['id_venta']; ?></td>
                                                        <td><?php echo $data['id_producto']; ?></td>
                                                        <td><?php echo $data['descripcion']; ?></td>
                                                        <td><?php echo $data['tipo_prod']; ?></td>
                                                        <td><?php echo $data['cantidad']; ?></td>
                                                       
                                                        <td><?php echo $data['fecha']; ?></td>
                                                        <td><?php echo $data['tipo_trans']; ?></td>
                                                        <td><?php echo $data['nombre']; ?></td>
                                                        <td><?php echo $data['cliente']; ?></td>
                                                         <td>
                                                                        <div class="form-check form-check-inline m-4">
                                                                        <input  type="checkbox"  id="chk1"  class="chk1 only-one"
                                                                        
                                                                        data-idventa="<?php echo $data['id_venta']; ?>"
                                                                        data-idproducto="<?php echo $data['id_producto']; ?>"
                                                                        data-descripcion="<?php echo $data['descripcion']; ?>"
                                                                        data-tipo_prod="<?php echo $data['tipo_prod']; ?>"
                                                                        <?php
                                                                                                                        if ( strpos($data['cliente'] , "General")  !== false    ) {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?> />
                                                                       
                                                                        </div>
                                                                    </td>
                                                                     <td>
                                                                        <div class="form-check form-check-inline m-4">
                                                                        <input type="checkbox"  id="chk2"   class="chk2 only-one"
                                                                         data-idventa="<?php echo $data['id_venta']; ?>"
                                                                         data-idproducto="<?php echo $data['id_producto']; ?>"
                                                                         data-descripcion="<?php echo $data['descripcion']; ?>"
                                                                         data-tipo_prod="<?php echo $data['tipo_prod']; ?>"
                                                   
                                                                                                                 <?php
                                                                                                                        if ( strpos($data['cliente'] , "Reserva")  !== false  || strpos($data['cliente'] , "Quirofano")  !== false   ) {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?> />
                                                                        </div>
                                                                    </td>
                                                                     <td>
                                                                        <div class="form-check form-check-inline m-4">
                                                                        <input  type="checkbox"  id="chk3"  class="chk3 only-one"
                                                                        
                                                                         data-idventa="<?php echo $data['id_venta']; ?>"
                                                                         data-idproducto="<?php echo $data['id_producto']; ?>" 
                                                                         data-descripcion="<?php echo $data['descripcion']; ?>"
                                                                         data-tipo_prod="<?php echo $data['tipo_prod']; ?>"

                                                                         <?php
                                                                                                                        if ( strpos($data['cliente'] , "Paro")  !== false   ) {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?> />
                                                                        </div>
                                                                    </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>

                                    </table>

                                  
                                    </div>

                                      <div class="row">   

                                                <div class="col-md-6">

                                                 </div>
                                                <div class="col-md-6">
                                                    <input type="submit" value="Realizar Traslado" class="btn btn-lg btn-success" id="btnGrabarTrasl">
                                                    
                                                </div>
                                            </div>
                                     </form>

                                    </div>

                                </div>


                </div>
           
            </div>

           
             
                       
                       
        </div>
    </div>
</div>

<script>
function actualizarCantidad(form, idInputCant) {
    // Obtiene el input de cantidad por su ID único
    const inputCant = document.getElementById(idInputCant);
    // Asigna su valor al campo oculto 'cant' del formulario
    form.querySelector('input[name="cant"]').value = inputCant.value;

    // Obtiene el ID de la venta desde el formulario
    const idVenta = form.querySelector('input[name="id_venta"]').value;
    
    // Obtiene el valor del input razón correspondiente a esta fila
    const razonInput = document.getElementById('razon_' + idVenta);
    form.querySelector('input[name="razon"]').value = razonInput.value;


    return true; // Permite el envío del formulario
}

 function toggleCheckboxes(columna) {
        // Mapeamos los nombres de columna a los números de prefijo
        const columnMap = {
            'Col1': '1',
            'Col2': '2',
            'Col3': '3'
        };
        
        const prefix = columnMap[columna];
        const selectAllCheckbox = document.getElementById(`selectAll${columna}`);
        const checkboxes = document.querySelectorAll(`input[id^="chk${prefix}"]`);
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });

        return false;
    }



document.getElementById('btnGrabarTrasl').addEventListener('click', function() {

     event.preventDefault();
    // Recolectar todos los registros
    const rows = document.querySelectorAll('tbody tr');
    const datosTraslado = [];
    
    rows.forEach(row => {
        const idVenta = row.querySelector('td:first-child').textContent;
        const idProducto = row.querySelector('td:nth-child(2)').textContent;
        const descripcion = row.querySelector('td:nth-child(3)').textContent;
        const tipoProd = row.querySelector('td:nth-child(4)').textContent;
        
        const chk1 = row.querySelector('.chk1')?.checked || false;
        const chk2 = row.querySelector('.chk2')?.checked || false;
        const chk3 = row.querySelector('.chk3')?.checked || false;
        

        
        // Solo agregar si al menos un checkbox está marcado
        if (chk1 || chk2 || chk3) {
            datosTraslado.push({
                id_venta: idVenta,
                id_producto: idProducto,
                descripcion:descripcion,
                tipo_prod:tipoProd,
                general: chk1 ? 1 : 0,
                reserva: chk2 ? 1 : 0,
                cparo: chk3 ? 1 : 0
            });
        }
    });
    
    if (datosTraslado.length === 0) {
        alert('No hay registros seleccionados para trasladar');
        return;
    }
    
    // Enviar datos al servidor
    
    fetch('procesar_traslado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ datos: datosTraslado })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Traslado realizado con éxito');
           // location.reload(); // Recargar la página para ver cambios
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al procesar el traslado');
    });
    
});






/** Codigo para seleccionar un solo check por cada fila */

document.querySelectorAll('table.tbldowngen tbody tr').forEach(row => {
    let checkedCheckbox = null;
    
    // Encuentra todos los checkboxes "only-one" en esta fila específica
    const checkboxes = row.querySelectorAll('.only-one');
    
    // Asigna el evento click a cada checkbox de la fila
    checkboxes.forEach(checkbox => {
        checkbox.onclick = function() {
            if (checkedCheckbox !== null && checkedCheckbox !== this) {
                checkedCheckbox.checked = false;
            }
            
            // Actualiza la referencia al checkbox marcado
            checkedCheckbox = this.checked ? this : null;
        };
        
        // Inicializa el checkedCheckbox si algún checkbox ya está marcado
        if (checkbox.checked && checkedCheckbox === null) {
            checkedCheckbox = checkbox;
        }
    });
});
</script>






<?php  } 
}else{
    header("Location: ../index.php");
    
}?>
<?php include_once "includes/footer.php"; ?>