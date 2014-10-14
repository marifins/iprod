<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Afdeling_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($kebun = 0, $tahun = 0, $bulan = 0){
        if($tahun == 0)
            $query = $this->db->query('SELECT * FROM afdeling WHERE kebun = 080.03 AND tahun = (SELECT MAX(tahun) FROM afdeling)');
        else
            $query = $this->db->query('SELECT * FROM afdeling WHERE kebun = "'.$kebun.'" AND tahun = "'.$tahun.'" AND bulan = "'.$bulan.'"');
        return $query;
    }

    function get_tahun_all(){
        $query = $this->db->query('SELECT tahun FROM afdeling');
        return $query->result();
    }

    function get_all($tanggal = 0)
    {
        $query = $this->main_query($tanggal);
        return $query->result();
    }
    function get_rows($kebun = 0, $tahun = 0, $bulan = 0){
        $query = $this->main_query($kebun, $tahun, $bulan);
        return $query->num_rows();
    }

    function get_last_ten($kebun = 0, $tahun = 0, $bulan = 0){
        if($tahun == 0 || $bulan == 0)
            $query = $this->db->query('SELECT * FROM afdeling WHERE kebun = 080.03 AND tahun = (SELECT MAX(tahun) FROM afdeling)');
        else
            $query = $this->db->query('SELECT * FROM afdeling WHERE kebun = "'.$kebun.'" AND tahun = "'.$tahun.'" AND bulan = "'.$bulan.'"');
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
        $query = $this->db->query('SELECT * FROM afdeling WHERE register = '.$register.'');
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
    $afdeling = $this->input->post('afdeling');
    $rkap = $this->input->post('rkap');
    $rko = $this->input->post('rko');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    
    $data = array(
      'kebun' => $kebun,
      'afdeling' => $afdeling,
      'rkap' => $rkap,
      'rko' => $rko,
      'tahun' => $tahun,
      'bulan' => $bulan
    );
    $this->db->insert('afdeling',$data);
  }

  function update(){
    $id = $this->input->post('id');
    $kebun = $this->input->post('kebun');
    $afdeling = $this->input->post('afdeling');
    $rkap = $this->input->post('rkap');
    $rko = $this->input->post('rko');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    
    $data = array(
      'kebun' => $kebun,
      'afdeling' => $afdeling,
      'rkap' => $rkap,
      'rko' => $rko,
      'tahun' => $tahun,
      'bulan' => $bulan
    );
    $this->db->where('id', $id);
    $this->db->update('afdeling', $data);
  }

  function delete(){
      $id = $this->input->post('id');
      $this->db->delete('afdeling', array('id' => $id));
  }

  function get_kebun_all() {
      $this->db->select('no_rek, nama_kebun');
      $this->db->from('kebun');
      $this->db->where('status', '1');
      $query = $this->db->get();
      return $query->result();
  }

  function get_kebun_not_in($tahun) {
      $query = $this->db->query('SELECT no_rek, nama_kebun FROM kebun WHERE no_rek NOT IN (SELECT kebun FROM afdeling WHERE tahun = '.$tahun.') AND status = 1');
      return $query->result();
  }

  function cek_data_af($tahun, $bulan, $kebun, $afdeling){
      $this->db->select('id');
      $this->db->from('afdeling');
      $this->db->where('tahun', $tahun);
      $this->db->where('bulan', $bulan);
      $this->db->where('kebun', $kebun);
      $this->db->where('afdeling', $afdeling);
      $query = $this->db->get();
      return $query->num_rows();
  }
}
?>