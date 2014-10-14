<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cek_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tanggal = 0) {
        if ($tanggal == 0)
            $query = $this->db->query('SELECT k.nama_kebun, p.id, p.afdeling, p.estimasi, p.realisasi, p.tanggal FROM produksi as p JOIN kebun as k WHERE p.kebun = k.no_rek ORDER BY tanggal DESC');
        else
            $query = $this->db->query('SELECT * FROM produksi WHERE tanggal = "' . $tanggal . '" ORDER BY tanggal DESC');
        return $query;
    }

    function get_all($tanggal = 0) {
        $query = $this->main_query($tanggal);
        return $query->result();
    }

    function get_rows($tanggal = 0) {
        $query = $this->main_query($tanggal);
        return $query->num_rows();
    }

    function get_data($kebun, $tanggal) {
        if ($kebun == 0)
            $kebun = '080.03';
        if ($tanggal == 0)
            $tanggal = date('Y-m-d');
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "' . $kebun . '" AND tanggal = "' . $tanggal . '" ORDER BY afdeling');
        return $query->result();
    }

    function get_info() {
        $today = date('Y-m-d');
        $yesterday = date("Y-m-d", time() - 86400);
        $query = $this->db->query('SELECT text, tanggal, no_ponsel FROM info WHERE SUBSTRING(tanggal, 1, 10) = "' . $today . '" OR SUBSTRING(tanggal, 1, 10) = "' . $yesterday . '" ORDER BY id DESC');
        return $query->result();
    }

    function count() {
        $query = $this->db->query('SELECT * FROM produksi');
        return $query->num_rows();
    }
    
    function get_complete($kebun, $tanggal) {
        $query = $this->db->query('SELECT afdeling FROM produksi WHERE telling IS NOT null AND estimasi IS NOT null AND realisasi IS NOT null AND brondolan IS NOT null AND sisa IS NOT null AND curah_hujan IS NOT null AND hk_dinas IS NOT null AND hk_bhl IS NOT null AND kebun = "'.$kebun.'" AND tanggal = "'.$tanggal.'"');
        return $query->result();
    }

    function get_details($id) {
        $query = $this->db->query('SELECT * FROM produksi AS p JOIN kebun AS k WHERE p.kebun = k.no_rek AND id = ' . $id . '');
        return $query->row();
    }

    function get_kebun_all() {
        $this->db->select('no_rek, nama_kebun');
        $this->db->from('kebun');
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_afd($kebun) {
        $query = $this->db->query('SELECT afdeling FROM afdeling WHERE kebun = "'.$kebun.'"');
        return $query->result();
    }
    
    function is_all($kebun, $afd, $tgl) {
        $query = $this->db->query('SELECT id FROM produksi WHERE telling IS NOT NULL AND estimasi IS NOT NULL AND realisasi IS NOT NULL AND brondolan IS NOT NULL AND sisa IS NOT NULL AND curah_hujan IS NOT NULL AND hk_dinas IS NOT NULL AND hk_bhl IS NOT NULL AND kebun = "'.$kebun.'" AND afdeling = "'.$afd.'" AND tanggal = "'.$tgl.'"');
        return $query->num_rows();
    }
    
    function is_empty($kebun, $afd, $tgl) {
        $query = $this->db->query('SELECT id FROM produksi WHERE telling IS NULL AND estimasi IS NULL AND realisasi IS NULL AND brondolan IS NULL AND sisa IS NULL AND curah_hujan IS NULL AND hk_dinas IS NULL AND hk_bhl IS NULL AND kebun = "'.$kebun.'" AND afdeling = "'.$afd.'" AND tanggal = "'.$tgl.'"');
        return $query->num_rows();
    }
    
    function is_some($kebun, $afd, $tgl) {
        $query = $this->db->query('SELECT id FROM produksi WHERE (telling IS NULL OR estimasi IS NULL OR realisasi IS NULL OR brondolan IS NULL OR sisa IS NULL OR curah_hujan IS NULL OR hk_dinas IS NULL OR hk_bhl IS NULL) AND kebun = "'.$kebun.'" AND afdeling = "'.$afd.'" AND tanggal = "'.$tgl.'"');
        return $query->num_rows();
    }

    function get_kebun_from_ponsel($ponsel) {
        $this->db->select('kebun_unit');
        $this->db->from('member');
        $this->db->where('no_ponsel', $ponsel);
        $query = $this->db->get();
        return $query->row();
    }

    function cek_data_log($kebun, $afdeling, $tanggal) {
        $this->db->select('id');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afdeling);
        $this->db->where('tanggal', $tanggal);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function save() {
        $tanggal = $this->input->post('tanggal');
        $kebun = $this->input->post('kebun');
        $afdeling = $this->input->post('afdeling');
        $estimasi = $this->input->post('estimasi');
        $realisasi = $this->input->post('realisasi');
        $brondolan = $this->input->post('brondolan');
        $hk_dinas = $this->input->post('hk_dinas');
        $hk_bhl = $this->input->post('hk_bhl');

        $data = array(
            'tanggal' => $tanggal,
            'kebun' => $kebun,
            'afdeling' => $afdeling,
            'estimasi' => $estimasi,
            'realisasi' => $realisasi,
            'brondolan' => $brondolan,
            'hk_dinas' => $hk_dinas,
            'hk_bhl' => $hk_bhl
        );
        $this->db->insert('produksi', $data);
    }

    function update() {
        $id = $this->input->post('id');
        $tanggal = $this->input->post('tanggal');
        $kebun = $this->input->post('kebun');
        $afdeling = $this->input->post('afdeling');
        $estimasi = $this->input->post('estimasi');
        $realisasi = $this->input->post('realisasi');
        $brondolan = $this->input->post('brondolan');
        $hk_dinas = $this->input->post('hk_dinas');
        $hk_bhl = $this->input->post('hk_bhl');

        $data = array(
            'tanggal' => $tanggal,
            'kebun' => $kebun,
            'afdeling' => $afdeling,
            'estimasi' => $estimasi,
            'realisasi' => $realisasi,
            'brondolan' => $brondolan,
            'hk_dinas' => $hk_dinas,
            'hk_bhl' => $hk_bhl
        );
        $this->db->where('id', $id);
        $this->db->update('produksi', $data);
    }

    function delete() {
        $id = $this->input->post('id');
        $this->db->delete('produksi', array('id' => $id));
    }

    function real_kebun($id) {
        $query = $this->db->query('SELECT SUM(realisasi) as r, SUM(telling) as t, SUM(sisa) as s FROM produksi WHERE kebun = "' . $id . '" AND tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
        return $query->row();
    }

    function real_kebun_sd($id) {
        $tanggal = date('Y-m-d');
        $str = substr($tanggal, 0, 7);
        $query = $this->db->query('SELECT SUM(realisasi) as r FROM produksi WHERE kebun = "' . $id . '" AND SUBSTRING(tanggal, 1, 7) = "' . $str . '"');
        return $query->row();
    }

}

?>