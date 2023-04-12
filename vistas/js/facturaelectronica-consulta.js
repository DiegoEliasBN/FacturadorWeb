if(localStorage.getItem("idCliente") != null){
	var idCliente=localStorage.getItem("idCliente");
	console.log(idCliente);
	$('.tablaFactura').DataTable({
	    "ajax": "ajax/datatable-facturaElectronica.ajax.php?idCliente="+idCliente,
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
}
$(".btnGenerarFacturaElectronicaPdf").click(function(){
	var idCliente = $("#cedula").val();
	var datos = new FormData();
    datos.append("cedula", idCliente);
    $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        //console.log("respuesta",respuesta);
        console.log(respuesta["id"]);
        if (respuesta!="") {
        	idCliente = respuesta["id"];
        	var datos = new FormData();
    		datos.append("idcliente", idCliente);
        	$.ajax({
		      url:"ajax/factura-electronica.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		      success:function(respuesta1){
		      	if (respuesta1!= "") {
		      		//console.log(respuesta1);
		      		localStorage.setItem("idCliente",idCliente);
		      		window.location = "f-electronicas?idCliente="+idCliente;
		      	}else{
		      		swal({
					  type: "error",
					  title: "No existen Facturas electronicas",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									$("#cedula").focus();
								}
						})
		      	}
		      	}
  			})
        }else{
        	swal({
					  type: "error",
					  title: "El cliente no esta registrado en el sistema o ingreso mal la cedula",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									$("#cedula").focus();
								}
						})
        }
      	/* $("#idCliente").val(respuesta["id"]);
	       $("#editarCliente").val(respuesta["nombre"]);
	       $("#editarDocumentoId").val(respuesta["documento"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
           $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);*/
	  }
  	})
		/*var idVenta = $(this).attr("idVenta");
		window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;*/
});
$(".tablaFactura tbody").on("click", "button.descargarXml", function(){
	var claveacceso=$(this).attr('codAcceso');
	window.location = "http://sistema.laternera-ec.com/?ruta=sri&xml="+claveacceso;
});
$(".tablaFactura tbody").on("click", "button.descargarPdf", function(){
	var claveacceso=$(this).attr('codAcceso');
	window.open ("http://sistema.laternera-ec.com/?ruta=sri&ride="+claveacceso,"_blank");
});
