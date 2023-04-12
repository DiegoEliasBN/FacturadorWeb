<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Apertura Caja
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Apertura Caja</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarACaja">Agregar Apertura de Caja</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Turno</th>
                <th>Cantidad</th>
                <th>Fecha Apertura</th>
                <th>Sucursal</th>
                <th style="text-align: center">Estado Apertura</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $item2="CodAlmacen";
                  $valor2=$_SESSION["CodAlmacen"];
                  $usuarios=ControladorACaja::ctrMostrarACaja($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["nombre"].'</td>
                                  <td>'.$value["descripcion"].'</td>
                                  <td>'.$value["valorapertura"].'</td>
                                  <td>'.$value["fechaapertura"].'</td>
                                  <td>'.$value["NombreAlmacen"].'</td>';
                      if ($value["estado_apertura"]==1) {
                      echo '      <td style="text-align: center">
                                      <button class="btn btn-success btn-xs" >Abierto</button>
                                  </td>
                                  </tr>';
                      }else{
                        echo      '<td style="text-align: center">
                                      <button class="btn btn-danger btn-xs">Cerrado</button>
                                  </td>
                                  </tr>';
                      }
                  }
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
</div>
<div id="modalAgregarACaja" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header"  style="background:#3c8dbc; color: white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Apertura de Caja</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                <select name="" id="idTurnoA" class="form-control input-lg" required>
                  <option value="">Seleccione un turno</option>
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
            <div class="form-group">
              <div class="input-group">
                <input type="hidden"  name="CodAlmacen" id="CodAlmacen" value="<?php echo $_SESSION["CodAlmacen"]; ?>" required>
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="CodUTurno" id="idUsuarioTurno" class="form-control input-lg" required>
                  <option value="">Seleccione Usuario</option>
                </select>
              </div>
            </div>
            <div class="input-group row">
                          <div class="col-xs-12 col-sm-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="number" class="form-control input-lg" id="" min="" step="any" name="valorapertura" placeholder="Valor de la apertura" required>
                            </div>
                          </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        <?php
            $crearUAlmacen= new ControladorACaja();
            $crearUAlmacen -> ctrCrearACaja();
        ?>
      </form>
    </div>
  </div>
</div>
