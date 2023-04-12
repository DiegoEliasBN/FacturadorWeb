$(document).on("click", ".btnEditarUTurno", function(){
	var idUTurno=$(this).attr("idUTurno");
	console.log("idUTurno",idUTurno);
	var datos=new FormData();
	datos.append("idUTurno",idUTurno);
	$.ajax({
		url:"ajax/uturno.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta){
			console.log("respuesta",respuesta);
			$("#editarUsuarioT").val(respuesta[0]["CodUsuario"]);
			$("#editarUsuarioT").html(respuesta[0]["nombre"]);
			$("#editarTurno").val(respuesta[0]["CodTurno"]);
			$("#editarTurno").html(respuesta[0]["descripcion"]);
			$("#idUTurno").val(respuesta[0]["id"]);
		}
	});
})
/*=============================================
ELIMINAR UALMACEN
=============================================*/
$(".tablas").on("click", ".btnEliminarUTurno", function(){
	 var idUTurno = $(this).attr("idUTurno");
	 swal({
	 	title: '¿Está seguro de borrar El Usuario De La Sucursal?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar la Sucursal!'
	 }).then(function(result){
	 	if(result.value){
	 		window.location = "index.php?ruta=usuarioturno&idUTurno="+idUTurno;
	 	}
	 })
})