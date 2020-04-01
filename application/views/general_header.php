<header class="main-header">
	<a href="escritorio" class="logo">
		<span class="logo-mini"><b>ML</b></span>
		<span class="logo-lg"><b>Municipalidad de Lavalle</b></span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
			<?php #var_dump($alertas);die();?>
				<?php foreach ($alertas as $alerta): ?>
                                    <li>
                                            <a href="<?php echo $alerta['url']; ?>" title="<?php echo $alerta['label']; ?>">
                                                    <i class="fa <?php echo $alerta['icon']; ?>"></i>
                                                    <span class="label <?php echo $alerta['class_name']; ?>"><?php echo $alerta['value']; ?></span>
                                            </a>
                                    </li>
				<?php endforeach; ?>
				<li class="dropdown user user-menu">
					<?php if (!empty($this->session->userdata('oficina_actual'))) : ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top:5px;padding-bottom:5px;">
							<span>
								<i class="fa fa-user" style="min-width:16px;text-align:center;"></i><?php echo $nombre . ' ' . $apellido; ?><br />
								<i class="fa fa-university" style="min-width:16px;text-align:center;"></i><?php echo $this->session->userdata('oficina_actual'); ?>
							</span>
						</a>
					<?php else: ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span>
								<i class="fa fa-user" style="min-width:16px;text-align:center;"></i><?php echo $nombre . ' ' . $apellido . ''; ?>
							</span>
						</a>
					<?php endif; ?>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="img/users/0.png" class="img-circle" alt="Usuario" />
							<p>
								<?php echo $nombre . ' ' . $apellido; ?>
								<?php if (!empty($login_actual)) : ?>
									<small>Ingreso actual <?php echo date('d/m/Y H:i', $login_actual); ?></small>
								<?php endif; ?>
								<?php if (!empty($ultimo_login)) : ?>
									<small>Ingreso anterior <?php echo date('d/m/Y H:i', $ultimo_login); ?></small>
								<?php endif; ?>
							</p>
						</li>
						<li class="user-footer">
							<a href="perfil/ver" class="btn btn-default btn-flat">Perfil</a>
							<!-- @TODO Si no es del grupo expedientes no mostrar -->
							<a href="expedientes/escritorio/cambiar_oficina" class="btn btn-default btn-flat">Cambiar Oficina</a>
							<a href="auth/logout" class="btn btn-default btn-flat">Salir</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>