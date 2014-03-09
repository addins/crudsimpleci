<?php

/**
 * Description of categories
 *
 * @author addin
 */
class Categories extends CI_Model {

    public static $table_name = "categories";
    public static $key_name = "id";

    function get($id) {
        if (isset($id) && is_numeric($id))
            return $this->db->where(array(self::$key_name => $id))->get(self::$table_name);
    }
    
    function count(){
        return $this->db->count_all(self::$table_name);
    }

    function get_all($limit = NULL, $offset = NULL) {
        if (isset($limit) && is_numeric($limit))
            $this->db->limit($limit);
        if (isset($offset) && is_numeric($offset))
            $this->db->offset($offset);
        return $this->db->get(self::$table_name);
    }

    function get_where($where = NULL, $limit = NULL, $offset = NULL) {
        if (isset($where) && is_array($where))
            $this->db->where($where);
        if (isset($limit) && is_numeric($limit))
            $this->db->limit($limit);
        if (isset($offset) && is_numeric($offset))
            $this->db->offset($offset);
        return $this->db->get(self::$table_name);
    }

    function delete($id) {
        if (isset($id) && is_numeric($id))
            return $this->db->where(array(self::$key_name => $id))->delete (self::$table_name);
    }

    function update($id, $data) {
        if (isset($data) && is_array($data) && isset($id) && is_numeric($id)){
            $data['modified_at'] = date("Y-m-d H:i:s",now());
            return $this->db->where(array(self::$key_name => $id))->update(self::$table_name, $data);
        }
    }

    function add($data) {
        if (isset($data) && is_array($data)) {
            $data['created_at'] = date("Y-m-d H:i:s",now());
            return $this->db->insert(self::$table_name, $data);
        }
    }

}

/* End of file categories.php */
/* Location: ./application/models/categories.php */