<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear traspaso
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear traspaso</li>
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
          <form role="form" method="post" class="formularioTraspaso">
            <div class="box-body">
              <div class="box">
                 <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="row" >
                  <div class=" form-group col-lg-5 col-xs-12">
                      <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <?php
                            $item = null;
                            $valor = null;
                            $item1="CodAlmacen";
                            $valor1=$_SESSION["CodAlmacen"];
                            $ventas = ControladorVentas::ctrMostrarVentas($item,$item1,$valor,$valor1);
                            if(!$ventas){
                              echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>';
                            }else{
                              foreach ($ventas as $key => $value) {
                              }
                              $codigo = $value["codigo"] + 1;
                              echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$codigo.'" readonly>';
                            }
                            ?>
                      </div>
                  </div>
                  <div class=" form-group col-lg-7 col-xs-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-building"></i></span>
                              <select name="nuevoAlmacen" class="form-control input-group cambioalmacen" id="inicio" readonly>
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
                              <span class="input-group-addon"><i class="fa fa-building"></i></span>
                              <select name="nuevoAlmacenEntradda" class="form-control input-group cambioalmacen" id="nuevoAlmacenEntradda" required="">
                                <option value="">Seleccione el almacen entrada</option>
                                <?php
                                  $item12=null;
                                  $valor12=null;
                                  $item21="CodAlmacen";
                                  $valor21=$_SESSION["CodAlmacen"];
                                  $usuarios=ControladorAlmacenes::ctrMostrarAlmacenes1($item12,$item21,$valor12,$valor21);
                                  foreach ($usuarios as $key => $value) {
                                     echo '
                                      <option value="'.$value["CodAlmacen"].'">'.$value["NombreAlmacen"].'</option>
                                    ';
                                  }
                                ?>
                              </select>
                            </div>
                </div>
                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
                <div class="form-group">
                <input type="hidden" value="traspaso" id="tipoFactura">
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
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group">
                     <table class="table table-striped" id="datosp" width="100%">
                          <thead>
                             <tr  style="background-color: #DF2B2B; color: #FFFFFF;font-size: 18px">
                               <th>Nombre</th>
                               <th>Cant.</th>
                             </tr> 
                          </thead>
                     </table>
                </div>
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaProductosT" name="listaProductosT">
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
            <button type="submit" class="btn btn-primary pull-right">Guardar Traspaso</button>
          </div>
        </form>
        <?php
          $guardarVenta = new ControladorTraspasos();
          $guardarVenta -> ctrCrearTraspaso();
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
            <table class="table table-bordered table-striped dt-responsive tablaTraspasos" width="100%">
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
