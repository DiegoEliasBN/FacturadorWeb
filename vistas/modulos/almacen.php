<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Sucursales
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Sucursales</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarAlmacen">Agregar Sucursal</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>RUC</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $usuarios=ControladorAlmacenes::ctrMostrarAlmacenes($item,$valor);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["NombreAlmacen"].'</td>
                                  <td>'.$value["DireccionAlmacen"].'</td>
                                  <td>'.$value["telefono"].'</td>
                                  <td>'.$value["email"].'</td>
                                  <td>'.$value["ruc"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarAlmacen btn btn-warning" idAlmacen="'.$value["CodAlmacen"].'" data-toggle="modal" data-target="#modalEditarAlmacen"  ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarAlmacen" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-times "></i></button>
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
<div id="modalAgregarAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Sucursal</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-file-alt"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoRuc" placeholder="Ingresar RUC" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-building"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoAlmacen"  placeholder="Ingresar Nombre De La Sucursal" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoDireccion" id="nuevoDireccion" placeholder="Ingresar direccion De La Sucursal" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-mobile-alt"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar Telefono" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                <input type="Email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar Email" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
        </div>
        <?php
            $crearAlmacen= new ControladorAlmacenes();
            $crearAlmacen -> ctrCrearAlmacen();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Sucursal</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control input-lg" name="editarRuc" id="editarRuc"  required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="editarAlmacen" id="editarAlmacen" required>
                <input type="hidden"  name="idAlmacen" id="idAlmacen" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion"  required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono"  required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="Email" class="form-control input-lg" name="editarEmail" id="editarEmail" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
        </div>
        <?php
            $crearUsuario= new ControladorAlmacenes();
            $crearUsuario -> ctrEditarAlmacen();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
  $borrarAlmacen = new ControladorAlmacenes();
  $borrarAlmacen -> ctrBorrarAlmacen();
?> 