<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Vehiculos
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Vehiculos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTransporte">
          Agregar Vehiculo
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Transportista</th>
           <th>Documento ID</th>
           <th>Placa Vehiculo</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $item1 = "CodAlmacen";
          $valor1 =$_SESSION["CodAlmacen"];
          $clientes = ControladorTransportes::ctrMostrarTransporteAlmacen($item, $item1, $valor, $valor1);
          foreach ($clientes as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre_chofer"].'</td>
                    <td>'.$value["identificacion_chofer"].'</td>
                    <td>'.$value["placa_vehiculo"].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarTransporte" data-toggle="modal" data-target="#modalEditarTransporte" idTransporte="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';
                          $item="CodUsuario";
                          $valor=$_SESSION["id"];
                          $usuario=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                          if ($usuario["perfil"]=="Administrador"){
                              echo '<button class="btn btn-danger btnEliminarTransporte" idTransporte="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                          }
                        echo '
                      </div>  
                    </td>
                  </tr>';
            }
        ?>
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAgregarTransporte" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Transporte</h4>
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
                <input type="text" class="form-control input-lg" name="nuevoTransporte" placeholder="Ingresar nombre" required>
                <input type="hidden" name="nuevoAlmacen" value=" <?php echo $_SESSION["CodAlmacen"];  ?>">
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span> 
                <input type="number" min="0" class="form-control input-lg" name="nuevoLicencia" placeholder="Ingresar Licencia" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <!-- ENTRADA PARA EL TELÉFONO -->
            <!-- ENTRADA PARA LA PLACA-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-car"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaPlaca" placeholder="Ingresar Placa del Vehiculo" >
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Transporte</button>
        </div>
      </form>
      <?php
        $crearTransporte = new ControladorTransportes();
        $crearTransporte -> ctrCrearTransporte();
      ?>
    </div>
  </div>
</div>
<!--=====================================
MODAL EDITAR CLIENTE
======================================-->
<div id="modalEditarTransporte" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Transporte</h4>
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
                <input type="text" class="form-control input-lg" name="editarTransporte" id="editarTransporte" required>
                <input type="hidden" id="idTransporte" name="idTransporte">
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="number" min="0" class="form-control input-lg" name="editarLicencia" id="editarLicencia" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <!-- ENTRADA PARA EL TELÉFONO -->
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="editarPlaca" id="editarPlaca"  required>
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
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
        $editarTransporte = new ControladorTransportes();
        $editarTransporte -> ctrEditarTransporte();
      ?>
    </div>
  </div>
</div>
<?php
  $eliminarTransporte = new ControladorTransportes();
  $eliminarTransporte -> ctrEliminarTransporte();
?>
