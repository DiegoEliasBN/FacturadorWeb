<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear Guia De Remision 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Guia De Remision</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-6 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioRemision">
            <div class="box-body">
              <div class="">
                 <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="row hidden-md hidden-xs hidden-lg" >
                  <div class=" hidden-md hidden-xs hidden-lg form-group col-lg-12 col-xs-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-building"></i></span>
                              <select name="id_local" class="form-control input-group cambioalmacen" id="id_local" readonly>
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
                <div class="row">
                  <div class="form-group col-lg-6 col-xs-12" >
                    <label for="">Transportista</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                      <select name="id_trasporte" class="form-control input-group cambioalmacen" id="id_trasporte" required="">
                        <option value="">SELECCIONE EL TRANSPORTISTA</option>
                        <?php
                          $item12=null;
                          $valor12=null;
                          $transporte=ControladorTransportes::ctrMostrarTransporte($item12,$valor12);
                          foreach ($transporte as $key => $value) {
                             echo '
                              <option value="'.$value["id"].'">'.$value["nombre_chofer"].'</option>
                            ';
                          }
                        ?>
                      </select>
                    </div>    
                  </div>
                  <!--=====================================
                  ENTRADA DEL cliente
                  ======================================-->
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                    <label for="">Cliente</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"> </i></span>
                      <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" required="" placeholder="Ingrese el nombre del cliente">
                      <input type="hidden" id="idCliente" name="seleccionarCliente">
                    </div>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL fechas
                ======================================-->
                <div class="row">
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                    <label for="">Fecha de salida</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       <input type="date" name="fecha_inicio" class="form-control" required="">
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                     <label for="">Fecha de llegada</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="date" name="fecha_fin" class="form-control" required="">
                    </div>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DE DIRECCION
                ======================================--> 
                <div class="row">
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                    <label for="">Direccion de salida</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                       <input  type="text" name="direccion_inicio" class="form-control" required="">
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                     <label for="">Direccion de destino</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                      <input type="text" name="direccion_destino" class="form-control" required="">
                    </div>
                  </div>
                </div>
                  <div class="row">
                      <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                         <label for="">Motivo del traslado</label>
                        <div class="input-group ">
                          <span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
                          <select name="motivo_traslado" class="form-control input-group" required="">
                            <option value="">SELECCIONE EL MOTIVO</option>
                            <option value="COMPRA">COMPRA</option>
                            <option value="VENTA">VENTA</option>
                            <option value="TRASPASO">TRASPASO</option></select>
                        </div>
                      </div>
                      <div class="form-group col-lg-6 col-xs-12" id="proveedores">
                         <label for="">Ruta</label>
                        <div class="input-group ">
                          <span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
                          <input type="text" name="ruta" class="form-control" required="">
                        </div>
                      </div>
                </div>
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group">
                     <table class="table table-striped" id="datosp" width="100%">
                          <thead>
                             <tr  style="background-color: #3c8dbc; color: #FFFFFF;font-size: 18px">
                               <th>Nombre</th>
                               <th>Cant.</th>
                             </tr> 
                          </thead>
                     </table>
                </div>
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaDetalle" name="listaDetalle">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" value="<?php echo $_SESSION["CodAlmacen"]; ?>" class="btn btn-default hidden-lg btnAgregarProductoT">Agregar producto</button>
                <hr>
                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar Guia Remision</button>
          </div>
        </form>
        <?php
          $guardarRemision = new ControladorRemisiones();
          $guardarRemision -> ctrCrearRemision();
        ?>
        </div>
      </div>
      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->
      <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaRemision" width="100%">
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="frmCliente" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar cliente</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask >
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" >
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask >
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="button" id="guardarCliente" class="btn btn-primary">Guardar cliente</button>
        </div>
      </form>
    </div>
  </div>
</div>
