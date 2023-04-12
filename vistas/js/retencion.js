var numDetalle = 0;
$(".btnAgregarDetalle").click(function(){
		numDetalle ++;
		var impuesto=$('#impuestos').val();
		//console.log("hola como estas");
		var datos = new FormData();
		datos.append("tipoimpuesto",impuesto);
		datos.append("campo","Tipo");
		$.ajax({
			url:"ajax/impuestos.ajax.php",
	      	method: "POST",
	      	data: datos,
	      	cache: false,
	      	contentType: false,
	      	processData: false,
	      	dataType:"json",
	      	success:function(respuesta){
	      		$('#ItemsDetalle').append('<div class="row">'+
	                    '<div class="form-group col-lg-2 col-xs-12 col-md-12">'+
	                      '<label for="">Impuesto</label>'+
	                      '<div class="input-group">'+
	                      	 '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarDetalle" idProducto><i class="fa fa-times"></i></button></span>'+
	                         '<select class="form-control impuestos" id="impuestos" name="seleccionarProveedor" required>'+
		                         '<option value="">------</option>'+
		                         '<option value="R">RENTA</option>'+
		                         '<option value="I">IVA</option>'+
	                          '</select>'+
	                      '</div>'+
	                    '</div>'+
	                    '<div class="form-group col-lg-5 col-xs-12 col-md-12">'+
	                      '<label for="">Renta</label>'+
	                      '<div class="input-group">'+
	                          '<select class="form-control seleccionarImpuesto" id="seleccionarImpuesto" name="seleccionarProveedor" required>'+
	                          '<option value="">---------------Seleccion el tipo de impuesto al que pertenece---------------</option>'+
	                          '</select>'+
	                      '</div>'+
	                    '</div>'+
	                    '<div class="form-group col-lg-1 col-xs-12 col-md-12">'+
	                      '<label for="">%Retencion</label>'+
	                      '<div class="input-group">'+
	                         '<input type="number" step="any" id="procentaje" name="fecha_inicio" class="form-control procentaje" required="" readonly="">'+
	                      '</div>'+
	                    '</div>'+
	                    '<div class="form-group col-lg-2 col-xs-12 col-md-12">'+
	                      '<label for="">Base imponible</label>'+
	                      '<div class="input-group">'+
	                         '<input type="number" step="any" id="baseImponible" name="fecha_inicio" class="form-control baseImponible" required="">'+
	                      '</div>'+
	                    '</div>'+
	                    '<div class="form-group col-lg-2 col-xs-12 col-md-12">'+
	                      '<label for="">Total</label>'+
	                      '<div class="input-group">'+
	                         '<input type="number" id="total" name="fecha_inicio" class="form-control total" required=""  readonly="">'+
	                      '</div>'+
	                    '</div>'+
	                  '</div>')
	      	}
	    })
	if (numDetalle == 2 || numDetalle > 2 ) {
		$('#boton').attr("disabled", true);
	}
	listarProducto()
});
$(".formularioRetencion").on("change", "select#impuestos", function(){
	var impuesto=$(this).val();
	var seleccionarImpuesto = $(this).parent().parent().parent().children().children().children("#seleccionarImpuesto");
	var procentaje = $(this).parent().parent().parent().children().children().children(".procentaje");
	var base= $(this).parent().parent().parent().children().children().children("#baseImponible");
	var totalx= $(this).parent().parent().parent().children().children().children("#total");
	//console.log("hola como estas");
	var datos = new FormData();
	datos.append("tipoimpuesto",impuesto);
	datos.append("campo","Tipo");
	$.ajax({
		url:"ajax/impuestos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		seleccionarImpuesto.html("");
	        seleccionarImpuesto.html('<option value="">---------------Seleccion el tipo de impuesto al que pertenece---------------</option>');
	         respuesta.forEach(funcionForEach);
	         function funcionForEach(item, index){
	         		seleccionarImpuesto.select2();
		         	seleccionarImpuesto.append(
						'<option value="'+item.ID+'">'+item.Nombre+'</option>'
		         	)
	         }
	        procentaje.val(respuesta[0].Porcetaje);
      		var retencion=procentaje.val();
			var baseImponible=base.val();
			if (retencion !="" && baseImponible!="") {
				var total= parseFloat(retencion)*parseFloat(baseImponible);
				var totalFinal= parseFloat(total)/100;
				totalx.val(totalFinal.toFixed(2));
			}
	         // SUMAR TOTAL DE PRECIOS
    		//sumarTotalPrecios()
    		// AGREGAR IMPUESTO
	       // agregarImpuesto()
	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
	        //$(".nuevoPrecioProducto").number(true, 2);
      	}
	})
	listarProducto()
});
$(".formularioRetencion").on("change", "select#seleccionarImpuesto", function(){
	var impuesto=$(this).val();
	var procentaje = $(this).parent().parent().parent().children().children().children(".procentaje");
	var base= $(this).parent().parent().parent().children().children().children("#baseImponible");
	var totalx= $(this).parent().parent().parent().children().children().children("#total");
	//console.log("hola como estas");
	var datos = new FormData();
	datos.append("tipoimpuesto",impuesto);
	datos.append("campo","ID");
	$.ajax({
		url:"ajax/impuestos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		console.log(respuesta);
      		procentaje.val(respuesta[0].Porcetaje);
      		var retencion=procentaje.val();
			var baseImponible=base.val();
			if (retencion !="" && baseImponible!="") {
				var total= parseFloat(retencion)*parseFloat(baseImponible);
				var totalFinal= parseFloat(total)/100;
				totalx.val(totalFinal.toFixed(2));
			}
      		//baseImponible();
	        // SUMAR TOTAL DE PRECIOS
    		//sumarTotalPrecios()
    		// AGREGAR IMPUESTO
	       // agregarImpuesto()
	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
	        //$(".nuevoPrecioProducto").number(true, 2);
      	}
	})
	listarProducto2()
});
$(".formularioRetencion").on("change", "input#baseImponible", function(){
	var procentaje = $(this).parent().parent().parent().children().children().children(".procentaje");
	var base= $(this).parent().parent().parent().children().children().children("#baseImponible");
	var totalx= $(this).parent().parent().parent().children().children().children("#total");
      		var retencion=procentaje.val();
			var baseImponible=base.val();
			if (retencion !="" && baseImponible!="") {
				var total= parseFloat(retencion)*parseFloat(baseImponible);
				var totalFinal= parseFloat(total)/100;
				totalx.val(totalFinal.toFixed(2));
			}
			listarProducto2()
});
/*=============================================
LISTAR EL DETALLE
=============================================*/
function listarProducto2(){
	var listaDetalle = [];
	var seleccionarImpuesto = $(".seleccionarImpuesto");
	var procentaje = $(".procentaje");
	var baseImponible = $(".baseImponible");
	var total = $(".total");
	for(var i = 0; i < seleccionarImpuesto.length; i++){
		listaDetalle.push({ "id_impuesto" : $(seleccionarImpuesto[i]).val(), 
							  "tazaretencion" : $(procentaje[i]).val(),
							  "baseimponible" : $(baseImponible[i]).val(),
							  "total" : $(total[i]).val()
							  })
	}
	console.log("listaDetalle",listaDetalle);
	$("#listaDetalle").val(JSON.stringify(listaDetalle));
}
/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
function quitarAgregarProducto(){
	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");
	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");
	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){
		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){
			if($(botonesTabla[j]).attr("idProducto") == boton){
				//$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				//$(botonesTabla[j]).addClass("btn-default");
			}
		}
	}
}
$(".tablas").on("click", ".btnAutorizarRetencion", function(){
var id=$(this).attr("idRetencion");
	window.open("http://sistema.laternera-ec.com/?ruta=sri&ride="+id, "_self");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
$(".tablas").on("click", ".btnImprimirRetencion", function(){
	var idRetencion = $(this).attr("idRetencion");
	var idAlmacen = $(this).attr("idAlmacen");
	window.open("extenciones/tcpdf/pdf/factura-retencion.php?codigo="+idRetencion+"&idAlmacen="+idAlmacen, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
$(".tablas").on("click", ".btnImprimirRetencionPDF", function(){
	var idRetencion=$(this).attr("idRetencion");
	console.log(idRetencion);
	window.open("https://facturador.systsolutions-ec.com/?ruta=sri&ride="+idRetencion, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
$(".tablas").on("click", ".btnImprimirRetencionXML", function(){
	var idRetencion=$(this).attr("idRetencion");
	console.log(idRetencion);
	window.open("https://facturador.systsolutions-ec.com/?ruta=sri&xml="+idRetencion, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
$('#daterangeR-btn').daterangepicker(
  {
    ranges   : {
      'HoyRetenciones'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment(),
    "cancelClass": "btn-danger"
  },
  function (start, end) {
    $('#daterangeR-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    var fechaInicial = start.format('YYYY-MM-DD');
    var fechaFinal = end.format('YYYY-MM-DD');
    var capturarRango = $("#daterangeR-btn span").html();
   	localStorage.setItem("capturarRangoR", capturarRango);
   	window.location = "index.php?ruta=retencion&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  }
)
$(".daterangepicker.opensleft .range_inputs .btn-danger").on("click", function(){
	localStorage.removeItem("capturarRangoR");
	localStorage.clear();
	window.location = "retencion";
})
$(".daterangepicker.opensleft .ranges li[data-range-key=HoyRetenciones]").on("click", function(){
	var textoHoy = $(this).attr("data-range-key");
	if(textoHoy == "HoyRetenciones"){
		var d = new Date();
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();
		dia = ("0"+dia).slice(-2);
		mes = ("0"+mes).slice(-2);
		var fechaInicial = año+"-"+mes+"-"+dia;
		var fechaFinal = año+"-"+mes+"-"+dia;	
    	localStorage.setItem("capturarRangoR", "Hoy");
    	window.location = "index.php?ruta=retencion&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
	}
})
