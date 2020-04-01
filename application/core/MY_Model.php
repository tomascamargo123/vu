<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $error;
    protected $row_id;
    protected $msg;
    protected $table_name;
    protected $id_name;
    protected $columnas;
    protected $requeridos;
    protected $unicos;
    protected $id_autoincrement = TRUE;

    public function __construct() {
        parent::__construct();
    }

    /**
     * get: Devuelve un arreglo de objetos
     *
     * options:
     * --------------
     * limit             	número de objetos devueltos
     * offset               número de objetos a saltar (requiere limit)
     * sort_by              columna para orden
     * join					join
     * where				where (string o array)
     *
     * @param array $options
     * @return array result()
     */
    public function get($options = array()) {
        if (isset($options['select'])) {
            $this->db->select($options['select']);
        } else {
            if (isset($options['join'])) {
                if (isset($options['from'])) {
                    foreach ($this->columnas as $columna) {
                        $this->db->select($options['from'] . '.' . $columna);
                    }
                } else {
                    foreach ($this->columnas as $columna) {
                        $this->db->select($this->table_name . '.' . $columna);
                    }
                }

                foreach ($options['join'] as $join) {
                    if (isset($join['columnas'])) {
                        $this->db->select($join['columnas']);
                    }
                }
            } else {
                $this->db->select($this->columnas);
            }
        }

        if (isset($options['where'])) {
            foreach ($options['where'] as $where) {
                if (is_array($where)) {
                    if (isset($where['override'])) {
                        $this->db->where($where['column'], $where['value'], FALSE);
                    } else {
                        $this->db->where($where['column'], $where['value']);
                    }
                } else {
                    $this->db->where($where);
                }
            }
        }

        if (isset($options['whereParam'])) {
            $this->db->where($options['whereParam'], '', FALSE);
        }

        foreach ($this->columnas as $columna) {
            $columna_mayor = $columna . ' >';
            $columna_menor = $columna . ' <';
            $columna_distinto = $columna . ' !=';
            $columna_mayor_igual = $columna . ' >=';
            $columna_menor_igual = $columna . ' <=';
            $columna_like_after = $columna . ' like after';
            $columna_like_before = $columna . ' like before';
            $columna_like_both = $columna . ' like both';
            if (isset($options[$columna])) {
                $this->db->where("$this->table_name.$columna", $options[$columna]);
            }
            if (isset($options[$columna_mayor])) {
                $this->db->where("$this->table_name.$columna_mayor", $options[$columna_mayor]);
            }
            if (isset($options[$columna_menor])) {
                $this->db->where("$this->table_name.$columna_menor", $options[$columna_menor]);
            }
            if (isset($options[$columna_distinto])) {
                $this->db->where("$this->table_name.$columna_distinto", $options[$columna_distinto]);
            }
            if (isset($options[$columna_mayor_igual])) {
                $this->db->where("$this->table_name.$columna_mayor_igual", $options[$columna_mayor_igual]);
            }
            if (isset($options[$columna_menor_igual])) {
                $this->db->where("$this->table_name.$columna_menor_igual", $options[$columna_menor_igual]);
            }
            if (isset($options[$columna_like_after])) {
                $this->db->like("$this->table_name.$columna", $options[$columna_like_after], 'after');
            }
            if (isset($options[$columna_like_before])) {
                $this->db->like("$this->table_name.$columna", $options[$columna_like_before], 'before');
            }
            if (isset($options[$columna_like_both])) {
                $this->db->like("$this->table_name.$columna", $options[$columna_like_both], 'both');
            }
        }

        if (isset($options['join'])) {
            foreach ($options['join'] as $join) {
                $this->db->join($join['table'], $join['where'], isset($join['type']) ? $join['type'] : '');
            }
        }

        if (isset($options['group_by'])) {
            $this->db->group_by($options['group_by']);
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->db->limit($options['limit'], $options['offset']);
        } else if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        if (isset($options['sort_by'])) {
            if (is_array($options['sort_by'])) {
                $this->db->order_by($options['sort_by'][0], '', $options['sort_by'][1]);
            } else {
                $this->db->order_by($options['sort_by']);
            }
        }

        if (isset($options['from'])) {
            $query = $this->db->get($options['from']);
        } else {
            $query = $this->db->get($this->table_name);
        }

        if (isset($options['debug']) && $options['debug'] === TRUE) {
            lm($this->db->last_query());
        }


        if ($query->num_rows() === 0) {
            return FALSE;
        }

        if ((isset($options[$this->id_name]) || (isset($options['single']) && $options['single'])) && $query->num_rows() === 1) {
            if (isset($options['return_array']) && $options['return_array']) {
                return $query->row_array(0);
            } else {
                return $query->row(0);
            }
        } else {
            if (isset($options['return_array']) && $options['return_array']) {
                return $query->result_array();
            } else {
                return $query->result();
            }
        }
    }

    /**
     * create: Crea un registro en la tabla.
     *
     * @param array $options
     * @return array insert_id()
     */
    public function create($options = array(), $trans_enabled = TRUE) {
        if (!$this->_required($this->requeridos, $options)) {
            $this->_set_error('Verifique que los campos requeridos contengan datos');
            return FALSE;
        }
        //var_dump($this->unicos);die();
        if (!$this->_unique($this->unicos, $options)) {
            $this->_set_error('Verifique que los datos ingresados no estén repetidos');
//                        var_dump('Verifique que los datos ingresados no estén repetidos');die();
            return FALSE;
        }

        foreach ($this->columnas as $columna) {
            if (isset($options[$columna])) {
                $this->db->set($columna, $options[$columna] == 'NULL' ? NULL : $options[$columna]);
            }
        }
        $this->db->set('audi_user', $this->session->userdata('user_id'));
        $this->db->set('audi_fecha', date_format(new DateTime(), 'Y/m/d H:i:s'));
        $this->db->set('audi_accion', 'I');

        if ($trans_enabled) {
            $this->db->trans_start();
        }

        $ret_value = $this->db->insert($this->table_name);
        if ($this->id_autoincrement) {
            $row_id_new = $this->db->insert_id();
        } else if ($ret_value) {
            $row_id_new = $options[$this->id_name];
        } else {
            $row_id_new = -1;
        }

        if ($row_id_new > -1) {
            $this->_set_msg('Registro de ' . $this->msg_name . ' creado');
            $this->_set_row_id($row_id_new);
            if ($trans_enabled) {
                $this->db->trans_complete();
            }
            return TRUE;
        } else {
            $this->_set_error('No se ha podido crear el registro de ' . $this->msg_name);
            if ($trans_enabled) {
                $this->db->trans_complete();
            }
            return FALSE;
        }
    }

    /**
     * update: Modifica un registro en la tabla.
     *
     * @param array $options
     * @return int affected_rows()
     */
    public function update($options = array(), $trans_enabled = TRUE) {
        if (!$this->_required(array($this->id_name), $options)) {
            $this->_set_error('Verifique que los campos requeridos contengan datos');
            return FALSE;
        }
        if (!$this->_unique($this->unicos, $options, $options[$this->id_name])) {
            $this->_set_error('Verifique que los datos ingresados no estén repetidos');
            return FALSE;
        }

        foreach ($this->columnas as $columna) {
            if (isset($options[$columna]) && $columna != $this->id_name)
                $this->db->set($columna, $options[$columna] == 'NULL' ? NULL : $options[$columna]);
        }

        $this->db->where($this->id_name, $options[$this->id_name]);

        if ($trans_enabled) {
            $this->db->trans_start();
        }
        /*
        if (isset($this->aud_table_name))
            $this->db->query("INSERT INTO $this->aud_table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
        else
            $this->db->query("INSERT INTO expedientes_aud.$this->table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
            */
            $this->db->set('audi_user', $this->session->userdata('user_id'));
        $this->db->set('audi_fecha', date_format(new DateTime(), 'Y/m/d H:i:s'));
        $this->db->set('audi_accion', 'U');
        $this->db->update($this->table_name);

        $rows = $this->db->affected_rows();
        if ($rows > -1) {
            $this->_set_msg('Registro de ' . $this->msg_name . ' modificado');
            if ($trans_enabled) {
                $this->db->trans_complete();
            }
            return TRUE;
        } else {
            $this->_set_error('No se ha podido modificar el registro de ' . $this->msg_name);
            if ($trans_enabled) {
                $this->db->trans_complete();
            }
            return FALSE;
        }
    }

    /**
     * delete: Elimina un registro de la tabla.
     *
     * @param array $options
     */
    public function delete($options = array(), $trans_enabled = TRUE) {
        if (!$this->_required(array($this->id_name), $options)) {
            $this->_set_error('Verifique que los campos requeridos contengan datos');
            return FALSE;
        }

        if ($this->_can_delete($options[$this->id_name])) {
            $this->db->where($this->id_name, $options[$this->id_name]);

            if ($trans_enabled) {
                $this->db->trans_start();
            }
            /*
            if (isset($this->aud_table_name))
                $this->db->query("INSERT INTO $this->aud_table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
            else
                $this->db->query("INSERT INTO expedientes_aud.$this->table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
                */
                $this->db->set('audi_user', $this->session->userdata('user_id'));
            $this->db->set('audi_fecha', date_format(new DateTime(), 'Y/m/d H:i:s'));
            $this->db->set('audi_accion', 'D');
            $this->db->where($this->id_name, $options[$this->id_name]);
            $this->db->update($this->table_name);
            /*
            if (isset($this->aud_table_name)) {
                $this->db->query("INSERT INTO $this->aud_table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
            } else {
                $this->db->query("INSERT INTO expedientes_aud.$this->table_name SELECT NULL as audi_id, $this->table_name.* FROM $this->table_name WHERE {$this->id_name}={$options[$this->id_name]}");
            }
             */
            $this->db->where($this->id_name, $options[$this->id_name]);
            if ($this->db->delete($this->table_name)) {
                $this->_set_msg('Registro de ' . $this->msg_name . ' eliminado');
                if ($trans_enabled) {
                    $this->db->trans_complete();
                }
                return TRUE;
            } else {
                $this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name);
                if ($trans_enabled) {
                    $this->db->trans_complete();
                }
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * count_rows: Cuenta las filas de una tabla.
     *
     * @return int count_all_results()
     */
    public function count_rows() {
        return $this->db->count_all_results($this->table_name);
    }

    /**
     * count_rows_where: Cuenta las filas de una tabla que cumplan con las condiciones.
     *
     * @param array $options
     * @return int count_all_results()
     */
    public function count_rows_where($options = array()) {
        foreach ($this->columnas as $columna) {
            $columna_mayor = $columna . ' >';
            $columna_menor = $columna . ' <';
            $columna_distinto = $columna . ' !=';
            $columna_mayor_igual = $columna . ' >=';
            $columna_menor_igual = $columna . ' <=';
            if (isset($options[$columna])) {
                $this->db->where($columna, $options[$columna]);
            }
            if (isset($options[$columna_mayor])) {
                $this->db->where($columna_mayor, $options[$columna_mayor]);
            }
            if (isset($options[$columna_menor])) {
                $this->db->where($columna_menor, $options[$columna_menor]);
            }
            if (isset($options[$columna_distinto])) {
                $this->db->where($columna_distinto, $options[$columna_distinto]);
            }
            if (isset($options[$columna_mayor_igual])) {
                $this->db->where($columna_mayor_igual, $options[$columna_mayor_igual]);
            }
            if (isset($options[$columna_menor_igual])) {
                $this->db->where($columna_menor_igual, $options[$columna_menor_igual]);
            }
        }
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

    /**
     * _required: Retorna falso si el array $data no contiene los campos del array $required.
     *
     * @param array $required
     * @param array $data
     * @return bool
     */
    protected function _required($required, $data) {
        foreach ($required as $field)
            if (!isset($data[$field])) {
                return FALSE;
            }
        return TRUE;
    }

    /**
     * _unique: Retorna falso si en la tabla para cada columna de $unique existe alguna fila con los mismos datos que $data.
     *
     * @param array $unique
     * @param array $data
     * @return bool
     */
    protected function _unique($unique, $data, $id = -1, $id_name = 'id') {
        if (empty($unique)) {
            //var_dump("return trueee");die();
            return TRUE;
        }
        $where = "";
        $first = TRUE;
        foreach ($unique as $field) {
            if (is_array($field)) {
                if ($first) {
                    $first_2 = TRUE;
                    foreach ($field as $field_2) {
                        if ($first_2) {
                            $where .= " ((" . $field_2 . " = '" . $data[$field_2] . "'";
                            $first_2 = FALSE;
                        } else {
                            $where .= " AND " . $field_2 . " = '" . $data[$field_2] . "'";
                        }
                    }
                    $where .= ")";
                    $first = FALSE;
                } else {
                    $first_2 = TRUE;
                    foreach ($field as $field_2) {
                        if ($first_2) {
                            $where .= " OR (" . $field_2 . " = '" . $data[$field_2] . "'";
                            $first_2 = FALSE;
                        } else {
                            $where .= " AND " . $field_2 . " = '" . $data[$field_2] . "'";
                        }
                    }
                    $where .= ")";
                }
            } else {
                if (empty($data[$field])) {
                    break;
                }

                if ($first) {
                    $where .= "(" . $field . " = '" . $data[$field] . "'";
                    $first = FALSE;
                } else {
                    $where .= " OR " . $field . " = '" . $data[$field] . "'";
                }
            }
        }
        $where .= ")";
        if ($where === ")") {
            return TRUE;
        }
//                var_dump($where);
//                var_dump($id_name);
//                var_dump($id);
        $this->db->where($where);
        $this->db->where($id_name . ' !=', $id);
//                    var_dump($this->db->last_query());
        if ($this->db->count_all_results($this->table_name) > 0) {
//                    var_dump($this->db->count_all_results($this->table_name));
//                    var_dump($this->db->last_query());
            return FALSE;
        }
        return TRUE;
    }

    /**
     * _can_delete: Retorna true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) {
        return TRUE;
    }

    /**
     * _set_error: Guarda un error.
     *
     * @return void
     */
    protected function _set_error($error) {
        $this->error = $error;
    }

    /**
     * get_error: Devuelve el error.
     *
     * @return string
     */
    public function get_error() {
        return $this->error;
    }

    /**
     * _set_msg: Guarda un mensaje.
     *
     * @return void
     */
    protected function _set_msg($msg) {
        $this->msg = $msg;
    }

    /**
     * get_msg: Devuelve el mensaje.
     *
     * @return string
     */
    public function get_msg() {
        return $this->msg;
    }

    /**
     * _set_row_id: Guarda el id de un elemento creado.
     *
     * @return void
     */
    protected function _set_row_id($id) {
        $this->row_id = $id;
    }

    /**
     * get_row_id: Devuelve el id del último elemento creado.
     *
     * @return int
     */
    public function get_row_id() {
        return $this->row_id;
    }

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */