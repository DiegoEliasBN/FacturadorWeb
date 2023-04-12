/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })
var idAlmacenP=$("#inicioc").val();
var lista=[];
$('.tablaCompras').DataTable({
    "ajax": "ajax/datatable-compras.ajax.php?nuevo="+idAlmacenP,
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
	}
});
$(".tablaCompras tbody").on("click", "button.agregarProductoc", function(){
	var jose=parseFloat(1.226);
	var manuel=Math.ceil(jose * 100)/100;
	//console.log(manuel);
	//console.log("presionaste el bton");
	var c=0;
	var idProducto = $(this).attr("idProducto");
	var item="id";
	//$(this).removeClass("btn-primary agregarProducto");
	//$(this).addClass("btn-default");
	//console.log("json",lista);
	for ( var datos in lista){
		if (idProducto==lista[datos].id) {
			c=1;
			lista[datos].cantidad=parseFloat(lista[datos].cantidad)+1;
			$("#id"+idProducto).attr("precioReal",lista[datos].precio);
			$("#"+idProducto).val(lista[datos].cantidad).trigger('change');
			$("#"+idProducto).focus();
		}
	}
	if (c==0) {
			var datos = new FormData();
		    datos.append("idProducto", idProducto);
		    datos.append("item", item);
		     $.ajax({
		     	url:"ajax/productosc.ajax.php",
		      	method: "POST",
		      	data: datos,
		      	cache: false,
		      	contentType: false,
		      	processData: false,
		      	dataType:"json",
		      	success:function(respuesta){
		      		var ivavalor=0;
		      		var ivafinal=0;
		      		var descripcion = respuesta["descripcion"];
		          	var stock = 0;
		          	var stockn =0;
		          	var precioconiva = respuesta["precio_venta"];
		          	var precio = respuesta["precio_compra"];
		          	var precioc= respuesta["precio_siniva"];
		          	//var CodAlmacen = respuesta["CodAlmacen"];
		          	var ivasi=respuesta["iva_producto"];
		          	//console.log("CodAlmacen",CodAlmacen);
		          	//var stockF = Number(respuesta[0]["CantidadIngreso"]-respuesta[0]["CantidadEgreso"]);
				          	/*if (ivasi=="S") {
				          		var ivavalorn=parseFloat(precioconiva)/parseFloat(1.12);
				          		ivavalor=(parseFloat(ivavalorn)*parseFloat(0.12)).toFixed(2);
				   				console.log("ivavalor",ivavalor);
				          		ivafinal=(parseFloat(ivavalorn)+parseFloat(ivavalor)).toFixed(2);
				          		//console.log("iva",ivafinal);
				          	}else{
				          		ivafinal=precio;
				          	}/*
		          	/*=============================================
		          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
		          	=============================================*/
		          	/*if(stockF == 0){
		      			swal({
					      title: "No hay stock disponible",
					      type: "error",
					      confirmButtonText: "¡Cerrar!"
					    });
					    $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
					    return;
		          	}*/
		          	$("#datosp").append(
		          	 '<tbody class="nuevoProducto">'+
					  '<!-- Descripción del producto -->'+
			        '<td width="45%">'+
			          '<div class="" style="padding-right:0px">'+
			            '<div class="input-group">'+
			              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
			              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
			            '</div>'+
			          '</div>'+
			        '</td>'+ 		
			          '<!-- Cantidad del producto -->'+
			        '<td>'+
			          '<div class="">'+
			             '<input type="number" class="form-control nuevaCantidadProductoc" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="" stock="'+stockn+'" nuevoStock="'+stock+'" required>'+
			          '</div>' +
			        '</td>'+
			        '<!-- precio -->'+
			        '<td>'+
			          '<div class="input-group">'+
			             '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
			             '<input type="text" class="form-control preciotodo" value="'+precio+'" readonly>'+
			          '</div>' +
			        '</td>'+
			          '<!-- Precio del producto -->'+
			        '<td>'+
			          '<div class=" ingresoPrecio" style="padding-left:0px">'+
			            '<div class="input-group">'+
			              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
			              '<input type="text" class="form-control nuevoPrecioProducto" id="id'+idProducto+'" ivavalor="'+ivavalor+'" ivafinal="'+ivafinal+'" ivasi="'+ivasi+'"  precioReal="'+precio+'" precioc="'+precioc+'" precioconiva="'+precioconiva+'" name="nuevoPrecioProducto" value="0.00" readonly required>'+
			            '</div>'+
			          '</div>'+
			          '</td>'+
			           '</tbody>') 
			        // SUMAR TOTAL DE PRECIOS
			        sumarTotalPreciosc()
			        // AGREGAR IMPUESTO
			        //agregarImpuesto()
			        // AGRUPAR PRODUCTOS EN FORMATO JSON
			        $("#"+idProducto).val('');
			        $("#"+idProducto).focus();
			       lista= listarProductosc();
			        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
			        $(".nuevoPrecioProducto").number(true, 2);
			        $(".preciotodo").number(true, 2);
		      	}
		     })
	}else{
		lista= listarProductosc();
	}
});
$(document).ready(function(){
      $("#buscador").keypress(function(e) {
      		var cliente =$('#seleccionarCliente').val();
			var descuento=0;
            //13 es el código de la tecla
            if(e.which == 13) {
            	if ($("#buscador").val()!="") {
            		if ($("#tipoFactura").val()=="compra") {
						//console.log(manuel);
						//console.log("presionaste el bton");
						var c=0;
						var idProducto = $("#buscador").val();
						var item="codigo";
						//$(this).removeClass("btn-primary agregarProducto");
						//$(this).addClass("btn-default");
						//console.log("json",lista);
						for ( var datos in lista){
							if (idProducto==lista[datos].id) {
								c=1;
								lista[datos].cantidad=parseFloat(lista[datos].cantidad)+1;
								$("#id"+idProducto).attr("precioReal",lista[datos].precio);
								$("#"+idProducto).val(lista[datos].cantidad).trigger('change');
								$("#"+idProducto).focus();
							}
						}
						if (c==0) {
								var datos = new FormData();
							    datos.append("idProducto", idProducto);
							    datos.append("item", item);
							     $.ajax({
							     	url:"ajax/productosc.ajax.php",
							      	method: "POST",
							      	data: datos,
							      	cache: false,
							      	contentType: false,
							      	processData: false,
							      	dataType:"json",
							      	success:function(respuesta){
							      		var ivavalor=0;
							      		var ivafinal=0;
							      		var descripcion = respuesta["descripcion"];
							          	var stock = 0;
							          	var stockn =0;
							          	var precioconiva = respuesta["precio_venta"];
							          	var precio = respuesta["precio_compra"];
							          	var precioc= respuesta["precio_siniva"];
							          	//var CodAlmacen = respuesta["CodAlmacen"];
							          	var ivasi=respuesta["iva_producto"];
							          	//console.log("CodAlmacen",CodAlmacen);
							          	//var stockF = Number(respuesta[0]["CantidadIngreso"]-respuesta[0]["CantidadEgreso"]);
									          	/*if (ivasi=="S") {
									          		var ivavalorn=parseFloat(precioconiva)/parseFloat(1.12);
									          		ivavalor=(parseFloat(ivavalorn)*parseFloat(0.12)).toFixed(2);
									   				console.log("ivavalor",ivavalor);
									          		ivafinal=(parseFloat(ivavalorn)+parseFloat(ivavalor)).toFixed(2);
									          		//console.log("iva",ivafinal);
									          	}else{
									          		ivafinal=precio;
									          	}/*
							          	/*=============================================
							          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
							          	=============================================*/
							          	/*if(stockF == 0){
							      			swal({
										      title: "No hay stock disponible",
										      type: "error",
										      confirmButtonText: "¡Cerrar!"
										    });
										    $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
										    return;
							          	}*/
							          	$("#datosp").append(
							          	 '<tbody class="nuevoProducto">'+
										  '<!-- Descripción del producto -->'+
								        '<td width="45%">'+
								          '<div class="" style="padding-right:0px">'+
								            '<div class="input-group">'+
								              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
								              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
								            '</div>'+
								          '</div>'+
								        '</td>'+ 		
								          '<!-- Cantidad del producto -->'+
								        '<td>'+
								          '<div class="">'+
								             '<input type="number" class="form-control nuevaCantidadProductoc" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="" stock="'+stockn+'" nuevoStock="'+stock+'" required>'+
								          '</div>' +
								        '</td>'+
								        '<!-- precio -->'+
								        '<td>'+
								          '<div class="input-group">'+
								             '<span class="input-group-addon"></span>'+
								             '<input type="text" class="form-control preciotodo" value="'+precio+'" readonly>'+
								          '</div>' +
								        '</td>'+
								          '<!-- Precio del producto -->'+
								        '<td>'+
								          '<div class=" ingresoPrecio" style="padding-left:0px">'+
								            '<div class="input-group">'+
								              '<span class="input-group-addon"></i></span>'+
								              '<input type="text" class="form-control nuevoPrecioProducto" id="id'+idProducto+'" ivavalor="'+ivavalor+'" ivafinal="'+ivafinal+'" ivasi="'+ivasi+'"  precioReal="'+precio+'" precioc="'+precioc+'" precioconiva="'+precioconiva+'" name="nuevoPrecioProducto" value="0.00" readonly required>'+
								            '</div>'+
								          '</div>'+
								          '</td>'+
								           '</tbody>') 
								        // SUMAR TOTAL DE PRECIOS
								        sumarTotalPrecios()
								        // AGREGAR IMPUESTO
								        //agregarImpuesto()
								        // AGRUPAR PRODUCTOS EN FORMATO JSON
								        $("#"+idProducto).val('');
								        $("#"+idProducto).focus();
								       lista= listarProductos();
								        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
								        $(".nuevoPrecioProducto").number(true, 2);
								        $(".preciotodo").number(true, 2);
							      	}
							     })
						}else{
							lista= listarProductos();
						}
					}else if ($("#tipoFactura").val()=="traspaso") {
						//console.log(manuel);
						//console.log("presionaste el bton");
						var c=0;
						var idProducto = $("#buscador").val();
						var idAlmacen = $("#inicio").val();
						//$(this).removeClass("btn-primary agregarProducto");
						//$(this).addClass("btn-default");
						//console.log("json",lista);
						for ( var datos in lista){
							if (idProducto==lista[datos].id) {
								c=1;
								lista[datos].cantidad=parseFloat(lista[datos].cantidad)+1;
								$("#id"+idProducto).attr("precioReal",lista[datos].precio);
								$("#"+idProducto).val(lista[datos].cantidad).trigger('change');
								$("#"+idProducto).focus();
							}
						}
						if (c==0) {
								var datos = new FormData();
							    datos.append("idProducto", idProducto);
							    datos.append("idAlmacen", idAlmacen);
							    $.ajax({
							     	url:"ajax/productos2.ajax.php",
							      	method: "POST",
							      	data: datos,
							      	cache: false,
							      	contentType: false,
							      	processData: false,
							      	dataType:"json",
							      	success:function(respuesta){
							      			if (respuesta!="") {
										      		var ivavalor=0;
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
										          	/*if (ivasi=="S") {
										          		var ivavalorn=parseFloat(precioconiva)/parseFloat(1.12);
										          		ivavalor=(parseFloat(ivavalorn)*parseFloat(0.12)).toFixed(2);
										   				console.log("ivavalor",ivavalor);
										          		ivafinal=(parseFloat(ivavalorn)+parseFloat(ivavalor)).toFixed(2);
										          		//console.log("iva",ivafinal);
										          	}else{
										          		ivafinal=precio;
										          	}*/
										          	/*=============================================
										          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
										          	=============================================*/
										          	if(stockF == 0){
										      			swal({
													      title: "No hay stock disponible",
													      type: "error",
													      confirmButtonText: "¡Cerrar!"
													    });
													    $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
													    return;
										          	}
										          	$("#datosp").append(
										          	 '<tbody class="nuevoProducto">'+
													  '<!-- Descripción del producto -->'+
											        '<td width="45%">'+
											          '<div class="" style="padding-right:0px">'+
											            '<div class="input-group">'+
											              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
											              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
											            '</div>'+
											          '</div>'+
											        '</td>'+ 		
											          '<!-- Cantidad del producto -->'+
											        '<td width="8%">'+
											          '<div class="">'+
											             '<input type="number" class="form-control nuevaCantidadProductot" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="1" stock1="'+stockF+'" stock="'+stockn+'" CodAlmacen="'+CodAlmacen+'" nuevoStock="'+stock+'" required>'+
											          '</div>' +
											        '</td>'+
											           '</tbody>') 
											        // SUMAR TOTAL DE PRECIOS
											        //sumarTotalPrecios()
											        // AGREGAR IMPUESTO
											        //agregarImpuesto()
											        // AGRUPAR PRODUCTOS EN FORMATO JSON
											        $("#"+idProducto).val('');
											        $("#"+idProducto).focus();
											       lista= listarProductos();
											        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
											        $(".nuevoPrecioProducto").number(true, 2);
											        $(".preciotodo").number(true, 2);
											}else{
												swal({
												  type: "error",
												  title: "El Producto no fue encontrado",
												  showConfirmButton: true,
												  confirmButtonText: "Cerrar"
												})
											}
			      					}
			     				})
						}else{
							lista= listarProductos();
						}
					}
            	}
            }
      });
});
/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/
var numProducto = 0;
$(".btnAgregarProductoc").click(function(){
	var idAlmacen = $(this).val();
	numProducto ++;
	var datos = new FormData();
	datos.append("traerProductos", "ok");
	datos.append("idAlmacen",idAlmacen);
	$.ajax({
		url:"ajax/productosc.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    //console.log("respuesta",respuesta);
      	    	$("#datosp").append(
		          	 '<tbody class="nuevoProducto">'+
					  '<!-- Descripción del producto -->'+
			        '<td width="45%">'+
			          '<div class="" style="padding-right:0px">'+
			            '<div class="input-group">'+
			              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+
			              '<select class="form-control nuevaDescripcionProducto" CodAlmacen="'+idAlmacen+'" id="producto'+numProducto+'" idProducto name="nuevaDescripcionProducto" required>'+
			              '<option>Seleccione el producto</option>'+
			              '</select>'+  
			            '</div>'+
			          '</div>'+
			        '</td>'+ 		
			          '<!-- Cantidad del producto -->'+
			        '<td>'+
			          '<div class="ingresoCantidad">'+
			             '<input type="number" class="form-control nuevaCantidadProductoc" step="any"  id="cantidad'+numProducto+'" name="nuevaCantidadProducto" min="0" value="" stock1="" stock="" CodAlmacen="" nuevoStock="" required>'+
			          '</div>' +
			        '</td>'+
			        '<!-- precio -->'+
			        '<td>'+
			          '<div class="input-group">'+
			             '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
			             '<input type="text" class="form-control preciotodo" value="" readonly>'+
			          '</div>' +
			        '</td>'+
			          '<!-- Precio del producto -->'+
			        '<td>'+
			          '<div class=" ingresoPrecio" style="padding-left:0px">'+
			            '<div class="input-group">'+
			              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
			              '<input type="text" class="form-control nuevoPrecioProducto" id="" ivavalor="" ivafinal="" ivasi=""  precioReal="" precioc="" precioconiva="" name="nuevoPrecioProducto" value="0.00" readonly required>'+
			            '</div>'+
			          '</div>'+
			          '</td>'+
			           '</tbody>') 
	        // AGREGAR LOS PRODUCTOS AL SELECT 
	         respuesta.forEach(funcionForEach);
	         function funcionForEach(item, index){
	         	var stock=Number(item.CantidadIngreso)-Number(item.CantidadEgreso);
	         	if(stock != 0){
	         		$("#producto"+numProducto).select2();
		         	$("#producto"+numProducto).append(
						'<option  idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)
		         }
	         }
	         // SUMAR TOTAL DE PRECIOS
    		sumarTotalPrecios()
    		// AGREGAR IMPUESTO
	       // agregarImpuesto()
	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
	        $(".nuevoPrecioProducto").number(true, 2);
      	}
	})
})
/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioCompra").on("change", "select.nuevaDescripcionProducto", function(){
	//console.log("hola entraste a cambiar la cantidad");
	var idAlmacen=$(this).attr("CodAlmacen");
	//console.log("idAlmacen",idAlmacen);
	var nombreProducto = $(this).val();
	//console.log("nombreProducto",nombreProducto);
	var nuevaDescripcionProducto = $(this).parent().parent().parent().parent().children().children().children().children(".nuevaDescripcionProducto");
	var nuevoPrecioProducto = $(this).parent().parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var todo = $(this).parent().parent().parent().parent().children().children().children(".preciotodo");
	var nuevaCantidadProducto = $(this).parent().parent().parent().parent().children().children(".ingresoCantidad").children(".nuevaCantidadProducto");
	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);
    datos.append("idAlmacen", idAlmacen);
	  $.ajax({
     	url:"ajax/productosc.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		console.log("respuesta",respuesta);
      		var ivasi=respuesta["iva_producto"];
      		var precio=respuesta["precio_venta"];
      		var ivavalor=0;
      		var ivafinal=0;
      	    var stock=Number(respuesta["CantidadIngreso"])-Number(respuesta["CantidadEgreso"]);
      	    $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", stock);
      	    $(nuevaCantidadProducto).attr("stock1", stock);
      	    $(todo).val(respuesta["precio_compra"]);
      	    $(nuevaCantidadProducto).attr("CodAlmacen", respuesta["CodAlmacen"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["CantidadEgreso"])+1);
      	    $(nuevoPrecioProducto).val('');
      	    $(nuevoPrecioProducto).attr("precioc",respuesta["precio_compra"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_compra"]);
      	    $(nuevoPrecioProducto).attr("precioconiva", respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("ivasi", ivasi);
      	    /*if (ivasi=="S") {
          		ivavalor=(parseFloat(precio)*parseFloat(0.12)).toFixed(2);
          		ivafinal=(parseFloat(precio)+parseFloat(ivavalor)).toFixed(2);
          		//console.log("iva",ivafinal);
          	}*/
          	$(nuevoPrecioProducto).attr("ivavalor", ivavalor);
          	$(nuevoPrecioProducto).attr("ivafinal", ivafinal);
  	      // AGRUPAR PRODUCTOS EN FORMATO JSON
  	      	$(nuevaCantidadProducto).focus();
	        lista=listarProductos();
	        sumarTotalPrecios()
	       //$("#cantidad"+numProducto).val(1);
	       //$("#cantidad"+numProducto).focus();
      	}
      })
})
/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioCompra").on("click", "button.quitarProducto", function(){
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
		$("#nuevoImpuestoCompra").val(0);
		$("#nuevoTotalCompra").val(0);
		$("#SubTotalc").val(0);
		$("#nuevoImpuestoCompras").val(0);
		$("#totalCompra").val(0);
		$("#nuevoTotalCompra").attr("total",0);
		lista="";
	}else{
		// SUMAR TOTAL DE PRECIOS
    	sumarTotalPreciosc()
    	// AGREGAR IMPUESTO
        //agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        lista=listarProductosc();
	}
})
$(".formularioCompra").on("change", "input.nuevaCantidadProductoc", function(){
	//console.log("entraste aqui");
	var precio = $(this).parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	console.log("iva",precio.attr("ivasi"));
	var ivasi=precio.attr("ivasi");
	var precioFinal = (parseFloat($(this).val()) *parseFloat(precio.attr("precioReal"))).toFixed(2);
	if (ivasi=="S") {
		var ivavalor =(precioFinal*0.12).toFixed(2);
	}else{
		var ivavalor =0;
	}
	var ivafinal = (parseFloat(precioFinal)+parseFloat(ivavalor)).toFixed(2);
	//console.log("final",precioFinal);
	//console.log("iva",ivavalor);
	//console.log("ivafinal",ivafinal);
	//console.log("precio",precioFinal);
	precio.val(precioFinal);
	precio.attr("ivavalor",ivavalor);
	precio.attr("ivafinal",ivafinal);
	// SUMAR TOTAL DE PRECIOS
	sumarTotalPreciosc()
	// AGREGAR IMPUESTO
    //agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    lista=listarProductosc();
})
function sumarTotalPreciosc(){
	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];
	var arraySumaPrecioF = [];
	var arraySumaIva = [];  
	for(var i = 0; i < precioItem.length; i++){
		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 arraySumaIva.push(Number($(precioItem[i]).attr("ivavalor")));
		 arraySumaPrecioF.push(Number($(precioItem[i]).attr("ivafinal")));
	}
	function sumaArrayPrecios(total, numero){
		return total + numero;
	}
	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	var sumaTotalPrecioF = arraySumaPrecioF.reduce(sumaArrayPrecios);
	var sumaTotalIva = arraySumaIva.reduce(sumaArrayPrecios);
	//console.log("suma",sumaTotalPrecio);
	$("#nuevoTotalCompra").val(sumaTotalPrecio);
	$("#nuevoImpuestoCompras").val(sumaTotalIva.toFixed(2));
	$("#nuevoIvac").val(sumaTotalIva.toFixed(2));
	$("#SubTotalc").val(sumaTotalPrecioF.toFixed(2));
	$("#nuevoTotalsitoc").val(sumaTotalPrecioF.toFixed(2));
	$("#totalCompra").val(sumaTotalPrecio);
	$("#nuevoTotalCompra").attr("total",sumaTotalPrecio);
}
$("#nuevoTotalCompra").number(true, 2);
$("#SubTotalc").number(true, 2);
$("#nuevoImpuestoCompras").number(true, 2);
function listarProductosc(){
	var listaProductos = [];
	var descripcion = $(".nuevaDescripcionProducto");
	var cantidad = $(".nuevaCantidadProductoc");
	var precio = $(".nuevoPrecioProducto");
	for(var i = 0; i < descripcion.length; i++){
		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precioc" : $(precio[i]).attr("precioReal"),
							  "precioconiva" : $(precio[i]).attr("precioconiva"),
							  "precio" : $(precio[i]).attr("precioc"),
							  "total" : $(precio[i]).attr("ivafinal"),
							  "iva" : $(precio[i]).attr("ivavalor"),
							  "subtotal" : $(precio[i]).val()})
	//console.log("listaProductos",listaProductos["id"]);
	}
	console.log("lista",listaProductos);
	$("#listaProductosc").val(JSON.stringify(listaProductos));
	return listaProductos; 
}
$(".formularioCompra").on("change", "input#nuevoCodigoTransaccion", function(){
	// Listar método en la entrada
     lista=listarMetodosc()
})
function listarMetodosc(){
	var listaMetodos = "";
	if($("#nuevoMetodoPagos").val() == "Efectivo"){
		$("#listaMetodoPagos").val("Efectivo");
	}else{
		$("#listaMetodoPagos").val("TC");
	}
}
$(".tablas").on("click", ".btnEliminarCompra", function(){
  var idVenta = $(this).attr("idCompra");
  var idAlmacen = $(this).attr("idAlmacen");
  swal({
        title: '¿Está seguro de borrar la compra?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?ruta=compras&idCompra="+idVenta+"&idAlmacen="+idAlmacen;
        }
  })
})
$(".formularioCompra").on("change", "input#nuevoValorEfectivo", function(){
	var efectivo = $(this).val();
	var cambio =  Number(efectivo) - Number($('#SubTotalc').val());
	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');
	nuevoCambioEfectivo.val(cambio.toFixed(2));
})
$(".tablas").on("click", ".btnImprimirCompra-carta", function(){
	var codigoVenta = $(this).attr("codigoCompra");
	var idAlmacen = $(this).attr("idAlmacen");
	window.open("extenciones/tcpdf/pdf/compra-carta.php?codigo="+codigoVenta+"&idAlmacen="+idAlmacen, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
