$(".btnGenerarDeudaF").click(function(){
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
		      	console.log('respuesta',respuesta1);
		      		 respuesta1.forEach(funcionForEachm);
			          function funcionForEachm(item, index){
			            deuda = Number(deuda)+Number(item.saldo);
			           }
			          	deuda=deuda.toFixed(2);
			        if (deuda>0) {
		        //console.log("respuesta",respuesta);
				         $("#id_cliente").val(idVenta);
				          $("#deuda").val(deuda);
				         $("#cobroClientesF").html("");
				         $("#cobroClientesF").append(
				              '<tr>'+
				                  '<td class="text-center" style="font-size: 20px">Nombre del cliente:</td>'+
				                  '<td  class="text-center" style="font-size: 20px">'+respuesta["nombre"]+'</td>'+
				              '</tr>'+
				              '<tr>'+
				                  '<td class="text-center" style="font-size: 20px">Deuda:</td>'+
				                  '<td  class="text-center text-danger" style="font-size: 28px">'+deuda+'</td>'+
				              '</tr>')
				         $("#detalleFactura").html("");
				          respuesta1.forEach(funcionForEachm);
				          /*function funcionForEachm(item, index){
				              $('#detalleFactura').append(
				                     '<tr>'+
				                       '<td style="width:10px">#'+parseFloat(index+1)+'</td>'+
				                       '<td><h1>'+item.codigo+'</h1></td>'+
				                       '<td>'+item.nombre+'</td>'+
				                       '<td>'+item.metodo_pago+'</td>'+
				                       '<td>'+item.total+'</td>'+
				                       '<td>'+item.saldo+'</td>'+
				                       '<td>'+item.fecha+'</td>'+
				                       '<td>Acciones</td>'+
				                     '</tr>'
				                   )
				           }
				       */
		      			$("#montopago").focus();
		      		}else{
		      			swal({
					  type: "success",
					  title: "El cliente "+respuesta['nombre']+ " no cuenta con una deuda",
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
									 $("#detalleFactura").html("");
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
$(".btnGenerarFacturaDeudaF").click(function(){
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
			window.location = "index.php?ruta=facturas-cliente&idCliente="+idVenta;
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
