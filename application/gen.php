<?php

$DB_SCHEMA = "sigmu";
$DB_USER = "root";
$DB_PASSWORD = "";
$MODULE_TITLE = "Expedientes";
$MODULE_PATH = "expedientes";
$TBL_PREFIX = '';
$MODULES_ENABLED = TRUE;
$TABLES = array(//table, t_n, t_1, n_name, 1_name, género, columna_descripcion
//	'ajustestock' => array('ajustestock', 'ajustes_stock', 'ajuste_stock', 'Ajustes de stock', 'Ajuste de stock', '', 'observacion'),
	'archivoadjunto' => array('archivoadjunto', 'archivos_adjuntos', 'archivo_adjunto', 'Archivos adjuntos', 'Archivo adjunto', '', 'nombre'),
	'aviso' => array('aviso', 'avisos', 'aviso', 'Avisos', 'Aviso', '', 'mensaje'),
	'ayuda_social' => array('ayuda_social', 'ayudas_sociales', 'ayuda_social', 'Ayudas sociales', 'Ayuda social', 'a', 'descripcion'),
	'expediente' => array('expediente', 'expedientes', 'expediente', 'Expedientes', 'Expediente', '', 'caratula'),
	'formulario' => array('formulario', 'formularios', 'formulario', 'Formularios', 'Formulario', '', 'nombre'),
//	'inmueble' => array('inmueble', 'inmuebles', 'inmueble', 'Inmuebles', 'Inmueble', '', 'CodiInmu'),
	'nivel' => array('nivel', 'niveles', 'nivel', 'Niveles', 'Nivel', '', 'DESCRIPCION'),
	'nivel_permiso' => array('nivel_permiso', 'permisos_niveles', 'permiso_nivel', 'Permisos de niveles', 'Permiso de nivel', '', 'id'),
	'notapase' => array('notapase', 'notas_pases', 'nota_pase', 'Notas de pases', 'Nota de pase', 'a', 'id'),
	'oficina' => array('oficina', 'oficinas', 'oficina', 'Oficinas', 'Oficina', 'a', 'nombre'),
	'pase' => array('pase', 'pases', 'pase', 'Pases', 'Pase', '', 'id'),
	'permiso' => array('permiso', 'permisos', 'permiso', 'Permisos', 'Permiso', '', 'nombre'),
	'persona'=>array('persona', 'personas', 'persona', 'Personas', 'Persona', 'a', 'DetaPers'),
	'plantilla' => array('plantilla', 'plantillas', 'plantilla', 'Plantillas', 'Plantilla', 'a', 'nombre'),
	'tipo_ayuda_social' => array('tipo_ayuda_social', 'tipos_ayudas_sociales', 'tipo_ayuda_social', 'Tipos de ayudas sociales', 'Tipo de ayuda social', '', 'nombre'),
	'tramite' => array('tramite', 'tramites', 'tramite', 'Trámites', 'Trámite', '', 'nombre'),
	'tramites_formularios' => array('tramites_formularios', 'formularios_tramites', 'formulario_tramite', 'Formularios de trámites', 'Formulario de trámite', '', 'formulario_id'),
	'usuario' => array('usuario', 'usuarios', 'usuario', 'Usuarios', 'Usuario', '', 'username'),
	'usuario_nivel' => array('usuario_nivel', 'niveles_usuarios', 'nivel_usuario', 'Niveles de usuarios', 'Nivel de usuario', '', 'ID'),
	'usuario_oficina' => array('usuario_oficina', 'oficinas_usuarios', 'oficina_usuario', 'Oficinas de usuarios', 'Oficina de usuario', 'a', 'ID'),
);

if (!is_dir("modules"))
	mkdir("modules");
if (!is_dir("modules/$MODULE_PATH"))
	mkdir("modules/$MODULE_PATH");
if (!is_dir("modules/$MODULE_PATH/controllers"))
	mkdir("modules/$MODULE_PATH/controllers");
if (!is_dir("modules/$MODULE_PATH/models"))
	mkdir("modules/$MODULE_PATH/models");
if (!is_dir("modules/$MODULE_PATH/views"))
	mkdir("modules/$MODULE_PATH/views");

$model_location = "modules/$MODULE_PATH/models";
$controller_location = "modules/$MODULE_PATH/controllers";

foreach ($TABLES as $row)
{
	if($row[0]==='persona')
		continue;
// <editor-fold defaultstate="collapsed" desc="Proceso">
	set_time_limit(300);
	$db_table = $TBL_PREFIX . $row[0];
	$table = $row[1];
	$table_1 = $row[2];
	$object_name = $row[3];
	$msg_name = $row[4];

	$controller_file_name = strtoupper(substr($table, 0, 1)) . substr($table, 1);
	$model_file_name = $controller_file_name . "_model";
	$multiple = strpos($table, '_');
	if (!empty($row[5]))
	{
		$art_1 = 'a';
		$art_2 = 'la';
	}
	else
	{
		$art_1 = 'o';
		$art_2 = 'el';
	}
	$mysqli = new mysqli("localhost", $DB_USER, $DB_PASSWORD, $DB_SCHEMA, 3306);
	if ($mysqli->connect_errno)
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

	$rs = $mysqli->query("SELECT C.COLUMN_NAME AS Field, C.COLUMN_TYPE AS Type, C.IS_NULLABLE AS 'Null', C.COLUMN_KEY AS 'Key', C.COLUMN_DEFAULT AS 'Default', C.EXTRA AS Extra, FK.REFERENCED_TABLE_NAME AS FK_Table, FK.REFERENCED_COLUMN_NAME AS FK_Column"
		. " FROM INFORMATION_SCHEMA.COLUMNS C"
		. " LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE FK ON C.TABLE_NAME=FK.TABLE_NAME AND C.COLUMN_NAME=FK.COLUMN_NAME AND C.TABLE_SCHEMA=FK.REFERENCED_TABLE_SCHEMA"
		. " WHERE C.TABLE_SCHEMA='$DB_SCHEMA' AND C.TABLE_NAME='$db_table'"
		. " ORDER BY C.ORDINAL_POSITION");

	$model_columnas = "array(";
	$model_fields = "array(";
	$model_requeridos = "array(";
	$controller_list_columns = "";
	$controller_datos_list_join = "";
	$controller_datos_list_columns = "";
	$controller_load_models = "";
	$controller_array_control_combos_agregar = "";
	$controller_array_control_combos_editar = "";
	$controller_array_control_combos_ver = "";
	$controller_query_create = "";
	$controller_query_update = "";
	$pk_name = "";
	$pk_name_nq = "";
	print_r("Tabla $table - $rs->num_rows columnas\n");
	while ($record = $rs->fetch_object())
	{
		//Model
		$field_name = $record->Field;
		$field_name_no_id = substr($field_name, -3) == '_id' ? substr($field_name, 0, -3) : $field_name;
		$field_auto_increment = strpos($record->Extra, 'auto_increment') !== false;

		if (strpos($field_name_no_id, '_') === FALSE)
		{
			$field_label = strtoupper(substr($field_name_no_id, 0, 1)) . substr($field_name_no_id, 1);
		}
		else
		{
			$names = explode('_', $field_name_no_id);
			$names[0] = strtoupper(substr($names[0], 0, 1)) . substr($names[0], 1);
			$names[1] = strtoupper(substr($names[1], 0, 1)) . substr($names[1], 1);
			$field_label = $names[0] . ' de ' . $names[1];
		}

		if ($record->Key !== "PRI" || !$field_auto_increment)
		{
			$model_fields.="
			array('name' => '$field_name_no_id', 'label' => '$field_label'";
			if (substr($field_name, -3) === '_id')
				$model_fields.=", 'input_type' => 'combo', 'id_name' => '$field_name'";
			else
			{
				if (strpos($record->Type, 'int') !== false)
				{
					$model_fields.=", 'type' => 'integer'";
					if (preg_match('!\(([^\)]+)\)!', $record->Type, $match))
					{
						$size = $match[1];
						$model_fields.=", 'maxlength' => '$size'";
					}
				}
				elseif (strpos($record->Type, 'char(') !== false)
				{
					if (preg_match('!\(([^\)]+)\)!', $record->Type, $match))
					{
						$size = $match[1];
						$model_fields.=", 'maxlength' => '$size'";
					}
				}
				elseif (strpos($record->Type, 'date') !== false)
				{
					$model_fields.=", 'type' => 'date'";
				}
			}

			if ($record->Null === "NO")
			{
				$model_requeridos.="'$record->Field', ";
				$model_fields.=", 'required' => TRUE";
			}
			$model_fields.="),";
		}
		$model_columnas.="'$record->Field', ";

		//Controller + Views

		$controller_datos_list_columns.="$db_table.$field_name, ";

		$align = 'left';
		$formatter = '';
		if ($record->Key == "PRI")
		{
			$pk_name = "'$field_name'";
			$pk_name_nq = "$field_name";
			if (strpos($record->Type, 'int') !== false)
				$align = 'right';
		}
		if ($record->Key !== "PRI" || !$field_auto_increment)
		{
			if (strpos($record->Type, 'date') !== false)
			{
				$controller_query_create.="
					'$field_name' => date_format(new DateTime(\$this->input->post('$field_name_no_id')), 'Y-m-d'),";
				$controller_query_update.="
						'$field_name' => date_format(new DateTime(\$this->input->post('$field_name_no_id')), 'Y-m-d'),";
			}
			else
			{
				$controller_query_create.="
					'$field_name' => \$this->input->post('$field_name_no_id'),";
				if ($record->Key !== "PRI")
					$controller_query_update.="
						'$field_name' => \$this->input->post('$field_name_no_id'),";
			}
			if (strpos($record->Type, 'int') !== false && substr($field_name, -3) !== '_id')
				$align = 'right';
			elseif (strpos($record->Type, 'date') !== false)
				$formatter = ", 'formatter' => 'datetime'";
		}
		if (empty($record->FK_Table))
			$controller_list_columns.="
					array('label' => '$field_label', 'data' => '$field_name', 'sort' => '$db_table.$field_name', 'width' => 10),";
		else
			$controller_list_columns.="
					array('label' => '$field_label', 'data' => '$field_name_no_id', 'sort' => '$record->FK_Table.{$TABLES[$record->FK_Table][6]}', 'width' => 10),";
	}
	$model_columnas = substr($model_columnas, 0, strlen($model_columnas) - 2);
	$model_columnas.=")";
	$model_fields = substr($model_fields, 0, strlen($model_fields) - 1);
	$model_fields.="
		)";
	if ($model_requeridos != 'array(')
		$model_requeridos = substr($model_requeridos, 0, strlen($model_requeridos) - 2);
	$model_requeridos.=")";
	$controller_query_create = substr($controller_query_create, 0, strlen($controller_query_create) - 1);
	$controller_query_update = substr($controller_query_update, 0, strlen($controller_query_update) - 1);
	$can_delete_fn = "";
	$rs->close();
	$rs_ref_fk = $mysqli->query("SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME" .
		" FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE" .
		" WHERE REFERENCED_TABLE_SCHEMA = '$DB_SCHEMA'" .
		" AND REFERENCED_TABLE_NAME='$db_table'" .
		" ORDER BY TABLE_NAME, COLUMN_NAME");
	while ($row = $rs_ref_fk->fetch_object())
	{
		$t_name = str_replace('_', ' de ', str_replace($TBL_PREFIX, '', $row->TABLE_NAME));
		$can_delete_fn.="
		if (\$this->db->where('$row->COLUMN_NAME', \$delete_id)->count_all_results('$row->TABLE_NAME') > 0)
		{
			\$this->_set_error('No se ha podido eliminar el registro de ' . \$this->msg_name . '. Verifique que no esté asociado a $t_name.');
			return FALSE;
		}";
	}
	$rs_ref_fk->close();
	$rs_fk = $mysqli->query("SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME" .
		" FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE" .
		" WHERE REFERENCED_TABLE_SCHEMA = '$DB_SCHEMA'" .
		" AND TABLE_NAME='$db_table'" .
		" ORDER BY REFERENCED_TABLE_NAME, COLUMN_NAME");
	while ($row = $rs_fk->fetch_object())
	{
		$t_name = str_replace($TBL_PREFIX, '', $row->TABLE_NAME);
		$c_name = str_replace('_id', '', $row->COLUMN_NAME);
		$r_t_name = str_replace($TBL_PREFIX, '', $row->REFERENCED_TABLE_NAME);
		$controller_datos_list_join.="
				->join(\"\$this->sigmu_schema.$row->REFERENCED_TABLE_NAME\", '$row->REFERENCED_TABLE_NAME.id = $row->TABLE_NAME.$row->COLUMN_NAME', 'left')";
		$controller_datos_list_columns.= "$row->REFERENCED_TABLE_NAME.{$TABLES[$r_t_name][6]} as $c_name, ";
		$controller_load_models.="
			\$this->load->model('$MODULE_PATH/{$TABLES[$r_t_name][1]}_model');";
		$controller_array_control_combos_agregar.="
			\$this->array_{$c_name}_control = \$array_{$c_name} = \$this->get_array('{$TABLES[$r_t_name][1]}', '{$TABLES[$r_t_name][6]}', 'id', null, array(0 => '-- Seleccionar $c_name --'));
			unset(\$this->array_{$c_name}_control[0]);";
		$controller_array_control_combos_editar.="
			\$this->array_{$c_name}_control = \$array_{$c_name} = \$this->get_array('{$TABLES[$r_t_name][1]}', '{$TABLES[$r_t_name][6]}');";
		$controller_array_control_combos_ver.="
			\$array_{$c_name} = \$this->get_array('{$TABLES[$r_t_name][1]}', '{$TABLES[$r_t_name][6]}');";
	}
	$controller_datos_list_columns=substr($controller_datos_list_columns, 0, strlen($controller_datos_list_columns)-2);
	$rs_fk->close();

	$views_location = "modules/$MODULE_PATH/views/$table";

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Archivo Modelo">
	$model_content = "<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class $model_file_name extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		\$this->sigmu_schema = \$this->config->item('sigmu_schema');
		\$this->table_name = \"\$this->sigmu_schema.$db_table\";
		\$this->msg_name = '$msg_name';
		\$this->id_name = $pk_name;
		\$this->columnas = $model_columnas;
		\$this->fields = $model_fields;
		\$this->requeridos = $model_requeridos;
		//\$this->unicos = array();
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int \$delete_id
	 * @return bool
	 */
	protected function _can_delete(\$delete_id)
	{{$can_delete_fn}
		return TRUE;
	}
}
/* End of file $model_file_name.php */
/* Location: ./application/$model_location/$model_file_name.php */";

	$fp = fopen("$model_location/$model_file_name.php", "w");
	fwrite($fp, ($model_content));
	fclose($fp);

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Archivo Controlador">
	$controller_content = "<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class $controller_file_name extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		\$this->sigmu_schema = \$this->config->item('sigmu_schema');
		\$this->load->model('$MODULE_PATH/{$table}_model');
		\$this->grupos_permitidos = array('admin', '{$MODULE_PATH}_admin', '{$MODULE_PATH}_consulta_general');
		\$this->grupos_solo_consulta = array('{$MODULE_PATH}_consulta_general');
	}

	public function listar()
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos))
		{
			\$tableData = array(
				'columns' => array(//@todo arreglar anchos de columnas$controller_list_columns
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => '{$table}_table',
				'source_url' => '$MODULE_PATH/$table/listar_data'
			);
			\$data['html_table'] = buildHTML(\$tableData);
			\$data['js_table'] = buildJS(\$tableData);
			\$data['error'] = \$this->session->flashdata('error');
			\$data['message'] = \$this->session->flashdata('message');
			\$data['title'] = '$MODULE_TITLE - $object_name';
			\$this->load_template('$MODULE_PATH/$table/{$table}_listar', \$data);
		}
		else
		{
			show_404();
		}
	}

	public function listar_data()
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos))
		{
			\$this->datatables
				->select('$controller_datos_list_columns')
				->unset_column('id')
				->from(\"\$this->sigmu_schema.$db_table\")$controller_datos_list_join
				->add_column('edit', '<a href=\"$MODULE_PATH/$table/ver/$1\" title=\"Administrar\"><i class=\"fa fa-cogs\"></i></a>', 'id');

			echo \$this->datatables->generate();
		}
		else
		{
			show_404();
		}
	}

	public function agregar()
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos))
		{
			if (in_groups(\$this->grupos_solo_consulta, \$this->grupos))
			{
				\$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect(\"$MODULE_PATH/$table/listar\", 'refresh');
			}{$controller_load_models}{$controller_array_control_combos_agregar}
			\$this->set_model_validation_rules(\$this->{$table}_model);
			if (\$this->form_validation->run() === TRUE)
			{
				\$trans_ok = TRUE;
				\$trans_ok&= \$this->{$table}_model->create(array($controller_query_create));

				if (\$trans_ok)
				{
					\$this->session->set_flashdata('message', \$this->{$table}_model->get_msg());
					redirect('$MODULE_PATH/$table/listar', 'refresh');
				}
			}
			\$data['error'] = (validation_errors() ? validation_errors() : (\$this->{$table}_model->get_error() ? \$this->{$table}_model->get_error() : \$this->session->flashdata('error')));

			\$data['fields'] = array();
			foreach (\$this->{$table}_model->fields as \$field)
			{
				if (empty(\$field['input_type']))
				{
					\$this->add_input_field(\$data['fields'], \$field);
				}
				elseif (\$field['input_type'] === 'combo')
				{
					if (isset(\$field['type']) && \$field['type'] === 'multiple')
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${'current_' . \$field['name']});
					}
					else
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']});
					}
				}
			}

			\$data['txt_btn'] = 'Agregar';
			\$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
			\$data['title'] = '$MODULE_TITLE - Agregar $table_1';
			\$this->load_template('$MODULE_PATH/$table/{$table}_abm', \$data);
		}
		else
		{
			show_404();
		}
	}

	public function editar(\$id = NULL)
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos) && \$id !== NULL && ctype_digit(\$id))
		{
			if (in_groups(\$this->grupos_solo_consulta, \$this->grupos))
			{
				\$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect(\"$MODULE_PATH/$table/ver/\$id\", 'refresh');
			}
			\$$table_1 = \$this->{$table}_model->get(array($pk_name => \$id));
			if (empty(\$$table_1))
			{
				show_404();
			}{$controller_load_models}{$controller_array_control_combos_editar}
			\$this->set_model_validation_rules(\$this->{$table}_model);
			if (isset(\$_POST) && !empty(\$_POST))
			{
				if (\$id !== \$this->input->post($pk_name))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if (\$this->form_validation->run() === TRUE)
				{
					\$trans_ok = TRUE;
					\$trans_ok&= \$this->{$table}_model->update(array(
						$pk_name => \$this->input->post($pk_name),$controller_query_update));
					if (\$trans_ok)
					{
						\$this->session->set_flashdata('message', \$this->{$table}_model->get_msg());
						redirect('$MODULE_PATH/$table/listar', 'refresh');
					}
				}
			}
			\$data['error'] = (validation_errors() ? validation_errors() : (\$this->{$table}_model->get_error() ? \$this->{$table}_model->get_error() : \$this->session->flashdata('error')));

			\$data['fields'] = array();
			foreach (\$this->{$table}_model->fields as \$field)
			{
				if (empty(\$field['input_type']))
				{
					\$this->add_input_field(\$data['fields'], \$field, \${$table_1}->{\$field['name']});
				}
				elseif (\$field['input_type'] === 'combo')
				{
					if (isset(\$field['type']) && \$field['type'] === 'multiple')
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${'current_' . \$field['name']});
					}
					else
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${$table_1}->{isset(\$field['id_name']) ? \$field['id_name'] : \$field['name']});
					}
				}
			}
			\$data['$table_1'] = \$$table_1;

			\$data['txt_btn'] = 'Editar';
			\$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			\$data['title'] = '$MODULE_TITLE - Editar $table_1';
			\$this->load_template('$MODULE_PATH/$table/{$table}_abm', \$data);
		}
		else
			show_404();
	}

	public function eliminar(\$id = NULL)
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos) && \$id !== NULL && ctype_digit(\$id))
		{
			if (in_groups(\$this->grupos_solo_consulta, \$this->grupos))
			{
				\$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect(\"$MODULE_PATH/$table/ver/\$id\", 'refresh');
			}
			\$$table_1 = \$this->{$table}_model->get(array($pk_name => \$id));
			if (empty(\$$table_1))
			{
				show_404();
			}" . (empty($controller_load_models . $controller_array_control_combos_ver) ? "" : "
" . $controller_load_models . $controller_array_control_combos_ver) . "
			if (isset(\$_POST) && !empty(\$_POST))
			{
				if (\$id !== \$this->input->post($pk_name))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				\$trans_ok = TRUE;
				\$trans_ok&= \$this->{$table}_model->delete(array($pk_name => \$this->input->post($pk_name)));
				if (\$trans_ok)
				{
					\$this->session->set_flashdata('message', \$this->{$table}_model->get_msg());
					redirect('$MODULE_PATH/$table/listar', 'refresh');
				}
			}
			\$data['error'] = (validation_errors() ? validation_errors() : (\$this->{$table}_model->get_error() ? \$this->{$table}_model->get_error() : \$this->session->flashdata('error')));

			\$data['fields'] = array();
			foreach (\$this->{$table}_model->fields as \$field)
			{
				\$field['disabled'] = TRUE;
					if (empty(\$field['input_type']))
					{
							\$this->add_input_field(\$data['fields'], \$field, \${$table_1}->{\$field['name']});
					}
					elseif (\$field['input_type'] == 'combo')
					{
						if (isset(\$field['type']) && \$field['type'] === 'multiple')
						{
							\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${'current_' . \$field['name']});
						}
						else
						{
							\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${$table_1}->{isset(\$field['id_name']) ? \$field['id_name'] : \$field['name']});
						}
				}
			}

			\$data['{$table_1}'] = \${$table_1};

			\$data['txt_btn'] = 'Eliminar';
			\$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			\$data['title'] = '$MODULE_TITLE - Eliminar $table_1';
			\$this->load_template('$MODULE_PATH/$table/{$table}_abm', \$data);
		}
		else
		{
			show_404();
		}
	}

	public function ver(\$id = NULL)
	{
		if (in_groups(\$this->grupos_permitidos, \$this->grupos) && \$id !== NULL && ctype_digit(\$id))
		{
			\$$table_1 = \$this->{$table}_model->get(array($pk_name => \$id));
			if (empty(\$$table_1))
			{
				show_404();
			}" . (empty($controller_load_models . $controller_array_control_combos_ver) ? "" : "
" . $controller_load_models . $controller_array_control_combos_ver) . "
			\$data['error'] = \$this->session->flashdata('error');

			\$data['fields'] = array();
			foreach (\$this->{$table}_model->fields as \$field)
			{
				\$field['disabled'] = TRUE;
				if (empty(\$field['input_type']))
				{
					\$this->add_input_field(\$data['fields'], \$field, \${$table_1}->{\$field['name']});
				}
				elseif (\$field['input_type'] == 'combo')
				{
					if (isset(\$field['type']) && \$field['type'] === 'multiple')
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${'current_' . \$field['name']});
					}
					else
					{
						\$this->add_combo_field(\$data['fields'], \$field, \${'array_' . \$field['name']}, \${$table_1}->{isset(\$field['id_name']) ? \$field['id_name'] : \$field['name']});
					}
				}
			}

			\$data['{$table_1}'] = \${$table_1};
			\$data['txt_btn'] = NULL;
			\$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			\$data['title'] = '$MODULE_TITLE - Ver $table_1';
			\$this->load_template('$MODULE_PATH/$table/{$table}_abm', \$data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file $controller_file_name.php */
/* Location: ./application/$controller_location/$controller_file_name.php */";

	$fp = fopen("$controller_location/$controller_file_name.php", "w");
	fwrite($fp, ($controller_content));
	fclose($fp);

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Archivo View List">
	$content_listar = "<div class=\"content-wrapper\">
	<section class=\"content-header\">
		<h1>
			$object_name
		</h1>
		<ol class=\"breadcrumb\">
			<li><a href=\"\"><i class=\"fa fa-home\"></i> Inicio</a></li>
			<li><a href=\"$MODULE_PATH/<?php echo \$controlador; ?>\"><?php echo ucfirst(\$controlador); ?></a></li>
			<li class=\"active\"><?php echo ucfirst(\$metodo); ?></li>
		</ol>
	</section>
	<section class=\"content\">
		<?php if (!empty(\$error)) : ?>
			<div class=\"alert alert-danger alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				<h4><i class=\"icon fa fa-ban\"></i> Error!</h4>
				<?php echo \$error; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty(\$message)) : ?>
			<div class=\"alert alert-success alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				<h4><i class=\"icon fa fa-check\"></i> OK!</h4>
				<?php echo \$message; ?>
			</div>
		<?php endif; ?>
		<div class=\"row\">
			<div class=\"col-xs-12\">
				<div class=\"box box-primary\">
					<div class=\"box-header with-border\">
						<h3 class=\"box-title\">Listado de $table</h3>
						<div class=\"box-tools pull-right\">
							<button class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
						</div>
					</div>
					<div class=\"box-body\">
						<?php echo \$js_table; ?>
						<?php echo \$html_table; ?>
					</div>
					<div class=\"box-footer\">
						<a class=\"btn btn-primary pull-right\" href=\"$MODULE_PATH/$table/agregar\" title=\"Agregar $table_1\">Agregar $table_1</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>";

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Archivo View Content">
	$content_abm = "<div class=\"content-wrapper\">
	<section class=\"content-header\">
		<h1>
			$object_name
		</h1>
		<ol class=\"breadcrumb\">
			<li><a href=\"\"><i class=\"fa fa-home\"></i> Inicio</a></li>
			<li><a href=\"<?php echo \$controlador; ?>\"><?php echo ucfirst(\$controlador); ?></a></li>
			<li class=\"active\"><?php echo ucfirst(\$metodo); ?></li>
		</ol>
	</section>
	<section class=\"content\">
		<?php if (!empty(\$error)) : ?>
			<div class=\"alert alert-danger alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				<h4><i class=\"icon fa fa-ban\"></i> Error!</h4>
				<?php echo \$error; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty(\$message)) : ?>
			<div class=\"alert alert-success alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				<h4><i class=\"icon fa fa-check\"></i> OK!</h4>
				<?php echo \$message; ?>
			</div>
		<?php endif; ?>
		<div class=\"row\">
			<div class=\"col-xs-12\">
				<div class=\"box box-primary\">
					<div class=\"box-header with-border\">
						<h3 class=\"box-title\">Administración de $table_1</h3>
						<div class=\"box-tools pull-right\">
							<button class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
						</div>
					</div>
					<?php \$data_submit = array('class' => 'btn btn-primary pull-right', 'title' => \$txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class=\"box-body\">
						<a class=\"btn btn-app btn-app-zetta <?php echo \$class['agregar']; ?>\" href=\"$MODULE_PATH/$table/agregar\">
							<i class=\"fa fa-plus\" id=\"btn-agregar\"></i> Agregar
						</a>
						<a class=\"btn btn-app btn-app-zetta <?php echo \$class['ver']; ?>\" href=\"$MODULE_PATH/$table/ver/<?php echo (!empty(\${$table_1}->$pk_name_nq)) ? \${$table_1}->$pk_name_nq : ''; ?>\">
							<i class=\"fa fa-search\" id=\"btn-ver\"></i> Ver
						</a>
						<a class=\"btn btn-app btn-app-zetta <?php echo \$class['editar']; ?>\" href=\"$MODULE_PATH/$table/editar/<?php echo (!empty(\${$table_1}->$pk_name_nq)) ? \${$table_1}->$pk_name_nq : ''; ?>\">
							<i class=\"fa fa-edit\" id=\"btn-editar\"></i> Editar
						</a>
						<a class=\"btn btn-app btn-app-zetta <?php echo \$class['eliminar']; ?>\" href=\"$MODULE_PATH/$table/eliminar/<?php echo (!empty(\${$table_1}->$pk_name_nq)) ? \${$table_1}->$pk_name_nq : ''; ?>\">
							<i class=\"fa fa-ban\" id=\"btn-eliminar\"></i> Eliminar
						</a>
						<?php foreach (\$fields as \$field): ?>
							<div class=\"form-group\">
								<?php echo \$field['label']; ?> 
								<?php echo \$field['form']; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class=\"box-footer\">
						<a class=\"btn btn-default\" href=\"$MODULE_PATH/$table/listar\" title=\"Cancelar\">Cancelar</a>
						<?php echo (!empty(\$txt_btn)) ? form_submit(\$data_submit, \$txt_btn) : ''; ?>
						<?php echo (\$txt_btn === 'Editar' || \$txt_btn === 'Eliminar') ? form_hidden($pk_name, \${$table_1}->$pk_name_nq) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>";

// </editor-fold>
	if (!is_dir("$views_location"))
		mkdir("$views_location");
	$operations = array('_listar', '_abm');
	foreach ($operations as $operation)
	{
		$fp = fopen("$views_location/{$table}$operation.php", "w");
		fwrite($fp, (${"content$operation"}));
		fclose($fp);
	}
}