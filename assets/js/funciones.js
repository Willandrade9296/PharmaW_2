/* Evento para desaparecer los mensajes de acuerdo a un tiempo */
setTimeout(function() {
    $(".alert").fadeOut();           
},3000);

document.addEventListener("DOMContentLoaded", function () {


const urlDataTable= "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json";

$(document).ready(function() {
    $(".dropdown-toggle").dropdown();
});

        $('#tblfechav').DataTable({
            language: {
                "url": urlDataTable
            },

            dom: 'lBfrtip',
                   
                        buttons: [
                            {
                                extend:'print',
                                text:"Imprimir",
                                title:'Productos por vencer',
                                titleAttr:'Imprimir Detalle'
                            }, 
                            {
                                extend:'excelHtml5',
                                text:"Excel",
                                title:'Productos por vencer',
                                titleAttr:'Exportar a Excel'
                            },
                            {
                                extend:'pdfHtml5',
                                text:"PDF",
                                title:'Productos por vencer',
                                titleAttr:'Exportar en PDF'
                                }
                            ]
                          
                        ,
                        initComplete: function () {
                            var btns = $('.dt-button');
                            btns.addClass('btn btn-success btn-sm');
                            btns.removeClass('dt-button');
    
                        },
    

            "order": [
                [0, "desc"]
            ]
        });





            $('#tblstockmin').DataTable({
                language: {
                    "url": urlDataTable
                },

                dom: 'lBfrtip',
                   
                        buttons: [
                            {
                                extend:'print',
                                text:"Imprimir",
                                title:'Productos stock mínimo',
                                titleAttr:'Imprimir Detalle'
                            }, 
                            {
                                extend:'excelHtml5',
                                text:"Excel",
                                title:'Productos stock mínimo',
                                titleAttr:'Exportar a Excel'
                            },
                            {
                                extend:'pdfHtml5',
                                text:"PDF",
                                title:'Productos stock mínimo',
                                titleAttr:'Exportar en PDF'
                                }
                            ]
                          
                        ,
                        initComplete: function () {
                            var btns = $('.dt-button');
                            btns.addClass('btn btn-success btn-sm');
                            btns.removeClass('dt-button');
    
                        },
    

                "order": [
                    [0, "desc"]
                ]
            });


            $('#tbl').DataTable({
                language: {
                    "url": urlDataTable
                },
                "order": [
                    [0, "desc"]
                ]
            });

    $('#tbl2').DataTable({
        language: {
            "url": urlDataTable
        },
        "order": [
            [0, "desc"]
        ]
    });


    $('#tblUtilidad').DataTable().destroy();
            
           
    
  


 /*   var tableU = $('#tblUtilidad').DataTable( {

        language: {
            "url": urlDataTable
        },
        "order": [
            [0, "desc"]
        ],
       
        buttons: [
            'copy', 'print', 'excel', 'pdf'
        ]
    } );

    if(tableU.data().count() > 0){ 
    tableU.buttons().container().appendTo( $('.col-sm-6:eq(0)', tableU.table().container() ) );
    }
*/
    $(".confirmar").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
    })
    $("#nom_cliente").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#idcliente").val(ui.item.id);
            $("#nom_cliente").val(ui.item.value);
            $("#idcedula").val(ui.item.idcedula);
            $("#tel_cliente").val(ui.item.telefono);
            $("#dir_cliente").val(ui.item.direccion);
            $("#mail_cliente").val(ui.item.email);
        }
    })
    $("#producto").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    pro: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#id_presentacion").val(ui.item.id_presentacion);
            $("#producto").val(ui.item.value);
           
            /* Titulo para visualización en modal de información */
            $("#LabelTituloI").text(ui.item.value);

            $('#stock').val(ui.item.cantidad);
            $('#stockFr').val(ui.item.stockFr);
            $("#precioC").val(ui.item.precioC);
            $("#precioPVP").val(ui.item.precioPVP);
            /*Precio PVP unidad almacena el precio PVP mientras que preciofr almacena el precio de unidad fracción */
            $("#precioPVPu").val(ui.item.precioPVP);
            $("#precioPVPfr").val(ui.item.precioFr);
            $("#precioPVPfr_c").val(ui.item.precioFr_c);

            $("#iva").val(ui.item.precioIVA);
            $("#info_producto_v").val(ui.item.info_prod);
           
            $("#info_caja_fr").val(ui.item.fraccion);
            $("#cantidad").focus();

       /* Habilitando botón para mostrar información sobre producto */
            $('#btnInfo').prop('disabled',false);
            

           var presentac= $("#id_presentacion").val();

           if(presentac === '4'){
            $('#panelFraccion').css('display','initial');
            $('#divShowCaja').css('display','initial');

            $('#tipoUnidad').prop('required',true);
          
            unidad_o_fraccion(event);

            

           }else{
            $('#panelFraccion').css('display','none');
            $('#divShowCaja').css('display','none');

            $('#tipoUnidad').removeAttr("required");
            $('#tipoUnidad').val('U');
            unidad_o_fraccion(event);
           }

        }
    })

    $('#btn_generar').click(function (e) {
        e.preventDefault();
        var rows = $('#tblDetalle tr').length;
        if (rows > 2) {
            var action = 'procesarVenta';
            var id = $('#idcliente').val();
            var active= $("input[name=active]:checked").val();
         
       //   var tipo_unidad= $("#tipoUnidad option:selected").val();
       if (active != null){ 
          
            $.ajax({
                url: 'ajax.php',
                async: true,
                data: {
                    procesarVenta: action,
                    id: id,
                    active:active
                   
                },
                success: function (response) {

                    const res = JSON.parse(response);
                    if (res['mensaje'] != 'error') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Venta Generada',
                            showConfirmButton: false,
                            timer: 2000
                        })


                        setTimeout(() => {
                            generarPDF(res.id_cliente, res.id_venta);
                            location.reload();
                        }, 300);
                      
                        /* Deshabilitando botón para mostrar información sobre producto */
                        $('#btnInfo').prop('disabled',true);

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error al generar la venta, verificar cliente.',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function (error) {

                }
            });

        }else{
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Por favor seleccionar tipo de transacción para la venta.',
                showConfirmButton: false,
                timer: 2000
            })

          }

        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'No hay producto para generar la venta',
                showConfirmButton: false,
                timer: 2000
            })
        }

          
    });

    if (document.getElementById("detalle_venta")) {
        listar();
    }
})

function calcularPrecio(e) {
    e.preventDefault();
    var cant = $("#cantidad").val();
    var stock = $("#stock").val();


if (cant != '')
{
    if (Number(stock) >= Number(cant))
    { 

    const precioC=$("#precioC").val();
    const precio = $('#precioPVP').val();
    const iva= $('#iva').val();
    const total = cant * (parseFloat(precio) );

    $('#sub_total').val(parseFloat(Number(total).toFixed(2)));

    var {type} = e.target.dataset;


            if (e.which == 13 || type === 'boton') {
                if (cant > 0 && cant != '') {
                    const id = $('#id').val();
                    registrarDetalle(e, id,cant,stock,precioC, precio,iva,'U');
                    $('#producto').focus();
                } else {
                    $('#cantidad').focus();
                    return false;
                }
            }
          
            



  }else{
   
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'No se puede agregar producto a esta venta, revisar stock.',
        showConfirmButton: false,
        timer: 3000
    })
    $("#stock").focus();
   

  }



           var presentac= $("#id_presentacion").val();

           if(presentac === '4'){
            $('#panelFraccion').css('display','initial');

            $('#tipoUnidad').prop('required',true);
           


           }else{
            $('#panelFraccion').css('display','none');

            $('#tipoUnidad').removeAttr("required");
            $('#tipoUnidad').val('U');

           }

}

}


function calcularPrecioFraccion(e) {
     e.preventDefault();
    var cantFr = $("#fraccion").val();
    var stockFr = $("#stockFr").val();

    

   if(cantFr != '' ){ 

    
    if (Number(stockFr) >= Number(cantFr))
    { 



    const precioC=$("#precioPVPfr_c").val();
    const precio = $('#precioPVP').val();
    
    const total = cantFr * precio;

    $('#sub_total').val(parseFloat(Number(total).toFixed(2)));

    var {type} = e.target.dataset;

    if (e.which == 13 || type === 'boton') {
        if (cantFr > 0 && cantFr != '') {
            const id = $('#id').val();
            registrarDetalle(e, id,cantFr,stockFr,precioC, precio,'0','F');
            $('#producto').focus();
        } else {
            $('#fraccion').focus();
            return false;
        }
    }




  }else{
    
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'No se puede agregar producto a esta venta, revisar stock en fracciones.',
        showConfirmButton: false,
        timer: 3000
    })
    $("#stockFr").focus();
   

  }

   

           var presentac= $("#id_presentacion").val();

           if(presentac === '4'){
            $('#panelFraccion').css('display','initial');

            $('#tipoUnidad').prop('required',true);
           


           }else{
            $('#panelFraccion').css('display','none');

            $('#tipoUnidad').removeAttr("required");
            $('#tipoUnidad').val('U');

           }
    }



}

function agregarCompra(event){
    
   var tipo =$("#tipoUnidad").val();
    if( tipo === 'F'){
       calcularPrecioFraccion(event);
    }else{

        
      calcularPrecio(event);
    }

}


function calcularDescuento(e, id) {
    if (e.which == 13) {
        let descuento = 'descuento';
        $.ajax({
            url: "ajax.php",
            type: 'GET',
            dataType: "json",
            data: {
                id: id,
                desc: e.target.value,
                descuento: descuento
                
            },
            success: function (response) {

                if (response.mensaje == 'descontado') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Descuento Aplicado',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    listar();
                } else {}
            }
        });
    }
}

function listar() {
    let html = '';
    let detalle = 'detalle';
    $.ajax({
        url: "ajax.php",
        dataType: "json",
        data: {
            detalle: detalle
        },
        success: function (response) {

            response.forEach(row => {
                html += `<tr>
                <td>${row['id']}</td>
                <td>${row['descripcion']}</td>
                <td>${row['tipo_prod']}</td>
                <td>${row['cantidad']}</td>
                <td width="100">
                <input class="form-control" placeholder="Desc" type="number" min="0" max="1" step="0.01" onkeyup="calcularDescuento(event, ${row['id']})">
                </td>
                <td>${row['descuento']}</td>
                <td>${row['precio_venta']}</td>
                <td>${row['sub_total']}</td>
                <td><button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']})">
                <i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
            });
            document.querySelector("#detalle_venta").innerHTML = html;
            calcular();
        }
    });
}

function registrarDetalle(e, id, cant,stock, precioC,precio,iva,tipo_unidad) {
    if (document.getElementById('producto').value != '') {
        if (id != null) {

            if( Number(stock) >= Number(cant)){ 
            let action = 'regDetalle';
            $.ajax({
                url: "ajax.php",
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    cant: cant,
                    regDetalle: action,
                    precioC:precioC,
                    precio: precio,
                    stock:stock,
                    iva:iva,
                    tipo_unidad:tipo_unidad
                },
                success: function (response) {

                    if (response == 'registrado') {
                        $('#id_presentacion').val('');
                        $('#cantidad').val('');
                        $('#fraccion').val('');
                        $('#stock').val('0');
                        $('#stockFr').val('0');
                        $('#precioC').val('');
                        $('#precioPVP').val('');
                        $('#iva').val('');
                        $("#producto").val('');
                        $("#sub_total").val('');
                        $("#producto").focus();

                        $('#btnInfo').prop('disabled',true);
                        
                        listar();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Ingresado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else if (response == 'actualizado') {
                        $('#id_presentacion').val('');
                        $('#cantidad').val('');
                        $('#fraccion').val('');
                        $('#stock').val('0');
                        $('#stockFr').val('0');
                        $('#precioC').val('');
                        $('#precioPVP').val('');
                        $('#iva').val('');
                        $("#producto").val('');
                        $("#producto").focus();
                        /* Deshabilitando botón para mostrar información sobre producto */
                        $('#btnInfo').prop('disabled',true);

                       
                        listar();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Actualizado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        $('#id').val('');
                        $('#id_presentacion').val('');
                        $('#cantidad').val('');
                        $('#fraccion').val('');
                        $('#stock').val('0');
                        $('#stockFr').val('0');
                        $('#precioC').val('');
                        $('#precioPVP').val('');
                        $('#iva').val('');
                        $("#producto").val('');
                        $("#producto").focus();
                        /* Deshabilitando botón para mostrar información sobre producto */
                        $('#btnInfo').prop('disabled',true);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }


                    $('#panelFraccion').css('display','none');

                    $('#tipoUnidad').removeAttr("required");
                    $('#tipoUnidad').val('U');
                }
            });

           }else{
             $('#stock').focus();

                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'No se puede realizar la venta',
                            showConfirmButton: false,
                            timer: 2000
                        })

           }

          
            

           
        }
    }
}

function deleteDetalle(id) {
    let detalle = 'Eliminar'
    $.ajax({
        url: "ajax.php",
        data: {
            id: id,
            delete_detalle: detalle
        },
        success: function (response) {

            if (response == 'restado') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Producto Descontado',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#producto").value = '';
                document.querySelector("#producto").focus();
                listar();
            } else if (response == 'ok') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Producto Eliminado',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#producto").value = '';
                document.querySelector("#producto").focus();
                listar();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}

function calcular() {
    // obtenemos todas las filas del tbody
    var filas = document.querySelectorAll("#tblDetalle tbody tr");

    var total = 0;

    // recorremos cada una de las filas
    filas.forEach(function (e) {

        // obtenemos las columnas de cada fila
        var columnas = e.querySelectorAll("td");

        // obtenemos los valores de la cantidad y importe
        var importe = parseFloat(columnas[7].textContent);

        total += importe;
    });

    // mostramos la suma total
    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[1].textContent = total.toFixed(2);
}

function generarPDF(cliente, id_venta) {
    url = 'pdf/generar.php?cl=' + cliente + '&v=' + id_venta;
    window.open(url, '_blank');
}
if (document.getElementById("stockMinimo")) {
    const action = "sales";
    $.ajax({
        url: 'chart.php',
        type: 'POST',
        data: {
            action
        },
        async: true,
        success: function (response) {
            if (response != 0) {
                var data = JSON.parse(response);
                var nombre = [];
                var cantidad = [];
                for (var i = 0; i < data.length; i++) {
                    nombre.push(data[i]['descripcion']);
                    cantidad.push(data[i]['existencia']);
                }
                var ctx = document.getElementById("stockMinimo");
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: nombre,
                        datasets: [{
                            data: cantidad,
                            backgroundColor: ['#024A86', '#E7D40A', '#581845', '#C82A54', '#EF280F', '#8C4966', '#FF689D', '#E36B2C', '#69C36D', '#23BAC4'],
                        }],
                    },
                });
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}
if (document.getElementById("ProductosVendidos")) {
    const action = "polarChart";
    $.ajax({
        url: 'chart.php',
        type: 'POST',
        async: true,
        data: {
            action
        },
        success: function (response) {
            if (response != 0) {
                var data = JSON.parse(response);
                var nombre = [];
                var cantidad = [];
                for (var i = 0; i < data.length; i++) {
                    nombre.push(data[i]['descripcion']);
                    cantidad.push(data[i]['cantidad']);
                }
                var ctx = document.getElementById("ProductosVendidos");
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: nombre,
                        datasets: [{
                            data: cantidad,
                            backgroundColor: ['#C82A54', '#EF280F', '#23BAC4', '#8C4966', '#FF689D', '#E7D40A', '#E36B2C', '#69C36D', '#581845', '#024A86'],
                        }],
                    },
                });
            }
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function btnCambiar(e) {
    e.preventDefault();
    const actual = document.getElementById('actual').value;
    const nueva = document.getElementById('nueva').value;
    if (actual == "" || nueva == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Los campos estan vacios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const cambio = 'pass';
        $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: {
                actual: actual,
                nueva: nueva,
                cambio: cambio
            },
            success: function (response) {
                if (response == 'ok') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Contraseña modificado',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    document.querySelector('#frmPass').reset();
                    $("#nuevo_pass").modal("hide");
                } else if (response == 'dif') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'La contraseña actual incorrecta',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al modificar la contraseña',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        });
    }
}

function editarCliente(id) {
    const action = "editarCliente";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarCliente: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#cedula').val(datos.cedula);
            $('#nombre').val(datos.nombre);
            $('#telefono').val(datos.telefono);
            $('#direccion').val(datos.direccion);
            $('#email').val(datos.email);
            $('#id').val(datos.idcliente);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarUsuario(id) {
    const action = "editarUsuario";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarUsuario: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.nombre);
            $('#usuario').val(datos.usuario);
            $('#correo').val(datos.correo);
            $('#id').val(datos.idusuario);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarProducto(e,id) {
    const action = "editarProducto";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarProducto: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#producto').val(datos.descripcion);
            $('#precio').val(datos.precio);
            $('#precioIva').val(datos.precioIVA);

            $('#precioPVP').val(datos.precioPVP);
            $('#id').val(datos.codproducto);
            $('#tipo').val(datos.id_tipo);
            $('#presentacion').val(datos.id_presentacion);
            $('#laboratorio').val(datos.id_lab);
            $('#vencimiento').val(datos.vencimiento);
            $('#cantidad').val(datos.existencia);
            
            $('#iva').val(datos.iva);
            $('#inform').val(datos.info_prod);


            if (datos.vencimiento != '0000-00-00') {
                $("#accion").prop("checked", true);
            }else{
                $("#accion").prop("checked", false);
            }
            
            presentacion_caja(e);

            $('#fraccion').val(datos.fraccion);
            $('#PrecioFr').val(datos.precioFr);

            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function limpiar() {
    $('#formulario')[0].reset();
    $('#id').val('');
    $('#btnAccion').val('Grabar');
}
function editarTipo(id) {
    const action = "editarTipo";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarTipo: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.tipo);
            $('#id').val(datos.id);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}


function editarGrupoC(id) {
    const action = "editarGrupoC";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarGrupoC: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.nombre);
            $('#detalle').val(datos.detalle);
            $('#id').val(datos.id);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}
function editarPresent(id) {
    const action = "editarPresent";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarPresent: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.nombre);
            $('#nombre_corto').val(datos.nombre_corto);
            $('#id').val(datos.id);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}
function editarLab(id) {
    const action = "editarLab";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarLab: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#laboratorio').val(datos.laboratorio);
            $('#direccion').val(datos.direccion);
            $('#id').val(datos.id);
            $('#btnAccion').val('Modificar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}





    

    
        function presentacion_caja(e){
           e.preventDefault();
               
               var valorSelect=$('#presentacion').val()
               if(valorSelect === '4'){ 
                $('#areaFraccion').css('display','initial');

                $('#fraccion').prop('required',true);
                $('#fraccion').val('');
                
                $('#PrecioFr').val('');

               
               }else{
                $('#areaFraccion').css('display','none');

                $('#fraccion').removeAttr("required");
                $('#fraccion').val('0');
                $('#PrecioFr').val('0');
               }
          }


          function calcularIVA(e){
             e.preventDefault();
            var precioPVP = $('#precioPVP').val();
            var valorIVA= $('#iva').val();
            
            if(valorIVA > 0  & valorIVA < 1){ 

                if(precioPVP > 0){ 
                    var valPorIVA= (parseFloat(precioPVP) * parseFloat(valorIVA)).toFixed(2);
                    
                    

                    $('#precioIva').val(valPorIVA);
                    
                }
            }else{
                        $('#precioIva').val(0.00);
                        
            }


           /* var precioCosto = $('#precio').val()
            var valorIVA= $('#iva').val()
            
            if(valorIVA > 0  & valorIVA < 1){ 
                    var valPorIVA= (parseFloat(precioCosto) * parseFloat(valorIVA)).toFixed(2);
                    var valPVP= (parseFloat(precioCosto) + parseFloat(valPorIVA)).toFixed(2);
                    

                    $('#precioIva').val(valPorIVA);
                    $('#precioPVP').val(valPVP);
            }else{
                        $('#precioIva').val(0.00);
                        
            }  */

          }



          // VENTAS

          function unidad_o_fraccion(e){
            e.preventDefault();
             
            var valorSelect= $('#tipoUnidad').val();
            if(valorSelect === 'U'){

                $('#areaUnidad').css('display','initial');
                
                $('#cantidad').prop('required',true);
                $('#cantidad').val('');

                $('#areaStockFr').css('display','none');
                $('#areaStock').css('display','initial');

                $('#areaFraccion').css('display','none');

                $('#fraccion').removeAttr("required");
                $('#fraccion').val('0');
                
               $('#precioPVP').val($('#precioPVPu').val());

                
                $('#sub_total').val('');

            }else if(valorSelect === 'F'){

                $('#areaFraccion').css('display','initial');
                $('#fraccion').prop('required',true);
                $('#fraccion').val('');
                
                $('#areaStockFr').css('display','initial');
                $('#areaStock').css('display','none');
                

                $('#areaUnidad').css('display','none');

                $('#cantidad').removeAttr("required");
                $('#cantidad').val('0');

                $('#precioPVP').val($('#precioPVPfr').val());

                $('#sub_total').val('');
            }

          }



          // DETALLE UTILIDAD


          function addDays(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
          } 

        function formatoFecha(dateObject) {
            var d = new addDays(dateObject,1).toLocaleDateString();
          
            let date=d;
            return date;
        };





        /* SELECCIONANDO TIPO DE FECHA CONSULTA EN DETALLE DE UTILIDAD */

        function cambiarTipoFechaUti(e){
            e.preventDefault();

            
            if ($("#tipoFecha").val() === "D" ){ 
            $("#panelDiaUtilidad").css('display','initial'); 
            $("#panelMesUtilidad").css('display','none'); 
            $("#panelAnoUtilidad").css('display','none');
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';


            }else if($("#tipoFecha").val() === "M"){ 
            $("#panelDiaUtilidad").css('display','none'); 
            $("#panelMesUtilidad").css('display','initial'); 
            $("#panelAnoUtilidad").css('display','none');
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';


            

            }
            else if($("#tipoFecha").val() === "A"){ 
                $("#panelDiaUtilidad").css('display','none'); 
                $("#panelMesUtilidad").css('display','none'); 
                $("#panelAnoUtilidad").css('display','initial'); 
                $('#tblUtilidad').DataTable().destroy();
                document.querySelector("#detalleUtilidad").innerHTML = '';
    
    
              
    
                }else{
            $("#panelDiaUtilidad").css('display','none'); 
            $("#panelMesUtilidad").css('display','none'); 
            $("#panelAnoUtilidad").css('display','none'); 
            $('#tblUtilidad').DataTable().destroy();
            document.querySelector("#detalleUtilidad").innerHTML = '';




            }



        }



        /* CONSULTA DE DETALLE DE UTILIDAD */
          $('#btnConsultaU').click(function (e) {
            e.preventDefault();
            var tipoFecha= $('#tipoFecha').val();

                    if(tipoFecha === 'D'){ 
                        
                        
                        if($('#tblUtilidad').DataTable().data().any()){ 

                        $('#tblUtilidad').DataTable().destroy();

                        }
                       
                        fecha_u = $("#fecha_utilidad").val();

                           // if(fecha_u.trim() === "" || isNaN(new Date(fecha_u).getTime())){ 
                            //                $('#panelDia').css('display','none');  

                           // }else{

                            //                 $('#panelDia').css('display','initial');
                                        
                                           // $('#fecha_sel').text(formatoFecha(fecha_u));
                               

                           // }


                    }else if(tipoFecha === 'M'){ 
                        
                        if($('#tblUtilidad').DataTable().data().any()){ 
                        $('#tblUtilidad').DataTable().destroy();

                        }
                        







                    }else{

                     //   $('#panelDia').css('display','none');
                        if($('#tblUtilidad').DataTable().data().any()){ 
                         $('#tblUtilidad').DataTable().destroy();

                        }
                       
                    }

          });




          /* LISTAR UTILIDAD  */

          function listar_utilidad(e) {

            
            e.preventDefault();
            let html = '';
            let fechaU = 'fechaUtilidad';
            let mesU ='mesUtilidad';
            let anioU ='anioUtilidad';

            var tipoFecha= $('#tipoFecha').val();
            let fecha=  formatoFecha($('#fecha_utilidad').val());
         
            //alert(fecha);
            if(tipoFecha === 'D'){ 
             var nombreArchivo='Detalle utilidad dia '+fecha;
                //Reiniciar Datatable
            $('#tblUtilidad').DataTable().destroy();
            
           
           var table = $('#tblUtilidad').DataTable({
              

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                },
                
                dom: 'lBfrtip',
               
                    buttons: [
                        {
                            extend:'print',
                            text:"Imprimir",
                            title:nombreArchivo,
                            titleAttr:'Imprimir Detalle'
                        }, 
                        {
                            extend:'excelHtml5',
                            text:"Excel",
                            title:nombreArchivo,
                            titleAttr:'Exportar a Excel'
                        },
                        {
                            extend:'pdfHtml5',
                            text:"PDF",
                            title:nombreArchivo,
                            titleAttr:'Exportar en PDF'
                            }
                        ]
                      
                    ,
                    initComplete: function () {
                        var btns = $('.dt-button');
                        btns.addClass('btn btn-success btn-sm');
                        btns.removeClass('dt-button');

                    },

                "processing": true,


                "ajax": {
                  "url": 'ajax.php',
                  
                  "data": {
                    fechaUtilidad: fechaU,
                    fecha: fecha
                  },
                      dataSrc:""
                },
                
                "columns": [{
                    "data": "id_venta"
                  },
                  {
                    "data": "codproducto"
                  },
                  {
                    "data": "descripcion"
                  },
                  {
                    "data": "cantidad"
                  },
                  {
                    "data": "precio"
                  },
                  {
                    "data": "precioPVP"
                  },
                  {
                    "data": "iva"
                  },
                  {
                    "data": "totalDescuento"
                  },
                  {
                    "data": "totalCosto"
                  },
                  {
                    "data": "totalPVP"
                  },
                  {
                    "data": "utilidad"
                  },
                  {
                    "data": "fecha_venta"
                  },
                  {
                    "data": "nombre_usuario"
                  },
                  {
                    "data": "nombre_cliente"
                  }
                  ,
                  {
                    "data": "transaccion"
                  }
                ],
                footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
       
        /******************* TOTAL Costo */
        // Total over all pages
        total = api
            .column(8)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(8, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';


        /******************* TOTAL PVP */
        // Total over all pages
        total = api
            .column(9)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(9, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';


        /******************* TOTAL UTILIDAD */
        // Total over all pages
        total = api
            .column(10)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(10, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
    },
                
                
                "order": [
                  [0, "asc"]
                ]
              });
              
            }else if (tipoFecha === 'M'){ 
                $('#tblUtilidad').DataTable().destroy();
                        document.querySelector("#detalleUtilidad").innerHTML = ''; 


                        
                var mes=$('#mes_utilidad').val();
                var anio=$('#mes_a_utilidad').val();

                var nombreArchivo='Detalle utilidad mes '+mes+' '+anio;

                var table = $('#tblUtilidad').DataTable({
              

                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                    },
                    
                    dom: 'lBfrtip',
                   
                        buttons: [
                            {
                                extend:'print',
                                text:"Imprimir",
                                title:nombreArchivo,
                                titleAttr:'Imprimir Detalle'
                            }, 
                            {
                                extend:'excelHtml5',
                                text:"Excel",
                                title:nombreArchivo,
                                titleAttr:'Exportar a Excel'
                            },
                            {
                                extend:'pdfHtml5',
                                text:"PDF",
                                title:nombreArchivo,
                                titleAttr:'Exportar en PDF'
                                }
                            ]
                          
                        ,
                        initComplete: function () {
                            var btns = $('.dt-button');
                            btns.addClass('btn btn-success btn-sm');
                            btns.removeClass('dt-button');
    
                        },
    
                    "processing": true,
    
    
                    "ajax": {
                      "url": 'ajax.php',
                      
                      "data": {
                        mesUtilidad: mesU,
                        mes: mes,
                        anio:anio
                      },
                          dataSrc:""
                    },
                    
                    "columns": [{
                        "data": "id_venta"
                      },
                      {
                        "data": "codproducto"
                      },
                      {
                        "data": "descripcion"
                      },
                      {
                        "data": "cantidad"
                      },
                      {
                        "data": "precio"
                      },
                      {
                        "data": "precioPVP"
                      },
                      {
                        "data": "iva"
                      },
                      {
                        "data": "totalDescuento"
                      },
                      {
                        "data": "totalCosto"
                      },
                      {
                        "data": "totalPVP"
                      },
                      {
                        "data": "utilidad"
                      },
                      {
                        "data": "fecha_venta"
                      },
                      {
                        "data": "nombre_usuario"
                      },
                      {
                        "data": "nombre_cliente"
                      },
                      {
                        "data": "transaccion"
                      }
                    ],

                    footerCallback: function (row, data, start, end, display) {
                        let api = this.api();
                 
                        // Remove the formatting to get integer data for summation
                        let intVal = function (i) {
                            return typeof i === 'string'
                                ? i.replace(/[\$,]/g, '') * 1
                                : typeof i === 'number'
                                ? i
                                : 0;
                        };
                 
                       
                        /******************* TOTAL Costo */
                        // Total over all pages
                        total = api
                            .column(8)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(8, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                
                
                        /******************* TOTAL PVP */
                        // Total over all pages
                        total = api
                            .column(9)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(9, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2)+ ' <span style="color:red">( Total: $' + total.toFixed(2)  + ')</span>';
                
                
                        /******************* TOTAL UTILIDAD */
                        // Total over all pages
                        total = api
                            .column(10)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Total over this page
                        pageTotal = api
                            .column(10, { page: 'current' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                 
                        // Update footer
                        api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                    },
                    
                    
                    "order": [
                      [0, "asc"]
                    ]
                  });
                  



                }else if(tipoFecha === 'A'){

                    $('#tblUtilidad').DataTable().destroy();
                    document.querySelector("#detalleUtilidad").innerHTML = '';

                    var anio=$('#anio_utilidad').val();
                    var nombreArchivo='Detalle utilidad anual '+anio;
                    var table = $('#tblUtilidad').DataTable({
              

                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                        },
                        
                        dom: 'lBfrtip',
                       
                            buttons: [
                                {
                                    extend:'print',
                                    text:"Imprimir",
                                    title:nombreArchivo,
                                    titleAttr:'Imprimir Detalle'
                                }, 
                                {
                                    extend:'excelHtml5',
                                    text:"Excel",
                                    title:nombreArchivo,
                                    titleAttr:'Exportar a Excel'
                                },
                                {
                                    extend:'pdfHtml5',
                                    text:"PDF",
                                    title:nombreArchivo,
                                    titleAttr:'Exportar en PDF'
                                    }
                                ]
                              
                            ,
                            initComplete: function () {
                                var btns = $('.dt-button');
                                btns.addClass('btn btn-success btn-sm');
                                btns.removeClass('dt-button');
        
                            },
        
                        "processing": true,
        
        
                        "ajax": {
                          "url": 'ajax.php',
                          
                          "data": {
                            anioUtilidad: anioU,
                            
                            anio:anio
                          },
                              dataSrc:""
                        },
                        
                        "columns": [{
                            "data": "id_venta"
                          },
                          {
                            "data": "codproducto"
                          },
                          {
                            "data": "descripcion"
                          },
                          {
                            "data": "cantidad"
                          },
                          {
                            "data": "precio"
                          },
                          {
                            "data": "precioPVP"
                          },
                          {
                            "data": "iva"
                          },
                          {
                            "data": "totalDescuento"
                          },
                          {
                            "data": "totalCosto"
                          },
                          {
                            "data": "totalPVP"
                          },
                          {
                            "data": "utilidad"
                          },
                          {
                            "data": "fecha_venta"
                          },
                          {
                            "data": "nombre_usuario"
                          },
                          {
                            "data": "nombre_cliente"
                          },
                          {
                            "data": "transaccion"
                          }
                        ],
    
                        footerCallback: function (row, data, start, end, display) {
                            let api = this.api();
                     
                            // Remove the formatting to get integer data for summation
                            let intVal = function (i) {
                                return typeof i === 'string'
                                    ? i.replace(/[\$,]/g, '') * 1
                                    : typeof i === 'number'
                                    ? i
                                    : 0;
                            };
                     
                           
                            /******************* TOTAL Costo */
                            // Total over all pages
                            total = api
                                .column(8)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(8, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(8).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                    
                    
                            /******************* TOTAL PVP */
                            // Total over all pages
                            total = api
                                .column(9)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(9, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(9).footer().innerHTML = '$' + pageTotal.toFixed(2)+ ' <span style="color:red">( Total: $' + total.toFixed(2)  + ')</span>';
                    
                    
                            /******************* TOTAL UTILIDAD */
                            // Total over all pages
                            total = api
                                .column(10)
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Total over this page
                            pageTotal = api
                                .column(10, { page: 'current' })
                                .data()
                                .reduce((a, b) => intVal(a) + intVal(b), 0);
                     
                            // Update footer
                            api.column(10).footer().innerHTML = '$' + pageTotal.toFixed(2) + ' <span style="color:red">( Total: $' + total.toFixed(2) + ')</span>';
                        },
                        
                        
                        "order": [
                          [0, "asc"]
                        ]
                      });

                
                }else{

                    $('#tblUtilidad').DataTable().destroy();
                    document.querySelector("#detalleUtilidad").innerHTML = '';

                 }
        }
     
     