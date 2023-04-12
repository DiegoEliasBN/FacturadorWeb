/*==============================
=            fotito            =
==============================*/
$(".nuevaFoto").change(function(){
	var imagen = this.files[0];
	if (imagen["type"] !="image/jpeg" && imagen["type"] !="image/png" ) {
		$(".nuevaFoto").val("");
		swal({
			title:"error al subir la imagen",
			text:"la imagen debe estar en formato JPG o PNG",
			type:"error",
			confirmButtonText:"Cerrar"
		});
	}else if (imagen["size"]>6000000) {
		$(".nuevaFoto").val("");
		swal({
			title:"error al subir la imagen",
			text:"la imagen no debe pesar mas de 6MB",
			type:"error",
			confirmButtonText:"Cerrar"
		});
	}else {
		var datosImagen= new FileReader;
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load",function(event){
			var rutaImagen=event.target.result;
			$(".previsualizar").attr("src",rutaImagen);
			$(".previsualizarEditar").attr("src",rutaImagen);
		})
	}
})
/*=====  End of fotito  ======*/
/*==============================
=            usuario editar          =
==============================*/
$(document).on("click", ".btnEditarUsuario", function(){
	var idUsuario=$(this).attr("idUsuario");
	var datos=new FormData();
	datos.append("idUsuario",idUsuario);
	$.ajax({
		url:"ajax/usuario_ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta){
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#editarPerfil").html(respuesta["perfil"]);
			$("#passwordActual").val(respuesta["password"]);
			$("#fotoActual").val(respuesta["foto"]);
			if (respuesta["foto"]!="") {
				$(".previsualizarEditar").attr("src",respuesta["foto"]);
			}else{
				$(".previsualizarEditar").attr("src","vistas/img/usuarios/default/anonymous.png");
			}
		}
	});
})
$(document).on("click", ".btnActivar", function(){
	var idUsuario= $(this).attr("idUsuario");
	var estadoUsuario= $(this).attr("estadoUsuario");
	var datos= new FormData();
	datos.append("activarId",idUsuario);
	datos.append("activarUsuario",estadoUsuario);
	$.ajax({
		url:"ajax/usuario_ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		success: function(respuesta){
		}
	});
	if (estadoUsuario==0) {
		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('desactivado');
		$(this).attr('estadoUsuario',1);
	}else{
		$(this).addClass('btn-success');
		$(this).removeClass('btn-danger');
		$(this).html('activado');
		$(this).attr('estadoUsuario',0);
	}
})
$("#nuevoUsuario").change(function(){
	$(".alert").remove();
	var usuario=$(this).val();
	var datos =new FormData();
	datos.append("validarUsuario",usuario);
	$.ajax({
		url:"ajax/usuario_ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success: function(respuesta){
			if (respuesta) {
				$("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
	    		$("#nuevoUsuario").val("");
	    		$("#nuevoUsuario").focus();
			}
		}
	});
})
/*=============================================
ELIMINAR USUARIO
=============================================*/
$(document).on("click", ".btnEliminarUsuario", function(){
  var idUsuario = $(this).attr("idUsuario");
  var fotoUsuario = $(this).attr("fotoUsuario");
  var usuario = $(this).attr("usuario");
  swal({
    title: '¿Está seguro de borrar el usuario?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar usuario!'
  }).then(function(result){
    if(result.value){
      window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
    }
  })
})
