<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Usuarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Usuarios</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar Usuario</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%" >
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Usuarios</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Ultimo Login</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.$value["CodUsuario"].'</td>
                                  <td>'.$value["nombre"].'</td>
                                  <td>'.$value["usuario"].'</td>';
                                  if ($value["foto"] != "") {
                                        echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';
                                      }else{
                                        echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                                      }
                    echo '
                                  <td>'.$value["perfil"].'</td>';
                                  if ($value["estado"]!=0) {
                                    echo '<td>
                                            <button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["CodUsuario"].'" estadoUsuario="0">Activado</button>
                                          </td>';
                                  }else{
                                    echo '<td>
                                            <button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["CodUsuario"].'" estadoUsuario="1">Desactivado</button>
                                          </td>';
                                  }
                                  echo '<td>'.$value["UltimoLogin"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarUsuario btn btn-warning" idUsuario="'.$value["CodUsuario"].'" data-toggle="modal" data-target="#modalEditarUsuario"  ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["CodUsuario"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'"><i class="fa fa-times "></i></button>
                                      </div>
                                  </td>
                              </tr>
                    ';
                  }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
</div>
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoNombre"  placeholder="Ingresar Nombre" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar Usuario" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="nuevoPassword" placeholder="Ingresar contraseña" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="nuevoPerfil" class="form-control input-lg">
                  <option value="Administrador">
                    Administrador
                  </option>
                  <option value="Especial">
                    Especial
                  </option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class ="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso Max 200 MB</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </div>
        <?php
            $crearUsuario= new ControladorUsuarios();
            $crearUsuario -> ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="editarPassword" placeholder="Ingresar Nueva contraseña" >
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select class="form-control input-lg" name="editarPerfil">
                  <option value="" id="editarPerfil"></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class ="nuevaFoto" name="editarFoto">
              <p class="help-block">Peso Max 200 MB</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizarEditar" width="100px">
              <input type="hidden" name="fotoActual" id="fotoActual">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar Usuario</button>
        </div>
        <?php
            $editarUsuario= new ControladorUsuarios();
            $editarUsuario -> ctrEditarUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();
?> 