<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cierre de Caja
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Cierre de caja </li>
      </ol>
    </section>
    <!-- Main content -->
    <?php 
        date_default_timezone_set('America/Guayaquil');
            $fecha=date('Y-m-d');
     ?>
          <section class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-globe"></i>La Ternera
                  <?php 
                  echo '<small class="pull-right">'.$fecha.'</small>';
                   ?>
                </h2>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <!-- /.row -->
            <!-- Table row -->
            <form role="form" method="post">
                  <div class="form-group row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <select name="" id="CodApetura" name="codaperturapc" class="form-control input-lg" required>
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
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-group" >
                          <button type="button"  class="btn btn-primary btn-lg btnGenerarCierre">Generar Cierre de caja</button>
                        </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-xs-12 table-responsive">
                      <input type="hidden" id="CodAperturag" name="CodAperturag" required>
                      <input type="hidden" value="<?php echo  $_SESSION["CodAlmacen"]; ?>" name="CodAlmaceng">
                      <input type="hidden" id="ValorCierreg" name="ValorCierreg" required>
                      <input type="hidden" id="facturapagadag" name="facturapagadag" required>
                      <input type="hidden" id="facturapagadatc" name="facturapagadatc" required>
                      <input type="hidden" id="totalConsolidado" name="totalConsolidado" required>
                      <input type="hidden" id="facturapagadatd" name="facturapagadatd" required>
                      <input type="hidden" id="facturafiadag" name="facturafiadag" required>
                      <input type="hidden" id="aperturacajag" name="aperturacajag" required>
                      <input type="hidden" id="facturapagadagn" name="facturapagadagn" required>
                      <input type="hidden" id="facturafiadagn" name="facturafiadagn" required>
                      <input type="hidden" id="aperturacajagn" name="aperturacajagn" required>
                      <input type="hidden" id="movimiento" name="movimiento" required>
                      <input type="hidden" id="movimienton" name="movimienton" required>
                      <table class="table table-striped table-responsive">
                        <thead>
                        <tr>
                          <th>Tipo Documento</th>
                           <th>Descripcion/Cliente</th>
                          <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="tblcierre">
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-7">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-5">
                      <div class="table-responsive">
                        <table class="table" id="tbltotalcierre">
                        </table>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div>
                  <div class="row">
                    <div class="hidden-xs col-sm-7"></div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group" >
                          <button type="submit"  class="btn btn-primary">Confirmar Cierre</button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group" >
                          <button type="button" id="btncancelarcaja" class="btn btn-primary">Cancelar Cierre</button>
                        </div>
                    </div>
                  </div>
                  <?php
                    $crearUAlmacen= new ControladorCCaja();
                    $crearUAlmacen -> ctrCrearCierreCaja();
                  ?>
            </form>
            <!-- this row will not appear when printing -->
          </section>
    <!-- /.content -->
</div>