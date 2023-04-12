<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Usuarios de Las Sucursales
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Usuarios de Las Sucursales</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUAlmacen">Agregar Usuario Sucursal</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Sucursal</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $usuarios=ControladorUsuariosAlmacen::ctrMostrarUsuariosAlmacen($item,$valor);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["nombre"].'</td>
                                  <td>'.$value["usuario"].'</td>
                                  <td>'.$value["NombreAlmacen"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarUAlmacen btn btn-warning" idUAlmacen="'.$value["CodUsuarioAlmacen"].'" data-toggle="modal" data-target="#modalEditarUAlmacen"  ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarUAlmacen" idUAlmacen="'.$value["CodUsuarioAlmacen"].'"><i class="fa fa-times "></i></button>
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
<div id="modalAgregarUAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Usuario Sucursal</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="nuevoUsuario" class="form-control input-lg" required>
                  <option value="">Seleccione Un Usuario</option>
                  <?php
                    $item=null;
                    $valor=null;
                    $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodUsuario"].'">'.$value["nombre"].'</option>
                    ';
                  }
                   ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="nuevoAlmacen" class="form-control input-lg" required>
                  <option value="">Seleccione Una Sucursal</option>
                  <?php
                    $item=null;
                    $valor=null;
                    $usuarios=ControladorAlmacenes::ctrMostrarAlmacenes($item,$valor);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodAlmacen"].'">'.$value["NombreAlmacen"].'</option>
                    ';
                  }
                   ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Usuario Sucursal</button>
        </div>
        <?php
            $crearUAlmacen= new ControladorUsuariosAlmacen();
            $crearUAlmacen -> ctrCrearUAlmacen();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarUAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Usuario Sucursal</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="editarUsuario" class="form-control input-lg" >
                  <option value="" id="editarUsuario"></option>
                  <?php
                    $item=null;
                    $valor=null;
                    $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodUsuario"].'">'.$value["nombre"].'</option>
                    ';
                  }
                   ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="hidden"  name="idUAlmacen" id="idUAlmacen">
                <select name="editarAlmacen" class="form-control input-lg" >
                  <option value="" id="editarAlmacen"></option>
                  <?php
                    $item=null;
                    $valor=null;
                    $usuarios=ControladorAlmacenes::ctrMostrarAlmacenes($item,$valor);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodAlmacen"].'">'.$value["NombreAlmacen"].'</option>
                    ';
                  }
                   ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php
            $editarAlmacen= new ControladorUsuariosAlmacen();
            $editarAlmacen -> ctrEditarUAlmacen();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
  $borrarUAlmacen = new ControladorUsuariosAlmacen();
  $borrarUAlmacen -> ctrEliminarUAlmacen();
?> 