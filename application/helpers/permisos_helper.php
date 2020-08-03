<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('groups_names'))
{

	function groups_names($grupos)
	{
		$nombres = array();
		foreach ($grupos as $Grupo)
		{
			array_push($nombres, $Grupo['name']);
		}
		return $nombres;
	}
}

if (!function_exists('in_groups'))
{

	function in_groups($grupos_permitidos, $grupos)
	{
		$result = array_intersect($grupos_permitidos, $grupos);
		return (!empty($result));
	}
}

if (!function_exists('load_permisos_nav'))
{

	function load_permisos_nav($grupos, $modulo, $controlador, $metodo)
	{
		$escritorio_active = '';
		$administracion_active = '';
		$reclamos_active = '';
		$reclamos_administracion_active = '';
		$reclamos_reportes_active = '';
		$expedientes_active = '';
		$expedientes_expedientes_active = '';
		$expedientes_pases_active = '';
		$expedientes_administracion_active = '';
		$expedientes_estadisticas_active = '';
		$requerimientos_active = '';
		switch ($controlador)
		{
			case 'grupos':
				if (empty($modulo))
				{
					$administracion_active = ' active';
				}
				else
				{
					$reclamos_active = ' active';
					$reclamos_administracion_active = ' class="active"';
				}
				break;
			case 'escritorio':
				if (empty($modulo))
				{
					$escritorio_active = ' class="active"';
				}
				else if ($modulo === 'reclamos')
				{
					$reclamos_active = ' active';
				}
				else
				{
					$expedientes_active = ' active';
				}
				break;
			case 'distritos':
			case 'usuarios':
				$administracion_active = ' active';
				break;
			case 'encuestas':
			case 'reclamos':
			case 'mapa':
				$reclamos_active = ' active';
				break;
			case 'graficos':
			case 'planillas':
				$reclamos_active = ' active';
				$reclamos_reportes_active = ' class="active"';
				break;
			case 'asignaciones_distritos':
			case 'asignaciones_grupos':
			case 'motivos_reclamos':
			case 'encuestas_preguntas':
			case 'prioridades':
			case 'sectores':
			case 'solicitantes':
				$reclamos_active = ' active';
				$reclamos_administracion_active = ' class="active"';
				break;
			case 'firmas':
				$expedientes_active = ' active';
				break;
			case 'expedientes':
			case 'personas':
				$expedientes_active = ' active';
				$expedientes_expedientes_active = ' class="active"';
				break;
			case 'pases':
				$expedientes_active = ' active';
				$expedientes_pases_active = ' class="active"';
				break;
			case 'requerimientos':
				$requerimientos_active = ' active';
				break;
			case 'oficinas':
			case 'plantillas':
			case 'tramites':
			case 'asignacion_usuarios':
			case 'cargos':
			case 'informes_infogov':
			case 'circuitos':
			case 'cargos_usuarios':
			case 'firmas_circuitos':
				$expedientes_active = ' active';
				$expedientes_administracion_active = ' class="active"';
				break;
			case 'estadisticas':
				$expedientes_active = ' active';
				$expedientes_estadisticas_active = ' class="active"';
				break;
		}
		$nav = '<li' . $escritorio_active . '><a href="escritorio"><i class="fa fa-laptop"></i> <span>Escritorio</span></a></li>';
		$grupos_admin = array('admin');
		$grupos_expedientes_admin = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
		$grupos_expedientes_supervision = array('expedientes_supervision');
		$grupos_expedientes_usuario = array('expedientes_usuario');
		$grupos_reclamos_admin = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$grupos_reclamos_coordinador = array('reclamos_coordinador');
		$grupos_reclamos_general = array('reclamos_usuario', 'reclamos_distrito');
		if (in_groups($grupos_admin, $grupos))
		{
			$nav .= '<li class="treeview' . $administracion_active . '">';
			$nav .= '<a href="#"><i class="fa fa-wrench"></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="distritos/listar"><i class="fa fa-circle-o"></i>Distritos</a></li>';
			$nav .= '<li><a href="grupos/listar"><i class="fa fa-circle-o"></i>Grupos</a></li>';
			$nav .= '<li><a href="usuarios/listar"><i class="fa fa-circle-o"></i>Usuarios</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		if (in_groups($grupos_admin, $grupos) || in_groups($grupos_reclamos_admin, $grupos))
		{
			$nav .= '<li class="treeview' . $reclamos_active . '">';
			$nav .= '<a href="#"><i class="fa fa-warning"></i> <span>Reclamos</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li' . $reclamos_administracion_active . '><a href="#"><i class="fa fa-circle-o"></i>Administración<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/asignaciones_distritos/listar"><i class="fa fa-circle-o"></i>Asignaciones de distritos</a></li>';
			$nav .= '<li><a href="reclamos/asignaciones_grupos/listar"><i class="fa fa-circle-o"></i>Asignaciones de grupos</a></li>';
			$nav .= '<li><a href="reclamos/grupos/listar"><i class="fa fa-circle-o"></i>Grupos</a></li>';
			$nav .= '<li><a href="reclamos/motivos_reclamos/listar"><i class="fa fa-circle-o"></i>Motivos de reclamos</a></li>';
			$nav .= '<li><a href="reclamos/encuestas_preguntas/listar"><i class="fa fa-circle-o"></i>Preguntas de encuestas</a></li>';
			$nav .= '<li><a href="reclamos/prioridades/listar"><i class="fa fa-circle-o"></i>Prioridades</a></li>';
			$nav .= '<li><a href="reclamos/sectores/listar"><i class="fa fa-circle-o"></i>Sectores</a></li>';
			$nav .= '<li><a href="reclamos/solicitantes/listar"><i class="fa fa-circle-o"></i>Solicitantes</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li><a href="reclamos/encuestas/listar"><i class="fa fa-circle-o"></i>Encuestas</a></li>';
			$nav .= '<li><a href="reclamos/reclamos/listar"><i class="fa fa-circle-o"></i>Reclamos</a></li>';
			$nav .= '<li><a href="reclamos/mapa"><i class="fa fa-circle-o"></i>Mapa</a></li>';
			$nav .= '<li' . $reclamos_reportes_active . '><a href="#"><i class="fa fa-circle-o"></i>Reportes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/graficos/listar"><i class="fa fa-circle-o"></i>Gráficos</a></li>';
			$nav .= '<li><a href="reclamos/planillas/listar"><i class="fa fa-circle-o"></i>Planillas</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		if (in_groups($grupos_reclamos_coordinador, $grupos))
		{
			$nav .= '<li class="treeview' . $reclamos_active . '">';
			$nav .= '<a href="#"><i class="fa fa-warning"></i> <span>Reclamos</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/encuestas/listar"><i class="fa fa-circle-o"></i>Encuestas</a></li>';
			$nav .= '<li><a href="reclamos/reclamos/listar"><i class="fa fa-circle-o"></i>Reclamos</a></li>';
			$nav .= '<li><a href="reclamos/mapa"><i class="fa fa-circle-o"></i>Mapa</a></li>';
			$nav .= '<li' . $reclamos_reportes_active . '><a href="#"><i class="fa fa-circle-o"></i>Reportes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/graficos/listar"><i class="fa fa-circle-o"></i>Gráficos</a></li>';
			$nav .= '<li><a href="reclamos/planillas/listar"><i class="fa fa-circle-o"></i>Planillas</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		if (in_groups($grupos_reclamos_general, $grupos))
		{
			$nav .= '<li class="treeview' . $reclamos_active . '">';
			$nav .= '<a href="#"><i class="fa fa-warning"></i> <span>Reclamos</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/reclamos/listar"><i class="fa fa-circle-o"></i>Reclamos</a></li>';
			$nav .= '<li><a href="reclamos/mapa"><i class="fa fa-circle-o"></i>Mapa</a></li>';
			$nav .= '<li' . $reclamos_reportes_active . '><a href="#"><i class="fa fa-circle-o"></i>Reportes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="reclamos/graficos/listar"><i class="fa fa-circle-o"></i>Gráficos</a></li>';
			$nav .= '<li><a href="reclamos/planillas/listar"><i class="fa fa-circle-o"></i>Planillas</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		if (in_groups($grupos_admin, $grupos) || in_groups($grupos_expedientes_admin, $grupos))
		{
			$nav .= '<li class="treeview' . $expedientes_active . '">';
			$nav .= '<a href="#"><i class="fa fa-file-text"></i> <span>Expedientes</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/firmas/bandeja"><i class="fa fa-circle-o"></i>Bandeja de Firmas</a></li>';
			$nav .= '<li><a href="expedientes/firmas/revision_archivos"><i class="fa fa-circle-o"></i>Revisión de archivos</a></li>';
			$nav .= '<li' . $expedientes_expedientes_active . '><a href="#"><i class="fa fa-circle-o"></i>Expedientes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/expedientes/iniciar"><i class="fa fa-circle-o"></i>Iniciar expediente</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar"><i class="fa fa-circle-o"></i>Buscar expediente</a></li>';
			$nav .= '<li><a href="expedientes/personas/listar"><i class="fa fa-circle-o"></i>Buscar persona</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_acumulados"><i class="fa fa-circle-o"></i>Acumulados</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			//$nav .= '<li><a href="expedientes/expedientes/listar_ayuda_social"><i class="fa fa-circle-o"></i>De Ayuda Social</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_pases_active . '><a href="#"><i class="fa fa-circle-o"></i>Pases<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_r"><i class="fa fa-circle-o"></i>Pendientes de recepción</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_e"><i class="fa fa-circle-o"></i>Pendientes de emisión</a></li>';
                        $nav .= '<li><a href="expedientes/pases/listar_pendientes_ee"><i class="fa fa-circle-o"></i>Expedientes electronicos</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_enviados_sinr"><i class="fa fa-circle-o"></i>Enviados sin recepción</a></li>';
			$nav .= '<li' . $expedientes_pases_active . '><a href="#"><i class="fa fa-circle-o"></i>Tickets<i class="fa fa-angle-left pull-right"></i></a>';	
					$nav .= '<ul class="treeview-menu">';
					$nav .= '<li><a href="expedientes/pases/listar_tickets_e"><i class="fa fa-circle-o"></i>Exps. emitidos</a></li>';
					$nav .= '<li><a href="expedientes/pases/listar_tickets_r"><i class="fa fa-circle-o"></i>Exps. recepcionados</a></li>';
					$nav .= '</ul>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_administracion_active . '><a href="#"><i class="fa fa-circle-o"></i>Administración<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/cargos/listar"><i class="fa fa-circle-o"></i>Cargos</a></li>';
			$nav .= '<li><a href="expedientes/informes_infogov/listar"><i class="fa fa-circle-o"></i>Informes Infogov</a></li>';
			$nav .= '<li><a href="expedientes/oficinas/listar"><i class="fa fa-circle-o"></i>Oficinas y Secretarías</a></li>';
			$nav .= '<li><a href="expedientes/plantillas/listar"><i class="fa fa-circle-o"></i>Plantillas para trámites</a></li>';
			$nav .= '<li><a href="expedientes/tramites/listar"><i class="fa fa-circle-o"></i>Trámites</a></li>';
			$nav .= '<li><a href="expedientes/formularios/listar"><i class="fa fa-circle-o"></i>Formularios</a></li>';
			$nav .= '<li><a href="expedientes/consultas/listar"><i class="fa fa-circle-o"></i>Consultas</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_estadisticas_active . '><a href="#"><i class="fa fa-circle-o"></i>Estadísticas<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/estadisticas/pases_oficina_usuario"><i class="fa fa-circle-o"></i>Pases por Oficina/Usuario</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/pases_usuario"><i class="fa fa-circle-o"></i>Pases por Usuario</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/pases_pendientes"><i class="fa fa-circle-o"></i>Pases pendientes por Oficina</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/expedientes_tipo"><i class="fa fa-circle-o"></i>Expedientes por Trámite</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		elseif (in_groups($grupos_expedientes_supervision, $grupos))
		{
			$nav .= '<li class="treeview' . $expedientes_active . '">';
			$nav .= '<a href="#"><i class="fa fa-file-text"></i> <span>Expedientes</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/firmas/bandeja"><i class="fa fa-circle-o"></i>Bandeja de Firmas</a></li>';
			$nav .= '<li><a href="expedientes/firmas/revision_archivos"><i class="fa fa-circle-o"></i>Revisión de archivos</a></li>';
			$nav .= '<li' . $expedientes_expedientes_active . '><a href="#"><i class="fa fa-circle-o"></i>Expedientes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/expedientes/iniciar"><i class="fa fa-circle-o"></i>Iniciar expediente</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar"><i class="fa fa-circle-o"></i>Buscar expediente</a></li>';
			$nav .= '<li><a href="expedientes/personas/listar"><i class="fa fa-circle-o"></i>Buscar persona</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_acumulados"><i class="fa fa-circle-o"></i>Acumulados</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			//$nav .= '<li><a href="expedientes/expedientes/listar_ayuda_social"><i class="fa fa-circle-o"></i>De Ayuda Social</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_pases_active . '><a href="#"><i class="fa fa-circle-o"></i>Pases<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_r"><i class="fa fa-circle-o"></i>Pendientes de recepción</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_e"><i class="fa fa-circle-o"></i>Pendientes de emisión</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_ee"><i class="fa fa-circle-o"></i>Expedientes electronicos</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_enviados_sinr"><i class="fa fa-circle-o"></i>Enviados sin recepción</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_estadisticas_active . '><a href="#"><i class="fa fa-circle-o"></i>Estadísticas<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/estadisticas/pases_oficina_usuario"><i class="fa fa-circle-o"></i>Pases por Oficina/Usuario</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/pases_usuario"><i class="fa fa-circle-o"></i>Pases por Usuario</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/pases_pendientes"><i class="fa fa-circle-o"></i>Pases pendientes por Oficina</a></li>';
			$nav .= '<li><a href="expedientes/estadisticas/expedientes_tipo"><i class="fa fa-circle-o"></i>Expedientes por Trámite</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		elseif (in_groups($grupos_expedientes_usuario, $grupos))
		{
			$nav .= '<li class="treeview' . $expedientes_active . '">';
			$nav .= '<a href="#"><i class="fa fa-file-text"></i> <span>Expedientes</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/firmas/bandeja"><i class="fa fa-circle-o"></i>Bandeja de Firmas</a></li>';
			$nav .= '<li><a href="expedientes/firmas/revision_archivos"><i class="fa fa-circle-o"></i>Revisión de archivos</a></li>';
			$nav .= '<li' . $expedientes_expedientes_active . '><a href="#"><i class="fa fa-circle-o"></i>Expedientes<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/expedientes/iniciar"><i class="fa fa-circle-o"></i>Iniciar expediente</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar"><i class="fa fa-circle-o"></i>Buscar expediente</a></li>';
			$nav .= '<li><a href="expedientes/personas/listar"><i class="fa fa-circle-o"></i>Buscar persona</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_acumulados"><i class="fa fa-circle-o"></i>Acumulados</a></li>';
			$nav .= '<li><a href="expedientes/expedientes/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			//$nav .= '<li><a href="expedientes/expedientes/listar_ayuda_social"><i class="fa fa-circle-o"></i>De Ayuda Social</a></li>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '<li' . $expedientes_pases_active . '><a href="#"><i class="fa fa-circle-o"></i>Pases<i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_r"><i class="fa fa-circle-o"></i>Pendientes de recepción</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_e"><i class="fa fa-circle-o"></i>Pendientes de emisión</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_pendientes_ee"><i class="fa fa-circle-o"></i>Expedientes electronicos</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_archivados"><i class="fa fa-circle-o"></i>Archivados</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_enviados_sinr"><i class="fa fa-circle-o"></i>Enviados sin recepción</a></li>';
			$nav .= '<li' . $expedientes_pases_active . '><a href="#"><i class="fa fa-circle-o"></i>Tickets<i class="fa fa-angle-left pull-right"></i></a>';	
			$nav .= '<ul class="treeview-menu">';
			$nav .= '<li><a href="expedientes/pases/listar_tickets_e"><i class="fa fa-circle-o"></i>Exps. emitidos</a></li>';
			$nav .= '<li><a href="expedientes/pases/listar_tickets_r"><i class="fa fa-circle-o"></i>Exps. recepcionados</a></li>';
			$nav .= '</ul>';
			$nav .= '</ul>';
			$nav .= '</li>';
			$nav .= '</ul>';
			$nav .= '</li>';
		}
		if (in_groups($grupos_admin, $grupos) || in_groups($grupos_reclamos_admin, $grupos))
		{
			$nav .= '<li class="treeview' . $requerimientos_active . '">';
			$nav .= '<a href="requerimientos/listar"><i class="fa fa-archive"></i> <span>Requerimientos</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '</li>';
		} else {
			$nav .= '<li class="treeview' . $requerimientos_active . '">';
			$nav .= '<a href="requerimientos/listar_personales"><i class="fa fa-archive"></i> <span>Requerimientos</span> <i class="fa fa-angle-left pull-right"></i></a>';
			$nav .= '</li>';
		}
		return $nav;
	}
}

if (!function_exists('load_permisos_escritorio'))
{

	function load_permisos_escritorio($grupos)
	{
		$accesos = '';
		$grupos_admin = array('admin');
		$grupos_reclamos = array('reclamos_admin', 'reclamos_coordinador', 'reclamos_usuario', 'reclamos_distrito', 'reclamos_consulta_general');
		$grupos_expedientes = array('expedientes_admin', 'expedientes_consulta_general');
		if (in_groups($grupos_admin, $grupos))
		{
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/escritorio"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-android-warning"></i></span><div class="info-box-content"><span class="info-box-number">Módulo Reclamos</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/escritorio"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-document-text"></i></span><div class="info-box-content"><span class="info-box-number">Módulo Expedientes</span></div></div></a></div>';
		}
		else
		{
			if (in_groups($grupos_reclamos, $grupos))
			{
				$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/escritorio"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-android-warning"></i></span><div class="info-box-content"><span class="info-box-number">Módulo Reclamos</span></div></div></a></div>';
			}
			if (in_groups($grupos_expedientes, $grupos))
			{
				$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/escritorio"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-document-text"></i></span><div class="info-box-content"><span class="info-box-number">Módulo Expedientes</span></div></div></a></div>';
			}
		}
		return $accesos;
	}
}

if (!function_exists('load_permisos_escritorio_reclamos'))
{

	function load_permisos_escritorio_reclamos($grupos)
	{
		$accesos = '';
		$grupos_reclamos_admin = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$grupos_reclamos_coordinador = array('reclamos_coordinador');
		$grupos_reclamos_general = array('reclamos_usuario', 'reclamos_distrito');
		if (in_groups($grupos_reclamos_admin, $grupos) || in_groups($grupos_reclamos_coordinador, $grupos))
		{
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/encuestas/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-thumbsup"></i></span><div class="info-box-content"><span class="info-box-number">Encuestas</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/reclamos/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-android-warning"></i></span><div class="info-box-content"><span class="info-box-number">Reclamos</span></div></div></a></div>';
			$accesos.= '<div class="clearfix visible-sm-block"></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/mapa"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-ios-location"></i></span><div class="info-box-content"><span class="info-box-number">Mapa</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/graficos/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-ios-paper"></i></span><div class="info-box-content"><span class="info-box-number">Gráficos</span></div></div></a></div>';
		}
		if (in_groups($grupos_reclamos_general, $grupos))
		{
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/reclamos/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-android-warning"></i></span><div class="info-box-content"><span class="info-box-number">Reclamos</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/mapa"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-ios-location"></i></span><div class="info-box-content"><span class="info-box-number">Mapa</span></div></div></a></div>';
			$accesos.= '<div class="clearfix visible-sm-block"></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="reclamos/graficos/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-ios-paper"></i></span><div class="info-box-content"><span class="info-box-number">Gráficos</span></div></div></a></div>';
		}
		return $accesos;
	}
}

if (!function_exists('load_permisos_escritorio_expedientes'))
{

	function load_permisos_escritorio_expedientes($grupos)
	{
		$accesos = '';
		$grupos_expedientes_admin = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
		if (in_groups($grupos_expedientes_admin, $grupos))
		{
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/firmas/bandeja"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-document-text"></i></span><div class="info-box-content"><span class="info-box-number">Bandeja de Firmas</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/expedientes/iniciar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-document-text"></i></span><div class="info-box-content"><span class="info-box-number">Iniciar Expediente</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/expedientes/listar"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-search"></i></span><div class="info-box-content"><span class="info-box-number">Buscar Expediente</span></div></div></a></div>';
			$accesos.= '<div class="clearfix visible-sm-block"></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/pases/listar_pendientes_r"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-archive"></i></span><div class="info-box-content"><span class="info-box-number">Pendiente recepción</span></div></div></a></div>';
			$accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/pases/listar_pendientes_e"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-share"></i></span><div class="info-box-content"><span class="info-box-number">Pendiente emisión</span></div></div></a></div>';
                        $accesos.= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><a href="expedientes/pases/listar_pendientes_ee"><div class="info-box info-box-lavalle"><span class="info-box-icon bg-lavalle"><i class="ion ion-document-text"></i></span><div class="info-box-content"><span class="info-box-number">Expedientes electronicos</span></div></div></a></div>';
		}
		return $accesos;
	}
}
/* End of file permisos_helper.php */
/* Location: ./application/helpers/permisos_helper.php */