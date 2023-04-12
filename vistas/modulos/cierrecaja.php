<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Cierre de caja
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Cierre de caja</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" id="btncierrecaja">Agregar Cierre de caja</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre Apertura</th>
                <th>Cantidad</th>
                <th>Fecha Cierre</th>
                <th>Acccion</th>
              </tr>
            </thead>
            <tbody>
               <?php 
                  $item=null;
                  $valor=null;
                  $item2="CodAlmacen";
                  $valor2=$_SESSION["CodAlmacen"];
                  $usuarios=ControladorCCaja::ctrMostrarCCaja($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                    $item3="CodApertura";
                    $valor3=$value["CodApertura"];
                    $respuesta=ControladorACaja::ctrMostrarACaja($item,$item3, $valor,$valor3);
                    foreach ($respuesta as $key1 => $value1) {
                      echo '
                              <tr>
                                  <td>'.($key1+1).'</td>
                                  <td>'.$value1["nombre"].'-'.$value1["descripcion"].'</td>
                                  <td>'.$value["valorcierre"].'</td>
                                  <td>'.$value["fecha"].'</td>
                                  <td><button class="btn btn-info btnImprimirCierre" idAlmacen="'.$value["CodAlmacen"].'" codigoCierre="'.$value["CodCierre"].'" ><i class="fa fa-print "></i></button></td>
                              </tr>
                    ';
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
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="" id="idCierreCaja" name="codaperturapc" class="form-control input-lg" required>
                  <option value="">Seleccione La apertura de caja ha cerrar </option>
                    <?php
                    $item=null;
                    $valor=null;
                    $item2="CodAlmacen";
                    $valor2=$_SESSION["CodAlmacen"];
                    $usuarios=ControladorCCaja::ctrMostrarCCajaAbierta($item,$item2,$valor,$valor2);
                  foreach ($usuarios as $key => $value) {
                    echo '
                      <option value="'.$value["CodApertura"].'">'.$value["nombre"].'-'.$value["descripcion"].'</option>
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
          <button type="button" class="btn btn-primary">Generar Cierre de caja</button>
        </div>
      </form>
    </div>
  </div>
</div>
