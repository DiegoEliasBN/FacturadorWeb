$('.tablaClientes').DataTable( {
  "ajax": "ajax/datatable-clientes.ajax.php?idperfiloculto="+idOculto,
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
} );
/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablaClientes").on("click", ".btnEditarCliente", function(){
	var idCliente = $(this).attr("idCliente");
  var tipo;
	var datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){      
      	 $("#idCliente").val(respuesta["id"]);
	       $("#editarCliente").val(respuesta["nombre"]);
	       $("#editarDocumentoId").val(respuesta["documento"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
         $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
         $("#tipo_documento").val(respuesta["tipo_documento"]);
         switch (respuesta["tipo_documento"]) {
            case "04":
              tipo = "RUC";
              break;
            case "05":
              tipo = "CEDULA";
              break;
            case "06":
               tipo = "PASAPORTE";
              break;
            case "07":
              tipo = "COSUMIDOR FINAL";
              break;
            case "08":
              tipo = "IDENTIFICACION DEL EXTERIOR";
              break;
          }
           $("#tipo_documento > option[value='"+respuesta["tipo_documento"]+"']").attr("selected",true);
        }
  	})
})
$(".btnEditarCliente").on("click", function(){
  var idCliente = $(this).attr("idCliente");
  var datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){      
         $("#idCliente").val(respuesta["id"]);
         $("#editarCliente").val(respuesta["nombre"]);
         $("#editarDocumentoId").val(respuesta["documento"]);
         $("#editarEmail").val(respuesta["email"]);
         $("#editarTelefono").val(respuesta["telefono"]);
         $("#editarDireccion").val(respuesta["direccion"]);
         $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
         switch (respuesta["tipo_documento"]) {
            case "04":
              tipo = "RUC";
              break;
            case "05":
              tipo = "CEDULA";
              break;
            case "06":
               tipo = "PASAPORTE";
              break;
            case "07":
              tipo = "COSUMIDOR FINAL";
              break;
            case "08":
              tipo = "IDENTIFICACION DEL EXTERIOR";
              break;
          }
           $("#edita_tipo_documento > option[value='"+respuesta["tipo_documento"]+"']").attr("selected",true);
    }
    })
})
/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablaClientes").on("click", ".btnEliminarCliente", function(){
	var idCliente = $(this).attr("idCliente");
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }
  })
})