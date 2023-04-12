<header class="main-header">
	<a href="inicio" class="logo">
		<span class="logo-mini">
			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding: 10px">
		</span>
		<span class="logo-lg">
			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive " style="padding: 0px 0px">
		</span>
	</a>
	<nav class="navbar navbar-static-top" data-log >
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php 
						if ($_SESSION["foto"] != "") {
							echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
						}else{
							echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
						}
					?>
						<span><?php echo $_SESSION["nombre"];  ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<?php 
								if ($_SESSION["foto"] != "") {
									echo '<img src="'.$_SESSION["foto"].'" class="img-circle" alt="Imagen de usuario">';
								}else{
									echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="Imagen de usuario">';
								}
							?>
								<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								<?php echo $_SESSION["nombre"];  ?> - </font><font style="vertical-align: inherit;"> <?php echo $_SESSION["perfil"];  ?>
								 </font></font>
								</p>
		                </li>
						<li class="user-footer">
							<div class="pull-right">
								<a href="salir" class="btn btn-default btn-flat ">Salir</a>
							</div>
						</li>
					</ul>	
				</li>
			</ul>
		</div>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class=" fa fa-building"></i>
					<?php
						if (isset($_SESSION["almacenes"])) {
	                      foreach ($_SESSION["almacenes"] as $key => $value) {
	                        echo '
	                          <span>'.$value["NombreAlmacen"].'</span>
	                        ';
	                      }
	                    }
                   ?>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</header>