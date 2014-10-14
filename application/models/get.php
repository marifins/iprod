<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Inbox_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tanggal = 0){
        if($tanggal == 0)
            $query = $this->db->query('SELECT * FROM inbox ORDER BY receivingdatetime DESC');
        else
            $query = $this->db->query('SELECT * FROM inbox WHERE tanggal = "'.$tanggal.'" ORDER BY receivingdatetime DESC');
        return $query;
    }

    function get_all($tanggal = 0)
    {
        $query = $this->main_query($tanggal);
        return $query->result();
    }
    function get_rows($tanggal = 0){
        $query = $this->main_query($tanggal);
        return $query->num_rows();
    }

    function get_last_ten($limit,$offset)
    {
        $query = $this->db->query('SELECT id, sendernumber, textdecoded, processed, receivingdatetime  FROM inbox ORDER BY receivingdatetime DESC LIMIT ' .$offset .',' .$limit);
        return $query->result();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM inbox');
        return $query->num_rows();
    }

    function rows_inbox() {
        $this->db->select('*');
        $this->db->from('inbox');
        $this->db->where('processed','false');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_inbox() {
        $this->db->select('id, sendernumber, textdecoded');
        $this->db->from('inbox');
        $this->db->where('processed','false');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    function rows_member($num) {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_kebun($num) {
        $this->db->select('kebun_unit');
        $this->db->from('member');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_inbox($id){
        $this->processed = 'true';
        $this->db->update('inbox', $this, array('id' => $id));
    }

    function get_krani($no){
        $this->db->select('kebun_unit, afdeling');
        $this->db->from('member');
        $this->db->where('no_ponsel', $no);
        $query = $this->db->get();

        $rows = $query->num_rows();
        if($rows > 0)
            return $query->row();
        else
            return "";
    }

    function get_nama_kebun($rek){
        $this->db->select('nama_kebun');
        $this->db->from('kebun');
        $this->db->where('no_rek', $rek);
        $query = $this->db->get();
        $rows = $query->num_rows();
        if($rows > 0)
            return $query->row();
        else
            return "";
    }
}
?>