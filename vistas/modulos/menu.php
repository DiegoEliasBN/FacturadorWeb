<aside class="main-sidebar">
	<section class="sidebar">
		<?php 
		$item="CodUsuario";
		$valor=$_SESSION["id"];
		$usuario=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
					if (isset($_SESSION["almacenes"])){
							echo '
									<ul class="sidebar-menu">
										<li class="active">
											<a href="inicio">
												<i class="glyphicon glyphicon-home"></i>
												<span>Inicio</span>
											</a>
										</li>';
							if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador") {
								echo 
								'
								<li class="treeview">
									<a href="#">
									<i class="fa fa-database "></i> <span> Administrar Caja</span>
									<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
									</span>
									</a>
								<ul class="treeview-menu">
									<li class="active"><a href="aperturacaja"><i class="fa fa-list"></i> Apertura de caja</a></li>
									<li><a href="cierrecaja"><i class="fa fa-money"></i> Cierre de caja</a></li>
							     </ul>
							   </li>
							';
							}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador" || $usuario["perfil"]=="Especial"|| $usuario["perfil"]=="Vendedor") {
							echo '<li class="treeview">
							<a href="#">
							<i class="fa fa-american-sign-language-interpreting "></i> <span>Movimientos/Trasportes</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
							</span>
							</a>
						<ul class="treeview-menu">
							<li class="active"><a href="mefectivo"><i class="fa fa-usd"></i>Movimiento Efectivo</a></li>
							<li><a href="transporte"><i class="fa fa-truck"></i>Transporte</a></li>
						 </ul>
					   </li>'
								  ;
						}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="Especial") {
							echo '
									<li class="treeview">
								          <a href="#">
								            <i class=" fa fa-product-hunt"></i> <span> Administrar Productos</span>
								            <span class="pull-right-container">
								              <i class="fa fa-angle-left pull-right"></i>
								            </span>
								          </a>
								          <ul class="treeview-menu">
								            <li class="active"><a href="productosAlmacen"><i class="fa fa-product-hunt"></i> Producto</a></li>
								            <li><a href="categorias"><i class="fa fa-th"></i> Categoria</a></li>
								            <li><a href="proveedor"><i class="fa fa-truck"></i> Proveedor</a></li>
								          </ul>
								    </li>
							';
						}
						if ($usuario["perfil"]=="SAdministrador") {
							echo '
									<li class="treeview">
								          <a href="#">
								            <i class=" fa fa-product-hunt"></i> <span> Administrar Productos</span>
								            <span class="pull-right-container">
								              <i class="fa fa-angle-left pull-right"></i>
								            </span>
								          </a>
								          <ul class="treeview-menu">
								            <li class="active"><a href="productos"><i class="fa fa-product-hunt"></i> Producto</a></li>
								            <li><a href="categorias"><i class="fa fa-th"></i> Categoria</a></li>
								            <li><a href="proveedor"><i class="fa fa-truck"></i> Proveedor</a></li>
								            <li><a href="stock"><i class="fa fa-truck"></i> Stock</a></li>
								          </ul>
								    </li>
							';
						}
						if ($usuario["perfil"]=="SAdministrador") {
							echo '
							<li class="treeview">
											<a href="#">
											<i class="fa fa-cog"></i> <span>Administración General</span>
											<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
											</span>
											</a>
											<ul class="treeview-menu">
												<li class="active"><a href="almacen"><i class="fa fa-building"></i>Crear Almacen</a></li>
												<li><a href="turnos"><i class="fa fa-clock-o"></i>Crear Turno</a></li>
												<li><a href="transporte"><i class="fa fa-truck"></i>Transporte</a></li>
											 </ul>
										   </li>
										<li class="treeview">
								          <a href="#">
								            <i class="fa fa-user"></i> <span> Administrar Usuarios</span>
								            <span class="pull-right-container">
								              <i class="fa fa-angle-left pull-right"></i>
								            </span>
								          </a>
								          <ul class="treeview-menu">
								            <li class="active"><a href="usuarios"><i class="fa fa-user-circle"></i> Crear Usuario</a></li>
								            <li><a href="Usuarioalmacen"><i class="fa fa-address-card"></i> Asignar Almacen</a></li>
								            <li><a href="usuarioturno"><i class="fa fa-clock-o"></i> Asignar Turno</a></li>
								          </ul>
										</li>
										<li>
											<a href="nalmacen">
												<i class=" fa fa-building-o "></i>
												<span>Almacen Asignado</span>
											</a>
										</li>
							';
						}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador" || $usuario["perfil"]=="Especial" || $usuario["perfil"]=="Vendedor") {
							echo '
								<li>
											<a href="clientes">
												<i class=" fa fa-users"></i>
												<span>Clientes</span>
											</a>
								</li>
								<li class="treeview">
											<a href="#">
												<i class=" fa fa-window-maximize"></i>
												<span>Ventas</span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
											<li class="active"><a href="ventas"><i class="fa fa-cogs"></i>Facturas</a></li>
								            <li><a href="crear-venta"><i class="fa fa-bars"></i>Crear Venta</a></li>
								';
						}
						if ($usuario["perfil"]=="Especial") {
							echo '
											</ul>
										</li>';
						}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador") {
										echo '<li>
													<a href="reportes">
														<i class="fa fa-pie-chart ">
															<span>Reporte De Venta</span>
														</i>
													</a>
												</li>
											</ul>
										</li>';
						}			
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador" ||$usuario["perfil"]=="Especial") {
											echo '<li class="treeview">
											<a href="#">
												<i class="fa fa-shopping-cart"></i>
												<span>Compras</span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
											<li class="active"><a href="compras"><i class="fa fa-cogs"></i>Administrar Compras</a></li>
								            <li><a href="crear-compra"><i class="fa fa-cart-arrow-down"></i>Crear Compra</a></li>
											';
										}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador" || $usuario["perfil"]=="Especial"|| $usuario["perfil"]=="Vendedor"){
							echo '
											</ul>
											</li>';
							}
						if ($usuario["perfil"]=="Administrador" || $usuario["perfil"]=="SAdministrador" || $usuario["perfil"]=="Especial"|| $usuario["perfil"]=="Vendedor"){
							echo'<li class="treeview">
								          <a href="#">
								            <i class="fa fa-edge"></i> <span> D-Electrónicos</span>
								            <span class="pull-right-container">
								              <i class="fa fa-angle-left pull-right"></i>
								            </span>
								          </a>
								          <ul class="treeview-menu">
								            <li class="active"><a href="retencion"><i class="fa fa-list"></i> Retenciones</a></li>
								            <li><a href="crear-retencion"><i class="fa fa-money"></i> Crear Retención</a></li>
								            <li><a href="guia-remision"><i class="fa fa-list"></i>Guias de Remision</a></li>
                                            <li><a href="crear-guia-remision"><i class="fa fa-road"></i>Crear G-Remision</a></li>
                                            <li><a href="liquidaciones"><i class="fa fa-list"></i>Liquidaciones</a></li>
								            <li><a href="crear-liquidacion"><i class="fa fa-money"></i>Crear Liquidacion</a></li>
								          </ul>
								    	</li>
										'
									;
						}				
					}else{
						echo '
						<ul class="sidebar-menu">
							<li>
								<a href="nalmacen">
									<i class=" fa fa-building"></i>
									<span>Sucursales Asignadas</span>
								</a>
							</li>
						</ul>
						';
					}
		?>
	</section>
</aside>