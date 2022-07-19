import { ajax, each, map } from 'jquery';
import { find, functionsIn } from 'lodash';
import Swal from 'sweetalert2';

$(document).ready(function() {

    // función sweetakert para mensaje configuración normal
    const SweetMessaje = Swal.mixin({
        // customClass: {
        //   confirmButton: 'btn btn-success',
        //   cancelButton: 'btn btn-danger'
        // },
        // buttonsStyling: false,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'ACEPTAR',
        cancelButtonText: 'CANCELAR',
        reverseButtons: true,
    })

    // función sweetalert para mensaje pequeño
    const Toast = Swal.mixin({
        width: 600,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        showCloseButton: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    // mensaje sweetAlert2 para activar/desactivar usuario
    $("button.btn-confirm").on('click',function(e){
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Seguro de realizar ésta acción?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                $(this).closest('form').submit();
            }
        });
    });

    // mensaje sweetAlert2 para anular transacciones permanentemente
    $("button.btn-anul").on('click',function(e){
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Seguro de anular ésta transacción?',
            html: 'La acción luego de ser realizada<br><strong class="text-danger">NO PUEDE SER REVERSADA</strong>.',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                $(this).closest('form').submit();
            }
        });
    });

    //Capitalizar texto.
    function capitalize(str){
        return str.toLowerCase()
            .split(' ')
            .map(v => v.length!=0 ? v[0].toUpperCase() + v.substr(1) : v)
            .join(' ');
    }
    $('input.capitalize').on('keyup',function(){
        var cp_value = capitalize($(this).val());
        $(this).val(cp_value);
    });

    $('input').on('blur',function(){
        $(this).val($(this).val().trim());
    });

    $('button.btn-back').on('click',function(){
        window.history.back();
    });

    $('input.lowercase').on('keyup', function(){
        $(this).val($(this).val().toLowerCase());
    });

    $('input.uppercase').on('keyup', function(){
        $(this).val($(this).val().toUpperCase());
    });

    var t=0;
    // Notificaciones
    if ( $("p.notif").length > 0 ) {
        // hacer algo aquí si el elemento existe
        setTimeout(() => {
            $.ajax({
                url : '/expiringLot',
                success : function(data) {
                    if (data.length>0) {
                        $('p.notif').before('<span class="notification notif">'+data.length+'</span>');
                        $('i.notif').after('<span class="badge badge-danger sidebar-custom notif">'+data.length+'</span>');
                        data.forEach(element => {
                            $('div.notif').append('<a class="dropdown-item" href="#">El lote "'+element.cod_lot+'" del producto "'+element.products.name+'" posee "'+(element.quantity-element.sold)+'" unidades vencidas o proximas a vencerse.</a>')
                        });
                        $('div.notif').after('<a class="btn btn-sm btn-info col-md-12" href="../notifications">VER TODAS LAS NOTIFICACIONES</a>');
                    } else {
                        $("div.notif").html("<div class='col-sm-12'>No posee notificaciones...</div>");
                    }
                },
                error : function(xhr, status) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Disculpe, se produjo un error para mostrar las notificaciones, '+status+'.'
                    });
                    console.log(xhr);
                },
            });
        }, 10);
    }

    var dolar = Number(0);
    var euro = Number(0);
    // Consultar precio del dolar
    if ( $(".info-dolar").length > 0 ) {
        setTimeout(() => {
            $.ajax({
                url: 'https://s3.amazonaws.com/dolartoday/data.json',
                success: function(r){
                    dolar = parseFloat(r.USD.promedio);
                    euro = parseFloat(r.EUR.promedio);
                    $('.info-dolar').html('<i class="material-icons">attach_money</i> '+new Intl.NumberFormat("es-ES").format(dolar));
                    $('.info-euro').html('<i class="material-icons">euro</i> '+new Intl.NumberFormat("es-ES").format(euro));
                },
                error : function(xhr, status) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Disculpe, se produjo un error al consultar las divisas, '+status+'.'
                    });
                    console.log(xhr);
                },
            });
        }, 10);
    }

    var conteo = $('select#conteo');
    var unidades = $('input#quantity');
    var unidadesCaja = $('input#unit_box');

    // Convertir bolivares a dolares
    $('input#price_bs.form-control').on('blur',function(){
        var price = parseFloat($(this).val());
        if(!isNaN(price)) {
            var total = Math.round((price/dolar + Number.EPSILON) * 100) / 100;
            $(this).val(Math.round((price + Number.EPSILON) * 100) / 100);
            $('input#price_dollar').val(total);
            // Calcularprecio recomendado
            var sellPrice = (30*price)/100;
            var totalSellPrice = conteo.val()==2 ? (sellPrice + price) /(parseInt(unidades.val()) * parseInt(unidadesCaja.val())) : sellPrice+price;
            totalSellPrice = Math.round((totalSellPrice + Number.EPSILON) * 100) / 100;
            $('input#sell_price').val(totalSellPrice);
            $("#divisa").val(1);

        }
    });

    // Convertir dolares a bolivares
    $('input#price_dollar').on('blur',function(){
        var price = parseFloat($(this).val());
        if(!isNaN(price)) {
            var total = Math.round((price*dolar + Number.EPSILON) * 100) / 100;
            $(this).val(Math.round((price + Number.EPSILON) * 100) / 100);
            $('input#price_bs.form-control').val(total);
            // Calcular precio recomendado
            var sellPrice = (30*price)/100;
            var totalSellPrice = conteo.val()==2 ? (sellPrice + price) /(parseInt(unidades.val()) * parseInt(unidadesCaja.val())) : sellPrice+price;
            totalSellPrice = Math.round((totalSellPrice + Number.EPSILON) * 100) / 100;
            $('input#sell_price').val(totalSellPrice);
            $("#divisa").val(2);
        }
    });

    // Redondear precio de venta
    $('input#sell_price').on('blur',function(){
        $(this).val(Math.round((parseFloat($(this).val()) + Number.EPSILON) * 100) / 100);
    });


    // Cambiar colores
    $('.fixed-plugin .active-color span').click(function(e) {
        // $full_page_background = $('.full-page-background');
        e.preventDefault();

        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('color');

        if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
        }

        if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
        }

        if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
        }
    });

    $('#usuarios').DataTable();


    // funciones para venta

    // transferir permiso automaticamente
    $('input.permiso-ckeck:checked').each(function() {
        var i = $(this).closest('.container');
        i.detach().hide().appendTo($("div.access")).show('normal');
    })

    // Transferencia de permisos
    $('input.permiso-ckeck').on('change', function() {
        var content = $(this).closest('.container');
        if($(this).is(':checked')){
            content.detach().hide().appendTo($("div.access")).show('normal');
        } else {
            content.detach().hide().appendTo($("div.unaccess")).show('normal');
        }
    });

    // Buscar permiso asignado
    $('#asignados').on('keyup', function() {
        var t = $(this).val();
        if(t.length>0) {
            $('.access div label:not(:contains("'+t+'"))').closest('.container').hide();
            $('.access div label:contains("'+t+'")').closest('.container').show();
        } else {
            $('.access div.container').show();
        }
    });

    // Buscar permiso no
    $('#noasignados').on('keyup', function() {
        var t = $(this).val();
        if(t.length>0) {
            $('.unaccess div label:not(:contains("'+t+'"))').closest('.container').hide();
            $('.unaccess div label:contains("'+t+'")').closest('.container').show();
        } else {
            $('.unaccess div.container').show();
        }
    });

    // quitar todos los permisos
    $('button.permission-none').on('click', function(){
        var cb = $('input.permiso-ckeck:checked');
        cb.prop('checked',false);
        cb.closest('.container').detach().hide().appendTo($("div.unaccess")).show('normal');
    });

    // agregar todos los permisos
    $('button.permission-all').on('click', function(){
        var cb = $('input.permiso-ckeck:not(:checked)');
        cb.prop('checked',true);
        cb.closest('.container').detach().hide().appendTo($("div.access")).show('normal');
    });

    // desplegar personal por motivo de retiro
    var tr = $('select#type_to_discount');
    tr.on('change', function() {
        if($(this).val() == 4){
            $('select#staff').closest('div.row').removeClass('d-none', 5000);
        } else {
            $('select#staff').closest('div.row').addClass('d-none', 5000);
            $('select#staff').val('')
        }

        if($(this).val() == 3 || $(this).val() == 4){
            $('#reason').closest('div.row').removeClass('d-none', 5000);
        } else {
            $('#reason').closest('div.row').addClass('d-none', 5000);
            $('#reason').val('');
        }
    });

    // Mostrar poppovers
    $('.pop').on('click',function(){
        var f = $(this).attr("data-target");
        if($('.popover-content'+'#'+f).hasClass('active')){
            $('.popover-content'+'#'+f).removeClass('active');

        } else {
            $('.popover-content'+'#'+f).addClass('active');
        }
    })

    // var tProd = $('#productos').DataTable({
    //     language: {
    //         emptyTable: "No se ha seleccionado ningùn producto.",
    //         info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
    //         infoEmpty: "",
    //         infoFiltered: "(filtrado de un total de _MAX_ productos)",
    //         lengthMenu: "Mostrar _MENU_ productos",
    //         search: "Buscar: ",
    //         paginate: {
    //             first:      "Primero",
    //             last:       "Último",
    //             next:       "Siguiente",
    //             previous:   "Anterior"
    //         },
    //     },
    //     lengthMenu: [[10, 20, 30, -1], [10, 20, 30, 'Todos']],
    // });

    // $('#addProd').on( 'click', function () {
    //     tProd.clear().draw();
    // } );

    // var prods = [
    //     {
    //         id: 1,
    //         name: 'chocolate',
    //         lots: [
    //             {
    //                 id: '1',
    //                 cod: '10',
    //                 price: 1,
    //                 divisa: 1,
    //                 cantidad: 3
    //             },
    //             {
    //                 id: 2,
    //                 cod: '15',
    //                 price: 1,
    //                 divisa: 1,
    //                 cantidad: 3
    //             }
    //         ]
    //     },
    //     {
    //         id: 7,
    //         name: 'Cafe',
    //         lots: [
    //             {
    //                 id: 6,
    //                 cod: 'SCP-26',
    //                 price: 2.5,
    //                 divisa: 1,
    //                 cantidad: 3
    //             }
    //         ]
    //     },
    // ];

    var prods = [];

    // función que itera los productos y los muestra en la vista
    async function showProd(prods){
        var html = '<ul class="list-group p-0">';
        var totald = 0;
        var totalb = 0;
        var ds;
        $.each(prods, function( k, row){
            html+=  '<li class="list-group-item p-0 m-0">'+
                        '<h4 class="text-primary">'+row.name+'</h4>'+
                        '<ul class="list-group">'+
                            '<li class="list-group-item">'+
                                '<table class="table table-striped m-0" style="width:100%" id="'+row.id+'">'+
                                    '<thead class="text-secondary">'+
                                        '<tr>'+
                                            '<th class="col-sm-4 p-0"><h6>Lote</h6></th>'+
                                            '<th class="col-sm-3 p-0"><h6>Precio</h6></th>'+
                                            '<th class="col-sm-1 p-0"><h6>Cantidad</h6></th>'+
                                            '<th class="col-sm-2 p-0"><h6>Costo total</h6></th>'+
                                            '<th class="col-sm-2 p-0 text-right"><h6>Acción</h6></th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody>';
                                    $.each(row.lots, function(i,d) {
                                        ds = d.divisa;
                                        html+= '<tr id='+d.id+'>'+
                                            '<td>'+d.cod+'</td>'+
                                            '<td>'+
                                                (ds == 1 ? d.price+' Bs = '+(d.price/dolar).toFixed(2)+' USD' : d.price+' USD = '+(d.price*dolar).toFixed(2)+' Bs')

                                            +'</td>'+
                                            '<td class="text-center">'+d.quantity+'</td>'+
                                            '<td>'+
                                                (ds == 1 ? (d.quantity*d.price).toFixed(2)+' Bs = '+ ((d.quantity*d.price)/dolar).toFixed(2) : (d.quantity*d.price).toFixed(2)+' USD = '+((d.quantity*d.price)*dolar).toFixed(2))
                                            +'</td>'+
                                            '<td class=" col-sm-2 td-actions text-right">'+
                                                // '<button type="button" class="btn btn-primary mod-prod" title="Modificar cantidades">'+
                                                //     '<i class="material-icons">edit</i>'+
                                                // '</button>'+
                                                '<button type="button" class="btn btn-danger del-prod" title="Eliminar producto asociado">'+
                                                    '<i class="material-icons">delete</i>'+
                                                '</button>'+
                                            '</td>'+
                                        '</tr>';
                                        ds==1 ? totalb+= d.quantity*d.price : totald+= d.quantity*d.price;
                                    });
                                    html+= '</tbody>'+
                                '</table>'+
                            '</li>'+
                        '</ul>'+
                    '</li>'+
                    '<div class="dropdown-divider p-0 mt-0 mx-0 mb-3"></div>';
        });
        html+= '</ul>';
        html = prods.length == 0 ? '<h6 class="card-category">No se ha seleccionado ningún producto</h6>' : html;

        totalb = (totalb/dolar);
        totald+=totalb;

        $('div.table-products').html(html);
        $('h5.total').html('Total: '+(totald==0 ? 0 : (totald*dolar).toFixed(2)+' Bs = '+totald.toFixed(2)+' USD <button type="button" class="btn btn-primary btn-sm" id="del-products">Eliminar Todo</button>'));
    }

    // funcion para habilitar boton para modal deproductos
    $('input#product_search').on('keyup', function(){
        if($(this).val()!='') {
            $('#searchProdButton').removeClass('disabled');
        } else {
            $('#searchProdButton').addClass('disabled');
        }
    });

    // funcion para dar formato a fechas
    function formatDate(date) {
        var d = new Date(date), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [day,month,year].join('/');
    };

    // variable para estructurar producto.
    var producto = [];


    // buscar producto
    $('#product_search').on('keypress', function(e){
        if(e.which == 13) {
            $("#searchProdButton").trigger("click");
        }
    });

    // Cargar info de producto para agregar
    $('#searchProdButton').click(function(){
        $('button#addProd').removeAttr('data-dismiss');
        $('#quantity').val('1');
        if(!$(this).hasClass('disabled')){
            var cod = $('input#product_search').val();
            $.ajax({
                url: "/prodLot/"+cod,
                type: "GET",
                cache: true,
                async : false,
                success: function (r) {
                    console.log(r)
                    // if(r==null||r==undefined||r.length==0) {
                    //     $('#searchProdButton').removeAttr('data-toggle');
                    //     $('#searchProdButton').removeAttr('data-target');
                    //     Toast.fire({
                    //         icon: 'error',
                    //         title: 'El producto que desea consultar no existe o fue deshailitado.'
                    //     });
                    // } else if(r[0].quantity-r[0].sold<=0) {
                    //     Toast.fire({
                    //         icon: 'error',
                    //         title: 'Ya no quedan existencias del producto.'
                    //     });
                    // } else {
                        $('#searchProdButton').attr('data-toggle','modal');
                        $('#searchProdButton').attr('data-target','#searchProd');
                        let expiration = formatDate(r.expiration);
                        producto = {
                            id: r.products.id,
                            name: r.products.name,
                            lots: [{
                                id: r.id,
                                cod: r.cod_lot,
                                price: r.sell_price,
                                divisa: r.divisa_id,
                                existencia: r.quantity-r.sold,
                                expiration: expiration,
                                quantity: 0
                            }]
                        }
                        $('div.prod-modal').html(r.products.name);
                        $('p.lot-modal').html(r.cod_lot);
                        $('p.price-modal').html(
                            r.divisa_id == 1 ? r.sell_price+' Bs => '+(r.sell_price/dolar).toFixed(2)+' USD' : r.sell_price+' USD => '+(r.sell_price*dolar).toFixed(2)+' Bs'
                        );
                        $('p.total-modal').html(r.quantity-r.sold);
                        $('p.fecha-modal').html(expiration);
                        $('input#quantity').attr('max',r.quantity-r.sold);
                    // }
                }, error : function(xhr, status) {
                    alert('Disculpe: '+status+'.');
                    console.log(xhr);
                }
            });
        }
    });

    // función para agregar productos a la lista
    $('button#addProd').click(function () {
        var cantidad = parseFloat($('input#quantity').val());
        var hide = false;
        if(cantidad>0) {
            if(cantidad>(producto.lots[0].existencia)) {
                Toast.fire({
                    icon: 'warning',
                    title: 'No puede descontar más productos que los que hay en existencia.'
                });
            } else {
                var indexP = prods.findIndex(x => x.id===producto.id)
                if(indexP>=0) {
                    var indexL = prods[indexP].lots.findIndex(x => x.id===producto.lots[0].id);
                    if(indexL>=0) {
                        if((prods[indexP].lots[indexL].quantity+cantidad)>prods[indexP].lots[indexL].existencia) {
                            Toast.fire({
                                icon: 'warning',
                                title: 'No puede descontar más productos que los que hay en existencia, recuerde que ya posee '+prods[indexP].lots[indexL].quantity+' en la cuenta a descontar de '+prods[indexP].lots[indexL].existencia+' que hay en existencia.'
                            });
                        } else {
                            prods[indexP].lots[indexL].quantity+=cantidad;
                            hide = true;
                        }
                    } else {
                        producto.lots[0].quantity = cantidad;
                        prods[indexP].lots.push(producto.lots[0]);
                        hide = true;
                    }
                } else {
                    producto.lots[0].quantity = cantidad;
                    prods.push(producto);
                    hide = true;
                }

                if(hide==true) {
                    $(this).attr('data-dismiss','modal');
                }
                showProd(prods);
                $('#product_search').val('');
            }
        } else {
            Toast.fire({
                icon: 'warning',
                title: 'Debe indicar una cantidad a descontar del inventario.'
            });
        }
    } );


    // función para eliminar productos de la lista
    async function delProds(prods,id) {
        $.each(prods,function(index, res) {
            $.each(res.lots, function(i,r){
                if(r.id==id){
                    prods[index].lots.splice( i, 1);
                }
            });
        });
        $.each(prods, function(k,r){
            if(r.lots.length==0){
                prods.splice( k, 1);
            }
        });
    }

    // boton de acción de eliminación de productos
    $('div.table-products').on('click', 'button.del-prod', function() {
        var id = $(this).closest('tr').attr('id');
        delProds(prods,id);
        showProd(prods);
    });

    // boton para vaciar la lista de productos
    $('.total').on('click', 'button#del-products', function(){
        SweetMessaje.fire({
            title: '¿Seguro desea quitar todos los productos de la lista?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                prods = [];
                showProd(prods);
            }
        });
    });

    // editar cantidad de productos por lote
    $('div.table-products').on('click', 'button.mod-prod', function () {
        var idLot = $(this).closest('tr').attr('id');
        var idProd = $(this).closest('table').attr('id');

        console.log(idProd);
        console.log(idLot);
    });

    // evitar envio involuntario de formulario
    $('form#transaccion').submit(function (e) {e.preventDefault();})

    // realizar retiro de los productos
    $('button#retiro-prods').click(function(){
        var token = $('input[name="_token"]').val();
        var type = $('#type_to_discount').val();
        var staff = $('select#staff').val();
        var reason = $('textarea#reason').val();

        // if(type=='') {
        //     Toast.fire({
        //         icon: 'warning',
        //         title: 'Debe completar el formulario.'
        //     });
        // } else if (prods.length<1) {
        //     Toast.fire({
        //         icon: 'error',
        //         title: 'Debe agregar por lo menos un producto.'
        //     });
        // } else {
            SweetMessaje.fire({
                title: '¿Seguro desea realizar el retiro de los productos?',
                icon: 'warning',
            }).then((result) => {
                 if(result.value){
                    $.ajax({
                        url: "/todiscount",
                        method: "POST",
                        data: {
                            "_token": token,
                            type_to_discount_id: type,
                            staff: staff,
                            reason: reason,
                            prods: prods,
                            dolar: dolar,
                        },
                        dataType: 'json',
                        success: function(r) {
                            $('p.error').remove();
                            console.log(r);
                            if(r.res==1) {
                                SweetMessaje.fire({
                                    icon: "success",
                                    title: "Éxito al registrar el retiro",
                                    showCancelButton: false,
                                }).then(()=> {
                                    window.location.href="./";
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: r.info
                                });
                            }
                        },
                        error : function(xhr, status) {
                            var e = 'error', m = 'Error al registrar el retiro.';
                            console.log(xhr.responseJSON);
                            if(xhr.status==422) {
                                $('p.error').remove();
                                $.each(xhr.responseJSON.errors, function(i,r) {
                                    if(i.match(/prods..*/)){
                                        alert("Error en el formato de la informacion del producto");
                                    } else {
                                        $('#'+i+'').after( "<p class='error text-danger'>"+r+"</p>" );
                                    }
                                });
                                e = 'warning';
                                m = 'Debe completar el formulario de manera correcta';
                            }
                            Toast.fire({
                                icon: e,
                                title: m
                            });
                        }
                    });
                }
            });
        // }
    });

    var divloading = $('.loading');
    var divproductos = $('.productos');
    var prodVenta = $('form#venta input#producto');
    var divModal = $('div#existencias-venta');
    $('form#venta button#searchProd').click(function () {
        divloading.removeClass('d-block').addClass('d-none');
        divproductos.removeClass('d-none').addClass('d-block');
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "/products",
            data: {
                info : prodVenta.val(),
                "_token": token,
                prods
            },
            dataType: "json",
            success: function (res) {
                if(res.length>0){
                    divModal.html('');
                    console.log(res);
                    $.each(res,function (i,r) {
                        divModal.append('<button type="button" value="'+r.id+'" class="list-group-item list-group-item-action btn-prod" data-dismiss="modal" '+ (r.quantity==0 ? "disabled" : "") +' ><strong class="text-primary">'+r.prod+'</strong>'+(r.quantity==0 ? '- <strong class="text-danger">AGOTADO</strong>' : '')+ '</button>')
                        // divModal.append('<button type="button" value="'+r.id+'" class="list-group-item list-group-item-action btn-prod" data-dismiss="modal" '+ (r.quantity==0 ? "disabled" : "") +' ><strong class="text-primary">'+r.prod+'</strong> - '+(r.quantity==0 ? '<strong class="text-danger">AGOTADO</strong>' : 'Existencia: '+r.quantity)+'</button>')
                    });
                } else {
                    divModal.html('<button type="button" disabled class="list-group-item list-group-item-action disabled">No se consiguieron productos relacionados a los criterios de búsqueda</button>');
                }
            }
        });
    });

    $('div.modal button').click(function () {
        divproductos.removeClass('d-block').addClass('d-none');
        divloading.removeClass('d-none').addClass('d-block');
    });

    function prodCar(d) {
        var table = $('table.table-shopping tbody');
        var html = '';
        console.log(d);
        $.each(d.reverse(), function (i, v) {
            var totalbs, totalusd, prcs,total='';
            if(v.price.length==1) {
                prcs = convertionPrices(v.price[0].price,v.price[0].divisa);
                totalbs = Math.round(((prcs.bs*parseFloat(v.sale)) + Number.EPSILON) * 100) / 100;
                totalusd = Math.round(((prcs.usd*parseFloat(v.sale)) + Number.EPSILON) * 100) / 100;
                total = totalbs+' Bs<br>'+totalusd+' USD';
            } else {
                $.each(v.price, function (k, i) {
                    if(i.selected==true){
                        prcs = convertionPrices(i.price,i.divisa);
                        totalbs = Math.round(((prcs.bs*parseFloat(v.sale)) + Number.EPSILON) * 100) / 100;
                        totalusd = Math.round(((prcs.usd*parseFloat(v.sale)) + Number.EPSILON) * 100) / 100;
                        total = totalbs+' Bs<br>'+totalusd+' USD';
                    }
                });
            }
            html+='<tr id='+v.id+'>'
                    +'<td class="td-name">'
                        +'<div class="row">'
                            +'<div class="img-container d-none d-xs-none d-sm-block col">'
                                +'<img class="img-thumbnail" src="../img/productos/'+(v.img==null ? 'none.jpg' : v.img)+'" alt="PRODUCTO">'
                            +'</div>'
                            +'<div class="col">'
                                +'<strong class="text-primary">'+v.prod+'</strong>'
                                +'<br><small>'+(v.desc!=null ? v.desc : '')+'</small>'
                            +'</div>'
                        +'</div>'
                    +'</td>'
                    +'<td class="td-number price">';

                    if(v.price.length>1) {
                        html+='<select id="price" class="form-control"><option selected disabled>PRECIO</option>';
                        $.each(v.price, function (i, v) {
                            html+='<option value="'+v.price+'" '+(v.selected==true && 'selected')+'>'+v.price+' '+(v.divisa==2 ? 'USD' : 'Bs')+'</option>';
                        });
                        html+='</select>';
                    } else {
                        html+=v.price[0].price+' '+(v.price[0].divisa==2 ? 'USD' : 'Bs');
                    }

                    html+='</td>'
                    +'<td class="text-right">'
                        +'<div class="row">'
                            +'<div class="col-xs-12 col-sm-8 input-group offset-sm-4">'
                                +'<div class="custom-file input-group-lg">'
                                    +"<input id='quantity' type='number' value='"+v.sale+"' class='form-control' autocomplete='off' min="+(v.sale_measure==1 ? "'1'" :"'0.01' step='0.01'")+">"
                                +'</div>'
                                +'<div class="input-group-append">'
                                    +'<button type="button" class="btn btn-round btn-info btn-sm less-prod"> <i class="material-icons">remove</i> </button>'
                                    +'<button type="button" class="btn btn-round btn-info btn-sm plus-prod"> <i class="material-icons">add</i> </button>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</td>'
                    +'<td class="td-number total">'
                        +total
                    +'</td>'
                    +'<td class="td-actions">'
                        +'<button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-danger del-prod">'
                        +'<i class="material-icons">close</i>'
                        +'</button>'
                    +'</td>'
                +'</tr>';
        });
        html = d.length == 0 ? '<h6 class="card-category">No se ha seleccionado ningún producto</h6>' : html;
        table.html(html);
    }

    divModal.on('click','button.btn-prod', function () {
        $('input#producto').val('')
        var id = $(this).val();
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "/prod",
            data: {
                id:id,
                "_token": token,
            },
            dataType: "json",
            success: function (res) {
                $.extend(res[0],{sale:1,total:res[0].price.price});
                prods.push(res[0]);
                prodCar(prods);
                divproductos.removeClass('d-block').addClass('d-none');
                divloading.removeClass('d-none').addClass('d-block');

            }, error : function(xhr, status) {
                alert('Disculpe: '+status+'.');
                console.log(xhr);
            }
        });
    });

    async function updateQuantityProd(number,input,id) {
        number = number<=0 ? 1 : number;
        $.each(prods.reverse(), function (i, v) {
            if (v.id==id){
                if (input.val()<=v.existence) {
                    var f = number>v.existence ? v.existence : number;
                    v.sale=f;
                }
                if (input.val()>v.existence) {
                    v.sale=v.existence;
                }
            }
        });
        prodCar(prods);
    }

    // agregar 1 a producto
    $('table.table-shopping tbody').on('click','tr td.text-right .input-group-append button.plus-prod', function () {
        var q = $(this).closest('.input-group').find('input#quantity');
        var id = $(this).closest('tr').attr('id');
        var f = parseFloat(q.val());
        f = ++f;
        updateQuantityProd(f,q,id);
    });

    // quitar 1 a producto
    $('table.table-shopping tbody').on('click','tr td.text-right .input-group-append button.less-prod', function () {
        var q = $(this).closest('.input-group').find('input#quantity');
        var id = $(this).closest('tr').attr('id');
        var f = parseFloat(q.val());
        f = --f;
        updateQuantityProd(f,q,id);
    });

    // reaccionar al cambio manual de cantidad de producto
    $('table.table-shopping tbody').on('change','tr td.text-right .custom-file input#quantity', function () {
        var id = $(this).closest('tr').attr('id');
        var f = parseFloat($(this).val());
        var total,sale,prcs;
        $.each(prods, function (i, v) {
            if (v.id==id){
                if(f>v.existence) {
                    f= v.existence;
                } else if (f<=0 || isNaN(f)) {
                    f = 1;
                }
                v.sale=f;
                if(v.price.length==1){
                    prcs = convertionPrices(v.price[0].price,v.price[0].divisa);
                    sale = v.sale;
                    total = (Math.round(((parseFloat(prcs.bs)*f) + Number.EPSILON) * 100) / 100) +' Bs <br>'+(Math.round(((parseFloat(prcs.usd)*f) + Number.EPSILON) * 100) / 100)+' USD';
                } else {
                    $.each(v.price, function (k, d) {
                        if(d.selected==true) {
                            prcs = convertionPrices(d.price,d.divisa);
                            total = (Math.round(((parseFloat(prcs.bs)*f) + Number.EPSILON) * 100) / 100) +' Bs <br>'+(Math.round(((parseFloat(prcs.usd)*f) + Number.EPSILON) * 100) / 100)+' USD';
                        }
                    });
                }
            }
        });
        $(this).val(f);
        $(this).closest('tr').children('td.total').html(total);
    });

    function convertionPrices(monto,divisa) {
        var usd,bs;
        if(divisa == 2) {
            bs = Math.round(((parseFloat(monto)*dolar) + Number.EPSILON) * 100) / 100;
            usd = Math.round((parseFloat(monto) + Number.EPSILON) * 100) / 100;
        } else {
            bs = Math.round(((parseFloat(monto)) + Number.EPSILON) * 100) / 100;
            usd = Math.round((dolar/parseFloat(monto) + Number.EPSILON) * 100) / 100;
        }
        return {bs:bs,usd:usd}
    }

    // corrección del campo codigo de barra
    var barCode = $('input#bar_code');
    function numeric(val) {
        var regExpNum = /([^0-9])/g;
        var data = val.replace(regExpNum,'');
        return data;
    }

    $('input.numeric-only').keyup(function () {
        // numeric($(this).val());
        $(this).val(numeric($(this).val()));
    });
    barCode.keyup(function () {
        barCode.val(numeric(barCode.val()).substring(0,13));
    });

    // corregir campo identificacion
    $('#identification').keyup(function () {
        $(this).val(numeric($(this).val()).substring(0,13));
    });

    // eliminar producto de venta
    $('table.table-shopping tbody').on('click','tr td.td-actions  button.del-prod', function () {
        var id = $(this).closest('tr').attr('id');
        var newProds=[];
        $.each(prods.reverse(), function (i, v) {
            if(v.id!=id) {
                newProds.push(v);
            }
        });
        prods = newProds;
        prodCar(prods);
    });

    // Seleccionar precio en caso de muchos precios
    $('table.table-shopping tbody').on('change','tr td.td-number.price  select#price', function () {
        var id = $(this).closest('tr').attr('id');
        var val = $(this).val();
        var total = 0;
        $.each(prods, function (i, v) {
            if(v.id==id){
                $.each(v.price, function (k, d) {
                    if(d.price==val) {
                        var t = convertionPrices(d.price,d.divisa);
                        total = (Math.round(((parseFloat(t.bs)*v.sale) + Number.EPSILON) * 100) / 100) +' Bs <br>'+(Math.round(((parseFloat(t.usd)*v.sale) + Number.EPSILON) * 100) / 100)+' USD';
                        d.selected=true;
                    } else {
                        d.selected=false;
                    }
                });
            }
       });
       $(this).closest('tr').children('td.total').html(total);
    });

    var divClient = $('div#div-client');
    var client = null;

    // buscar clientes registrados por su nombre
    divClient.on('click','button#clientSearch',function () {
        divloading.removeClass('d-block').addClass('d-none');
        divproductos.removeClass('d-none').addClass('d-block');
        var token = $('input[name="_token"]').val();
        var info = $(this).closest('div#div-client').find('input#client_search').val();
        $.ajax({
            type: "post",
            url: "/clients_registered",
            data: {
                info : info,
                "_token": token,
            },
            dataType: "json",
            success: function (res) {
                if(res.length>0){
                    divModal.html('');
                    $.each(res,function (i,r) {
                        r.status==true &&
                            divModal.append('<button type="button" value="'+r.id+'" class="list-group-item list-group-item-action btn-client" data-dismiss="modal"><strong class="text-primary">'+r.name+' '+r.lastname+'</strong> - Identificación: '+(r.ced)+' </button>');
                    });
                    divModal.append('<button type="button" id="reg-client" class="list-group-item list-group-item-action" data-dismiss="modal">Registrar cliente</button>');
                } else {
                    divModal.html('<button type="button" id="reg-client" class="list-group-item list-group-item-action" data-dismiss="modal">Registrar cliente</button>');
                }
            }
        });
    });

    // mostrar modal del registro del cliente en ventas
    divModal.on('click','button#reg-client',function () {
        $('button#reg_client').click();
    });

    // funcion para agregar cliente a la compra
    function addClient(data) {
        console.log(data);
        divClient.html('<button id="current_client" type="button" title="Al hacer clic quitará al cliente" class="btn btn-outline-primary btn-lg p-1">'+data.name+' '+data.lastname+' <span class="material-icons m-1">highlight_off</span></button>');
        client = data.id;
    }

    // consultar clientes por su id
    divModal.on('click','button.btn-client', function () {
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "/clients_registered",
            data: {
                id: $(this).val(),
                "_token": token,
            },
            dataType: "json",
            success: function (res) {
                addClient(res);
            }, error : function(xhr, status) {
                alert('Disculpe: '+status+'.');
                console.log(xhr);
            }
        });
    });

    // eliminar cliente seleccionado
    divClient.on('click','button#current_client', function () {
        client = null;
        divClient.html('<div class="custom-file input-group-lg">'+
                            '<input type="text" autocomplete="off" class="form-control " name="client_search" id="client_search" placeholder="introduzca el número de lote del producto.">'+
                        '</div>'+
                        '<div class="input-group-append">'+
                            '<button class="btn btn-outline-primary btn-sm disabled" type="button" id="clientSearch" data-toggle="modal" data-target="#info">'+
                            '<span class="material-icons">search</span>Buscar'+
                            '</button>'+
                        '</div>')
    });

    // agregar señalización de campo requerido
    $('input[required]:not(.disable-required-span)').before('<span class="text-danger required">*</span>');
    $('select[required]').before('<span class="text-danger required" style="right:-15px !important;">*</span>');

    // validar y enviar datos para creación de cliente
    $('form#create_client button#sumit').click(function (e) {
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Ingresó los datos datos correctamente?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                var form = $(this).closest('form').serialize();
                $.ajax({
                    type: "POST",
                    url: "../clients",
                    data: form,
                    dataType: "json",
                    success: function (r) {
                        r.res ==1 ?
                        SweetMessaje.fire({
                            icon: "success",
                            title: "Éxito al registrar al cliente",
                            showCancelButton: false,
                        }).then(()=> {
                            window.location.href="../clients";
                        }) : Toast.fire({icon: 'error',title: r});
                    }, error : function(xhr, status) {
                        var e = 'error', m = 'Error al registrar el cliente.';
                        console.log(xhr.responseJSON);
                        if(xhr.status==422) {
                            $('p.error').remove();
                            $.each(xhr.responseJSON.errors, function(i,r) {
                                $('#'+i+'').parent().after( "<div class='col-sm-12'><p class='error text-danger'>"+r+"</p></div>" );
                            });
                            e = 'warning';
                            m = 'Debe completar el formulario de manera correcta';
                        }
                        Toast.fire({
                            icon: e,
                            title: m
                        });
                    }
                });
            }
        });
    });


    // vaciar formulario de registro de cliente del modal en ventas
    $('form#create_client button.close-modal').click(function (e) {
        e.preventDefault();
        this.form.reset();
    });

    // registrar clientes desde ventana de venta
    $('form#create_client button#sumit').click(function (e) {
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Ingresó los datos datos correctamente?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                var form = $(this).closest('form').serialize();
                $.ajax({
                    type: "POST",
                    url: "../clients",
                    data: form,
                    dataType: "json",
                    success: function (r) {
                        if (r.res ==1) {
                            $('.close-modal').click();
                            SweetMessaje.fire({
                                icon: "success",
                                title: "Éxito al registrar al cliente",
                                showCancelButton: false,
                            }).then(()=> {
                                addClient(r.info);
                            })
                        } else {
                            Toast.fire({icon: 'error',title: r});
                        }
                    }, error : function(xhr, status) {
                        var e = 'error', m = 'Error al registrar el cliente.';
                        console.log(xhr.responseJSON);
                        if(xhr.status==422) {
                            $('p.error').remove();
                            $.each(xhr.responseJSON.errors, function(i,r) {
                                $('#'+i+'').parent().after( "<div class='col-sm-12 p-0'><p class='error text-danger'>"+r+"</p></div>" );
                            });
                            e = 'warning';
                            m = 'Debe completar el formulario de manera correcta';
                        }
                        Toast.fire({
                            icon: e,
                            title: m
                        });
                    }
                });
            }
        });
    });

    // validación y enviar datos al controlador de la venta
    $('form#venta').submit(function (e) {
        e.preventDefault();
        var token = $('input[name="_token"]').val(), type = $('select#tipo').val(), method = [];

        $("input[type=checkbox][name='method[]']:checked").each(function () {
            method.push(parseInt($(this).val()));
        });
        SweetMessaje.fire({
            icon: "warning",
            title: "¿Desea concluir la transacción?",
        }).then(()=> {
            $.ajax({
                type: "POST",
                url: "/sales",
                data: {
                    '_token': token,
                    transaction_type: type,
                    client_id: client,
                    prods,
                    payment_method_id: method,
                    usd: dolar
                },
                dataType: "json",
                success: function (r) {
                    console.log(r);
                    if (r.res ==1) {
                        SweetMessaje.fire({
                            icon: "success",
                            title: "Éxito al realizar la transacción",
                            showCancelButton: false,
                        }).then(()=> {
                            window.location.href="/sales/create";
                        })
                    } else {
                        Toast.fire({icon: 'error',title: 'Error al registrar la transacción. Motivo: '+r.info});
                    }
                }, error : function(xhr, status) {
                    var e = 'error', m = 'Error al registrar la transacción.';
                    console.log(xhr.responseJSON);
                    if(xhr.status==422) {
                        $('p.error').html('');
                        $.each(xhr.responseJSON.errors, function(i,r) {
                            if(i.match(/prods..*/)){
                                alert("Error en el formato de la informacion del producto");
                            } else {
                                $('#'+i+'').html(r);
                            }
                        });
                        e = 'warning';
                        m = 'Debe completar el formulario de manera correcta';
                    }
                    Toast.fire({
                        icon: e,
                        title: m
                    });
                }
            });
        })
    });

    // reiniciar select al cambiar metodo de pago
    $('select#tipo').change(function (e) {
        var method = $('#method');
        method.prop('selectedIndex',0);
        if($(this).val()==1) {
            method.closest('div.row.mt-3').addClass('d-flex').removeClass('d-none');
        } else {
            method.closest('div.row.mt-3').addClass('d-none').removeClass('d-flex');
        }
    });


    // registrar cliente en ventana principal de registro de cliente
    $('form#createClient button#sumit').click(function (e) {
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Ingresó los datos datos correctamente?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                var form = $(this).closest('form').serialize();
                $.ajax({
                    type: "POST",
                    url: "../clients",
                    data: form,
                    dataType: "json",
                    success: function (r) {
                        r.res ==1 ?
                        SweetMessaje.fire({
                            icon: "success",
                            title: "Éxito al registrar al cliente",
                            showCancelButton: false,
                        }).then(()=> {
                            window.location.href="/clients";
                        }) : Toast.fire({icon: 'error',title: r});
                    }, error : function(xhr, status) {
                        var e = 'error', m = 'Error al registrar el cliente.';
                        console.log(xhr.responseJSON);
                        if(xhr.status==422) {
                            $('p.error').remove();
                            $.each(xhr.responseJSON.errors, function(i,r) {
                                $('#'+i+'').parent().after( "<div class='col-sm-12'><p class='error text-danger'>"+r+"</p></div>" );
                            });
                            e = 'warning';
                            m = 'Debe completar el formulario de manera correcta';
                        }
                        Toast.fire({
                            icon: e,
                            title: m
                        });
                    }
                });
            }
        });
    });

    $('form#editClient button#sumit').click(function (e) {
        e.preventDefault();
        SweetMessaje.fire({
            title: '¿Ingresó los datos datos correctamente?',
            icon: 'warning',
        }).then((result) => {
            if(result.value){
                var form = $(this).closest('form').serialize();
                $.ajax({
                    type: "PUT",
                    url: "/clients/"+$('input[name="id"]').val(),
                    data: form,
                    dataType: "json",
                    success: function (r) {
                        console.log(r);
                        r.res ==1 ?
                        SweetMessaje.fire({
                            icon: "success",
                            title: r.info,
                            showCancelButton: false,
                        }).then(()=> {
                            window.location.href="/clients/";
                            // window.location.href="/clients/"+$('input[name="id"]').val();
                        }) : Toast.fire({icon: 'error',title: r});
                    }, error : function(xhr, status) {
                        var e = 'error', m = 'Error al actualizar los datos del cliente.';
                        console.log(xhr.responseJSON);
                        if(xhr.status==422) {
                            $('p.error').remove();
                            $.each(xhr.responseJSON.errors, function(i,r) {
                                $('#'+i+'').parent().after( "<div class='col-sm-12'><p class='error text-danger'>"+r+"</p></div>" );
                            });
                            e = 'warning';
                            m = 'Debe completar el formulario de manera correcta';
                        }
                        Toast.fire({
                            icon: e,
                            title: m
                        });
                    }
                });
            }
        });
    });


    function calculateChange(value,divisa) {
        var value = parseFloat(value);
        if(value!='') {
            var bs = 0, usd = 0, total = '';
            divisa == 1 ? (bs = value, usd = Math.round((bs/dolar + Number.EPSILON) * 100) / 100) : (usd = value, bs = Math.round(((usd*dolar) + Number.EPSILON) * 100) / 100 );
            total = bs+'Bs / '+usd+'USD';
            !isNaN(value) ? $('h4#cambio').html(total) : $('h4#cambio').html('');
        }
    }

    // cambio de dolar a bolivar y viceversa
    $('form#pay_debt input#amount').keyup(function () {
        var value = $(this).val(), divisa = $('select#divisa').val();
        calculateChange(value,divisa);
    });

    $('form#pay_debt input#amount').change(function () {
        var value = $(this).val(), divisa = $('select#divisa').val();
        calculateChange(value,divisa);
    });

    $('form#pay_debt select#divisa').change(function () {
        var divisa = $(this).val(), value = $('form#pay_debt input#amount').val();
        calculateChange(value,divisa);
    });

    $('form#pay_debt').submit(function (e) {
        e.preventDefault();
        SweetMessaje.fire({
            title: "¿Seguro de registrar el pago?",
            icon: "warning",
        }).then((result) => {
            if(result.value){
                var token = $('input[name="_token"]').val();
                var method = $('input[name="_method"]').val();
                var amount = $('input#amount').val();
                var divisa = $('select#divisa').val();
                var id = $('input#id').val();
                var payment_method = [];

                $('input[name="payment_method[]"]:checked').each(function () {
                    payment_method.push(parseInt($(this).val()));
                });
                $.ajax({
                    type: "POST",
                    url: "/debts/"+id,
                    data: {
                        _token:token,
                        _method:method,
                        payment_method:payment_method,
                        id:id,
                        divisa:divisa,
                        amount:amount,
                        dolar:dolar
                    },
                    dataType: "json",
                    success: function (r) {
                        console.log(r)
                        if(r.res ==1) {
                            SweetMessaje.fire({
                                icon: "success",
                                title: "Éxito al registrar el pago",
                                showCancelButton: false,
                            }).then(()=> {
                                window.location.href="/debts/"+id;
                            })
                        } else if (r.res==2) {
                            SweetMessaje.fire({
                                icon: 'warning',
                                title: r.msj,
                                showCancelButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            }).then(()=> {
                                window.location.href="/debts";
                            });
                        } else {
                            Toast.fire({icon: 'error',title: r.msj});
                        }
                    }, error : function(xhr, status) {
                        var e = 'error', m = 'Error al pagar la deuda.';
                        console.log(xhr.responseJSON.msj);
                        if(xhr.status==422) {
                            $('p.error').html('');
                            $.each(xhr.responseJSON.errors, function(i,r) {
                                $('p#'+i+'.error').html( r );
                            });
                            e = 'warning';
                            m = 'Debe completar el formulario de manera correcta';
                        }
                        if(xhr.responseJSON.msj){
                            m = xhr.responseJSON.msj;
                        }
                        Toast.fire({
                            icon: e,
                            title: m
                        });
                    }
                });
            }
        });

    });

    $("#loading-body").fadeOut(300, function() { $(this).remove(); });

    $('input#limit').change(function () {
        if($(this).is(':checked')){
            $('input#limit_amount').removeAttr('disabled');
            $('input#limit_amount').focus();
        } else {
            $('input#limit_amount').attr('disabled','');
            $('input#limit_amount').val('');
        }
    });
    if($('input#limit').is(':checked')){
        $('input#limit_amount').removeAttr('disabled');
        $('input#limit_amount').focus();
    } else {
        $('input#limit_amount').attr('disabled','');
        $('input#limit_amount').val('');
    }

    // EJEMPLO DE BOOTSTRAP NOTIFY
    // $.notify({
    //     title: '<strong>Info...</strong>',
    //     icon: 'info',
    //     message: "Mensaje!"
    //   },{
    //     type: 'info',
    //     animate: {
    //           enter: 'animated fadeInUp',
    //       exit: 'animated fadeOutRight'
    //     },
    //     placement: {
    //       from: "bottom",
    //       align: "left"
    //     },
    //     offset: 20,
    //     spacing: 10,
    //     z_index: 1031,
    //     timer: 1000,
    //     animate: {
    //         enter: 'animated fadeInDown',
    //         exit: 'animated fadeOutUp'
    //     },
    //   });


    if ($('#weekSales').length>0) {
        const dias = [
            'Dom',
            'Lun',
            'Mar',
            'Mié',
            'Jue',
            'Vie',
            'Sáb',
        ];
        let _token = $("input[name='_token']").val();
        $.ajax({
            type: "post",
            url: "../sales/week",
            data: { _token:_token },
            dataType: "json",
            success: function (response) {
                let dates = new Date().getDay(), b = 0, labels = [], sales = [0,0,0,0,0,0,0], debts=[0,0,0,0,0,0,0], first=dates;
                for (let i = 0; i < 7; i++) {
                    var x=dates-b;
                    labels.push(dias[x]);
                    if (x==0) {
                        if(first==0) {
                            b=-7
                        } else if (first==1) {
                            b=-6
                        } else if (first==2) {
                            b=-5
                        } else if (first==3) {
                            b=-4
                        } else if (first==4) {
                            b=-3
                        } else if (first==5) {
                            b=-2
                        } else if (first==6) {
                            b=-1
                        }
                    }
                    b=b+1;
                }
                labels = labels.reverse();
                $.each(response,function(i,r){
                    if(r.type==1){
                        sales[labels.indexOf(r.dia)] = r.count;
                    } else {
                        debts[labels.indexOf(r.dia)] = r.count;
                    }
                });
                const reducer = (accumulator, curr) => accumulator + curr;
                let promSales = sales.reduce(reducer) / 7;
                let promDebts = debts.reduce(reducer) / 7;
                let roundPromSales = Math.round((promSales+Number.EPSILON)*100)/100;
                let roundPromDebts = Math.round((promDebts+Number.EPSILON)*100)/100;
                $('span#promedio').html(roundPromSales);
                $('span#promedioDebts').html(roundPromDebts);
                let info = {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas de Contado',
                        data: sales,
                        fill: false,
                        borderColor: 'green',
                        tension: 0.1
                    },
                    {
                        label: 'Ventas a Crédito',
                        data: debts,
                        fill: false,
                        borderColor: 'red',
                        tension: 0.1
                    }]
                };
                let config = {
                    type: 'line',
                    data: info,
                };
                const weekSales = document.getElementById('weekSales').getContext('2d');
                const weekSalesChart = new Chart(weekSales, config);

                $.ajax({
                    type: "post",
                    url:  "../sale/last",
                    data: {_token:_token},
                    dataType: "json",
                    success: function (data) {
                        var fechaInicio = new Date(data.date);
                        var fechaFin    = new Date().getTime();
                        var diff = fechaFin - fechaInicio;
                        let dias = Math.trunc(diff/(1000*60*60*24));
                        let horas = Math.trunc(diff/(1000*60*60));
                        let min = Math.trunc(diff/(1000*60));
                        let seg = Math.trunc(diff/(1000));
                        let lastSale = (dias > 0) ? dias+' día/s' : (horas > 0) ? horas+' hora/s' : (min > 0) ? min+' minuto/s' : seg+' segundo/s';
                        $('#lastSale').html(lastSale);
                    }
                });
            }
        });
    }

    if ($('#userWeekSales').length>0) {
        const dias = [
            'Dom',
            'Lun',
            'Mar',
            'Mié',
            'Jue',
            'Vie',
            'Sáb',
        ];
        let id = $("input[name='id']").val();
        let _token = $("input[name='_token']").val();

        $.ajax({
            type: "post",
            url: "../sales/week",
            data: {
                id:id,
                _token:_token
            },
            dataType: "json",
            success: function (response) {
                let dates = new Date().getDay(), b = 0, labels = [], sales = [0,0,0,0,0,0,0], debts=[0,0,0,0,0,0,0], first=dates;
                for (let i = 0; i < 7; i++) {
                    var x=dates-b;
                    labels.push(dias[x]);
                    if (x==0) {
                        if(first==0) {
                            b=-7
                        } else if (first==1) {
                            b=-6
                        } else if (first==2) {
                            b=-5
                        } else if (first==3) {
                            b=-4
                        } else if (first==4) {
                            b=-3
                        } else if (first==5) {
                            b=-2
                        } else if (first==6) {
                            b=-1
                        }
                    }
                    b=b+1;
                }
                labels = labels.reverse();
                $.each(response,function(i,r){
                    if(r.type==1){
                        sales[labels.indexOf(r.dia)] = r.count;
                    } else {
                        debts[labels.indexOf(r.dia)] = r.count;
                    }
                });
                const reducer = (accumulator, curr) => accumulator + curr;
                let promSales = sales.reduce(reducer) / 7;
                let promDebts = debts.reduce(reducer) / 7;
                let roundPromSales = Math.round((promSales+Number.EPSILON)*100)/100;
                let roundPromDebts = Math.round((promDebts+Number.EPSILON)*100)/100;
                $('span#promedio').html(roundPromSales);
                $('span#promedioDebts').html(roundPromDebts);
                let info = {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas de Contado',
                        data: sales,
                        fill: false,
                        borderColor: 'green',
                        tension: 0.1
                    },
                    {
                        label: 'Ventas a Crédito',
                        data: debts,
                        fill: false,
                        borderColor: 'red',
                        tension: 0.1
                    }]
                };
                let config = {
                    type: 'line',
                    data: info,
                };
                const weekSales = document.getElementById('userWeekSales').getContext('2d');
                const weekSalesChart = new Chart(weekSales, config);

                $.ajax({
                    type: "post",
                    url: "../sale/last",
                    data: {
                        id:id,
                        _token:_token,
                    },
                    dataType: "json",
                    success: function (data) {
                        var fechaInicio = new Date(data.date);
                        var fechaFin    = new Date().getTime();
                        var diff = fechaFin - fechaInicio;
                        let dias = Math.trunc(diff/(1000*60*60*24));
                        let horas = Math.trunc(diff/(1000*60*60));
                        let min = Math.trunc(diff/(1000*60));
                        let seg = Math.trunc(diff/(1000));
                        let lastSale = (dias > 0) ? dias+' día/s' : (horas > 0) ? horas+' hora/s' : (min > 0) ? min+' minuto/s' : seg+' segundo/s';
                        if (isNaN(diff)) {
                            $('#lastSale').closest('.card-footer').remove();
                        } else {
                            $('#lastSale').html(lastSale);
                        }
                    }
                });
            }
        });
    }

    if ($('#transactionsClient').length>0) {
        console.log('ACTIVO')
        const dias = [
            'Dom',
            'Lun',
            'Mar',
            'Mié',
            'Jue',
            'Vie',
            'Sáb',
        ];
        let id = $("input[name='id']").val();
        let _token = $("input[name='_token']").val();

        $.ajax({
            type: "post",
            url: "../sale/week/client",
            data: {
                id:id,
                _token:_token
            },
            dataType: "json",
            success: function (response) {
                let dates = new Date().getDay(), b = 0, labels = [], sales = [0,0,0,0,0,0,0], debts=[0,0,0,0,0,0,0], first=dates;
                for (let i = 0; i < 7; i++) {
                    var x=dates-b;
                    labels.push(dias[x]);
                    if (x==0) {
                        if(first==0) {
                            b=-7
                        } else if (first==1) {
                            b=-6
                        } else if (first==2) {
                            b=-5
                        } else if (first==3) {
                            b=-4
                        } else if (first==4) {
                            b=-3
                        } else if (first==5) {
                            b=-2
                        } else if (first==6) {
                            b=-1
                        }
                    }
                    b=b+1;
                }
                labels = labels.reverse();
                $.each(response,function(i,r){
                    if(r.type==1){
                        sales[labels.indexOf(r.dia)] = r.count;
                    } else {
                        debts[labels.indexOf(r.dia)] = r.count;
                    }
                });
                const reducer = (accumulator, curr) => accumulator + curr;
                let promSales = sales.reduce(reducer) / 7;
                let promDebts = debts.reduce(reducer) / 7;
                let roundPromSales = Math.round((promSales+Number.EPSILON)*100)/100;
                let roundPromDebts = Math.round((promDebts+Number.EPSILON)*100)/100;
                $('span#promedio').html(roundPromSales);
                $('span#promedioDebts').html(roundPromDebts);
                let info = {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas de Contado',
                        data: sales,
                        fill: false,
                        borderColor: 'green',
                        tension: 0.1
                    },
                    {
                        label: 'Ventas a Crédito',
                        data: debts,
                        fill: false,
                        borderColor: 'red',
                        tension: 0.1
                    }]
                };
                let config = {
                    type: 'line',
                    data: info,
                };
                const weekSales = document.getElementById('transactionsClient').getContext('2d');
                const weekSalesChart = new Chart(weekSales, config);

                $.ajax({
                    type: "post",
                    url: "../sale/last",
                    data: {
                        id:id,
                        _token:_token,
                    },
                    dataType: "json",
                    success: function (data) {
                        var fechaInicio = new Date(data.date);
                        var fechaFin    = new Date().getTime();
                        var diff = fechaFin - fechaInicio;
                        let dias = Math.trunc(diff/(1000*60*60*24));
                        let horas = Math.trunc(diff/(1000*60*60));
                        let min = Math.trunc(diff/(1000*60));
                        let seg = Math.trunc(diff/(1000));
                        let lastSale = (dias > 0) ? dias+' día/s' : (horas > 0) ? horas+' hora/s' : (min > 0) ? min+' minuto/s' : seg+' segundo/s';
                        if (isNaN(diff)) {
                            $('#lastSale').closest('.card-footer').remove();
                        } else {
                            $('#lastSale').html(lastSale);
                        }
                    }
                });
            }
        });
    }

});
