<?php
class ControladorUsuarios
{
    public static function ctrIngresoUsuario()
    {
        if (isset($_POST["ingUsuario"])) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {
                $encriptar  = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');
                $tabla      = "usuario";
                $item       = "usuario";
                $valor      = $_POST["ingUsuario"];
                $respuesta  = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                $tabla1     = "usuarioalmacen";
                $item1      = "CodUsuario";
                $valor1     = $respuesta["CodUsuario"];
                $respuesta1 = ModeloUAlmacen::mdlMostrarUAlmacenes($tabla1, $item1, $valor1);
                $i          = 0;
                foreach ($respuesta1 as $key => $value) {
                    $i = $i + 1;
                }
                if ($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar) {
                    if ($respuesta["estado"] == 1) {
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id"]            = $respuesta["CodUsuario"];
                        $_SESSION["nombre"]        = $respuesta["nombre"];
                        $_SESSION["usuario"]       = $respuesta["usuario"];
                        $_SESSION["foto"]          = $respuesta["foto"];
                        $_SESSION["perfil"]        = $respuesta["perfil"];
                        date_default_timezone_set('America/Guayaquil');
                        $fecha       = date('Y-m-d');
                        $hora        = date('H:i:s');
                        $fechaActual = $fecha . ' ' . $hora;
                        $item1  = "UltimoLogin";
                        $valor1 = $fechaActual;
                        $item2  = "CodUsuario";
                        $valor2 = $respuesta["CodUsuario"];
                        $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
                        if ($ultimoLogin == "ok") {
                            if ($i > 1) {
                                $_SESSION["valorAlmacen"] = $respuesta1;
                                echo '<script>
									window.location ="nalmacen";
								  </script>';
                            } elseif ($i = 1) {
                                $_SESSION["almacenes"]  = $respuesta1;
                                $_SESSION["CodAlmacen"] = $respuesta1[0]["CodAlmacen"];
                                echo '<script>
										window.location ="inicio";
							 		  </script>';
                            } else {
                                echo '<br><div class="alert alert-danger btnActivar">El usuario no esta asignado a una Sucursal</div>';
                            }
                        }
                    } else {
                        echo '<br><div class="alert alert-danger btnActivar">El usuario no esta activado </div>';
                    }
                } else {
                    echo '<br><div class="alert alert-danger btnActivar">Usuario o Contraseña INCORRECTA</div>';
                }
            }
        }
    }
    public static function ctrCrearUsuario()
    {
        if (isset($_POST["nuevoUsuario"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])) {
                $ruta = "";
                if (!empty($filename_temp)) {
                    list($ancho, $alto, $type, $attr)=getimagesize($filename_temp);
					//list($ancho,$alto)=getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    $nuevoAncho         = 200;
                    $nuevoAlto          = 200;
                    $directorio = "vistas/img/usuarios/" . $_POST["nuevoUsuario"];
                    mkdir($directorio, 0755);
                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {
                        $aleatorio = mt_rand(100, 9999);
                        $ruta      = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/" . $aleatorio . ".jpg";
                        $origen    = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino   = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if ($_FILES["nuevaFoto"]["type"] == "image/png") {
                        $aleatorio = mt_rand(100, 9999);
                        $ruta      = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/" . $aleatorio . ".png";
                        $origen    = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino   = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "usuario";
                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$usesomesillystringforsalt$');
                $datos     = array("nombre" => $_POST["nuevoNombre"],
                    "usuario"                   => $_POST["nuevoUsuario"],
                    "password"                  => $encriptar,
                    "perfil"                    => $_POST["nuevoPerfil"],
                    "foto"                      => $ruta);
                $respuesta = ModeloUsuarios::MDLIngresarUsuario($tabla, $datos);
                if ($respuesta == "ok") {
                    echo '<script>
					swal({
						type:"success",
						title: "Usuario creado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							window.location="usuarios";
						}
					});
				</script>';
                }
            } else {
                echo '<script>
					swal({
						type:"error",
						title: "El usuario no puede ir vacio ni llevar caracteres especiales",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							window.location="usuarios";
						}
					});
				</script>';
            }
        }
    }
    public static function ctrMostrarUsuarios($item, $valor)
    {
        $tabla     = "usuario";
        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrEditarUsuario()
    {
        if (isset($_POST["editarUsuario"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {
                /*=============================================
                VALIDAR IMAGEN
                =============================================*/
                $ruta = $_POST["fotoActual"];
                echo "hola";
                print_r($ruta);
                var_dump($ruta);
                if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {
                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto  = 500;
                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/
                    $directorio = "vistas/img/usuarios/" . $_POST["editarUsuario"];
                    /*=============================================
                    PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                    =============================================*/
                    if (!empty($_POST["fotoActual"])) {
                        unlink($_POST["fotoActual"]);
                    } else {
                        mkdir($directorio, 0755);
                    }
                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/
                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if ($_FILES["editarFoto"]["type"] == "image/png") {
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".png";
                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "usuario";
                if ($_POST["editarPassword"] != "") {
                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {
                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');
                    } else {
                        echo '<script>
								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {
										window.location = "usuarios";
										}
									})
						  	</script>';
                        return;
                    }
                } else {
                    $encriptar = $_POST["passwordActual"];
                }
                $datos = array("nombre" => $_POST["editarNombre"],
                    "usuario"               => $_POST["editarUsuario"],
                    "password"              => $encriptar,
                    "perfil"                => $_POST["editarPerfil"],
                    "foto"                  => $ruta);
                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
                if ($respuesta == "ok") {
                    echo '<script>
					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "usuarios";
									}
								})
					</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "usuarios";
							}
						})
			  	</script>';
            }
        }
    }
    /*=============================================
    BORRAR USUARIO
    =============================================*/
    public static function ctrBorrarUsuario()
    {
        if (isset($_GET["idUsuario"])) {
            $tabla = "usuario";
            $datos = $_GET["idUsuario"];
            if ($_GET["fotoUsuario"] != "") {
                unlink($_GET["fotoUsuario"]);
                rmdir('vistas/img/usuarios/' . $_GET["usuario"]);
            }
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if ($respuesta == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "usuarios";
								}
							})
				</script>';
            }
        }
    }
}
