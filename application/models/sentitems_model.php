<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Sentitems_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function main_query($tanggal = 0){
        if($tanggal == 0)
            $query = $this->db->query('SELECT * FROM sentitems ORDER BY updatedindb DESC');
        else
            $query = $this->db->query('SELECT * FROM sentitems WHERE tanggal = "'.$tanggal.'" ORDER BY updatedindb DESC');
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
        $query = $this->db->query('SELECT id, destinationnumber, textdecoded, creatorid, sendingdatetime FROM sentitems ORDER BY updatedindb DESC LIMIT ' .$offset .',' .$limit);
        return $query->result();
    }

    function count(){
        $query = $this->db->query('SELECT * FROM sentitems ORDER BY updatedindb DESC');
        return $query->num_rows();
    }

    function insert_outbox($num, $pesan)
    {
        //$this->insertintodb = 'CURRENT_TIMESTAMP';
        $this->destinationnumber = $num;
        $this->textdecoded = $pesan;
        $this->creatorid = 'm. a. s';

        $this->db->insert('outbox', $this);
    }
}
?>