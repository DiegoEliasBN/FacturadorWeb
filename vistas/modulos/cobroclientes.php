<div id="back"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cobro a Clientes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Cobro a Clientes </li>
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
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 
                              <input type="number" min="0" class="form-control input-lg" id="cedula" name="cedula" placeholder="Ingresar cedula del cliente" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group" >
                          <button type="button"  class="btn btn-primary btn-lg btnGenerarDeuda">Consultar</button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group" >
                          <button type="button"  class="btn btn-primary  btn-lg btnGenerarFacturaDeuda">Facturas</button>
                        </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-xs-4 table-responsive">
                    <?php 
                      $item="CodUsuario";
                      $valor=$_SESSION["id"];
                      $item2="CodAlmacen";
                      $valor2=$_SESSION["CodAlmacen"];
                      $caja=ControladorACaja::ctrMostrarACajaAbierta($item,$item2,$valor,$valor2); 
                    ?>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                     <input type="hidden" name="CodApertura" value="<?php echo $caja; ?>">
                      <input type="hidden" value="<?php echo  $_SESSION["CodAlmacen"]; ?>" name="CodAlmaceng">
                      <input type="hidden" id="id_cliente" name="id_cliente" required>
                      <input type="hidden" id="deuda" name="deuda" required>
                      <table class="table table-striped table-responsive" id="cobroClientes">
                        <thead>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <div class="row">
                    <div class="hidden-xs col-sm-5"></div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group" >
                          <button type="submit"  class="btn btn-primary pull-right">Confirmar Cobro</button>
                        </div>
                    </div>
                  </div>
                  <?php
                    $crearUAlmacen= new ControladorCobros();
                    $crearUAlmacen -> ctrGuardarCobro();
                  ?>
            </form>
            <!-- this row will not appear when printing -->
          </section>
    <!-- /.content -->
</div>