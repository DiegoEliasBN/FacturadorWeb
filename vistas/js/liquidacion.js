if (localStorage.getItem("capturarRango")!=null) {
	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));
}else{
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i>Rango de fecha');
}
/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })
$("#buscadorLiquidacion").focus();
var lista=[];
$(document).ready(function(){
  	$("#buscadorLiquidacion").keypress(function(e) {
        //13 es el código de la tecla
        if(e.which == 13) {
        	//console.log('hola aqui estoy');
        	if ($("#buscadorLiquidacion").val()!="") {
        		//console.log('presionaste enter');
        		var idProducto = $("#buscadorLiquidacion").val();	
				var datos = new FormData();
			    datos.append("codigo", idProducto);
				$.ajax({
			     	url:"ajax/liquidacion.ajax.php",
			      	method: "POST",
			      	data: datos,
			      	cache: false,
			      	contentType: false,
			      	processData: false,
			      	dataType:"json",
			      	success:function(respuesta){
					    if (respuesta!="") {
				      		var ivavalor=0;
				      		var valorcompra=0;
				      		var ivafinal=0;
				      		var descripcion = respuesta["descripcion"];
				          	var stock = parseFloat(respuesta["CantidadEgreso"])+parseFloat(1);
				          	var stockn =respuesta["CantidadEgreso"];
				          	var precioconiva = respuesta["precio_venta"];
				          	var precio = respuesta["precio_siniva"];
				          	var precioc= respuesta["precio_compra"];
				          	var CodAlmacen = respuesta["CodAlmacen"];
				          	var ivasi=respuesta["iva_producto"];
				          	//console.log("CodAlmacen",CodAlmacen);
				          	var stockF = Number(respuesta["CantidadIngreso"]-respuesta["CantidadEgreso"]);
				          	idProducto=respuesta["id"];
				          	if(stockF == 0){
				      			swal({
							      title: "No hay stock disponible",
							      type: "error",
							      confirmButtonText: "¡Cerrar!"
							    });
						    	return;
						    }
				        	$("#datosp").append(
				          		'<tr class="nuevoProducto">'+
							  		'<!-- Descripción del producto -->'+
					        		'<td width="45%">'+
					          			'<div class="" style="padding-right:0px">'+
							            	'<div class="input-group">'+
							              		'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
							              		'<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" disabled="true" required>'+
							            	'</div>'+
					          			'</div>'+
					        		'</td>'+ 
					          		'<!-- Cantidad del producto -->'+
							        '<td>'+
							        	'<div class="">'+
							            	'<input type="number" class="form-control nuevaCantidadProducto" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="" stock1="'+stockF+'" stock="'+stockn+'" CodAlmacen="'+CodAlmacen+'" nuevoStock="'+stock+'" required>'+
							        	'</div>' +
							        '</td>'+
					        		'<!-- precio -->'+
							        '<td>'+
							        	'<div class="input-group">'+
							             	'<input type="text" class="form-control preciotodo" value="'+precioc+'" disabled>'+
							          	'</div>' +
							        '</td>'+
					          		'<!-- Precio del producto -->'+
							        '<td>'+
							        	'<div class=" ingresoPrecio" style="padding-left:0px">'+
								            '<div class="input-group">'+
								            	'<input type="text" class="form-control nuevoPrecioProducto" id="id'+idProducto+'" valorcompra="'+valorcompra+'" ivavalor="'+ivavalor+'" ivafinal="'+ivafinal+'" ivasi="'+ivasi+'"  precioReal="'+precio+'" precioc="'+precioc+'" precioconiva="'+precioc+'" name="nuevoPrecioProducto" value="0.00" disabled="true" required>'+
								            '</div>'+
							          	'</div>'+
							        '</td>'+
					            '</tr>'
					        ) 
			         		// SUMAR TOTAL DE PRECIOS
					        sumarTotalPrecios()
					        // AGREGAR IMPUESTO
					        //agregarImpuesto()
					        // AGRUPAR PRODUCTOS EN FORMATO JSON
					        $('.nuevaCantidadProducto').focus();
					       	lista= listarProductos();
					        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
					        console.log(precioc);
					        $(".nuevoPrecioProducto").number(true, 2);
					        $(".preciotodo").number(true, 2);
					        $("#buscadorPrecio").html(precioc);
					        $("#buscadorPrecio").number(true,2);
							$("#agregarLiquidacion").prop('disabled', false);
						}else{
							swal({
							  type: "error",
							  title: "El Producto no fue encontrado",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							})
						}
					},
					error: function (request, status, error) {
        			console.log(request.responseText);
    				}
				})
        	}
        }
  	});
});
/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioLiquidacion").on("click", "button.quitarProducto", function(){
	$(this).parent().parent().parent().parent().parent().remove();
	var idProducto = $(this).attr("idProducto");
	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/
	if(localStorage.getItem("quitarProducto") == null){
		idQuitarProducto = [];
	}else{
		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
	}
	idQuitarProducto.push({"idProducto":idProducto});
	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
	//$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
	//$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
	if($(".nuevoProducto").children().length == 0){
		$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#SubTotal").val(0);
		$("#nuevoImpuestoVentas").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalsito").val("");
		$("#nuevoTotalVenta").attr("total",0);
		lista="";
		$("#agregarLiquidacion").prop('disabled', true);
	}else{
		// SUMAR TOTAL DE PRECIOS
    	sumarTotalPrecios()
    	// AGREGAR IMPUESTO
        //agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        lista=listarProductos();
	}
})
$(document).ready(function(){
    $(document).on('keydown',function(e) {
     if(e.ctrlKey && e.which === 88) {
    	$("#buscadorVenta").val('');
    	$("#buscadorVenta").focus();
    }
      });                  
});
$(".formularioLiquidacion").on("change", "input.nuevaCantidadProducto", function(){
	//console.log("entraste aqui");
	var ivavalor =0;
	var precio = $(this).parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	//console.log("iva",precio.attr("ivasi"));
	var ivasi=precio.attr("ivasi");
	//var preciocompra=precio.attr("precioc");
	preciocompra=parseFloat($(this).val()) *parseFloat(precio.attr("precioc"));
	//var precioFinal = (parseFloat($(this).val()) *parseFloat(precio.attr("precioconiva"))).toFixed(2); 
	if (ivasi=="S") {
		ivavalor = parseFloat(preciocompra) * parseFloat(0.12);
	}
	var ivafinal = (parseFloat(preciocompra)+parseFloat(ivavalor)).toFixed(2);
	//console.log("sumaaaa",preciocompra);
	//console.log("iva",ivavalor);
	//console.log("ivafinal",ivafinal);
	//console.log("precio",precioFinal);
	precio.val(preciocompra.toFixed(2));
	precio.attr("ivavalor",ivavalor);
	precio.attr("ivafinal",ivafinal);
	precio.attr("valorcompra",preciocompra);
	var nuevoStock = Number($(this).attr("stock")) + Number($(this).val());
	$(this).attr("nuevoStock", nuevoStock);
	if(Number($(this).val()) > Number($(this).attr("stock1"))){
		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/
		$(this).val('');
		var precioFinal = $(this).val() * precio.attr("ivafinal");
		precio.val(preciocompra);
		precio.attr("ivavalor",'');
		precio.attr("ivafinal",'');
		$(this).focus();
		sumarTotalPrecios();
		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock1")+" unidades!",
	      allowOutsideClick:false,
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });
	    return;
	}
	// SUMAR TOTAL DE PRECIOS
	sumarTotalPrecios()
	// AGREGAR IMPUESTO
    //agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    lista=listarProductos();
})
/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
$("#nuevoTotalVenta").number(true, 2);
$("#SubTotal").number(true, 2);
$("#nuevoImpuestoVentas").number(true, 2);
/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function(){
	var idVenta = $(this).attr("idVenta");
	window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;
})
/*=============================================
BORRAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEliminarLiquidacion", function(){
	var idVenta = $(this).attr("idVenta");
	var idAlmacen = $(this).attr("idAlmacen");
	swal({
	    title: '¿Está seguro de borrar la liquidacion?',
	    text: "¡Si no lo está puede cancelar la accíón!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, borrar liquidacion!'
	  }).then(function(result){
	    if (result.value) {
	        window.location = "index.php?ruta=liquidaciones&idVenta="+idVenta+"&idAlmacen="+idAlmacen;
	    }
	})
});
$(".tablas").on("click", ".btnImprimirLiquidacion", function(){
	var codigoVenta = $(this).attr("codigoVenta");
	var idAlmacen = $(this).attr("idAlmacen");
	window.open("extenciones/tcpdf/pdf/liquidacion.php?codigo="+codigoVenta+"&idAlmacen="+idAlmacen, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterangeL-btn').daterangepicker(
  {
    ranges   : {
      'HoyLiquidaciones'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment(),
    "cancelClass": "cancelLiquidacion"
  },
  function (start, end) {
    $('#daterangeL-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    var fechaInicial = start.format('YYYY-MM-DD');
    var fechaFinal = end.format('YYYY-MM-DD');
    var capturarRango = $("#daterange-btn span").html();
   	localStorage.setItem("capturarRango", capturarRango);
   	window.location = "index.php?ruta=liquidaciones&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  }
)
/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelLiquidacion").on("click", function(){
	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "liquidaciones";
})
/*=============================================
CAPTURAR HOY
=============================================*/
$(".daterangepicker.opensleft .ranges li[data-range-key=HoyLiquidaciones]").on("click", function(){
	var textoHoy = $(this).attr("data-range-key");
	if(textoHoy == "HoyLiquidaciones"){
		var d = new Date();
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();
		dia = ("0"+dia).slice(-2);
		mes = ("0"+mes).slice(-2);
		var fechaInicial = año+"-"+mes+"-"+dia;
		var fechaFinal = año+"-"+mes+"-"+dia;	
    	localStorage.setItem("capturarRango", "Hoy");
    	window.location = "index.php?ruta=liquidaciones&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
	}
})
//agregar venta 
$("#agregarLiquidacion").on("click", function(){
	$("#agregarLiquidacion").prop('disabled', true);
	var validacion = "ok";
	var nuevoAlmacen = $("#inicio").val();
	var idVendedor = $("#idVendedor").val();
	var CodUTurno = $("#CodUTurno").val();
	var listaProductos = $("#listaProductos").val();
	var seleccionarCliente = $("#idCliente").val();
	var nuevoIva = $("#nuevoIva").val();
	var nuevoIva12 = $("#nuevoIva12").val();
	var nuevoIva0 = $("#nuevoIva0").val();
	var totalVenta = $("#totalVenta").val();
	var nuevoTotalsito = $("#nuevoTotalsito").val();
	var datos = new FormData();
	datos.append("nuevoAlmacen", nuevoAlmacen);
	datos.append("idVendedor", idVendedor);
	datos.append("CodUTurno", CodUTurno);
	datos.append("listaProductos", listaProductos);
	datos.append("seleccionarCliente", seleccionarCliente);
	datos.append("nuevoIva", nuevoIva);
	datos.append("nuevoIva12", nuevoIva12);
	datos.append("nuevoIva0", nuevoIva0);
	datos.append("totalVenta", totalVenta);
	datos.append("nuevoTotalsito", nuevoTotalsito);
	console.log("almacen", nuevoAlmacen);
	if ( nuevoAlmacen != "" && idVendedor != "" &&
		CodUTurno != "" && listaProductos != "" &&
		seleccionarCliente != "" && nuevoIva != "" && nuevoIva12 != "" && 
		nuevoIva0 != "" && totalVenta != "" && nuevoTotalsito != "" )
		 {
		 	var listaProductosValidar= JSON.parse(listaProductos);
			listaProductosValidar.forEach(funcionForEach);
			function funcionForEach(item, index){
				  	if (item["cantidad"]=="" || item["cantidad"]==0) {
				  		validacion="error";
				  		swal({
									  	type: "error",
									  	title: "UN CAMPO DEL DETLLE ESTA VACIO O EL VALOR EN 0.00",
									  	allowOutsideClick:false,
									  	showConfirmButton: true,
									  	confirmButtonText: "Cerrar"
									  	})
				  	}      
			}
			if (validacion=="error") {
				$("#agregarLiquidacion").prop('disabled', false);
				return false;
			}
		    $.ajax({
		      url:"ajax/liquidacion.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		      success:function(respuesta){
		      	if (respuesta["respuesta"] == "ok") {
		      		localStorage.removeItem("rango");
					swal({
						type: "success",
						title: "La liquidacion por compra ha sido guardada correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						timer: 1000,
						closeOnConfirm: false
						}).then((result) => {
								if (result.value) {
									window.open("extenciones/tcpdf/pdf/liquidacion.php?codigo="+respuesta['id_liquidacion']+"&idAlmacen="+nuevoAlmacen, "_blank");
									window.location = "crear-liquidacion";
								}else{
									window.open("extenciones/tcpdf/pdf/liquidacion.php?codigo="+respuesta['id_liquidacion']+"&idAlmacen="+nuevoAlmacen, "_blank");
									window.location = "crear-liquidacion";
								}
							})
				}else{
					$("#agregarLiquidacion").prop('disabled', false);
					swal({
					  	type: "error",
					  	title: "La liquidacion por compra no se ha guardado",
					  	allowOutsideClick:false,
					  	showConfirmButton: true,
					  	confirmButtonText: "Cerrar"
					  	}).then((result) => {
							if (result.value) {
								window.location = "crear-liquidacion";
							}
					})
				}
			  },
			  error: function (request, status, error) {
        			console.log(request.responseText);
    			}
		  	})
	}else{
		$("#agregarLiquidacion").prop('disabled', false);
		swal({
			type: "error",
			title: "¡LA FACTURA NO ESTA LISTA UNO O VARIOS CAMPOS ESTAS VACIOS!",
			allowOutsideClick:false,
			showConfirmButton: true,
			confirmButtonText: "Cerrar"
		  })
	}
});
//editar la venta
$("#btnEditarVenta").on("click", function(){
	$("#btnEditarVenta").prop('disabled', true);
	var validacion = "ok";
	var idVendedor = $("#idVendedor").val();
	var editarVenta = $("#nuevaVenta").val();
	var nuevoAlmacen = $("#inicio").val();
	var CodUTurno = $("#CodUTurno").val();
	var listaProductos = $("#listaProductos").val();
	var Factura = $("#Factura").val();
	var seleccionarCliente = $("#idCliente").val();
	var nuevoIva = $("#nuevoIva").val();
	var nuevoIva12 = $("#nuevoIva12").val();
	var nuevoIva0 = $("#nuevoIva0").val();
	var totalVenta = $("#totalVenta").val();
	var nuevoTotalsito = $("#nuevoTotalsito").val();
	var totalCompra = $("#totalCompra").val();
	var nuevoMetodoPago = $("#nuevoMetodoPagos").val();
	var codigo_df = $("#nuevoCodigoTransaccion").val();
	var datos = new FormData();
	datos.append("idVendedor", idVendedor);
	datos.append("editarVenta", editarVenta);
	datos.append("CodUTurno", CodUTurno);
	datos.append("CodAlmacen", nuevoAlmacen);
	datos.append("listaProductos", listaProductos);
	datos.append("editarFactura", Factura);
	datos.append("seleccionarCliente", seleccionarCliente);
	datos.append("nuevoIva", nuevoIva);
	datos.append("nuevoIva12", nuevoIva12);
	datos.append("nuevoIva0", nuevoIva0);
	datos.append("totalVenta", totalVenta);
	datos.append("nuevoTotalsito", nuevoTotalsito);
	datos.append("totalCompra", totalCompra);
	datos.append("nuevoMetodoPago", nuevoMetodoPago);
	datos.append("codigo_df", codigo_df);
	if (idVendedor != "" &&
		CodUTurno != "" && Factura != "" &&
		seleccionarCliente != "" && nuevoIva != "" && nuevoIva12 != "" && 
		nuevoIva0 != "" && totalVenta != "" && nuevoTotalsito != "" &&
		totalCompra != "" && nuevoMetodoPago != "" )
		 {
		 	if (listaProductos !="") {
			 	var listaProductosValidar= JSON.parse(listaProductos);
				listaProductosValidar.forEach(funcionForEach);
				function funcionForEach(item, index){
					  	if (item["cantidad"]=="" || item["cantidad"]==0) {
					  		validacion="error";
				  			swal({
							  	type: "error",
							  	title: "UN CAMPO DEL DETLLE ESTA VACIO O EL VALOR EN 0.00",
							  	allowOutsideClick:false,
							  	showConfirmButton: true,
							  	confirmButtonText: "Cerrar"
							})
					  	}  
				}    
			}
			if (nuevoMetodoPago=="TC" || nuevoMetodoPago=="TD") {
				if (codigo_df=="") {
					validacion="error";
					swal({
						type: "error",
						title: "¡El codigo de la transaccion esta vacio!",
						allowOutsideClick:false,
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					  })
				}
			}
			if (validacion=="error") {
				$("#btnEditarVenta").prop('disabled', false);
				return false;
			}
		    $.ajax({
		      url:"ajax/ventas.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		      success:function(respuesta){
		      	if (respuesta== "ok") {
		      		localStorage.removeItem("rango");
		            swal({
		                  type: "success",
		                  title: "La venta ha sido editada correctamente",
		                  showConfirmButton: true,
		                  confirmButtonText: "Cerrar"
		                  }).then((result) => {
	                            if (result.value) {
	                                window.location = "ventas";
	                            }
		            })
				}else{
					$("#agregarLiquidacion").prop('disabled', false);
					swal({
					  	type: "error",
					  	title: "La venta no se ha editado",
					  	allowOutsideClick:false,
					  	showConfirmButton: true,
					  	confirmButtonText: "Cerrar"
					  	}).then((result) => {
							if (result.value) {
								window.location = "crear-venta";
							}
					})
						}
			  },
			  error: function (request, status, error) {
        			console.log(request.responseText);
    			}
		  	})
	}else{
		$("#btnEditarVenta").prop('disabled', false);
		swal({
			type: "error",
			title: "¡LA FACTURA NO ESTA LISTA UNO O VARIOS CAMPOS ESTAS VACIOS!",
			allowOutsideClick:false,
			allowOutsideClick:false,
			showConfirmButton: true,
			confirmButtonText: "Cerrar"
		  })
	}
});
//buscar producto por nombre
$(document).ready(function() {
	$('#buscadorLiquidacion').autocomplete({
		source: function(request, response){
			$.ajax({
				url:"ajax/liquidacion.ajax.php",
				dataType:"json",
				data:{descripcion:request.term},
				success: function(data){
					response($.each(data, function(item,i){
						//console.log("esto es",i);
						return{
							value: i.value,
							nombre:i.nombre
						}
					}));
				},
				error: function (request, status, error) {
    				console.log(request.responseText);
    			}
    		});
		},
		minLength: 4,
		select: function(event,ui){
    		var cliente =$('#idCliente').val();
			var nombre = ui.item.nombre;
			var datos = new FormData();
		    datos.append("nombreProducto", nombre);
			$.ajax({
		     	url:"ajax/liquidacion.ajax.php",
		      	method: "POST",
		      	data: datos,
		      	cache: false,
		      	contentType: false,
		      	processData: false,
		      	dataType:"json",
		      	success:function(respuesta){
				    if (respuesta!="") {
			      		var ivavalor=0;
			      		var valorcompra=0;
			      		var ivafinal=0;
			      		var descripcion = respuesta["descripcion"];
			          	var stock = parseFloat(respuesta["CantidadEgreso"])+parseFloat(1);
			          	var stockn =respuesta["CantidadEgreso"];
			          	var precioconiva = respuesta["precio_venta"];
			          	var precio = respuesta["precio_siniva"];
			          	var precioc= respuesta["precio_compra"];
			          	var CodAlmacen = respuesta["CodAlmacen"];
			          	var ivasi=respuesta["iva_producto"];
			          	//console.log("CodAlmacen",CodAlmacen);
			          	var stockF = Number(respuesta["CantidadIngreso"]-respuesta["CantidadEgreso"]);
			          	var idProducto=respuesta["id"];
			          	if(stockF == 0){
			      			swal({
						      title: "No hay stock disponible",
						      type: "error",
						      confirmButtonText: "¡Cerrar!"
						    });
					    	return;
					    }
					    $.ajax({
				      		url:"ajax/descuento.ajax.php",
					      	method: "POST",
					      	data: false,
					      	cache: false,
					      	contentType: false,
					      	processData: false,
					      	dataType:"json",
					      	success:function(respuestaD){
					        	$("#datosp").append(
				          		'<tr class="nuevoProducto">'+
							  		'<!-- Descripción del producto -->'+
					        		'<td width="45%">'+
					          			'<div class="" style="padding-right:0px">'+
							            	'<div class="input-group">'+
							              		'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
							              		'<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" disabled="true" required>'+
							            	'</div>'+
					          			'</div>'+
					        		'</td>'+ 
					          		'<!-- Cantidad del producto -->'+
							        '<td>'+
							        	'<div class="">'+
							            	'<input type="number" class="form-control nuevaCantidadProducto" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="" stock1="'+stockF+'" stock="'+stockn+'" CodAlmacen="'+CodAlmacen+'" nuevoStock="'+stock+'" required>'+
							        	'</div>' +
							        '</td>'+
					        		'<!-- precio -->'+
							        '<td>'+
							        	'<div class="input-group">'+
							             	'<input type="text" class="form-control preciotodo" value="'+precioc+'" disabled>'+
							          	'</div>' +
							        '</td>'+
					          		'<!-- Precio del producto -->'+
							        '<td>'+
							        	'<div class=" ingresoPrecio" style="padding-left:0px">'+
								            '<div class="input-group">'+
								            	'<input type="text" class="form-control nuevoPrecioProducto" id="id'+idProducto+'" valorcompra="'+valorcompra+'" ivavalor="'+ivavalor+'" ivafinal="'+ivafinal+'" ivasi="'+ivasi+'"  precioReal="'+precio+'" precioc="'+precioc+'" precioconiva="'+precioc+'" name="nuevoPrecioProducto" value="0.00" disabled="true" required>'+
								            '</div>'+
							          	'</div>'+
							        '</td>'+
					            '</tr>'
					        ) 
				         		// SUMAR TOTAL DE PRECIOS
						        sumarTotalPrecios()
						        // AGREGAR IMPUESTO
						        //agregarImpuesto()
						        // AGRUPAR PRODUCTOS EN FORMATO JSON
						        $('.nuevaCantidadProducto').focus();
						       	lista= listarProductos();
						        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
						        $(".nuevoPrecioProducto").number(true, 2);
						        $(".preciotodo").number(true, 2);
						        $("#buscadorPrecio").html(precioconiva);
							    $("#buscadorPrecio").number(true,2);
								$("#agregarLiquidacion").prop('disabled', false);
					        }
	      				})
					}else{
						swal({
						  type: "error",
						  title: "El Producto no fue encontrado",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						})
					}
				},
				error: function (request, status, error) {
    				console.log(request.responseText);
    			}
			})
		}	
	});
});
$('#buscadorLiquidacion').focus(function(){
 	$(this).select();
});
