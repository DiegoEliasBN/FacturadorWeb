<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear Compra
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Compra</li>
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
          <form role="form" method="post" class="formularioCompra">
            <div class="box-body">
              <div class="">
                 <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class=" row" >
                 <input type="hidden" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>
                  <div class=" form-group col-lg-12 col-xs-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <select name="nuevoAlmacen" class="form-control input-group cambioalmacen" id="inicioc">
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
                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
                <div class="form-group">
                  <div class="input-group">
                    <?php 
                      $item="CodUsuario";
                      $valor=$_SESSION["id"];
                      $item2="CodAlmacen";
                      $valor2=$_SESSION["CodAlmacen"];
                      $caja=ControladorACaja::ctrMostrarACajaAbierta($item,$item2,$valor,$valor2); 
                    ?>
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                    <input type="hidden" name="CodUTurno" value="<?php echo $caja; ?>">
                  </div>
                </div> 
                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 
                <div class="form-group" id="proveedores">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>
                        <option value="">Seleccione el proveedor</option>
                    <?php
                      $item = null;
                      $valor = null;
                      $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);
                       foreach ($proveedores as $key => $value) {
                         echo '<option value="'.$value["id"].'">'.$value["razon_social"].'</option>';
                       }
                    ?>
                    </select>
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar proveedor</button></span>
                  </div>
                </div>
                <input type="hidden" value="compra" id="tipoFactura">
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group">
                     <table class="table table-striped" id="datosp" width="100%">
                          <thead>
                             <tr  style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px">
                               <th>Nombre</th>
                               <th>Cant.</th>
                               <th>Prec.</th>
                               <th>Total</th>
                             </tr> 
                          </thead>
                     </table>
                </div>
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaProductosc" name="listaProductosc">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" value="<?php echo $_SESSION["CodAlmacen"]; ?>" class="btn btn-default hidden-lg btnAgregarProductoc">Agregar producto</button>
                <hr>
                <div class="row">
                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  <div class="col-xs-12 pull-right">
                    <table class="table">
                      <thead>
                        <tr  style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px">
                          <th>SubTotal</th>
                          <th>Iva</th>
                          <th>Total</th>      
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="width: 33%">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalCompra" name="nuevoTotalCompra" total="" placeholder="00000" readonly required>
                              <input type="hidden" name="totalCompra" id="totalCompra">
                            </div>
                          </td>
                          <td style="width: 33%">
                            <div class="input-group">
                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoCompra" name="nuevoImpuestoCompra" placeholder="0" required>
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" min="0" id="nuevoImpuestoCompras" name="nuevoImpuestoCompra" placeholder="0000" readonly required>
                               <input type="hidden" name="nuevoPrecioImpuestoc" id="nuevoPrecioImpuestoc">
                               <input type="hidden" name="nuevoIvac" id="nuevoIvac">
                               <input type="hidden" name="nuevoPrecioNetoc" id="nuevoPrecioNetoc">
                            </div>
                          </td>
                          <td style="width: 33%">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" min="0" id="SubTotalc" name="SubTotal" placeholder="0000" readonly required>
                               <input type="hidden" name="nuevoPrecioImpuestoc" id="nuevoPrecioImpuestoc">
                               <input type="hidden" name="nuevoTotalsitoc" id="nuevoTotalsitoc" >
                               <input type="hidden" name="nuevoPrecioNetoc" id="nuevoPrecioNetoc" >
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
                <div class="form-group row">
                  <div class="col-xs-6" style="padding-right:0px">
                     <div class="input-group">
                      <select class="form-control" id="nuevoMetodoPagos" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Contado</option>
                        <option value="Credito">Crédito</option>                 
                      </select>    
                    </div>
                  </div>
                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPagos" name="listaMetodoPago">
                </div>
                <br>
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar compras</button>
          </div>
        </form>
        <?php
          $guardarVenta = new ControladorCompras();
          $guardarVenta -> ctrCrearCompra();
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
            <table class="table table-bordered table-striped dt-responsive tablaCompras" width="100%">
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
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
      <form role="form" method="post">
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
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cliente</button>
        </div>
      </form>
      <?php
        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();
      ?>
    </div>
  </div>
</div>
