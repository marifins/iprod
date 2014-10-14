<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package default_template
 * @modified Sep 2, 2010
 */

 class Load extends CI_Controller {
    public $pesan = "";
    public $tgl = "";
    public $kebun = "";
    public $afdeling = "";

    public function __construct() {
        parent::__construct();
        $this->load->model('inbox_model');
        $this->load->model('outbox_model');
        $this->load->model('produksi_model');
        $this->load->model('produksi_kebun_model');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('load');
        $rows = $this->inbox_model->rows_inbox();
        $data = $this->inbox_model->get_inbox();
        $d['data'] = $data;
        if($rows > 0){
            $this->analyse($data);
            $this->load->view('load', $d, '');
            
        }
        // send to manager
        $this->check_afd();
        $this->get_status();
    }

    function check_afd(){
        $psn = ""; $psn2 = "";
        $data_tgl = $this->produksi_model->get_not_app();
        $waktu = date("H")+5 .":" .date("i:s");
        $yesterday = date("Y-m-d", strtotime("yesterday"));
        foreach($data_tgl as $r)
        {
            $psn = "";
            $psn2 = "";
            $all_kebun = $this->produksi_model->get_kebun_all();
            foreach($all_kebun as $k){
                $afd = "";
                $count = $this->produksi_model->check_afd($k->no_rek, $r->tanggal);
                //$pembanding = $this->produksi_model->get_jlh_afd($k->no_rek);
                if($count > 0){
                    $data = $this->produksi_model->get_data_kebun($k->no_rek, $r->tanggal);
                    $i = 0;
                    foreach($data as $d){
                        $kebun = $this->fungsi->rekToKebun($d->kebun);
                        $afd = $d->afdeling;
                        $i++;
                        if($i == 1) $psn .= $d->tanggal ."\r\n";
                        if($i == 6) $psn2 .= $d->tanggal ."\r\n";
                        if($i <= 5) $psn .= $kebun ." Afd. " .$afd ." = TEL:" .$d->telling.", EST:" .$d->estimasi.", REAL:" .$d->realisasi.", BRD:" .$d->brondolan.", SISA:" .$d->sisa .", CH:" .$d->curah_hujan.", HK:" .$d->hk_dinas ."/" .$d->hk_bhl ."\r\n";
                        else if($i > 5) $psn2 .= $d->afdeling ."=" .$d->estimasi."," .$d->realisasi."," .$d->brondolan."," .$d->hk_dinas ."|" .$d->hk_bhl ."\r\n";
                    }
                    $data = $this->produksi_model->get_ponsel_manager($k->no_rek);
                    $ponsel = $data->no_ponsel;
                    $this->to_outbox($ponsel, $psn);
                    if($psn2 != "")$this->to_outbox($ponsel, $psn2);
                    $this->produksi_model->after_send($k->no_rek, $afd, $r->tanggal);
                }else if(($r->tanggal == $yesterday) && ($waktu == "8:00:01")){
                    $data = $this->produksi_model->get_data_kebun($k->no_rek, $r->tanggal);
                    $i = 0;
                    foreach($data as $d){
                        $i++;
                        if($i == 1) $psn .= $d->tanggal ."\r\n";
                        if($i == 6) $psn2 .= $d->tanggal ."\r\n";
                        if($i <= 5) $psn .= $d->afdeling ."=" .$d->estimasi."," .$d->realisasi."," .$d->brondolan."," .$d->hk_dinas ."|" .$d->hk_bhl ."\r\n";
                        else if($i > 5) $psn2 .= $d->afdeling ."=" .$d->estimasi."," .$d->realisasi."," .$d->brondolan."," .$d->hk_dinas ."|" .$d->hk_bhl ."\r\n";
                    }
                    $data = $this->produksi_model->get_ponsel_manager($k->no_rek);
                    $ponsel = $data->no_ponsel;
                    $this->to_outbox($ponsel, $psn);
                    if($psn2 != "")$this->to_outbox($ponsel, $psn2);
                }
            }
        }
    }
    
    function clear(){
        $pesan = "";
        $tgl = "";
        $kebun = "";
        $afdeling = "";
    } 

    function analyse($data){
        foreach($data as $d){
            //echo "<embed src =\"$file\" hidden=\"true\" autostart=\"true\"></embed>";
            $exp = null;
            $pesan = "";
            $id = $d->id;
            $num = $d->sendernumber;
            $msg = strtoupper($d->textdecoded);
            $valid = $this->is_valid_sender($num);
            $validm = $this->is_valid_manager($num);
            $validt = $this->is_toplevelman($num);
            if($valid){
                $exp = explode(",", $msg);
                if(count($exp) == 8){
                    $this->to_all($id, $num, $msg);
                }else if(count($exp) == 1){
                    $exp = explode(" ", $msg);
                    if($exp[0] == "REAL" || $exp[0] == "REALISASI"){
                        $this->to_real($id, $num, $msg);
                    }else if(($exp[0] == "EST") || ($exp[0] == "ESTIMASI")){
                        $this->to_est($id, $num, $msg);
                    }else if($exp[0] == "BRD"){
                        $this->to_brd($id, $num, $msg);
                    }else if($exp[0] == "HK"){
                        $this->to_hk($id, $num, $msg);
                    }else if($exp[0] == "INFO"){
                        $this->to_info($id, $num, $msg);
                    }else if($exp[0] == "PROD"){
                        $this->to_prod($id, $num, $msg);
                    }else if($exp[0] == "SISA"){
                        $this->to_sisa($id, $num, $msg);
                    }else if($exp[0] == "CH"){
                        $this->to_ch($id, $num, $msg);
                    }else if($exp[0] == "TEL"){
                        $this->to_tel($id, $num, $msg);
                    }
                }else{
                    $pesan = "Error. Format pesan " .$msg ." salah.";
                }
            }else if($validm){
                $exp = explode(",", $msg);
                if(count($exp) == 3){
                    $this->to_all_m($id, $num, $msg);
                }else if(count($exp) == 1){
                    $exp = explode(" ", $msg);
                    if($exp[0] == "REAL"){
                        $this->to_real_m($id, $num, $msg);
                    }else if($exp[0] == "RKAP"){
                        $this->to_est_m($id, $num, $msg);
                    }else if($exp[0] == "INFO"){
                        $this->to_info($id, $num, $msg);
                    }else if($exp[0] == "PROD"){
                        $this->to_prod($id, $num, $msg);
                    }else if($exp[0] == "SISA"){
                        $this->to_sisa_m($id, $num, $msg);
                    }else{
                        $pesan = "Error. Format pesan " .$msg ." salah.";
                    }
                }else{
                    $pesan = "Error. Format pesan " .$msg ." salah.";
                }
            }else if($validt){
                $exp = explode(" ", $msg);
                if($exp[0] == "PROD"){
                    $this->to_prod($id, $num, $msg);
                }else{
                    $pesan = "Error. Format pesan " .$msg ." salah.";
                }
            }else{
                $pesan = "Error. Ponsel " .$num ." belum terdaftar pada sistem.";
            }
            // set processed field in table inbox to 'true'
            $this->update_inbox($id);
            // insert record to outbox to send the message
            if($pesan != "") $this->to_outbox($num, $pesan);
        }
    }
    
    function init($num, $msg){
        $this->clear();
        
        $exp = explode(" ", $msg);
        if(count($exp) == 3)
            $this->tgl = $exp[1];
        else if((count($exp) == 2) && (strlen($exp[1]) > 5))
            $this->tgl = substr ($exp[1], 0, 8);
        else if(count($exp) == 2)
            $this->tgl = date("Ymd");
        
        //$tgl_len = strlen($tgl);
        
        $dt = $this->produksi_model->get_afd_from_member($num);
        $this->afdeling = $dt->afdeling;
        //$this->afdeling = strtolower($afdeling);
        
        $value = "";
        if(count($exp) == 3)
            $value = $exp[2];
        else if((count($exp) == 2) && (strlen($exp[1]) > 5))
            $value = substr ($exp[1], 8);
        else if(count($exp) == 2)
            $value = $exp[1];
        
        // get kebun based on cellphone number
        $data = $this->inbox_model->get_kebun($num);
        $this->kebun = $data['0']['kebun_unit'];
        
        return $value;
    }
    
    function init_all($num, $msg){
        $this->clear();
        
        $exp = explode(" ", $msg);
        if(count($exp) > 2)
            $this->tgl = $exp[0];
        else if(count($exp) == 2)
            $this->tgl = $exp[0];
        else
            $this->tgl = date("Ymd");
        
        $dt = $this->produksi_model->get_afd_from_member($num);
        $this->afdeling = $dt->afdeling;
        
        // get kebun based on cellphone number
        $data = $this->inbox_model->get_kebun($num);
        $this->kebun = $data['0']['kebun_unit'];
    }
    
    function init_m_all($num, $msg){
        $this->clear();
        
        $exp = explode(" ", $msg);
        if(count($exp) > 2)
            $this->tgl = $exp[0];
        else if(count($exp) == 2)
            $this->tgl = $exp[0];
        else
            $this->tgl = date("Ymd");
        
        // get kebun based on cellphone number
        $data = $this->produksi_kebun_model->get_kebun($num);
        $this->kebun = $data['0']['no_rek'];
    }
    
    function init_m($num, $msg){
        $this->clear();
        
        $exp = explode(" ", $msg);
        if(count($exp) == 3)
            $this->tgl = $exp[1];
        else if(count($exp) == 2)
            $this->tgl = date("Ymd");
        
        $tgl_len = strlen($this->tgl);
        
        $value = "";
        if(count($exp) == 3)
            $value = $exp[2];
        else if(count($exp) == 2)
            $value = $exp[1];
        
        // get kebun based on cellphone number
        $data = $this->produksi_kebun_model->get_kebun($num);
        $this->kebun = $data['0']['no_rek'];
        
        return $value;
    }
    
    // all functions
    function to_all($id, $num, $msg){
        $pesan = $this->init_all($num, $msg);
        $exp = explode(",", $msg);
        
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        
        if($this->is_null($exp)){  
            // cek apakah len tanggal 8 digit
            if($tgl_len == 8){
                $tgl = $this->to_date($tgl);
                $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
                // if data kebun belum ada
                if($rows == 0){
                    $pesan = $this->insert_all($tgl, $kebun, $afdeling, $exp, "insert");
                }else{
                    $pesan = $this->insert_all($tgl, $kebun, $afdeling, $exp, "update");
                }
            }else{
                $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
            }
        }else{
            $pesan = "Error. Lengkapi format data yg anda kirim.";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }
    
    function is_null($arr){
        $res = true;
        $tel = substr($arr[0], 8);
        $tel = trim($tel);
        if($tel == "") $res =  false;
        for($i=0; $i<count($arr); $i++){
            if(trim($arr[$i]) == "") $res = false;
        }
        return $res;
    }

    function insert_all($tgl, $kebun, $afdeling, $exp, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_all($tgl, $kebun, $afdeling, $exp);
        if($status == "update"){
            $ret = $this->produksi_model->update_all($tgl, $kebun, $afdeling, $exp);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data produksi kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of all functions
    
    // all_m functions
    function to_all_m($id, $num, $msg){
        $pesan = $this->init_m_all($num, $msg);
        $exp = explode(",", $msg);
        
        $kebun = $this->kebun;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        
        if($this->is_null($exp)){  
            // cek apakah len tanggal 8 digit
            if($tgl_len == 8){
                $tgl = $this->to_date($tgl);
                $rows = $this->produksi_kebun_model->get_rows_produksi($kebun, $tgl);
                // if data kebun belum ada
                if($rows == 0){
                    $pesan = $this->insert_all_m($tgl, $kebun, $exp, "insert");
                }else{
                    $pesan = $this->insert_all_m($tgl, $kebun, $exp, "update");
                }
            }else{
                $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
            }
        }else{
            $pesan = "Error. Lengkapi format data yg anda kirim.";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }
    
    function insert_all_m($tgl, $kebun, $exp, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_kebun_model->insert_all($tgl, $kebun, $exp);
        if($status == "update"){
            $ret = $this->produksi_kebun_model->update_all($tgl, $kebun, $exp);
            $this->produksi_kebun_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $pesan = "Terima kasih. Data produksi kebun " . $kebun . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of all_m functions

    // realisasi functions
    function to_real($id, $num, $msg){
        $realisasi = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_real($tgl, $kebun, $afdeling, $realisasi, "insert");
            }else{
                $pesan = $this->insert_real($tgl, $kebun, $afdeling, $realisasi, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_real($tgl, $kebun, $afdeling, $realisasi, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_realisasi($tgl, $kebun, $afdeling, $realisasi);
        if($status == "update"){
            $ret = $this->produksi_model->update_realisasi($tgl, $kebun, $afdeling, $realisasi);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data realisasi kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of realisasi functions

    // estimasi functions
    function to_est($id, $num, $msg){
        $estimasi = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_est($tgl, $kebun, $afdeling, $estimasi, "insert");
            }else{
                $pesan = $this->insert_est($tgl, $kebun, $afdeling, $estimasi, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_est($tgl, $kebun, $afdeling, $estimasi, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_estimasi($tgl, $kebun, $afdeling, $estimasi);
        if($status == "update"){
            $ret = $this->produksi_model->update_estimasi($tgl, $kebun, $afdeling, $estimasi);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data estimasi kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of estimasi functions

    // brondolan functions
    function to_brd($id, $num, $msg){
        $brd = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_brd($tgl, $kebun, $afdeling, $brd, "insert");
            }else{
                $pesan = $this->insert_brd($tgl, $kebun, $afdeling, $brd, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_brd($tgl, $kebun, $afdeling, $brd, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_brd($tgl, $kebun, $afdeling, $brd);
        if($status == "update"){
            $ret = $this->produksi_model->update_brd($tgl, $kebun, $afdeling, $brd);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data brondolan kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of brondolan functions

    // HK functions
    function to_hk($id, $num, $msg){
        $hk = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_hk($tgl, $kebun, $afdeling, $hk, "insert");
            }else{
                $pesan = $this->insert_hk($tgl, $kebun, $afdeling, $hk, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_hk($tgl, $kebun, $afdeling, $hk, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_hk($tgl, $kebun, $afdeling, $hk);
        if($status == "update"){
            $ret = $this->produksi_model->update_hk($tgl, $kebun, $afdeling, $hk);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data HK kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of HK functions
    
    
    // INFO functions
    function to_info($id, $num, $msg){
        $pesan = "";
        $pos = strpos($msg, " ");
        $text = substr($msg, 4);
        $text = strtolower($text);
        
        $pesan = $this->insert_info($num, $text);
        if ($pesan != "")
            $this->to_outbox($num, $pesan);
    }
    function insert_info($num, $text){
        $ret = $this->produksi_model->insert_info($num, $text);
        $pesan = "Terima kasih. Informasi telah kami terima";
        
        return $pesan;
    }
    // end of INFO functions
    
    // PROD functions
    function to_prod($id, $num, $msg){
        $pesan = "";
        $exp = explode(" ", $msg);
        $len = count($exp);
        if($len == 4){
            $kebun = $exp[1];
            $afd = $exp[2];
            $tgl = $exp[3];
            $pesan = $this->get_prod_kebun($kebun, $afd, $tgl);
        }else if($len == 3){
            $kebun = $exp[1];
            $tgl = $exp[2];
            $pesan = $this->get_prod_kebun_all($kebun, $tgl);
        }else if($len == 2){
            $tgl = $exp[1];
            $pesan = $this->get_afd_self($num, $tgl);
        }
        
        if ($pesan != "") $this->to_outbox($num, $pesan);
    }
    
    // sisa functions
    function to_sisa($id, $num, $msg){
        $sisa = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_sisa($tgl, $kebun, $afdeling, $sisa, "insert");
            }else{
                $pesan = $this->insert_sisa($tgl, $kebun, $afdeling, $sisa, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_sisa($tgl, $kebun, $afdeling, $sisa, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_sisa($tgl, $kebun, $afdeling, $sisa);
        if($status == "update"){
            $ret = $this->produksi_model->update_sisa($tgl, $kebun, $afdeling, $sisa);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data Sisa TBS kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of sisa functions
    
    // sisa curah hujan
    function to_ch($id, $num, $msg){
        $ch = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_ch($tgl, $kebun, $afdeling, $ch, "insert");
            }else{
                $pesan = $this->insert_ch($tgl, $kebun, $afdeling, $ch, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_ch($tgl, $kebun, $afdeling, $ch, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_ch($tgl, $kebun, $afdeling, $ch);
        if($status == "update"){
            $ret = $this->produksi_model->update_ch($tgl, $kebun, $afdeling, $ch);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data Curah Hujan kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of curah hujan functions
    
    // telling
    function to_tel($id, $num, $msg){
        $tel = $this->init($num, $msg);
        $kebun = $this->kebun;
        $afdeling = $this->afdeling;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $afdeling, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_tel($tgl, $kebun, $afdeling, $tel, "insert");
            }else{
                $pesan = $this->insert_tel($tgl, $kebun, $afdeling, $tel, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_tel($tgl, $kebun, $afdeling, $tel, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_model->insert_tel($tgl, $kebun, $afdeling, $tel);
        if($status == "update"){
            $ret = $this->produksi_model->update_tel($tgl, $kebun, $afdeling, $tel);
            $this->produksi_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afdeling = $this->fungsi->toRomawi($afdeling);
            $pesan = "Terima kasih. Data Telling kebun " . $kebun . " afd. " . $afdeling . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of telling
    
    function get_prod_kebun($str_kebun, $str_afd, $tgl){
        $afd = $this->fungsi->toDec($str_afd);
        $kebun = $this->fungsi->kebunToRek($str_kebun);
        $row = $this->produksi_model->get_prod_kebun_row($kebun, $afd, $tgl);
        if($row > 0){
            $r = $this->produksi_model->get_prod_kebun($kebun, $afd, $tgl);
            $pesan = $str_kebun .", Afd. " .$str_afd ." | " .$tgl ."\r\n";
            $pesan .= "Tel=" .$r->telling .", ";
            $pesan .= "Est=" .$r->estimasi .", ";
            $pesan .= "Real=" .$r->realisasi .", ";
            $pesan .= "Brd=" .$r->brondolan .", ";
            $pesan .= "Dinas=" .$r->hk_dinas .", ";
            $pesan .= "BHL=" .$r->hk_bhl .", ";
            $pesan .= "Sisa=" .$r->sisa .", ";
            $pesan .= "CH=" .$r->curah_hujan;
        }else{
            $pesan = "Data produksi yang anda request belum tersedia";
        }
        return $pesan;
    }
    
    function get_prod_kebun_all($str_kebun, $tgl){
        $kebun = $this->fungsi->kebunToRek($str_kebun);
        $row = $this->produksi_model->get_prod_kebun_all_row($kebun, $tgl);
        if($row > 0){
            $data = $this->produksi_model->get_prod_kebun_all($kebun, $tgl);
            $pesan = $str_kebun ." | " .$tgl . "\r\n";
            $pesan .= "Real PKS:" . "\r\n";
            foreach($data as $r){
                $afd = $this->fungsi->toRomawi($r->afdeling);
                $pesan .= $afd ."=" .$r->realisasi ."\r\n";
            }
        }else{
            $pesan = "Data produksi yang anda request belum tersedia";
        }
        return $pesan;
    }

    function get_afd_self($num, $tgl){
        $data_krani = $this->produksi_model->get_kebun_afd($num);
        $kebun = $data_krani->kebun_unit;
        $afd = $data_krani->afdeling;
        $tgl = $this->to_date($tgl);

        $row = $this->produksi_model->get_prod_afd_row($kebun, $afd, $tgl);
        if($row > 0){
            $r = $this->produksi_model->get_prod_afd($kebun, $afd, $tgl);
            $kebun = $r->kebun;
            $kebun = $this->fungsi->rekToKebun($kebun);
            $afd = $r->afdeling;
            $afd = $this->fungsi->toRomawi($afd);
 
            $pesan = $kebun .", Afd. " .$afd ." | " .$tgl ."\r\n";
            $pesan .= "Tel=" .$r->telling .", ";
            $pesan .= "Est=" .$r->estimasi .", ";
            $pesan .= "Real=" .$r->realisasi .", ";
            $pesan .= "Brd=" .$r->brondolan .", ";
            $pesan .= "Dinas=" .$r->hk_dinas .", ";
            $pesan .= "BHL=" .$r->hk_bhl .", ";
            $pesan .= "Sisa=" .$r->sisa .", ";
            $pesan .= "CH=" .$r->curah_hujan;
        }else{
            $pesan = "Data produksi yang anda request belum tersedia";
        }
        return $pesan;
    }
    // end of PROD functions
    

    function is_valid_sender($num){
        $rows_member = $this->inbox_model->rows_member($num);
        if($rows_member > 0){
            return true;
        }else{
            return false;
        }
    }

    function is_valid_manager($num){
        $rows_manager = $this->produksi_model->get_ponsel_kebun($num);
        if($rows_manager > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function is_toplevelman($num){
        $rows_tlm = $this->produksi_model->get_toplevelman($num);
        if($rows_tlm > 0){
            return true;
        }else{
            return false;
        }
    }

    function to_outbox($num, $pesan){
         $this->outbox_model->insert_outbox($num, $pesan);
    }

    function to_date($tgl){
        $year = substr($tgl, 0, 4);
        $month = substr($tgl, 4, 2);
        $date = substr($tgl, 6, 2);
        return $year ."-" .$month ."-" .$date;
    }
    
    function from_date($tgl){
        $year = substr($tgl, 0, 4);
        $month = substr($tgl, 5, 2);
        $date = substr($tgl, 7, 2);
        return $year ."" .$month ."" .$date;
    }

    function update_inbox($id){
        $this->inbox_model->update_inbox($id);
    }
    
    // approval publish the data
    function to_approve($num, $msg){
        $pesan = "";
        $exp = explode(" ", $msg);
        $tgl = $exp[1];
        $data = $this->produksi_model->get_kebun_manager($num);
        $kebun = $data->no_rek;
        $rows = $this->produksi_model->cek_tgl_prod($kebun, $tgl);

        $data_status = $this->produksi_model->cek_status_prod($kebun, $tgl);
        $status = $data_status->status;
        if($tgl == "" || $tgl == " "){
            $pesan = "Error. Format pesan salah. Ketik 1 spasi tanggal. Contoh:1 20120316";
        }else if($rows == 0){
            $pesan = "Error. Data produksi pd tgl." .$tgl ." belum ada pd database";
        }else if($status == 0){
            $pesan = "Error. Data produksi pd tgl." .$tgl ." belum lengkap";
        }else{
            $res = $this->produksi_model->set_approve($kebun, $tgl);
            $pesan = "Terima kasih, anda telah menyetujui publikasi data produksi tanggal " .$tgl;
        }
        return $pesan;
    }
    
    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }
    
    
    /*************************************** DATA KEBUN ********************************************/
    // realisasi functions
    function to_real_m($id, $num, $msg){
        $realisasi = $this->init_m($num, $msg);
        $kebun = $this->kebun;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_kebun_model->get_rows_produksi($kebun, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_real_m($tgl, $kebun, $realisasi, "insert");
            }else{
                $pesan = $this->insert_real_m($tgl, $kebun, $realisasi, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_real_m($tgl, $kebun, $realisasi, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_kebun_model->insert_realisasi($tgl, $kebun, $realisasi);
        if($status == "update"){
            $ret = $this->produksi_kebun_model->update_realisasi($tgl, $kebun, $realisasi);
            //$this->produksi_kebun_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $pesan = "Terima kasih. Data realisasi kebun " . $kebun ." tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of realisasi functions

    // estimasi functions
    function to_est_m($id, $num, $msg){
        $estimasi = $this->init_m($num, $msg);
        $kebun = $this->kebun;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_model->get_rows_produksi($kebun, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_est_m($tgl, $kebun, $estimasi, "insert");
            }else{
                $pesan = $this->insert_est_m($tgl, $kebun, $estimasi, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_est_m($tgl, $kebun, $estimasi, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_kebun_model->insert_estimasi($tgl, $kebun, $estimasi);
        if($status == "update"){
            $ret = $this->produksi_kebun_model->update_estimasi($tgl, $kebun, $estimasi);
            //$this->produksi_kebun_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $pesan = "Terima kasih. Data RKAP kebun " . $kebun . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of estimasi functions
    
    // sisa functions
    function to_sisa_m($id, $num, $msg){
        $sisa = $this->init_m($num, $msg);
        $kebun = $this->kebun;
        $tgl = $this->tgl;
        $tgl_len = strlen($this->tgl);
        // cek apakah len tanggal 8 digit
        if($tgl_len == 8){
            $tgl = $this->to_date($tgl);
            $rows = $this->produksi_kebun_model->get_rows_produksi($kebun, $tgl);
            // if data kebun belum ada
            if($rows == 0){
                $pesan = $this->insert_sisa_m($tgl, $kebun, $sisa, "insert");
            }else{
                $pesan = $this->insert_sisa_m($tgl, $kebun, $sisa, "update");
            }
        }else{
            $pesan = "Error. Format tanggal pd pesan (" .$msg .") salah. Periksa kembali spasi";
        }
        if($pesan != "") $this->to_outbox($num, $pesan);
    }

    function insert_sisa_m($tgl, $kebun, $sisa, $status) {
        $pesan = ""; $ret = "";
        if($status == "insert") $ret = $this->produksi_kebun_model->insert_sisa($tgl, $kebun, $sisa);
        if($status == "update"){
            $ret = $this->produksi_kebun_model->update_sisa($tgl, $kebun, $sisa);
            $this->produksi_kebun_model->set_back_status($kebun, $tgl);
        }
        if ($ret == 1) {
            $kebun = $this->fungsi->rekToKebun($kebun);
            $pesan = "Terima kasih. Data Sisa TBS kebun " . $kebun . " tgl. " . $tgl . " sudah tersimpan pada database.";
        } else {
            $pesan = "Error. Format pesan yang Anda kirim salah.";
        }
        return $pesan;
    }
    // end of sisa functions
    
    function get_status() {

        // menjalankan command untuk mengenerate file service.log
        passthru("net start > service.log");

        // membuka file service.log
        $handle = fopen("service.log", "r");

        // status awal = 0 (dianggap servicenya tidak jalan)
        $status = 0;

        // proses pembacaan isi file
        while (!feof($handle)) {
            // baca baris demi baris isi file
            $baristeks = fgets($handle);
            if (substr_count($baristeks, 'Gammu SMSD Service (GammuSMSD)') > 0) {
                // jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
                // statusnya berubah menjadi 1
                $status = 1;
            }
        }
        // menutup file
        fclose($handle);

        // jika status terakhir = 1, maka gammu service running
        if ($status == 1)
            echo "Gammu service running..";
        // jika status terakhir = 0, maka service gammu berhenti
        else if ($status == 0) {
            echo "Gammu service stopped";
            passthru("gammu-smsd -c smsdrc -s");
        }
    }

}

?>
