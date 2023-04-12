$("#idUsuarioTurno").change(function(){
	$(".alert").remove();
	var usuario=$(this).val();
	console.log("usuario",usuario);
	var datos =new FormData();
	datos.append("validarUsuario",usuario);
	$.ajax({
		url:"ajax/acaja.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta){
			if (respuesta!="") {
				$("#idUsuarioTurno").parent().after('<div class="alert alert-warning">Ya existe una caja abierta para este usuario</div>');
	    		$("#idUsuarioTurno").val("");
			}
		}
	});
})
/*=============================================
ELIMINAR UALMACEN
=============================================*/
$("#idTurnoA").change(function(){
	var idTurno = $(this).val();
	//console.log("idTurno",idTurno);
	var datos = new FormData();
	datos.append("idTurno",idTurno);
	$.ajax({
		url:"ajax/acaja.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		//console.log("respuesta",respuesta);
      		$("#idUsuarioTurno").html("");
      		$("#idUsuarioTurno").append(
						'<option  value="">Seleccione el Usuario</option>'
		         	)
      		respuesta.forEach(funcionForEach);
	         function funcionForEach(item, index){
		         	$("#idUsuarioTurno").append(
						'<option  value="'+item.id+'">'+item.nombre+'</option>'
		         	)
	         }
      	}
    });
});