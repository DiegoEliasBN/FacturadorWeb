<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Factura
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear venta</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <!--=====================================
            EL FORMULARIO
      ======================================-->
      <form role="form" method="post" class="formularioVenta">
        <!--=====================================
          PRIMERA COLUMNA DONDE VA EL DETALLE DE LA FACTURA
        ======================================-->
        <div class="col-lg-8 col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="">
                  <?php
                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $item1="CodAlmacen";
                    $valor1=$_SESSION["CodAlmacen"];
                    $venta = ControladorVentas::ctrMostrarVentas($item,$item1, $valor,$valor1);
                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];
                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                    if ($venta["tipo"]=="F") {
                      $nombreTipo="FACTURA";
                      $tipo="NV";
                      $nombreTipo2="NOTA DE VENTA";
                    }else{
                      $nombreTipo="NOTA DE VENTA";
                      $nombreTipo2="FACTURA";
                      $tipo="F";
                    }
                  ?>
                  <!--=====================================
                    ID DEL LOCAL, FACTURA
                  ======================================-->
                  <input type="hidden" class="form-control" id="inicio" value="<?php echo $venta["CodAlmacen"]; ?>" >
                  <input type="hidden" id="nuevaVenta" name="editarVenta" value="<?php echo $valor; ?>" readonly>
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
                    <div class="col-lg-7 col-lg-offset-1 col-md-7 col-xs-7 col-md-offset-1 col-xs-offset-1">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-barcode"> </i></span>
                        <input type="text" id="buscadorVenta" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-3">
                      <div class="input-group input-group-sm">
                        <button type="button" id="buscadorPrecio" class="btn btn-success"></button>
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
                              <?php
                                $item = "id_factura";
                                $valor = $_GET["idVenta"];
                                $detalleVenta = ControladorVentas::ctrMostrarDetalleVenta($item, $valor);
                                foreach ($detalleVenta as $key => $value) {
                                  $item = "CodProducto";
                                  $valor = $value["id_producto"];
                                  $item1= "CodAlmacen";
                                  $valor1=$_SESSION["CodAlmacen"];
                                  $respuesta = ControladorProductos::ctrMostrarStock($item,$item1, $valor,$valor1);
                                  $stockAntiguo = $respuesta["CantidadEgreso"] - $value["cantidad"];
                                  $stockAntiguo1 = $respuesta["CantidadIngreso"] - $stockAntiguo;
                                  $stockAntiguo2 = $respuesta["CantidadIngreso"] - $stockAntiguo1;
                                  $iva=$respuesta["precio_venta"]*0.12;
                                  $iva1=$iva*$value["cantidad"];
                                  $ivaT=$iva+$respuesta["precio_venta"];
                                  $ivaT1=$ivaT*$value["cantidad"];
                                  echo '<tr class="nuevoProducto">
                                          <!-- Descripción del producto -->
                                          <td width="45%">
                                            <div class="" style="padding-right:0px">
                                              <div class="input-group">
                                                <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id_producto"].'"><i class="fa fa-times"></i></button></span>
                                                <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id_producto"].'" name="agregarProducto" value="'.$value["descripcion_producto"].'" disabled="true" required>
                                              </div>
                                            </div>
                                          </td>   
                                          <!-- Cantidad del producto -->
                                          <td>
                                            <div class="">
                                               <input type="number" class="form-control nuevaCantidadProducto" step="any" id="'.$value["id_producto"].'" name="nuevaCantidadProducto" min="0" value="'.$value["cantidad"].'" stock1="'.$stockAntiguo1.'" stock="'.$stockAntiguo.'" CodAlmacen="" nuevoStock="" required>
                                            </div>
                                          </td>
                                          <!-- precio -->
                                          <td>
                                            <div class="input-group">
                                               <input type="text" class="form-control preciotodo" value="'.$value["precio_venta"].'" disabled="true">
                                            </div>
                                          </td>
                                          <!-- Precio del producto -->
                                          <td>
                                            <div class=" ingresoPrecio" style="padding-left:0px">
                                              <div class="input-group">
                                                <input type="text" class="form-control nuevoPrecioProducto" id="'.$value["id_producto"].'" ivavalor="'.$value["total_iva"].'" valorcompra="'.$value["total_precio_compra"].'" ivafinal="'.$value["total_con_iva"].'" ivasi="'.$value["estado_iva"].'"  precioReal="'.$value["precio_venta"].'" precioc="'.$value["precio_compra"].'" precioconiva="'.$value["precio_con_iva"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" disabled="true" required>
                                              </div>
                                            </div>
                                          </td>
                                        </tr>';
                                }
                              ?>
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
            <div class="box-header with-border"></div>
            <div class="box-body">
              <!--=====================================
              TIPO DE DOCUMENTO FACTURA O NOTA DE VENTA
              ======================================-->
              <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px" class="form-control text-center ">
                 <label class="text-center" for="">DATOS FACTURA</label>
              </div>
              <br>
              <div class="form-group">
                 <select class="form-control " name="tipo" id="Factura">
                  <option value="<?php echo $venta["tipo"]; ?>"><?php echo $nombreTipo; ?></option>
                  <option value="<?php echo $tipo; ?>"><?php echo $nombreTipo2; ?></option>
                 </select>
              </div>
              <!--=====================================
              ENTRADA DEL CLIENTE
              ======================================-->
              <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px" class="form-control text-center ">
                   <label class="text-center" for="">DATOS DEL CLIENTE</label>
              </div>
              <!--=====================================
              NUMERO DE DOCUMENTO DEL CLIENTE
              ======================================-->
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"> </i></span>
                  <input type="text" class="form-control"  value="<?php echo $cliente["documento"]; ?>" id="seleccionarCliente" placeholder="Ingrese documento del cliente" name="seleccionarCliente" required maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
                  <input type="hidden"  value="<?php echo $cliente["id"]; ?>" id="idCliente">
                  <span class="input-group-addon"><button type="button" class='btn btn-warning btnEditarCliente btn-xs' id="editarClienteFactura" idCliente="<?php echo $cliente["id"]; ?>" data-toggle='modal' data-target='#modalEditarCliente'><i class='fa fa-pencil'></i></button></span>
              </div>
              <!--=====================================
              NOMBRE DEL CLIENTE
              ======================================-->
              <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"> </i></span>
                      <input type="text" class="form-control" value="<?php echo $cliente["nombre"]; ?>" name="nombreCliente" id="nombreCliente" required="" placeholder="Ingrese el nombre del cliente">
                      <span class="input-group-addon"></span>
              </div>
              <!--=====================================
              DIRECCION DEL CLIENTE
              ======================================-->
              <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"> </i></span>
                      <input type="text" class="form-control" value="<?php echo $cliente["direccion"]; ?>" name="direccionCliente" id="direccionCliente" required="" placeholder="Ingrese la direccion del cliente">
                      <span class="input-group-addon"></span>
              </div>
              <div class="box-footer">
               <button type="button" id="agregarclienteFactura" disabled="true" class="btn btn-primary btn-xs pull-right glyphicon glyphicon-floppy-save"></button>
              </div>
              <!--=====================================
              ENTRADA SUBTOTAL IVA Y TOTAL
              ======================================-->
              <div class="container-fluid">
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">SUBTOTAL 12%</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" value="<?php echo number_format($venta["iva_12"],2); ?>" class="form-control input-sm" id="subtotal12" name="subtotal12" total="" placeholder="0.00" disabled="true" required>
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">SUBTOTAL + IVA</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="subtotal12iva" name="subtotal12iva" total="" value="<?php echo number_format($venta["iva_12"]+$venta["impuesto"],2); ?>" placeholder="0.00" disabled="true" required>
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">SUBTOTAL 0%</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" value="<?php echo number_format($venta["iva_0"],2); ?>" class="form-control input-sm" id="subtotal0" name="subtotal0" total="" placeholder="0.00" disabled="true" required>
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">BASE IMPONIBLE</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" value="<?php echo number_format($venta["neto"],2); ?>" placeholder="0.00" disabled="true" required>
                          <input type="hidden" value="<?php echo $venta["neto"]; ?>" name="totalVenta" id="totalVenta">
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6">
                    <label class="text-right" for="">Iva</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                    <input type="hidden" class="form-control input-lg" value="<?php echo $venta["impuesto"]; ?>" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>
                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                    <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" min="0" id="nuevoImpuestoVentas" name="nuevoImpuestoVenta" value="<?php echo number_format($venta["impuesto"],2); ?>" placeholder="0.00" disabled="true" required>
                    <input type="hidden" value="<?php echo $venta["total"]; ?>" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto">
                    <input type="hidden" value="<?php echo $venta["impuesto"]; ?>" name="nuevoIva" id="nuevoIva">
                    <input type="hidden" value="<?php echo $venta["iva_12"]; ?>" name="nuevoIva12" id="nuevoIva12">
                    <input type="hidden" name="nuevoIva0" value="<?php echo $venta["iva_0"]; ?>" id="nuevoIva0">
                    <input type="hidden" value="<?php echo $venta["total_compra"]; ?>" name="nuevoCompra" id="totalCompra">
                    <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto">
                  </div>
                </div>
                <div class="row">
                  <div style="background-color: #DF2B2B; color: #FFFFFF;font-size: 17px" class="text-right col-lg-6 col-xs-6 ">
                    <label class="text-right" for="">TOTAL</label>
                  </div>
                  <div class="input-group col-lg-6 col-xs-6">
                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                    <input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control input-sm" min="0" id="SubTotal" name="SubTotal" placeholder="0.00" value="<?php echo number_format($venta["total"],2); ?>" disabled="true" required>
                    <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto">
                    <input type="hidden" value="<?php echo $venta["total"]; ?>" name="nuevoTotalsito" id="nuevoTotalsito" >
                    <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" >
                  </div>
                </div>
              </div>
              <br>
              <div class="form-group row">
                <div class="col-xs-8" style="padding-right:0px">
                  <div class="input-group">
                    <select class="form-control" id="nuevoMetodoPagos" name="nuevoMetodoPago" required>
                      <option value="">Seleccione método de pago</option>
                      <option value="Efectivo">Contado</option>
                      <option value="TC">Tarjeta de Crédito</option>
                      <option value="TD">Tarjeta de Débito</option>
                    </select>
                  </div>
                  <hr>
                </div>
                <div class="cajasMetodoPago">
                </div>
                <input type="hidden" id="listaMetodoPagos" name="listaMetodoPago">
              </div>
            </div>
            <div class="box-footer">
              <button type="button" id="btnEditarVenta" class="btn btn-danger pull-right glyphicon glyphicon-floppy-save"></button>
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
