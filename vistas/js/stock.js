var idAlmacenP=$("#almacenStock").val();
$('.tablaStock').DataTable({
    "ajax": "ajax/datatable-stock.ajax.php?nuevo="+idAlmacenP,
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
/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablaStock tbody").on("click", "button.editarStock", function(){
	var idProducto = $(this).attr("idProducto");
	var idAlmacen = $(this).attr("idAlmacen");
	var datos = new FormData();
    datos.append("idProducto", idProducto);
    datos.append("idAlmacen", idAlmacen);
     $.ajax({
      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      	//console.log("CodAlmacen",CodAlmacen);
      	var stockF = Number(respuesta[0]["CantidadIngreso"]-respuesta[0]["CantidadEgreso"]);
      	$("#editarCodigo").val(respuesta[0]["codigo"]);
        $("#idproducto").val(respuesta[0]["id"]);
        $("#editarDescripcion").val(respuesta[0]["descripcion"]);
        $("#editarIngreso").val(respuesta[0]["CantidadIngreso"]);
        $("#editarEgreso").val(respuesta[0]["CantidadEgreso"]);
        $("#CodAlmacen").val(respuesta[0]["CodAlmacen"]);
        $("#stock").val(stockF.toFixed(2));
      }
  })
})
$("#editarIngreso").change(function(){
 var ingreso = $("#editarIngreso").val();
 var egreso =$("#editarEgreso").val();
 ingreso=parseFloat(ingreso);
 egreso=parseFloat(egreso);
 if(ingreso < egreso){
	swal({
	  title: "La cantidad de Ingreso debe ser mayor a la de Egreso",
	  type: "error",
	  confirmButtonText: "¡Cerrar!"
	});
	return;
 }
 var stock= Number(ingreso- egreso);
 $("#stock").val(stock.toFixed(2));
})
