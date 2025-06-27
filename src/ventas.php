<?php
session_start();
include_once "includes/header.php";

if (!empty($_SESSION['idUser'])){  


$id_user = $_SESSION['idUser'];
$permiso = "nueva_venta";

$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso' ");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
   // header('Location: permisos.php');
   include "permisos.php";
   
}else{ 

?>
<script>


   function onlyOne(checkbox) {
        var checkboxes = document.getElementsByName('active');
        checkboxes.forEach((item) => {
            if (item !== checkbox) 
            item.checked = false;
        })
    }


</script>

<div class="row">
    <div class="col-lg-12">
        
        <div class="card">

                              <div class="card-header card-header-primary ">
									<h4 class="card-title">Venta de Productos</h4>
									
								</div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="hidden" id="idcliente" value="0" name="idcliente" required>
                                <label class=" text-dark font-weight-bold">Cédula o Nombre del Cliente</label>
                                <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" placeholder="Ingrese cédula o nombre del cliente" required>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">

                            <div class="form-group">
                                
                                <label class=" text-dark font-weight-bold">Cédula</label>
                                <input type="text" name="idcedula" id="idcedula" class="form-control" disabled required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label class=" text-dark font-weight-bold">Teléfono del Cliente</label>
                                <input type="number" name="tel_cliente" id="tel_cliente" class="form-control" disabled required>
                            </div>
                        </div>
                        </div>
                       </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                       <div class="row">
                       
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class=" text-dark font-weight-bold">Dirección del Cliente</label>
                                            <input type="text" name="dir_cliente" id="dir_cliente" class="form-control" disabled required>
                                        </div>
                                   </div>
                                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class=" text-dark font-weight-bold">E-mail del Cliente</label>
                                            <input type="text" name="mail_cliente" id="mail_cliente" class="form-control" disabled required>
                                        </div>
                                   </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
           
            <div class="card-body">
                <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="producto" class=" text-dark font-weight-bold">Código o Nombre del Producto</label>
                                                <input id="producto" class="form-control" type="text" name="producto" placeholder="Ingresa el código o nombre" autofocus required>
                                                <input id="id" type="hidden" name="id">
                                                <input id="id_presentacion" type="hidden" name="id_presentacion">
                                            </div>
                                        </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group" >
                                                <div id="areaFraccion" style="display:none;">
                                                <label for="fraccion" class=" text-dark font-weight-bold">Fracción/Venta</label>
                                                <input id="fraccion" class="form-control text-center" type="number" name="fraccion" min="0" placeholder="Fracciones" title="Presionar tecla Enter para agregar fracción a la venta."  onkeyup="calcularPrecioFraccion(event)" required>
                                                </div>
                                                <div id="areaUnidad">
                                                    <label for="cantidad" class=" text-dark font-weight-bold">Unidad/Venta</label>
                                                    <input id="cantidad" class="form-control text-center" type="number" name="cantidad" min="0" placeholder="Unidades" title="Presionar tecla Enter para agregar producto a la venta."  onkeyup="calcularPrecio(event)" required>
                                                </div>
                                                </div>
                                            </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                            <div id="areaStockFr" style="display:none;">

                                            <label for="stockFr" class=" text-dark font-weight-bold" style="font-size:11px;">Stock Bod. Fr.</label>
                                            <input id="stockFr" class="form-control text-center" type="text" name="stock" style="background-color: #f8fbac; text-content:center;"  disabled>
                                        
                                            </div>

                                            <div id="areaStock" >
                                                <label for="stock" class=" text-dark font-weight-bold">Stock Bod.</label>
                                                <input id="stock" class="form-control text-center" type="text" name="stock" style="background-color: #f8fbac; text-content:center;"  disabled>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                               <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                        <input id="precioC"  name="precioC" type="hidden" />

                                        
                                            <label for="precioPVP" class=" text-dark font-weight-bold">Precio PVP/u.</label>
                                            <input id="precioPVP" class="form-control text-center" type="text" name="precioPVP" style="background-color:#f7b77f"  disabled>
                                            <input id="precioPVPu"  type="hidden" name="precioPVPu" />
                                            <input id="precioPVPfr"  type="hidden" name="precioPVPfr" />
                                            <input id="precioPVPfr_c"  type="hidden" name="precioPVPfr_c" />
                                        
                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group" class=" text-dark font-weight-bold">
                                            <label for="iva" class=" text-dark font-weight-bold">Valor IVA</label>
                                            <input id="iva" class="form-control text-center" type="text" name="iva"  readonly>
                                        
                                        </div>

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="sub_total" class=" text-dark font-weight-bold">Total Producto</label>
                                            <input id="sub_total" class="form-control text-center" type="number" step="0,01" name="sub_total" style="background-color:#a8f45b"  disabled>
                                        </div>
                                    </div>
                           </div>
                        </div>


                        </div>

                    <div class="row" id="panelFraccion" style="display:none;">
                        <div class="col-lg-12">
                        <div class="row">
                                <div class="col-lg-2">
                                    
                                        <div class="form-group">
                                        <label for="tipoUnidad" class=" text-dark font-weight-bold">Tipo Unidad:</label>
                                        <select class="form-control" id="tipoUnidad" name="tipoUnidad" onchange="unidad_o_fraccion(event)">
                                            <option value="U">Unidad</option>
                                            <option value="F">Fracción</option>

                                        </select>
                                        
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                        <h4><span class="badge badge-pill badge-warning">Seleccionar para este tipo de medicamento si la venta es por caja (unidad) o por fracción.</span></h4>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                               
                            <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-success btn-sm" name="BtnAgregar" id="BtnAgregar" data-type="boton" onclick="agregarCompra(event)">
                                                Agregar a Compra
                                            </button>
                                        
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                            <button type="button" class="btn btn-primary btn-sm" id="btnInfo" name="btnInfo" data-bs-toggle="modal" data-bs-target="#ModalInfo" disabled>
                                                Información
                                            </button>
                                        
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                          <!-- <button type="button" class="btn btn-warning btn-sm" id="btnAlternativas" style="display:none" name="btnAlternativas" disabled>
                                                Alternativas
                                            </button>  -->
                                        </div>
                                </div>
                            </div>

                    </div>

            </div>
        </div>

       
        <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover" id="tblDetalle">
                <thead class="thead-light">
                    <tr >
                        <th>Id</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Unidades</th>
                        <th>Aplicar Desc.(%)</th>
                        <th>Desc.</th>
                        <th>Precio PVP/u.</th>
                        <th>Precio Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="detalle_venta">

                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td style="font-size:20px; font-weight: bold;">Total Pagar:</td>
                        <td style="font-size:20px; font-weight: bold;"></td>
                    </tr>
                </tfoot>
            </table>

      
      
        
        
        </div>
        </div>



   </div>
</div>

<div class="row">
                    <div class="col-lg-6 col-md-6" id="panelTransaccion">
                                        <div class="card">
                                                    <div class="card-body">
                                                       <b> Tipo Transacción:</b>
                                                    </div>   
                                                    <div class="card-body">
                                                            <input type="checkbox" name="active"  id="checkEfec" value="EF" onclick="onlyOne(this)" checked />
                                                            <label for="checkEfec" style="font-weight:bold">Efectivo</label>

                                                            <input type="checkbox"  name="active" id="checkTrans" value="TR" onclick="onlyOne(this)"/>
                                                            <label for="checkTrans" style="font-weight:bold">Transferencia</label>

                                                            <input type="checkbox" name="active"  id="checkTarj" value="TJ" onclick="onlyOne(this)"/>
                                                            <label for="checkTarj" style="font-weight:bold">Tarjeta</label>

                                                            <input type="checkbox" name="active" id="checkDeUna" value="DU" onclick="onlyOne(this)" />
                                                            <label for="checkDeUna" style="font-weight:bold">De una</label>
                                                    </div>

                                        </div>
                        </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
    
        <a href="#" class="btn btn-primary" id="btn_generar"><i class="fas fa-save"></i> Generar Venta</a>
    
    </div>
    

</div>



<!-- Modal -->
<div class="modal fade" id="ModalInfo" tabindex="-1" role="dialog" aria-labelledby="Label1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="Label1">Información Producto</h4>
        
      </div>
      <div class="modal-body">
        <div class="container">
     <div class="row">
      <h3 id="LabelTituloI" name="LabelTituloI">Titulo Información</h3>
     </div>
      <hr>
      <div class="row">
      <label for="info_producto_v" class=" text-dark font-weight-bold"><b>Información:</b></label>
      <textarea placeholder="" class="form-control" name="info_producto_v" id="info_producto_v" rows="16"  disabled></textarea>
      </div>
      <div class="row">
      <div id="divShowCaja" style="margin-top:1em;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

         <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
         <label for="info_caja_fr" class=" text-dark font-weight-bold"><b>Caja contiene:</b></label>
         </div>
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                
                <input id="info_caja_fr" style="width:6em; text-align:center;" name="info_caja_fr" disabled /> fracciones.
            </div>
      </div>
</div>
        </div>
       </div>
      </div>
</div>
      <div class="modal-footer">
      <div class="row">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
       </div>
       
      </div>
    </div>
  </div>
</div>





<?php 
 }
 }else{
    header("Location: ../index.php");
 } ?>
<?php include_once "includes/footer.php"; ?>