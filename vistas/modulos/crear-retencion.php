<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear Retencion 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Retencion</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <!--=====================================
      EL FORMULARIO
      ======================================-->  
      <div class="col-lg-12 col-xs-12 col-md-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioRetencion">
            <div class="box-body">
              <div class="">
                 <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="row hidden-md hidden-xs hidden-lg" >
                  <div class=" form-group col-lg-12 col-xs-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-building"></i></span>
                              <select name="id_almacen" class="form-control input-group cambioalmacen" id="id_almacen" readonly>
                                <?php
                                  foreach ($_SESSION["almacenes"] as $key => $value) {
                                    echo '
                                      <option value="'.$value["CodAlmacen"].'">'.$value["NombreAlmacen"].'</option>
                                    ';
                                  }
                                ?>
                              </select>
                            </div>
                  </div>
                </div>
                <div class="form-group" >
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                    <select name="tipocomprobante" class="form-control input-group cambioalmacen" id="tipocomprobante" required="">
                      <option value="">SELECCIONE TIPO DE COMPROBANTE</option>
                     <?php 
                        $tipocomprobante = ControladorRetenciones::ctrMostrarTipoComprobante();
                       foreach ($tipocomprobante as $key => $value) {
                         echo '<option value="'.$value["ID"].'">'.$value["Comprobante"].'</option>';
                       }
                      ?>
                    </select>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL proveedor
                ======================================-->
               <div class="form-group" id="proveedores">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                    <select class="form-control" id="acreedor" name="acreedor" required>
                        <option value="">SELECCIONE EL PROVEEDOR</option>
                    <?php
                      $item = null;
                      $valor = null;
                      $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);
                       foreach ($proveedores as $key => $value) {
                         echo '<option value="'.$value["id"].'">'.$value["razon_social"].'</option>';
                       }
                    ?>
                    </select>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL fechas
                ======================================-->
                <div class="row">
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                    <label for="">Numero del comprobante</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                       <input type="text" name="numerocomprobante" class="form-control" required="">
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                     <label for="">Fecha del comprobante</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="date" name="fechacomprobante" class="form-control" required="">
                    </div>
                  </div>
                </div>
                <!--=====================================
                detalle
                ======================================-->
                <div class="form-group">
                     <table class="table table-striped" id="datosp" width="100%">
                          <thead>
                             <tr  style="background-color: #3c8dbc; color: #FFFFFF;font-size: 18px">
                               <th>DETALLE</th>
                             </tr> 
                          </thead>
                     </table>
                </div> 
                <div id="ItemsDetalle">
                </div> 
                <input type="hidden" id="listaDetalle" name="listaDetalle">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" id="boton" class="btn btn-success btn-xs fa fa-plus  btnAgregarDetalle"></button>
                <hr>
                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar Retencion</button>
          </div>
        </form>
        <?php
          $guardarRetencion = new ControladorRetenciones();
          $guardarRetencion -> ctrCrearRetenciones();
        ?>
        </div>
      </div>
    </div>
  </section>
</div>
