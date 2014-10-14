<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Rkap_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tahun = 0){
        if($tahun == 0)
            $query = $this->db->query('SELECT * FROM tahunan WHERE tahun = (SELECT MAX(tahun) FROM tahunan)');
        else
            $query = $this->db->query('SELECT * FROM tahunan WHERE tahun = "'.$tahun.'"');
        return $query;
    }

    function get_tahun_all(){
        $query = $this->db->query('SELECT tahun FROM tahunan');
        return $query->result();
    }

    function get_all($tanggal = 0)
    {
        $query = $this->main_query($tanggal);
        return $query->result();
    }
    function get_rows($tahun = 0){
        $query = $this->main_query($tahun);
        return $query->num_rows();
    }

    function get_last_ten($tahun = 0){
        if($tahun == 0)
            $query = $this->db->query('SELECT * FROM tahunan WHERE tahun = (SELECT MAX(tahun) FROM tahunan)');
        else
            $query = $this->db->query('SELECT * FROM tahunan WHERE tahun = "'.$tahun.'"');
        return $query->result();
    }

    function get_kebun_name($id){
        $query = $this->db->query('SELECT nama_kebun FROM kebun WHERE no_rek = "'.$id.'"');
        return $query->row();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM user');
        return $query->num_rows();
    }
    
    function get_details($register){
        $query = $this->db->query('SELECT * FROM tahunan WHERE register = '.$register.'');
        return $query->row();
    }

    function get_level(){
        $query = $this->db->query('SELECT lu.id_level, lu.nama_level FROM user AS u JOIN level_user AS lu WHERE u.level = lu.id_level');
        return $query->result();
    }
    function getAll(){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->limit(5);
        $this->db->order_by('register','ASC');
        $query = $this->db->get();

        return $query->result();
  }
  function save(){
    $kebun = $this->input->post('kebun');
    $rkap = $this->input->post('rkap');
    $tahun = $this->input->post('tahun');
    
    $data = array(
      'kebun' => $kebun,
      'rkap' => $rkap,
      'tahun' => $tahun
    );
    $this->db->insert('tahunan',$data);
  }

  function update(){
    $id = $this->input->post('id');
    $kebun = $this->input->post('kebun');
    $rkap = $this->input->post('rkap');
    $tahun = $this->input->post('tahun');
    
    $data = array(
      'kebun' => $kebun,
      'rkap' => $rkap,
      'tahun' => $tahun
    );
    $this->db->where('id', $id);
    $this->db->update('tahunan', $data);
  }

  function delete(){
      $id = $this->input->post('id');
      $this->db->delete('tahunan', array('id' => $id));
  }

  function get_kebun_all() {
      $this->db->select('no_rek, nama_kebun');
      $this->db->from('kebun');
      $this->db->where('status', '1');
      $query = $this->db->get();
      return $query->result();
  }

  function get_kebun_not_in($tahun) {
      $query = $this->db->query('SELECT no_rek, nama_kebun FROM kebun WHERE no_rek NOT IN (SELECT kebun FROM tahunan WHERE tahun = '.$tahun.') AND status = 1');
      return $query->result();
  }

  function cek_data_rkap($tahun, $kebun){
      $this->db->select('id');
      $this->db->from('tahunan');
      $this->db->where('tahun', $tahun);
      $this->db->where('kebun', $kebun);
      $query = $this->db->get();
      return $query->num_rows();
  }

  //SELECT no_rek FROM `kebun` WHERE status = 1 AND no_rek NOT IN (SELECT kebun FROM tahunan WHERE tahun = '2011')
}
?>