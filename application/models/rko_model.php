<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Rko_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tahun = 0, $bulan = 0){
        if($tahun == 0)
            $query = $this->db->query('SELECT * FROM bulanan WHERE tahun = (SELECT MAX(tahun) FROM bulanan) AND bulan = (SELECT MAX(bulan) FROM bulanan WHERE tahun = (SELECT MAX(tahun) FROM bulanan))');
        else
            $query = $this->db->query('SELECT * FROM bulanan WHERE tahun = "'.$tahun.'" AND bulan = "'.$bulan.'"');
        return $query;
    }

    function get_tahun_all(){
        $query = $this->db->query('SELECT tahun FROM bulanan');
        return $query->result();
    }

    function get_all($tanggal = 0)
    {
        $query = $this->main_query($tanggal);
        return $query->result();
    }
    function get_rows($tahun = 0, $bulan = 0){
        $query = $this->main_query($tahun = 0, $bulan = 0);
        return $query->num_rows();
    }

    function get_last_ten($tahun = 0, $bulan = 0){
        if($tahun == 0)
            $query = $this->db->query('SELECT * FROM bulanan WHERE tahun = (SELECT MAX(tahun) FROM bulanan) AND bulan = (SELECT MAX(bulan) FROM bulanan WHERE tahun = (SELECT MAX(tahun) FROM bulanan)) ORDER BY kebun');
        else
            $query = $this->db->query('SELECT * FROM bulanan WHERE tahun = "'.$tahun.'" AND bulan = "'.$bulan.'" ORDER BY kebun');
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
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    $kebun = $this->input->post('kebun');
    $rkap = $this->input->post('rkap');
    $rko = $this->input->post('rko');
    
    $data = array(
      'tahun'=> $tahun,
      'bulan' => $bulan,
      'kebun' => $kebun,
      'rkap' => $rkap,
      'rko' => $rko
    );
    $this->db->insert('bulanan', $data);
  }

  function update(){
    $id = $this->input->post('id');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    $kebun = $this->input->post('kebun');
    $rkap = $this->input->post('rkap');
    $rko = $this->input->post('rko');
    
    $data = array(
      'tahun' => $tahun,
      'bulan' => $bulan,
      'kebun' => $kebun,
      'rkap' => $rkap,
      'rko' => $rko
    );
    $this->db->where('id',$id);
    $this->db->update('bulanan', $data);
  }

  function delete(){
      $id = $this->input->post('id');
      $this->db->delete('bulanan', array('id' => $id));
  }

  function cek_data_rko($tahun, $bulan, $kebun){
      $this->db->select('id');
      $this->db->from('bulanan');
      $this->db->where('tahun', $tahun);
      $this->db->where('bulan', $bulan);
      $this->db->where('kebun', $kebun);
      $query = $this->db->get();
      return $query->num_rows();
  }
}
?>