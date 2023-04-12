/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarTurno", function(){
	var idTurno = $(this).attr("idTurno");
	console.log("idTurno",idTurno);
	var datos = new FormData();
	datos.append("idTurno", idTurno);
	$.ajax({
		url: "ajax/turno.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta",respuesta);
     		console.log("respuesta",respuesta);
     		$("#editarTurno").val(respuesta[0]["descripcion"]);
     		$("#eHoraInicio").val(respuesta[0]["hora_inicio"]);
     		$("#eHoraFin").val(respuesta[0]["hora_fin"]);
     		$("#idTurno").val(respuesta[0]["CodTurno"]);
     	}
	})
})
/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarTurno", function(){
	 var idTurno = $(this).attr("idTurno");
	 swal({
	 	title: '¿Está seguro de borrar El Turno?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar la Sucursal!'
	 }).then(function(result){
	 	if(result.value){
	 		window.location = "index.php?ruta=turnos&idTurno="+idTurno;
	 	}
	 })
})
