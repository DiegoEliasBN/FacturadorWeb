<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Usuarios Turno
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Usuarios Turnos</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUTurno">Agregar Usuario Turno</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Turno</th>
                <th>Sucursal</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $item2="CodAlmacen";
                  $valor2=$_SESSION["CodAlmacen"];
                  $usuarios=ControladorUsuariosTurno::ctrMostrarUsuariosTurno($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["nombre"].'</td>
                                  <td>'.$value["usuario"].'</td>
                                  <td>'.$value["descripcion"].'</td>
                                  <td>'.$value["NombreAlmacen"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarUTurno btn btn-warning" idUTurno="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUTurno"  ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarUTurno" idUTurno="'.$value["id"].'"><i class="fa fa-times "></i></button>
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
<div id="modalAgregarUTurno" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Usuario Turno</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="nuevoUsuario" class="form-control input-lg" required>
                  <option value="">Seleccione Un Usuario</option>
                  <?php
                    $item="CodAlmacen";
                    $valor=$_SESSION["CodAlmacen"];
                    $usuarios=ControladorUsuariosAlmacen::ctrMostrarUsuariosAlmacen1($item,$valor);
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
                <input type="hidden"  name="CodAlmacen" id="CodAlmacen" value="<?php echo $_SESSION["CodAlmacen"]; ?>" required>
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="nuevoTurno" class="form-control input-lg" required>
                  <option value="">Seleccione Una Sucursal</option>
                  <?php
                    $item=null;
                    $valor=null;
                    $item2="CodAlmacen";
                    $valor2=$_SESSION["CodAlmacen"];
                    $usuarios=ControladorTurnos::ctrMostrarTurnos2($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodTurno"].'">'.$value["descripcion"].'</option>
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
            $crearUAlmacen= new ControladorUsuariosTurno();
            $crearUAlmacen -> ctrCrearUTurno();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarUTurno" class="modal fade" role="dialog">
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
                <select name="editarUsuarioT" class="form-control input-lg" >
                  <option value="" id="editarUsuarioT"></option>
                  <?php
                    $item="CodAlmacen";
                    $valor=$_SESSION["CodAlmacen"];
                    $usuarios=ControladorUsuariosAlmacen::ctrMostrarUsuariosAlmacen1($item,$valor);
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
                <input type="hidden"  name="idUTurno" id="idUTurno">
                <select name="editarTurno" class="form-control input-lg" >
                  <option value="" id="editarTurno"></option>
                  <?php
                    $item=null;
                    $valor=null;
                    $item2="CodAlmacen";
                    $valor2=$_SESSION["CodAlmacen"];
                    $usuarios=ControladorTurnos::ctrMostrarTurnos2($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodTurno"].'">'.$value["descripcion"].'</option>
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
            $editarAlmacen= new ControladorUsuariosTurno();
            $editarAlmacen -> ctrEditarUTurno();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
  $borrarUAlmacen = new ControladorUsuariosTurno();
  $borrarUAlmacen -> ctrEliminarUTurno();
?> 