<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <!--=====================================
            EL FORMULARIO
      ======================================-->
      <form role="form" method="post" class="formularioLiquidacion">
        <!--=====================================
          PRIMERA COLUMNA DONDE VA EL DETALLE DE LA FACTURA
        ======================================-->
        <!--=====================================
        ID DEL LOCAL
        ======================================-->
        <?php
          foreach ($_SESSION["almacenes"] as $key => $value) {
              echo '<input id="inicio" name="nuevoAlmacen" type="hidden" value="' . $value["CodAlmacen"] . '">';
          }
        ?>
        <div class="col-lg-8 col-xs-12">
          <div class="box box-primary">
              <div class="box-body">
                <div class="">
                  <div class="form-group">
                    <div class="input-group">
                      <!--=====================================
                      VERIFICAR SI TIENE ABIERTA UNA CAJA
                      ======================================-->
                      <?php
                        $item   = "CodUsuario";
                        $valor  = $_SESSION["id"];
                        $item2  = "CodAlmacen";
                        $valor2 = $_SESSION["CodAlmacen"];
                        $caja   = ControladorACaja::ctrMostrarACajaAbierta($item, $item2, $valor, $valor2);
                        ?>
                     <input type="hidden" id="idVendedor" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                     <input type="hidden" id="CodUTurno" name="CodUTurno" value="<?php echo $caja; ?>">
                    </div>
                  </div>
                  <!--=====================================
                  ENTRADA PARA BUSCAR POR NOMBRE O CODIGO DE BARRA
                  ======================================-->
                  <div class="row">
                    <div class="col-lg-6 col-lg-offset-1 col-md-6 col-xs-4 col-md-offset-1">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-barcode"> </i></span>
                        <input type="text" id="buscadorLiquidacion" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-5">
                      <div class="input-group input-group-sm">
                        <button type="button" type="button" id="buscadorPrecio" class="btn btn-success"></button>
                      </div>
                    </div>
                    <div class="col-lg-1 col-xs-1">
                      <div class="input-group">
                        <a class=" btn btn-primary pull-right" href="crear-liquidacion" target="_blank"><i class="glyphicon glyphicon-duplicate"></i></a>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!--=====================================
                  TABLA DEL DETTALE DE LA FACTURA
                  ======================================-->
                  <div class="scrollable">
                       <table class="table table-bordered " width="100%">
                            <thead>
                               <tr  style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px">
                                 <th class="text-center" >Nombre</th>
                                 <th class="text-center" >Cant.</th>
                                 <th class="text-center" >Prec.</th>
                                 <th class="text-center" >Total</th>
                               </tr>
                            </thead>
                            <tbody  id="datosp">
                            </tbody>
                       </table>
                  </div>
                  <!--=====================================
                  ENTRADA PARA LOS PRODUCTOS AGREGADOS
                  ======================================-->
                  <div class="form-group row nuevoProducto">
                  </div>
                  <input type="hidden" id="listaProductos" name="listaProductos">
                  <!--=====================================
                  ENTRADA MÉTODO DE PAGO
                  ======================================-->
                  <div class="form-group row">
                    <div class="cajasMetodoPago"></div>
                    <input type="hidden" id="listaMetodoPagos" name="listaMetodoPago">
                  </div>
                </div>
              </div>
          </div>
        </div>
      <!--=====================================
      COLUMNA DONDE VA LA CABECERA DE LA FACTURA
      ======================================-->
        <div class="col-lg-4 col-xs-12">
          <div class="box box-warning">
            <div class="box-body">
              <!--=====================================
              TIPO DE DOCUMENTO FACTURA O NOTA DE VENTA
              ======================================-->
              <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px" class="form-control text-center ">
                 <label class="text-center" for="">DATOS LIQUIDACION</label>
              </div>
              <br>
              <div class="form-group">
                 <select class="form-control " name="tipo" id="liquidacion">
                   <option value="F">LIQUIDACION POR COMPRA</option>
                 </select>
              </div>
              <!--=====================================
              ENTRADA DEL CLIENTE
              ======================================-->
              <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px" class="form-control text-center ">
                   <label class="text-center" for="">DATOS DEL CLIENTE</label>
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-info-circle"></i></span> 
                <select class="form-control input-xs" id="tipo_documento" name="tipo_documento" required disabled="true">
                  <option value="">NO TIENE UN TIPO DE DOCUMENTO ASIGNADO</option>
                  <option value="04">RUC</option>
                  <option value="05">CEDULA</option>
                  <option value="06">PASAPORTE</option>
                  <option value="07">CONSUMIDOR FINAL</option>
                  <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                </select>
              </div>
              <!--=====================================
              NUMERO DE DOCUMENTO DEL CLIENTE
              ======================================-->
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card-o"> </i></span>
                <input type="text" class="form-control" id="seleccionarCliente" name="seleccionarCliente" required maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingrese documento del cliente" />
                <input type="hidden" id="idCliente">
                <span class="input-group-addon"><button type="button" class='btn btn-warning btnEditarCliente btn-xs' id="editarClienteFactura" idCliente='' data-toggle='modal' data-target='#modalEditarCliente'><i class='fa fa-pencil'></i></button></span>
              </div>
              <!--=====================================
              NOMBRE DEL CLIENTE
              ======================================-->
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"> </i></span>
                <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" required="" placeholder="Ingrese el nombre del cliente">
              </div>
              <!--=====================================
              DIRECCION DEL CLIENTE
              ======================================-->
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"> </i></span>
                <input type="text" class="form-control" name="direccionCliente" id="direccionCliente" required="" placeholder="Ingrese la direccion del cliente">
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"> </i></span>
                <input type="text" class="form-control" name="emailCliente" id="emailCliente" required="" placeholder="Ingrese el correo">
              </div>
              <div class="box-footer">
               <button type="button" id="agregarclienteFactura" disabled="true" class="btn btn-primary btn-xs pull-right glyphicon glyphicon-floppy-save"></button>
              </div>
              <!--=====================================
              ENTRADA SUBTOTAL IVA Y TOTAL
              ======================================-->
              <div class="container-fluid">
                <!--<div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">SUBTOTAL 12%</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="subtotal12" name="subtotal12" total="" placeholder="0.00" disabled="true" required>
                  </div>
                </div>-->
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">MONTO 12%</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="subtotal12iva" name="subtotal12iva" total="" placeholder="0.00" disabled="true" required>
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">MONTO 0%</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="subtotal0" name="subtotal0" total="" placeholder="0.00" disabled="true" required>
                  </div>
                </div>
               <!-- <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">BASE IMPONIBLE</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="0.00" disabled="true" required>
                          <input type="hidden" name="totalVenta" id="totalVenta">
                  </div>
                </div>-->
                <input type="hidden" name="totalVenta" id="totalVenta">
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">IVA</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" min="0" id="nuevoImpuestoVentas" name="nuevoImpuestoVenta" placeholder="0.00" disabled="true" required>
                           <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto">
                           <input type="hidden" name="nuevoIva" id="nuevoIva">
                           <input type="hidden" name="nuevoIva12" id="nuevoIva12">
                           <input type="hidden" name="nuevoIva0" id="nuevoIva0">
                           <input type="hidden" name="nuevoCompra" id="totalCompra">
                           <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto">
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6 ">
                    <label class="text-right" for="">TOTAL</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" min="0" id="SubTotal" name="SubTotal" placeholder="0.00" disabled="true" required>
                           <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto">
                           <input type="hidden" name="nuevoTotalsito" id="nuevoTotalsito" >
                           <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" >
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="button" disabled="true" id="agregarLiquidacion" class="btn btn-danger pull-right glyphicon glyphicon-floppy-save"></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
<!--=====================================
MODAL EDITAR CLIENTE
======================================-->
<div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar cliente</h4>
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
                <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" required>
                <input type="hidden" id="idCliente" name="idCliente">
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="number" min="0" class="form-control input-lg" name="editarDocumentoId" id="editarDocumentoId" required>
              </div>
            </div>
             <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span> 
                <select class="form-control input-lg" id="edita_tipo_documento" name="edita_tipo_documento" required>
                  <option value="">NO TIENE UN TIPO DE DOCUMENTO ASIGNADO</option>
                  <option value="04">RUC</option>
                  <option value="05">CEDULA</option>
                  <option value="06">PASAPORTE</option>
                  <option value="07">CONSUMIDOR FINAL</option>
                  <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion"  required>
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control input-lg" name="editarFechaNacimiento" id="editarFechaNacimiento"  data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="button" id="editarClienteFacturaM" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
