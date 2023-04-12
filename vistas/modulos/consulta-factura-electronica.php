 <div id="back"></div>
  <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="login-box">
            <div class="login-logo">
            <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding: 0px 0px 0px 0px">
            </div>
        </section>
        <!-- Main content -->
        <?php 
            date_default_timezone_set('America/Guayaquil');
                $fecha=date('Y-m-d');
         ?>
              <section class="invoice">
                <!-- title row -->
                <div class="box">
                <!-- info row -->
                <!-- /.row -->
                  <div class="login-box-body">
                    <!-- Table row -->
                    <form role="form" method="post">
                          <div class="form-group row">
                            <div class="col-xs-12 col-sm-5 col-md-offset-2">
                                <div class="form-group">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 
                                      <input type="number" min="0" class="form-control input-lg" id="cedula" name="cedula" placeholder="Ingresar cedula" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-1">
                                <div class="input-group" >
                                  <button type="button"  class="btn btn-primary btn-lg glyphicon glyphicon-list-alt btnGenerarFacturaElectronicaPdf"></button>
                                </div>
                            </div>
                            <div class=" col-xs-12 col-sm-1">
                                <div class="input-group" >
                                  <a href="http://laternera-ec.com" class="btn btn-warning  btn-lg glyphicon glyphicon-arrow-left"></a>
                                </div>
                          </div>
                          <div class="row " border="4" style="margin: 0 auto;">
                            <div class="col-xs-6  col-md-offset-3 table-responsive"> 
                              <table class="table table-striped table-responsive" border="4" style="margin: 0 auto;">
                                <thead id="cobroClientesF">
                                </thead>
                              </table>
                            </div>
                            <!-- /.col -->
                          </div>
                          </div >
                    </form>
                  </div>
                </div>
                <!-- this row will not appear when printing -->
              </section>
        <!-- /.content -->
  </div>
<script src="vistas/js/cobroclientes2.js"></script>
<script src="vistas/js/plantilla2.js"></script>
