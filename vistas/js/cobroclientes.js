$(".btnGenerarFacturaDeuda").click(function(){
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
        if (respuesta!="") {
        	idVenta = respuesta["id"];
			window.location = "index.php?ruta=facturasdeuda&idCliente="+idVenta;
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
$(".btnGenerarDeuda").click(function(){
	var deuda=0;
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
        if (respuesta!="") {
        	idVenta = respuesta["id"];
        	var datos = new FormData();
		    datos.append("idCliente", idVenta);
		    $.ajax({
		      url:"ajax/cobroclientes.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		      success:function(respuesta1){
		      		 respuesta1.forEach(funcionForEachm);
			          function funcionForEachm(item, index){
			            deuda = Number(deuda)+Number(item.saldo);
			           }
			          	deuda=deuda.toFixed(2);
			        if (deuda>0) {
		        //console.log("respuesta",respuesta);
				         $("#id_cliente").val(idVenta);
				          $("#deuda").val(deuda);
				         $("#cobroClientes").html("");
				         $("#cobroClientes").append(
				              '<tr>'+
				                  '<td>Nombre del cliente:</td>'+
				                  '<td>'+respuesta["nombre"]+'</td>'+
				              '</tr>'+
				              '<tr class="text-center">'+
				                  '<td class="text-center">Deuda:</td>'+
				                  '<td>'+deuda+'</td>'+
				              '</tr>'+
				              '<tr>'+
				                  '<td>Monto a pagar:</td>'+
				                  '<td width="30%">'+
				                  '<div class="" style="padding-right:0px">'+
					            	'<div class="input-group">'+
					              	'<input type="number" id="montopago" step="any" min=0 name="valorCobro" class="form-control " required>'+
					            '</div>'+
					          '</div>'+
				                  '</td>'+
				              '</tr>'
		         			 )
		      			$("#montopago").focus();
		      		}else{
		      			swal({
					  type: "success",
					  title: "El cliente no cuenta con una deuda",
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
									 $("#cobroClientes").html("");
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