<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Stock
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Stock De Productos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <!--<div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          Agregar producto
        </button>
      </div>-->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablaStock" width="100%">
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
        <input type="hidden" id="idperfiloculto" value=" <?php echo $_SESSION["id"];  ?>">
        <input type="hidden" id="almacenStock" value=" <?php echo $_SESSION["CodAlmacen"];  ?>">
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<div id="modalEditarStock" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Stock</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo"  required readonly>
                <input type="hidden" name="idproducto" id="idproducto">
                <input type="hidden" name="CodAlmacen" id="CodAlmacen">
              </div>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required readonly>
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
                    <input type="number" class="form-control input-lg" id="editarIngreso" name="editarIngreso" step="any" min="0" required>
                  </div>
                </div>
                <!-- ENTRADA PARA PRECIO VENTA -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" class="form-control input-lg" id="editarEgreso" name="editarEgreso" step="any" min="0"  required readonly>
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
                      <span class="input-group-addon"><i class="fa fa-arrow-right"></i></span>
                      <input type="text" id="stock" class="form-control input-lg" min="0" required readonly>
                    </div>
                  </div>
             </div>
            <!-- ENTRADA PARA SUBIR FOTO -->
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
          $editarProducto = new ControladorVentas();
          $editarProducto -> ctrEditarStock();
        ?>      
    </div>
  </div>
</div>
