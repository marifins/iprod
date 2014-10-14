<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Produksi extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('produksi_model');
        $this->load->helper('url');
        $this->load->library('fungsi');
    }

    public function index($kebun = 0, $tanggal = 0){
        //if($kebun == 0) $kebun = '080.03';

        $d['query'] = $this->produksi_model->get_all($kebun, $tanggal);
        $d['rows'] = $this->produksi_model->get_rows($kebun, $tanggal);
        $d['rows_afd'] = $this->produksi_model->get_rows_afd($kebun, 2, $tanggal);
        $d['allkebun'] = $this->produksi_model->get_kebun_all();

        $this->load->library('parser');

        $data = array(
            'title' => 'Produksi',
            'judul' => 'Produksi Harian Kebun per Afdeling',
            'content' => $this->load->view('produksi/view_produksi', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
    public function index_ajax($kebun = 0, $tanggal = 0){
        //if($kebun == 0) $kebun = '080.03';
        
        $d['query'] = $this->produksi_model->get_all($kebun, $tanggal);
        $d['rows'] = $this->produksi_model->get_rows($kebun, $tanggal);
        $d['rows_afd'] = $this->produksi_model->get_rows_afd($kebun, 2, $tanggal);
        //$d['kebun'] = $kebun;

        $this->load->view('produksi/show_produksi', $d);
    }

    public function detail_afdeling($kebun = 0, $tgl = 0){
        $d['row'] = $this->produksi_model->get_data($kebun, $tgl);
        $d['kebun'] = $kebun;
        $d['tgl'] = $tgl;
        $data = array(
            'title' => 'User Details',
            'judul' => 'USER DETAILS',
        );

        $this->load->view('produksi/detail_afdeling', $d);
    }
    
    public function total_details($tgl = 0){
        $d['row'] = $this->produksi_model->get_total_details($tgl);
        $d['tgl'] = $tgl;
        $data = array(
            'title' => 'Total Details',
            'judul' => 'TOTAL DETAILS',
        );

        $this->load->view('produksi/total_details', $d);
    }
    
    public function input($tanggal = 0)
    {
        //$this->load->model('produksi_model');
        $this->load->library('parser');
        $d['afd'] = $this->produksi_model->get_afd($tanggal);
        $d['afd_rows'] = $this->produksi_model->get_afd_rows($tanggal);
        $data = array(
            'title' => 'Sistem Informasi Kebun',
            'judul' => 'Input Produksi Hari Ini',
            'content' => $this->load->view('produksi/edit_produksi', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function graph($tanggal = 0)
    {
        //$this->load->model('produksi_model');

        $d['query'] = $this->produksi_model->get_all($tanggal);
        $d['rows'] = $this->produksi_model->get_rows();

        $this->load->library('parser');
        $data = array(
            'title' => 'Kebun Cot Girek',
            'judul' => 'Grafik Perolehan Produksi',
            'content' => $this->load->view('produksi/graph', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function topdf($kebun = 0, $tanggal = 0){
        $this->load->library('cezpdf');

        $pdf = new Cezpdf();
        $pdf->selectFont('./fonts/Helvetica.afm');
        $pdf->ezText('                          Laporan Produksi Harian Kelapa Sawit', 17);

        //$tanggal = $this->fungsi->tanggal($tanggal);
        $data = $this->produksi_model->get_array($kebun, $tanggal);
        $rows_afd = $this->produksi_model->get_rows_afd($kebun, 2, $tanggal);

        $tgl = "";
        $jlh_luas = 0;
        $jlh_rkap = 0;
        $jlh_rkap_sd = 0;
        $jlh_rko = 0;
        $jlh_rko_sd = 0;
        $jlh_realisasi = 0;
        $jlh_realisasi_sd = 0;

        $jlh_dinas_hi = 0;
        $jlh_bhl_hi = 0;
        $jlh_dinas_sd_hi = 0;
        $jlh_bhl_sd_hi = 0;

        $jlh_prestasi_hi = 0;
        $jlh_prestasi_sd = 0;
        $jlh_brondolan_hi = 0;
        $jlh_brondolan_sd = 0;
        $jlh_pc_brondolan = 0;
        
        $jlh_pc_rkap = 0;
        $jlh_pc_rkap_sd = 0;
        $jlh_pc_rko = 0;
        $jlh_pc_rko_sd = 0;

        foreach($data as $r){
            $tgl = $r['tanggal'];
            $afd = $this->fungsi->toRomawi($r['afdeling']);
            
            $d = $this->produksi_model->get_luas_afdeling($kebun, $r['afdeling'], $tanggal);
            $luas = $d->luas;
            
            $hr_kerja = $this->produksi_model->get_hr_kerja($tgl);
            $jh = $hr_kerja->jlh_hari;

            $luas_afd = $this->produksi_model->get_luas_afdeling($kebun, $r['afdeling'], $tanggal);
            $la = $luas_afd->luas;
            
            $rkap_hr = $r['rkap'] / $jh;
            $rko_hr  = $r['rko'] / $jh;
            
            $rkap = $this->fungsi->setNum($rkap_hr);
            $rkap_sd = $rkap_hr * $rows_afd;
            $rkap_sd = $this->fungsi->setNum($rkap_sd);

            $rko = $this->fungsi->setNum($rko_hr);
            $rko_sd = $rko_hr * $rows_afd;
            $rko_sd = $this->fungsi->setNum($rko_sd);

            $real = $this->fungsi->setNum($r['realisasi']);
            $d = $this->produksi_model->get_sum_real($kebun, $r['afdeling'], $tanggal);

            $real_sd = "";

            foreach($d as $rw){
                $real_sd = $rw->realisasi_sd;
                $jlh_realisasi_sd += $real_sd;
            }
            $real_sd = $this->fungsi->setNum($real_sd);

            // %RKAP
            $pc_rkap = round($real / $rkap * 100,2);
            $pc_rkap_sd = round($real_sd / $rkap_sd * 100,2);

            // %RKO
            $pc_rko = round($real / $rko * 100,2);
            $pc_rko_sd = round($real_sd / $rko_sd * 100,2);

            // Jumlah
            $jlh_luas += $luas;
            $jlh_rkap += $rkap_hr;
            $jlh_rkap_sd += ($rkap_hr * $rows_afd);
            $jlh_rko += $rko_hr;
            $jlh_rko_sd += ($rko_hr * $rows_afd);
            $jlh_realisasi += $r['realisasi'];
            
            $jlh_pc_rkap = round($jlh_realisasi / $jlh_rkap * 100,2);
            $jlh_pc_rkap_sd = round($jlh_realisasi_sd / $jlh_rkap_sd * 100,2);

            $jlh_pc_rko = round($jlh_realisasi / $jlh_rko * 100,2);
            $jlh_pc_rko_sd = round($jlh_realisasi_sd / $jlh_rko_sd * 100,2);
            // end of Jumlah

            // TABLE II

            $jlh_brondolan_hi += $r['brondolan'];

            $d_hk = $this->produksi_model->get_sum_hk($kebun, $r['afdeling'], $tanggal);

            $dinas_sd = "";
            $bhl_sd = "";


            foreach($d_hk as $rw){
                $dinas_sd = $rw->dinas_sd;
                $bhl_sd = $rw->bhl_sd;
                $jlh_dinas_sd_hi += $rw->dinas_sd;
                $jlh_bhl_sd_hi += $rw->bhl_sd;
            }

            $d_br = $this->produksi_model->get_sum_br($kebun, $r['afdeling'], $tanggal);

            $br_sd = "";
            //$bhl_sd = "";

            foreach($d_br as $rw){
                $br_sd = $rw->brondolan_sd;
                //$bhl_sd = $rw->bhl_sd;
                $jlh_brondolan_sd += $rw->brondolan_sd;
            }
            
            if(($r['hk_dinas'] + $r['hk_bhl']) == 0) $prestasi_hi = 0;
            else $prestasi_hi = $r['realisasi'] / ($r['hk_dinas'] + $r['hk_bhl']);
                
            $prestasi_hi = round($prestasi_hi);
            
            if(($dinas_sd + $bhl_sd) == 0) $prestasi_sd = 0;
            else $prestasi_sd = $real_sd / ($dinas_sd + $bhl_sd);
            
            if(($jlh_dinas_sd_hi + $jlh_bhl_sd_hi) == 0) $jlh_prestasi_sd = 0;
            else $jlh_prestasi_sd = $jlh_realisasi_sd / ($jlh_dinas_sd_hi + $jlh_bhl_sd_hi);
            
            $prestasi_sd = round($prestasi_sd * 1000);
            $jlh_prestasi_sd = round($jlh_prestasi_sd);

            $brondolan_hi = $r['brondolan'];
            $br_sd_num = $this->fungsi->setNum($br_sd);
            $pc_brondolan = round($brondolan_hi / $r['realisasi'] * 100,2);

            // Jumlah
            $jlh_dinas_hi += $r['hk_dinas'];
            $jlh_bhl_hi += $r['hk_bhl'];
            
            if(($jlh_dinas_hi + $jlh_bhl_hi) == 0) $jlh_prestasi_hi = 0;
            else $jlh_prestasi_hi = $jlh_realisasi / ($jlh_dinas_hi + $jlh_bhl_hi);
            $jlh_prestasi_hi = round($jlh_prestasi_hi);
            
            $jlh_pc_brondolan = round($jlh_brondolan_hi / $jlh_realisasi * 100,2);
            
            $brondolan_hi = $this->fungsi->setNum($brondolan_hi);
            $br_sd = $this->fungsi->setNum($br_sd);

            // end of Jumlah
            // END OF TABLE II

            $db_data[] = array('afdeling' => $afd,
                'luas' => $luas, 'rkap' => $rkap,
                'rkap_sd' => $rkap_sd, 'rko' => $rko,
                'rko_sd' => $rko_sd, 'realisasi' => $real,
                'real_sd' => $real_sd, 'pc_rkap' => $pc_rkap,
                'pc_rkap_sd' => $pc_rkap_sd, 'pc_rko' => $pc_rko,
                'pc_rko_sd' => $pc_rko_sd);

            $db_brondolan[] = array('afdeling' => $afd,'dinas_hi' => $r['hk_dinas'],
                'bhl_hi' => $r['hk_bhl'], 'jlh_hi' => $r['hk_dinas'] + $r['hk_bhl'],
                'dinas_sd_hi' => $dinas_sd, 'bhl_sd_hi' => $bhl_sd,
                'jlh_sd_hi' => $dinas_sd + $bhl_sd, 'dinas_sd_bi' => $dinas_sd,
                'bhl_sd_bi' => $bhl_sd, 'jlh_sd_bi' => $dinas_sd + $bhl_sd,
                'prestasi_hi' => $prestasi_hi, 'prestasi_sd' => $prestasi_sd,
                'brondolan_hi' => $brondolan_hi, 'brondolan_sd_hi' => $br_sd,
                'brondolan_sd_bi' => $br_sd_num, 'pc_brondolan' => $pc_brondolan);

        }
        $jlh_luas = $this->fungsi->setNum($jlh_luas);
        $jlh_rkap = $this->fungsi->setNum($jlh_rkap);
        $jlh_rkap_sd = $this->fungsi->setNum($jlh_rkap_sd);
        $jlh_rko = $this->fungsi->setNum($jlh_rko);
        $jlh_rko_sd = $this->fungsi->setNum($jlh_rko_sd);
        $jlh_realisasi = $this->fungsi->setNum($jlh_realisasi);
        $jlh_realisasi_sd = $this->fungsi->setNum($jlh_realisasi_sd);

        $jlh_dinas_sd_hi = $this->fungsi->setNum($jlh_dinas_sd_hi);
        $jlh_bhl_sd_hi = $this->fungsi->setNum($jlh_bhl_sd_hi);
        
        $jlh_prestasi_hi = $this->fungsi->setNum($jlh_prestasi_hi);
        $jlh_prestasi_sd = $this->fungsi->setNum($jlh_prestasi_sd);

        $jlh_brondolan_hi = $this->fungsi->setNum($jlh_brondolan_hi);
        $jlh_brondolan_sd = $this->fungsi->setNum($jlh_brondolan_sd);



        $db_data[] = array('afdeling' => 'Total',
                'luas' => $jlh_luas, 'rkap' => $jlh_rkap,
                'rkap_sd' => $jlh_rkap_sd, 'rko' => $jlh_rko,
                'rko_sd' => $jlh_rko_sd, 'realisasi' => $jlh_realisasi,
                'real_sd' => $jlh_realisasi_sd, 'pc_rkap' => $jlh_pc_rkap,
                'pc_rkap_sd' => $jlh_pc_rkap_sd, 'pc_rko' => $jlh_pc_rko,
                'pc_rko_sd' => $jlh_pc_rko_sd);

        $db_brondolan[] = array('afdeling' => 'Total',
                'dinas_hi' => $jlh_dinas_hi, 'bhl_hi' => $jlh_bhl_hi,
                'jlh_hi' => $jlh_dinas_hi + $jlh_bhl_hi, 'dinas_sd_hi' => $jlh_dinas_sd_hi,
                'bhl_sd_hi' => $jlh_bhl_sd_hi, 'jlh_sd_hi' => $jlh_dinas_sd_hi + $jlh_bhl_sd_hi,
                'dinas_sd_bi' => $jlh_dinas_sd_hi, 'bhl_sd_bi' => $jlh_bhl_sd_hi,
                'jlh_sd_bi' => $jlh_dinas_sd_hi + $jlh_bhl_sd_hi, 'prestasi_hi' => $jlh_prestasi_hi,
                'prestasi_sd' => $jlh_prestasi_sd,'brondolan_hi' => $jlh_brondolan_hi,
                'brondolan_sd_hi' => $jlh_brondolan_sd,'brondolan_sd_bi' => $jlh_brondolan_sd,
                'pc_brondolan' => $jlh_pc_brondolan);

        $titlecolumn  = array(
            'afdeling' => 'Afd',
            'luas' => 'Luas',
            'rkap' => 'RKAP',
            'rkap_sd' => 'RKAP s/d',
            'rko' => 'RKO',
            'rko_sd' => 'RKO s/d',
            'realisasi' => 'Realisasi',
            'real_sd' => 'Realisasi s/d',
            'pc_rkap' => '% RKAP',
            'pc_rkap_sd' => '% RKAP s/d',
            'pc_rko' => '% RKO',
            'pc_rko_sd' => '% RKO s/d',
        );
        $title_brondolan  = array(
            'afdeling' => 'Afd',
            'dinas_hi' => 'Dinas HI',
            'bhl_hi' => 'BHL HI',
            'jlh_hi' => 'Jlh HI',
            'dinas_sd_hi' => 'Dinas s/d HI',
            'bhl_sd_hi' => 'BHL s/d HI',
            'jlh_sd_hi' => 'Jlh s/d HI',
            'dinas_sd_bi' => 'Dinas s/d BI',
            'bhl_sd_bi' => 'BHL s/d BI',
            'jlh_sd_bi' => 'Jlh s/d BI',
            'prestasi_hi' => '% Prestasi HI',
            'prestasi_sd' => '% Prestasi s/d',
            'brondolan_hi' => 'Brond HI',
            'brondolan_sd_hi' => 'Brond s/d HI',
            'brondolan_sd_bi' => 'Brond s/d BI',
            'pc_brondolan' => '% Brond',
        );
        
        $data_kebun = $this->produksi_model->get_kebun_name($kebun);

        $pdf->ezTable($db_data, $titlecolumn , $data_kebun->nama_kebun . " | " .$tgl, array('width' => 560, 'fontSize' => 8));
        $pdf->ezTable($db_brondolan, $title_brondolan , 'HK dan Brondolan', array('width' => 560, 'fontSize' => 8));
        $pdf->ezStream();
    }

    public function delete($id)
    {
        $this->load->model('produksi_model');
        $this->karpim_model->delete_entry($spk);
        redirect(base_url().'produksi/');
    }

    public function details($id){
        $this->load->model('produksi_model');
        $this->load->library('parser');

        $d['result'] = $this->produksi_model->get_details($id);
        $data = array(
            'title' => 'Sistem Informasi Kebun',
            'judul' => 'Detail SPK',
            'content' => $this->load->view('produksi/detail_spk', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function edit($id){
        $this->load->model('produksi_model');
        $this->load->library('parser');
        $d['afd'] = $this->produksi_model->get_afd();
        $d['rows'] = $this->produksi_model->get_afd_rows();
        $d['result'] = $this->produksi_model->get_details($id);
        $data = array(
            'title' => 'Sistem Informasi Kebun',
            'judul' => 'Edit SPK',
            'content' => $this->load->view('produksi/edit_produksi', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function insert() {
        $this->load->library('parser');
        $this->load->library('form_validation');
        $this->load->model('produksi_model');
        $d['afd'] = $this->produksi_model->get_afd();
        $d['afd_rows'] = $this->produksi_model->get_afd_rows();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run('produksi') == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Input Produksi Hari Ini',
                'content' => $this->load->view('produksi/edit_produksi', $d, TRUE)
            );
            $this->parser->parse('template', $data);
        } else {
            $this->load->model('produksi_model');
            $this->produksi_model->insert_entry();
            $this->load->helper('url');
            redirect(base_url().'produksi/input');

        }
    }

    public function update() {
        $this->load->library('parser');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Tambah Karpim',
                'content' => $this->load->view('master/edit_produksi', '', TRUE)
            );
            $this->parser->parse('template', $data);
        } else {
            $this->load->model('produksi_model');
            $this->produksi_model->update_entry();
            $this->load->helper('url');
            redirect(base_url().'master/karpim/');
        }
    }

     public function to_pdf($id = 0){
        $this->load->model('produksi_model');
        $this->load->library('cezpdf');
        $query = $this->db->query("SELECT * FROM brg");

        $db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
        $db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
        $db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'deka@someplacepsecial.com');

        $col_names = array(
            'gol_brg' => 'Name',
            'nam_gol' => 'Phone Number'
        );



        $this->cezpdf->ezTable($query, $col_names, 'Contact List', array('width' => 550));
        $this->cezpdf->ezStream();
    }

}
?>
