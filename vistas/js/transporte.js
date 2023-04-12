/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarTransporte", function(){
  var idTransporte = $(this).attr("idTransporte");
  //console.log(idTransporte);
	var datos = new FormData();
    datos.append("idTransporte", idTransporte);
    $.ajax({
      url:"ajax/transporte.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
       // console.log("respuesta",respuesta);
      	 $("#idTransporte").val(respuesta["id"]);
	       $("#editarTransporte").val(respuesta["nombre_chofer"]);
	       $("#editarLicencia").val(respuesta["identificacion_chofer"]);
	       $("#editarPlaca").val(respuesta["placa_vehiculo"]);
	  }
  	})
})
/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarTransporte", function(){
	var idTransporte = $(this).attr("idTransporte");
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Transporte!'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?ruta=transporte&idTransporte="+idTransporte;
        }
  })
})