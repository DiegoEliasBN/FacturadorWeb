<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Turnos
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Turnos</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTurno">Agregar Turno</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Descripcion</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $item2="CodAlmacen";
                  $valor2=$_SESSION["CodAlmacen"];
                  $usuarios=ControladorTurnos::ctrMostrarTurnos2($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["descripcion"].'</td>
                                  <td>'.$value["hora_inicio"].'</td>
                                  <td>'.$value["hora_fin"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarTurno btn btn-warning" idTurno="'.$value["CodTurno"].'" data-toggle="modal" data-target="#modalEditarTurno"  ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarTurno" idTurno="'.$value["CodTurno"].'"><i class="fa fa-times "></i></button>
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
<div id="modalAgregarTurno" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Turno</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-file-alt"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoTurno" placeholder="Ingresar Turno" required>
                <input type="hidden"  name="CodAlmacen" id="CodAlmacen" value="<?php echo $_SESSION["CodAlmacen"]; ?>" required>
              </div>
            </div>
            <div class="form-group row">
                  <div class="col-xs-12 col-sm-6 ">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                      <input type="time" class="form-control input-lg" name="HoraInicio"  required>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                      <input type="time" class="form-control input-lg" name="HoraFin" id="HoraFin"  required>
                    </div>
                  </div>
            </div>    
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Turno</button>
        </div>
        <?php
            $crearAlmacen= new ControladorTurnos();
            $crearAlmacen -> ctrCrearTurno();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarTurno" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Turno</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control input-lg" name="editarTurno" id="editarTurno"  required>
              </div>
            </div>
            <div class="form-group row">
                  <div class="col-xs-12 col-sm-6 ">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                      <input type="time" class="form-control input-lg" name="eHoraInicio" id="eHoraInicio"  required>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                      <input type="time" class="form-control input-lg" name="eHoraFin" id="eHoraFin"  required>
                      <input type="hidden"  name="idTurno" id="idTurno" required>
                    </div>
                  </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Turno</button>
        </div>
        <?php
            $crearUsuario= new ControladorTurnos();
            $crearUsuario -> ctrEditarTurno();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
  $borrarAlmacen = new ControladorTurnos();
  $borrarAlmacen -> ctrBorrarTurno();
?> 