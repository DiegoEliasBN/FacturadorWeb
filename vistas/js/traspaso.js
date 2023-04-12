var lista=[];
var idAlmacenP=$("#inicio").val();
$('.tablaTraspasos').DataTable({
    "ajax": "ajax/datatable-ventas.ajax.php?nuevo="+idAlmacenP,
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
$(".tablaTraspasos tbody").on("click", "button.agregarProducto", function(){
	var jose=parseFloat(1.226);
	var manuel=Math.ceil(jose * 100)/100;
	//console.log(manuel);
	//console.log("presionaste el bton");
	var c=0;
	var idProducto = $(this).attr("idProducto");
	var idAlmacen = $(this).attr("idAlmacen");
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
		     	url:"ajax/productos.ajax.php",
		      	method: "POST",
		      	data: datos,
		      	cache: false,
		      	contentType: false,
		      	processData: false,
		      	dataType:"json",
		      	success:function(respuesta){
		      		var ivavalor=0;
		      		var ivafinal=0;
		      		var descripcion = respuesta[0]["descripcion"];
		          	var stock = parseFloat(respuesta[0]["CantidadEgreso"])+parseFloat(1);
		          	var stockn =respuesta[0]["CantidadEgreso"];
		          	var precioconiva = respuesta[0]["precio_venta"];
		          	var precio = respuesta[0]["precio_siniva"];
		          	var precioc= respuesta[0]["precio_compra"];
		          	var CodAlmacen = respuesta[0]["CodAlmacen"];
		          	var ivasi=respuesta[0]["iva_producto"];
		          	//console.log("CodAlmacen",CodAlmacen);
		          	var stockF = Number(respuesta[0]["CantidadIngreso"]-respuesta[0]["CantidadEgreso"]);
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
			        '<td width="30%">'+
			          '<div class="" style="padding-right:0px">'+
			            '<div class="input-group">'+
			              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
			              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
			            '</div>'+
			          '</div>'+
			        '</td>'+ 		
			          '<!-- Cantidad del producto -->'+
			        '<td width="8%">'+
			          '<div  class="">'+
			             '<input type="number" class="form-control nuevaCantidadProductot" step="any" id="'+idProducto+'" name="nuevaCantidadProducto" min="0" value="" stock1="'+stockF+'" stock="'+stockn+'" CodAlmacen="'+CodAlmacen+'" nuevoStock="'+stock+'" required>'+
			          '</div>' +
			        '</td>'+
			           '</tbody>') 
			        // SUMAR TOTAL DE PRECIOS
			        // AGREGAR IMPUESTO
			        //agregarImpuesto()
			        // AGRUPAR PRODUCTOS EN FORMATO JSON
			        $("#"+idProducto).val('');
			        $("#"+idProducto).focus();
			       lista= listarProductos();
			        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
		      	}
		     })
	}else{
		lista= listarProductost();
	}
});
/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioTraspaso").on("change", "input.nuevaCantidadProductot", function(){
	if(Number($(this).val()) > Number($(this).attr("stock1"))){
		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/
		$(this).val(1);
		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock1")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });
	    return;
	}
	// SUMAR TOTAL DE PRECIOS
	// AGREGAR IMPUESTO
    //agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    lista=listarProductost();
})
function listarProductost(){
	var listaProductos = [];
	var descripcion = $(".nuevaDescripcionProducto");
	var cantidad = $(".nuevaCantidadProductot");
	for(var i = 0; i < descripcion.length; i++){
		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "CodAlmacen" : $(cantidad[i]).attr("CodAlmacen")})
	//console.log("listaProductos",listaProductos);
	}
	$("#listaProductosT").val(JSON.stringify(listaProductos));
	return listaProductos; 
}
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioTraspaso").on("click", "button.quitarProducto", function(){
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
		lista=listarProductost();
	}else{
		// SUMAR TOTAL DE PRECIOS
    	//sumarTotalPrecios()
    	// AGREGAR IMPUESTO
        //agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        lista=listarProductost();
	}
})
$(".tablas").on("click", ".btnEliminarTraspaso", function(){
  var idVenta = $(this).attr("idTraspaso");
  var idAlmacen = $(this).attr("idAlmacen");
  swal({
        title: '¿Está seguro de borrar el Traspaso?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar el traspaso!'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?ruta=traspasos&idTraspaso="+idVenta+"&idAlmacen="+idAlmacen;
        }
  })
})
var numProducto = 0;
$(".btnAgregarProductoT").click(function(){
	var idAlmacen = $(this).val();
	numProducto ++;
	var datos = new FormData();
	datos.append("traerProductos", "ok");
	datos.append("idAlmacen",idAlmacen);
	$.ajax({
		url:"ajax/productos.ajax.php",
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
			             '<input type="number" class="form-control nuevaCantidadProductot" step="any"  id="cantidad'+numProducto+'" name="nuevaCantidadProducto" min="0" value="" stock1 stock="" CodAlmacen="" nuevoStock="" required>'+
			          '</div>' +
			        '</td>'+
			        '<!-- precio -->'+
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
    		//sumarTotalPrecios()
    		// AGREGAR IMPUESTO
	       // agregarImpuesto()
	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
	        //$(".nuevoPrecioProducto").number(true, 2);
      	}
	})
})
/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioTraspaso").on("change", "select.nuevaDescripcionProducto", function(){
	//console.log("hola entraste a cambiar la cantidad");
	var idAlmacen=$(this).attr("CodAlmacen");
	//console.log("idAlmacen",idAlmacen);
	var nombreProducto = $(this).val();
	//console.log("nombreProducto",nombreProducto);
	var nuevaDescripcionProducto = $(this).parent().parent().parent().parent().children().children().children().children(".nuevaDescripcionProducto");
	var nuevoPrecioProducto = $(this).parent().parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var todo = $(this).parent().parent().parent().parent().children().children().children(".preciotodo");
	var nuevaCantidadProducto = $(this).parent().parent().parent().parent().children().children(".ingresoCantidad").children(".nuevaCantidadProductot");
	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);
    datos.append("idAlmacen", idAlmacen);
	  $.ajax({
     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		//console.log("respuesta",respuesta["CantidadIngreso"]);
      		//console.log("respuesta",respuesta["CantidadEgreso"]);
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
	        lista=listarProductost();
	        //sumarTotalPrecios()
	       //$("#cantidad"+numProducto).val(1);
	       //$("#cantidad"+numProducto).focus();
      	}
      })
})
$(".tablas").on("click", ".btnImprimirTraspaso-carta", function(){
	var codigoVenta = $(this).attr("codigoTraspaso");
	var idAlmacen = $(this).attr("idAlmacen");
	window.open("extenciones/tcpdf/pdf/traspaso-carta.php?codigo="+codigoVenta+"&idAlmacen="+idAlmacen, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
