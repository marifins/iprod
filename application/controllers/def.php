<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package default_template
 * @modified Sep 2, 2010
 */

 class Def extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
        $this->load->model('produksi_model');
        $this->load->helper('url');
        $this->load->library('auth');
    }

    public function index($tahun = 0, $bulan = 0) {
        if($tahun == 0) $tahun = date("Y");
        if($bulan == 0) $bulan = date("m");
        
        $this->load->library('parser');

        $d['query'] = $this->produksi_model->getAll($tahun, $bulan);
        $d['rows'] = $this->produksi_model->getRowsAll($tahun, $bulan);
        
        $d['query_g'] = $this->produksi_model->getAll2($tahun, $bulan);
        $d['rows_g'] = $this->produksi_model->getRowsAll2($tahun, $bulan);
        //$d['kebun'] = $this->produksi_model->get_kebun_aktif();
        $d['tahun'] = $this->produksi_model->get_tahun_produksi();
        $d['year'] = $tahun;
        $d['month'] = $bulan;
        
        $data = array(
            'title' => 'SMS-Based Information System for Oil Palm FFB Production',
            'judul' => 'Produksi Harian Kebun',
            'content' => $this->load->view('home', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function i($tahun = 0, $bulan = 0) {
        if($tahun == 0) $tahun = date("Y");
        if($bulan == 0) $bulan = date("m");
        
        $this->load->library('parser');

        $d['query'] = $this->produksi_model->getAll($tahun, $bulan);
        $d['rows'] = $this->produksi_model->getRowsAll($tahun, $bulan);
        //$d['kebun'] = $this->produksi_model->get_kebun_aktif();
        $d['tahun'] = $this->produksi_model->get_tahun_produksi();

        $d['year'] = $tahun;
        $d['month'] = $bulan;

        $data = array(
            'title' => 'SMS-Based Information System FFB Production',
            'judul' => 'Welcome!'
        );
        $this->load->view('show_home', $d, '');
    }

    public function igraph($tahun = 0, $bulan = 0){
        if($tahun == 0) $tahun = date("Y");
        if($bulan == 0) $bulan = date("m");

        $d['query_g'] = $this->produksi_model->getAll2($tahun, $bulan);
        $d['rows_g'] = $this->produksi_model->getRowsAll2($tahun, $bulan);

        $this->load->view('graph', $d, '');
    }

    public function graph($tahun = 0, $bulan = 0) {
        if($tahun == 0) $tahun = date("Y");
        if($bulan == 0) $bulan = date("m");

        $this->load->library('parser');

        $d['query'] = $this->produksi_model->getAll($tahun, $bulan);
        $d['rows'] = $this->produksi_model->getRowsAll($tahun, $bulan);

        $data = array(
            'title' => 'SMS-Based Information System FFB Production',
            'judul' => 'Produksi Harian Kebun',
            'content' => $this->load->view('graph', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function graph2($kebun = 0){

        $d['query'] = $this->produksi_model->get_data_per_kebun($kebun);
        $d['rows'] = $this->produksi_model->get_data_per_kebun_row($kebun);

        $this->load->view('graph', $d, '');
    }
    
    public function topdf($tahun = 0, $bulan = 0){
        $this->load->library('cezpdf');
        
        $pdf = new Cezpdf();
        $pdf->selectFont('./fonts/Helvetica.afm');
        $pdf->ezText('                                     LAPORAN PRODUKSI HARIAN KEBUN', 14);
        
        if($tahun == 0) $tahun = date("Y");
        if($bulan == 0) $bulan = date("m");

        $data = $this->produksi_model->getArray($tahun, $bulan);
        
        $total_ptg = 0; $total_klm = 0; $total_kbr = 0; $total_tsw = 0; $total_jru = 0; $total_cgr = 0;
        $total = 0;
        
        foreach ($data as $r) {
            $tgl = $r['tanggal'];
            
            $ptg = $this->produksi_model->by_kebun('080.01', $tgl);
            $klm = $this->produksi_model->by_kebun('080.02', $tgl);
            $kbr = $this->produksi_model->by_kebun('080.03', $tgl);
            $tsw = $this->produksi_model->by_kebun('080.08', $tgl);
            $jru = $this->produksi_model->by_kebun('080.04', $tgl);
            $cgr = $this->produksi_model->by_kebun('080.13', $tgl);
            
            $total_ptg += $this->s($ptg); $total_klm += $this->s($klm); $total_kbr += $this->s($kbr);
            $total_tsw += $this->s($tsw); $total_jru += $this->s($jru); $total_cgr += $this->s($cgr);
            
            $jlh = $this->s($ptg) + $this->s($klm) + $this->s($kbr) + $this->s($tsw) + $this->s($jru) + $this->s($cgr);
            $total += $jlh;
           
            $db_data[] = array('tanggal' => $tgl,
                'ptg' => $this->s($ptg),
                'klm' => $this->s($klm),
                'kbr' => $this->s($kbr),
                'tsw' => $this->s($tsw),
                'jru' => $this->s($jru),
                'cgr' => $this->s($cgr),
                'jumlah' => $jlh
            );
        }
        $db_data[] = array('tanggal' => 'Total',
            'ptg' => $total_ptg,
            'klm' => $total_klm,
            'kbr' => $total_kbr,
            'tsw' => $total_tsw,
            'jru' => $total_jru,
            'cgr' => $total_cgr,
            'jumlah' => $total
        );
        
        $col_names = array(
            'tanggal' => 'Tanggal',
            'ptg' => 'PTG',
            'klm' => 'KLM',
            'kbr' => 'KBR',
            'tsw' => 'TSW',
            'jru' => 'JRU',
            'cgr' => 'CGR',
            'jumlah' => 'Jumlah'
        );
        
        
        $pdf->ezTable($db_data, $col_names, $this->fungsi->bulan($bulan)." " .$tahun, array('width' => 550, 'fontSize' => 9));
        $pdf->ezStream();
        
    }
    
    function tables() {
        $this->load->library('cezpdf');

        $db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
        $db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
        $db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');

        $col_names = array(
            'name' => 'Name',
            'phone' => 'Phone Number',
            'email' => 'E-mail Address'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Contact List', array('width' => 550));
        $this->cezpdf->ezStream();
    }
    
    function s($input){
        $res = 0;
        if (array_key_exists('0', $input)) {
            $res = $input['0']['realisasi'] / 1000;
            return round($res, 2);
        }else{
            return 0;
        }
    }
    
    public function not_found() {
        $this->load->library('parser');
        
        $data = array(
            'title' => 'Page Not Found',
            'judul' => '',
            'content' => $this->load->view('404', '', TRUE)
        );
        $this->parser->parse('template', $data);
    }
}

?>
