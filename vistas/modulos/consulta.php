<?php 
unset($_SESSION['ver']); ?>
<div id="back"></div>
<div class="login-box">
  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding: 30px 100px 0px 100px">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Consulta deuda</p>
    <form method="post">
      <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="Ingrese Cedula" name="cedula" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="button" id="btnConsulta" class="btn btn-primary btn-block btn-flat ">Consultar</button>
        </div>
        <div class="col-xs-6">
          <button type="button" onclick = "location='../posFinal/index2.php'" class="btn btn-primary btn-block btn-flat ">salir</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<script>
$("#btnConsulta").click(function(){
      swal({
              type: "success",
              title: "La deduda del cliente Diego Elias es de 25 Dolares",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
      });
});
</script>