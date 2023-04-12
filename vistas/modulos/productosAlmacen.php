<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar productos
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          Agregar producto
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablaPAlmacen" width="100%">
        <thead>
          <tr>
           <th style="width:10px">#</th>
           <th>Imagen</th>
           <th>Código</th>
           <th>Descripción</th>
           <th>IVA</th>
           <th>Categoría</th>
           <th>Precio de compra</th>
           <th>Precio de venta</th>
           <th>Stock</th>
           <th>Agregado</th>
           <th>Acciones</th>
         </tr> 
        </thead>
       </table>
        <input type="hidden" id="idperfiloculto" value=" <?php echo $_SESSION["id"];  ?>">
        <input type="hidden" id="productosAlmacen" value=" <?php echo $_SESSION["CodAlmacen"];  ?>">
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar producto</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  <option value="">Selecionar categoría</option>
                  <?php
                  $item = null;
                  $valor = null;
                  $item1 = "CodAlmacen";
                  $valor1 =$_SESSION["CodAlmacen"];
                  $categorias = ControladorCategorias::ctrMostrarCategoriasAlmacen($item,$item1, $valor, $valor1);
                  foreach ($categorias as $key => $value) {
                    echo '<option value="'.$value["idCategoria"].'">'.$value["categoria"].'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" required>
                <input type="hidden" name="nuevoAlmacen" value=" <?php echo $_SESSION["CodAlmacen"];  ?>">
              </div>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
             <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required>
              </div>
            </div>
             <!-- ENTRADA PARA STOCK -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Ingrese el stock" required>
              </div>
            </div>
             <!-- ENTRADA PARA PRECIO COMPRA -->
             <div class="form-group row">
                <div class="col-xs-12 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>
                  </div>
                </div>
                <!-- ENTRADA PARA PRECIO VENTA -->
               <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                      <input type="number" class="form-control input-lg" id="preciosiniva" name="preciosiniva" min="0" step="any" placeholder="Precio Venta" readonly required>
                    </div>
                  <!-- CHECKBOX PARA PORCENTAJE -->
                 <!-- <div class="col-xs-12">
                    <div class="form-group">
                      <label>
                        <input type="checkbox" class="minimal porcentaje" checked>
                        Utilizar procentaje
                      </label>
                    </div>
                  </div>-->
                </div>
             </div>
             <div class="form-group row">
                  <!-- ENTRADA PARA PORCENTAJE -->
                  <!--<div class="col-xs-6" style="padding:0">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>-->
                  <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                      <input type="number" id="porcentajeganancia" class="form-control input-lg" min="0" readonly required>
                    </div>
                  </div>
                   <div class="col-xs-12 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" min="0" step="any" placeholder="Precio de venta + IVA" required>
                  </div>
                  <!-- CHECKBOX PARA PORCENTAJE -->
                 <!-- <div class="col-xs-12">
                    <div class="form-group">
                      <label>
                        <input type="checkbox" class="minimal porcentaje" checked>
                        Utilizar procentaje
                      </label>
                    </div>
                  </div>-->
                </div>
             </div>
             <div class="form-group">
                      <label>
                        <input type="checkbox" name="iva_producto" class="minimal porcentaje cambioIva" value="S">
                        IVA
                      </label>
              </div>
            <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="nuevaImagen">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </form>
        <?php
          $crearProducto = new ControladorProductos();
          $crearProducto -> ctrCrearProductoAlmacen();
        ?>  
    </div>
  </div>
</div>
<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<div id="modalEditarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar producto</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg"  name="editarCategoria" required>
                  <option id="editarCategoria"></option>
                   <?php
                  $item = null;
                  $valor = null;
                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  foreach ($categorias as $key => $value) {
                    echo '<option value="'.$value["idCategoria"].'">'.$value["categoria"].'</option>';
                  }
                  ?>
                </select>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo"  required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>
              </div>
            </div>
             <!-- ENTRADA PARA STOCK -->
            <!--<div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>
              </div>
            </div>-->
             <!-- ENTRADA PARA PRECIO COMPRA -->
             <div class="form-group row">
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>
                  </div>
                </div>
                <!-- ENTRADA PARA PRECIO VENTA -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" class="form-control input-lg" id="epreciosiniva" name="epreciosiniva" step="any" min="0"  required readonly>
                  </div>
                  <br>
                  <!-- CHECKBOX PARA PORCENTAJE -->
                  <!--<div class="col-xs-6">
                    <div class="form-group">
                      <label>
                        <input type="checkbox" class="minimal porcentaje" checked>
                        Utilizar procentaje
                      </label>
                    </div>
                  </div>-->
                  <!-- ENTRADA PARA PORCENTAJE -->
                  <!--<div class="col-xs-6" style="padding:0">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>-->
                </div>
             </div>
             <div class="form-group row">
                  <!-- ENTRADA PARA PORCENTAJE -->
                  <!--<div class="col-xs-6" style="padding:0">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>-->
                  <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                      <input type="text" id="porcentajegananciae" class="form-control input-lg" min="0" required readonly>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                      <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" required>
                    </div>
                  </div>
             </div>
             <div class="form-group">
                      <label>
                        <input type="checkbox" name="editar_iva" id="editar_iva" class="minimal porcentaje cambioIva" value="S">
                        IVA
                      </label>
             </div>
            <!-- ENTRADA PARA SUBIR FOTO -->
             <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="editarImagen">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizarProducto" width="100px">
              <input type="hidden" name="imagenActual" id="imagenActual">
               <input type="hidden" name="idproducto" id="idproducto">
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
        <?php
          $editarProducto = new ControladorProductos();
          $editarProducto -> ctrEditarProductoAlmacen();
        ?>      
    </div>
  </div>
</div>
<?php
  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();
?>      
