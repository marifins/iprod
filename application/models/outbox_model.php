<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Outbox_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tanggal = 0){
        if($tanggal == 0)
            $query = $this->db->query('SELECT * FROM outbox');
        else
            $query = $this->db->query('SELECT * FROM outbox WHERE tanggal = "'.$tanggal.'"');
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
        $query = $this->db->query('SELECT id, destinationnumber, textdecoded, creatorid, sendingdatetime FROM outbox LIMIT ' .$offset .',' .$limit);
        return $query->result();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM outbox');
        return $query->num_rows();
    }

    function insert_outbox($num, $pesan)
    {
        $this->destinationnumber = $num;
        $this->textdecoded = $pesan;
        $this->creatorid = 'm. a. s';

        $this->db->insert('outbox', $this);
    }
    function save() {
        $no_tujuan = $this->input->post('destinationnumber');
        $pesan = $this->input->post('textdecoded');
        
        if($no_tujuan == "Semua Krani"){
            $query = $this->db->query('SELECT no_ponsel from member');
            $krani = $query->result();
            foreach($krani as $k){
                $data = array(
                'destinationnumber' => $k->no_ponsel,
                'textdecoded' => $pesan,
                'sendingdatetime' => date("Y:m:d H:i:s")
            );
            $this->db->insert('outbox', $data);
            }
        }else{
            $data = array(
                'destinationnumber' => $no_tujuan,
                'textdecoded' => $pesan,
                'sendingdatetime' => date("Y:m:d H:i:s")
            );
            $this->db->insert('outbox', $data);
        }
    }
}
?>