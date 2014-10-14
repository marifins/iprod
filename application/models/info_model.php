<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Info_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tanggal = 0){
        if($tanggal == 0)
            $query = $this->db->query('SELECT k.nama_kebun, p.id, p.afdeling, p.estimasi, p.realisasi, p.tanggal FROM produksi as p JOIN kebun as k WHERE p.kebun = k.no_rek');
        else
            $query = $this->db->query('SELECT * FROM produksi WHERE tanggal = "'.$tanggal.'"');
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
        $query = $this->db->query('SELECT id, no_ponsel, text, cast(tanggal as date) as date, cast(tanggal as time) as time FROM info ORDER BY tanggal DESC LIMIT ' .$offset .',' .$limit);
        return $query->result();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM info');
        return $query->num_rows();
    }

    function getAll(){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->limit(5);
        $this->db->order_by('register','ASC');
        $query = $this->db->get();

        return $query->result();
  }
  
  function delete(){
      $id = $this->input->post('id');
      $this->db->delete('info', array('id' => $id));
  }
  
  function get_kebun_by_ponsel($no){
      $query = $this->db->query('SELECT k.nama_kebun FROM member AS m JOIN kebun AS k WHERE m.no_ponsel = "'.$no.'" AND k.no_rek = m.kebun_unit');
      return $query->row();
  }
}
?>