$(document).on("click", ".btnEditarUAlmacen", function(){
	var idUAlmacen=$(this).attr("idUAlmacen");
	var datos=new FormData();
	datos.append("idUAlmacen",idUAlmacen);
	$.ajax({
		url:"ajax/ualmacen_ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta){
			$("#editarUsuario").val(respuesta["CodUsuario"]);
			$("#editarUsuario").html(respuesta["nombre"]);
			$("#editarAlmacen").val(respuesta["CodAlmacen"]);
			$("#editarAlmacen").html(respuesta["NombreAlmacen"]);
			$("#idUAlmacen").val(respuesta["CodUsuarioAlmacen"]);
		}
	});
})
/*=============================================
ELIMINAR UALMACEN
=============================================*/
$(".tablas").on("click", ".btnEliminarUAlmacen", function(){
	 var idUAlmacen = $(this).attr("idUAlmacen");
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
	 		window.location = "index.php?ruta=Usuarioalmacen&idUAlmacen="+idUAlmacen;
	 	}
	 })
})