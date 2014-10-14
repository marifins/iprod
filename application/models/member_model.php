<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Member_model extends CI_Model {

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
        $query = $this->db->query('SELECT * FROM member LIMIT ' .$offset .',' .$limit);
        return $query->result();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM member');
        return $query->num_rows();
    }
    
    function get_details($register){
        $query = $this->db->query('SELECT * FROM member WHERE register = "'.$register.'"');
        return $query->row();
    }

    function get_level(){
        $query = $this->db->query('SELECT lu.id_level, lu.nama_level FROM user AS u JOIN level_user AS lu WHERE u.level = lu.id_level');
        return $query->result();
    }
    function getAll(){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->limit(5);
        $this->db->order_by('register','ASC');
        $query = $this->db->get();

        return $query->result();
  }
  function save(){
    $register = $this->input->post('register');
    $nama_lengkap = $this->input->post('nama_lengkap');
    $no_ponsel = $this->input->post('no_ponsel');
    $kebun_unit = $this->input->post('kebun_unit');
    $afd = $this->input->post('afdeling');
    $jabatan = $this->input->post('jabatan');
    
    $data = array(
      'register' => $register,
      'nama_lengkap' => $nama_lengkap,
      'no_ponsel' => $no_ponsel,
      'kebun_unit' => $kebun_unit,
      'afdeling' => $afd,
      'jabatan' => $jabatan
    );
    $this->db->insert('member',$data);
  }

  function update(){
    $register = $this->input->post('register');
    $nama_lengkap = $this->input->post('nama_lengkap');
    $no_ponsel = $this->input->post('no_ponsel');
    $kebun_unit = $this->input->post('kebun_unit');
    $afd = $this->input->post('afdeling');
    $jabatan = $this->input->post('jabatan');
    
    $data = array(
      'nama_lengkap' => $nama_lengkap,
      'no_ponsel' => $no_ponsel,
      'kebun_unit' => $kebun_unit,
      'afdeling' => $afd,
      'jabatan' => $jabatan
    );
    $this->db->where('register', $register);
    $this->db->update('member', $data);
  }

  function delete($reg){
      $this->db->delete('member', array('register' => $reg));
  }

  function get_kebun_name($id){
        $this->db->select('nama_kebun');
        $this->db->from('kebun');
        $this->db->where('no_rek', $id);
        $query = $this->db->get();
        return $query->row();
  }
  
  function get_kebun_all(){
        $this->db->select('no_rek, nama_kebun');
        $this->db->from('kebun');
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
  }

  function cek_data_member($reg){
      $this->db->select('register');
      $this->db->from('member');
      $this->db->where('register', $reg);
      $query = $this->db->get();
      return $query->num_rows();
  }
}
?>