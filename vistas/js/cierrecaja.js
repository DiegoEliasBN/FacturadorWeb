$(".btnGenerarCierre").click(function(){
   var idApertura=$("#CodApetura").val();
   console.log("idApertura",idApertura);
   var datos = new FormData();
   datos.append("idApertura", idApertura);
   $.ajax({
		    url: "ajax/ccaja.ajax.php",
		    method: "POST",
      	data: datos,
      	cache: false,
     	  contentType: false,
     	  processData: false,
     	  dataType:"json",
     	  success: function(respuesta){
     		 console.log("respuesta",respuesta);
         var tipodocumento=respuesta["facturae"]["tipodocumento"];
         var totalfp=respuesta["facturae"]["Total"];
         totalfp=totalfp.toFixed(2);
         var tipodocumentoc=respuesta["facturac"]["tipodocumento"];
         var totalfpc=respuesta["facturac"]["Total"];
         totalfpc=totalfpc.toFixed(2);
         var tipodocumentoa=respuesta["apertura"]["tipodocumento"];
         var totala=respuesta["apertura"]["Total"];
         totala=(Number(totala)).toFixed(2);
         var tipodocumentom=respuesta["movimiento"]["tipodocumento"];
         var totalm=respuesta["movimiento"]["Total"];
         var totaltc=respuesta["facturatc"]["Total"];
         var totaltd=respuesta["facturatd"]["Total"];
         totaltc=totaltc.toFixed(2);
         totaltd=totaltd.toFixed(2);
         totalm=totalm.toFixed(2);
        //var total =Number(totalfp);
         var total=Number(totalfp)-Number(totalfpc)-Number(totalm)-Number(totaltc)-Number(totaltd);
         var totalconsolidado=Number(totalfp)+Number(totalfpc)+Number(totaltc)+Number(totaltd);
         total=total.toFixed(2);
         totalconsolidado=totalconsolidado.toFixed(2);
         $("#CodAperturag").val(idApertura);
         $("#ValorCierreg").val(total);
         $("#facturapagadag").val(totalfp);
         $("#facturafiadag").val(totalfpc);
         $("#facturapagadatc").val(totaltc);
         $("#facturapagadatd").val(totaltd);
          $("#totalConsolidado").val(totalconsolidado);
         //$("#aperturacajag").val(totala);
         //$("#facturapagadagn").val(tipodocumento);
         //$("#facturafiadagn").val(tipodocumentoc);
         //$("#aperturacajagn").val(tipodocumentoa);
         $("#movimiento").val(totalm);
         //$("#movimienton").val(tipodocumentom);
         $("#tblcierre").html("");
          $("#tblcierre").append(
              '<tr>'+
                  '<td class="facturaPagada" CodMovimiento="1"  descripcionMovimiento="Todas" tipodocumento="'+tipodocumento+'"  valorMovimiento="'+totalfp+'">'+tipodocumento+'</td>'+
                  '<td>Todas</td>'+
                  '<td>'+totalfp+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td class="apertura" CodMovimiento="'+idApertura+'"  descripcionMovimiento="Inicio" tipodocumento="'+tipodocumentoa+'"  valorMovimiento="'+totala+'">'+tipodocumentoa+'</td>'+
                  '<td>Inicio</td>'+
                  '<td>'+totala+'</td>'+
              '</tr>')
         respuesta["facturac"]["Todo"].forEach(funcionForEach);
           function funcionForEach(item, index){
            $("#tblcierre").append(
              '<tr>'+
                  '<td class="facturaFiada" CodMovimiento="'+item.id+'"  descripcionMovimiento="'+item.nombre+'" tipodocumento="'+tipodocumentoc+'"  valorMovimiento="'+item.total+'">'+tipodocumentoc+'</td>'+
                  '<td>'+item.nombre+'</td>'+
                  '<td>'+item.total+'</td>'+
              '</tr>'
          )
           }
           respuesta["movimiento"]["Todo"].forEach(funcionForEachm);
           function funcionForEachm(item, index){
            $("#tblcierre").append(
              '<tr>'+
                  '<td class="movimiento" CodMovimiento="'+item.CodMovimiento+'"  descripcionMovimiento="'+item.descripcionMovimiento+'" tipodocumento="'+tipodocumentom+'"  valorMovimiento="'+item.valorMovimiento+'">'+tipodocumentom+'</td>'+
                  '<td >'+item.descripcionMovimiento+'</td>'+
                  '<td>'+item.valorMovimiento+'</td>'+
              '</tr>'
          )
           }
         /*$("#tblcierre").html("");
         $("#tblcierre").append(
              '<tr>'+
                  '<td>'+tipodocumento+'</td>'+
                  '<td>'+totalfp+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>'+tipodocumentoc+'</td>'+
                  '<td>'+totalfpc+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>'+tipodocumentoa+'</td>'+
                  '<td>'+totala+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>'+tipodocumentom+'</td>'+
                  '<td>'+totalm+'</td>'+
              '</tr>'
          )*/
         $("#tbltotalcierre").html("");
         $("#tbltotalcierre").append(
            '<tr>'+
                  '<td>Total Facturas Pagadas</td>'+
                  '<td>'+totalfp+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>Total Facturas Fiadas</td>'+
                  '<td>'+totalfpc+'</td>'+
              '</tr>'+
               '<tr>'+
                  '<td>Total Facturas pagadas con tarjeta de credito</td>'+
                  '<td>'+totaltc+'</td>'+
              '</tr>'+
               '<tr>'+
                  '<td>Total Facturas Pagadas con tarjeta de debito</td>'+
                  '<td>'+totaltd+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>Total movimientos</td>'+
                  '<td>'+totalm+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>Total Cierre</td>'+
                  '<td>'+total+'</td>'+
              '</tr>'+
              '<tr>'+
                  '<td>Total consolidado de las facturas</td>'+
                  '<td>'+totalconsolidado+'</td>'+
              '</tr>'
          )
         listarIdFacturaFiada();
     	}
	})
});
$("#btncierrecaja").click(function(){
  window.location="cierredecajaf";
})
$("#btncancelarcaja").click(function(){
  window.location="cierrecaja";
})
$(".tablas").on("click", ".btnImprimirCierre", function(){
  var codigoVenta = $(this).attr("codigoCierre");
  var idAlmacen = $(this).attr("idAlmacen");
  window.open("extenciones/tcpdf/pdf/cierre.php?codigo="+codigoVenta+"&idAlmacen="+idAlmacen, "_blank");
})
function listarIdFacturaFiada(){
  var listaId = [];
  var descripcion = $(".movimiento");
  var facturaFiada = $(".facturaFiada");
  var facturaPagada = $(".facturaPagada");
  var apertura = $(".apertura");
  for(var i = 0; i < descripcion.length; i++){
    listaId.push({ "CodDocumento" : $(descripcion[i]).attr("CodMovimiento"), 
                "tipodocumento" : $(descripcion[i]).attr("tipodocumento"),
                "descripcion_cliente" : $(descripcion[i]).attr("descripcionMovimiento"),
                "valorcadauno" : $(descripcion[i]).attr("valorMovimiento")
                })
  }
   for(var i = 0; i < facturaFiada.length; i++){
    listaId.push({ "CodDocumento" : $(facturaFiada[i]).attr("CodMovimiento"), 
                "tipodocumento" : $(facturaFiada[i]).attr("tipodocumento"),
                "descripcion_cliente" : $(facturaFiada[i]).attr("descripcionMovimiento"),
                "valorcadauno" : $(facturaFiada[i]).attr("valorMovimiento")
                })
  }
   listaId.push({ "CodDocumento" : $(facturaPagada).attr("CodMovimiento"), 
                "tipodocumento" : $(facturaPagada).attr("tipodocumento"),
                "descripcion_cliente" : $(facturaPagada).attr("descripcionMovimiento"),
                "valorcadauno" : $(facturaPagada).attr("valorMovimiento")
                })
   listaId.push({ "CodDocumento" : $(apertura).attr("CodMovimiento"), 
                "tipodocumento" : $(apertura).attr("tipodocumento"),
                "descripcion_cliente" : $(apertura).attr("descripcionMovimiento"),
                "valorcadauno" : $(apertura).attr("valorMovimiento")
                })
  $("#movimienton").val(JSON.stringify(listaId));
  console.log("lista",listaId);
}
/*function listarIdMovimiento(){
  var listaId = [];
  var descripcion = $(".nuevaDescripcionProducto");
  var cantidad = $(".nuevaCantidadProducto");
  var precio = $(".nuevoPrecioProducto");
  for(var i = 0; i < descripcion.length; i++){
    listaId.push({ "id" : $(descripcion[i]).attr("idProducto"), 
                "descripcion" : $(descripcion[i]).val(),
                "cantidad" : $(cantidad[i]).val(),
                "stock" : $(cantidad[i]).attr("nuevoStock"),
                "precio" : $(precio[i]).attr("precioReal"),
                "precioconiva" : $(precio[i]).attr("precioconiva"),
                "precioc" : $(precio[i]).attr("precioc"),
                "CodAlmacen" : $(cantidad[i]).attr("CodAlmacen"),
                "total" : $(precio[i]).val()})
  console.log("listaProductos",listaId);
  }
  $("#listaProductos").val(JSON.stringify(listaId));
  //return listaProductos; 
}*/