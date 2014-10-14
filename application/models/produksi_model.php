<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Produksi_model extends CI_Model {

    /*var $no_reg = '';
    var $nama = '';
    var $jabatan = '';
    var $gol = '';
    var $bagian = '';
    var $kebun_unit = '';*/

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all($kebun = 0, $tanggal = 0)
    {
        if($tanggal == 0 || $kebun == 0) $query = $this->db->query('SELECT p.id, p.kebun, p.afdeling, p.realisasi, p.brondolan, p.hk_dinas, p.hk_bhl, p.tanggal, l.rkap, l.rko  FROM produksi as p JOIN afdeling as l WHERE p.afdeling = l.afdeling AND p.kebun = l.kebun AND tanggal = (SELECT MAX(tanggal) FROM produksi) AND status = 1 ORDER BY afdeling');
        else $query = $this->db->query('SELECT p.id, p.kebun, p.afdeling, p.realisasi, p.brondolan, p.hk_dinas, p.hk_bhl, p.tanggal, l.rkap, l.rko  FROM produksi as p JOIN afdeling as l WHERE p.afdeling = l.afdeling AND tanggal = "'.$tanggal.'" AND p.kebun = "'.$kebun.'" AND p.kebun = l.kebun AND status = 1 ORDER BY afdeling');
        return $query->result();
    }

    function get_array($kebun = 0, $tanggal = 0)
    {
        if($tanggal == 0 || $kebun == 0) $query = $this->db->query('SELECT p.id, p.afdeling, p.realisasi, p.brondolan, p.hk_dinas, p.hk_bhl, p.tanggal, l.rkap, l.rko  FROM produksi as p JOIN afdeling as l WHERE p.afdeling = l.afdeling AND p.kebun = l.kebun AND tanggal = (SELECT MAX(tanggal) max FROM produksi) AND status = 1 ORDER BY afdeling');
        else $query = $this->db->query('SELECT p.id, p.afdeling, p.realisasi, p.brondolan, p.hk_dinas, p.hk_bhl, p.tanggal, l.rkap, l.rko  FROM produksi as p JOIN afdeling as l WHERE p.afdeling = l.afdeling AND p.kebun = "'.$kebun.'" AND p.kebun = l.kebun AND tanggal = "'.$tanggal.'" AND status = 1 ORDER BY afdeling');
        return $query->result_array();
    }

    function get_rows($kebun = 0, $tanggal = 0){
        if($tanggal == 0 || $kebun == 0) $query = $this->db->query('SELECT * FROM produksi WHERE tanggal = (SELECT MAX(tanggal) FROM produksi) AND status = 1');
        else $query = $this->db->query('SELECT * FROM produksi WHERE tanggal = "'.$tanggal.'" AND kebun = "'.$kebun.'" AND status = 1');
        return $query->num_rows();
    }
    
    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }

    function get_rows_afd($kebun, $afdeling, $tanggal){
        if($tanggal == 0){
            $data = $this->get_max_tanggal();
            $kebun = $data->kebun;
            $tanggal = $data->tanggal;
        }
        $str = substr($tanggal, 0, 7);
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'.$kebun.'" AND afdeling = "'.$afdeling.'" AND SUBSTRING(tanggal,1,7) = "'.$str.'" AND status = 1');
        return $query->num_rows();
    }
    
    function get_max_tanggal(){
        $query = $this->db->query('SELECT kebun, tanggal FROM produksi WHERE tanggal = (SELECT MAX(tanggal) FROM produksi WHERE status = 1) AND status = 1');
        return $query->row();
    }

    function get_sum_real($kebun, $afdeling, $tanggal){
        $str = substr($tanggal, 0, 7);
        $query = $this->db->query('SELECT (SUM(realisasi)) as realisasi_sd FROM produksi WHERE kebun = "'.$kebun.'" AND afdeling = "'.$afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" AND status = 1 GROUP BY afdeling');
        return $query->result();
    }

    function get_sum_hk($kebun, $afdeling, $tanggal){
        $str = substr($tanggal, 0, 7);
        $query = $this->db->query('SELECT (SUM(hk_dinas)) as dinas_sd, (SUM(hk_bhl)) as bhl_sd FROM produksi WHERE kebun = "'.$kebun.'" AND afdeling = "'.$afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" AND status = 1 GROUP BY afdeling');
        return $query->result();
    }

    function get_sum_br($kebun, $afdeling, $tanggal){
        $str = substr($tanggal, 0, 7);
        $query = $this->db->query('SELECT (SUM(brondolan)) as brondolan_sd, (SUM(realisasi)) as realisasi_sd FROM produksi WHERE kebun = "'.$kebun.'" AND afdeling = "'.$afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" AND status = 1 GROUP BY afdeling');
        return $query->result();
    }

    function get_afd($tanggal = 0){
        if($tanggal == 0) $query = $this->db->query('SELECT afdeling FROM afdeling WHERE afdeling NOT IN (SELECT afdeling from produksi WHERE tanggal = CURDATE() AND status = 1)');
        else $query = $this->db->query('SELECT afdeling FROM afdeling WHERE afdeling NOT IN (SELECT afdeling from produksi WHERE tanggal = "'.$tanggal.'" AND status = 1)');
        return $query->result();
    }

    function get_afd_rows($tanggal = 0){
        if($tanggal == 0) $query = $this->db->query('SELECT afdeling FROM afdeling WHERE afdeling NOT IN (SELECT afdeling from produksi WHERE tanggal = CURDATE() AND status = 1)');
        else $query = $this->db->query('SELECT afdeling FROM afdeling WHERE afdeling NOT IN (SELECT afdeling from produksi WHERE tanggal = "'.$tanggal.'" AND status = 1)');
        return $query->num_rows();
    }

    /*function get_produksi()
    {
        $query = $this->db->query('SELECT id, afdeling, realisasi, (SUM(realisasi)) as realisasi_sd, tanggal FROM produksi GROUP BY afdeling');
        return $query->result();
    }*/

    function count(){
        $query = $this->db->query('SELECT * FROM produksi WHERE status = 1');
        return $query->num_rows();
    }

    function insert_entry()
    {
        $this->id = '';
        $this->afdeling = $_POST['afdeling'];
        $this->realisasi = $_POST['realisasi_tbs'];
        $this->brondolan = $_POST['brondolan'];
        $this->hk_dinas = $_POST['hk_dinas'];
        $this->hk_bhl = $_POST['hk_bhl'];
        $this->tanggal = $_POST['tanggal'];

        $this->db->insert('produksi', $this);
    }

    function update_entry()
    {
        $this->no_reg = $_POST['no_reg'];
        $this->nama = $_POST['nama'];
        $this->jabatan = $_POST['jabatan'];
        $this->gol = $_POST['gol'];
        $this->bagian = $_POST['bagian'];
        $this->kebun_unit = $_POST['kebun_unit'];

        $this->db->update('produksi', $this, array('no_reg' => $_POST['no_reg']));
    }

    function get_details($id){
        $query = $this->db->query('SELECT * FROM produksi WHERE id = '.$id.' AND status = 1');
        return $query->row();
    }

    function delete_entry($id){
        $this->db->query('DELETE FROM produksi WHERE no_reg = '.$id.'');
    }

    function get_rows_produksi($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'"');
        return $query->num_rows();
    }

    function get_rows_realisasi($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND realisasi IS NOT NULL');
        return $query->num_rows();
    }

    function get_rows_estimasi($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND estimasi IS NOT NULL');
        return $query->num_rows();
    }

    function get_rows_brd($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND brondolan IS NOT NULL');
        return $query->num_rows();
    }

    function get_rows_hk($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND hk_dinas IS NOT NULL');
        return $query->num_rows();
    }
    
    function get_rows_sisa($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND sisa IS NOT NULL');
        return $query->num_rows();
    }
    
    function get_rows_ch($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND curah_hujan IS NOT NULL');
        return $query->num_rows();
    }
    
    function get_rows_tel($kebun, $afdeling, $tgl){
        $query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'. $kebun .'" AND afdeling = "'. $afdeling .'" AND tanggal = "'. $tgl .'" AND telling IS NOT NULL');
        return $query->num_rows();
    }
    
    function insert_all($tgl, $kebun, $afdeling, $arr){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $tel = substr($arr[0], 8);
        $this->telling = trim($tel);
        $this->estimasi = trim($arr[1]);
        $this->realisasi = trim($arr[2]);
        $this->brondolan = trim($arr[3]);
        $this->sisa = trim($arr[4]);
        $this->curah_hujan = trim($arr[5]);
        $this->hk_dinas = trim($arr[6]);
        $this->hk_bhl = trim($arr[7]);

        $this->db->insert('produksi', $this);
        return $this->get_rows_realisasi($kebun, $afdeling, $tgl);
    }

    function update_all($tgl, $kebun, $afdeling, $arr){
        $tel = substr($arr[0], 8);
        $this->telling = trim($tel);
        $this->estimasi = $arr[1];
        $this->realisasi = $arr[2];
        $this->brondolan = $arr[3];
        $this->sisa = $arr[4];
        $this->curah_hujan = $arr[5];
        $this->hk_dinas = $arr[6];
        $this->hk_bhl = $arr[7];

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_realisasi($kebun, $afdeling, $tgl);
    }

    function insert_realisasi($tgl, $kebun, $afdeling, $realisasi){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $this->realisasi = $realisasi;

        $this->db->insert('produksi', $this);
        return $this->get_rows_realisasi($kebun, $afdeling, $tgl);
    }

    function update_realisasi($tgl, $kebun, $afdeling, $realisasi){
        $this->realisasi = $realisasi;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_realisasi($kebun, $afdeling, $tgl);
    }

    function insert_estimasi($tgl, $kebun, $afdeling, $estimasi){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $this->estimasi = $estimasi;

        $this->db->insert('produksi', $this);
        return $this->get_rows_estimasi($kebun, $afdeling, $tgl);
    }

    function update_estimasi($tgl, $kebun, $afdeling, $estimasi){
        $this->estimasi = $estimasi;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_estimasi($kebun, $afdeling, $tgl);
    }

    function insert_brd($tgl, $kebun, $afdeling, $brd){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $this->brondolan = $brd;

        $this->db->insert('produksi', $this);
        return $this->get_rows_brd($kebun, $afdeling, $tgl);
    }

    function update_brd($tgl, $kebun, $afdeling, $brd){
        $this->brondolan = $brd;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_brd($kebun, $afdeling, $tgl);
    }

    function insert_hk($tgl, $kebun, $afdeling, $hk){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $data = explode('/', $hk);
        $this->hk_dinas = $data[0];
        $this->hk_bhl = $data[1];

        $this->db->insert('produksi', $this);
        return $this->get_rows_hk($kebun, $afdeling, $tgl);
    }

    function update_hk($tgl, $kebun, $afdeling, $hk){
        $data = explode('/', $hk);
		
        if(isset($data[0])) $this->hk_dinas = $data[0];
		else $this->hk_dinas = "";
		
        if(isset($data[1])) $this->hk_bhl = $data[1];
		else $this->hk_bhl = "";

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_hk($kebun, $afdeling, $tgl);
    }
    
    function insert_sisa($tgl, $kebun, $afdeling, $sisa){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $this->sisa = $sisa;

        $this->db->insert('produksi', $this);
        return $this->get_rows_sisa($kebun, $afdeling, $tgl);
    }

    function update_sisa($tgl, $kebun, $afdeling, $sisa){
        $this->sisa = $sisa;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_sisa($kebun, $afdeling, $tgl);
    }
    
    function insert_ch($tgl, $kebun, $afdeling, $ch){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        //if($ch == '0') $ch = '1';
        $this->curah_hujan = $ch;

        $this->db->insert('produksi', $this);
        return $this->get_rows_ch($kebun, $afdeling, $tgl);
    }

    function update_ch($tgl, $kebun, $afdeling, $ch){
        //if($ch == '0') $ch = '1';
        $this->curah_hujan = $ch;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_ch($kebun, $afdeling, $tgl);
    }
    
    function insert_tel($tgl, $kebun, $afdeling, $tel){
        $this->tanggal = $tgl;
        $this->kebun = $kebun;
        $this->afdeling = $afdeling;
        $this->telling = $tel;

        $this->db->insert('produksi', $this);
        return $this->get_rows_tel($kebun, $afdeling, $tgl);
    }

    function update_tel($tgl, $kebun, $afdeling, $tel){
        $this->telling = $tel;

        $this->db->update('produksi', $this, array('tanggal' => $tgl, 'kebun' => $kebun, 'afdeling' => $afdeling));
        return $this->get_rows_tel($kebun, $afdeling, $tgl);
    }
    
    function getAll($tahun, $bulan) {
        if($tahun == "0") $tahun = date("Y");
        if($bulan == "0") $bulan = date("m");
        $str = $tahun ."-" .$bulan;

        $this->db->select('*');
        $this->db->from('produksi');
        //$this->db->limit(5);
        $this->db->where('SUBSTRING(tanggal,1,7)', $str);
        $this->db->where('status','1');
        $this->db->order_by('tanggal', 'ASC');
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->result();
    }

    function getRowsAll($tahun, $bulan) {
        if($tahun == "0") $tahun = date("Y");
        if($bulan == "0") $bulan = date("m");
        $str = $tahun ."-" .$bulan;

        $this->db->select('*');
        $this->db->from('produksi');
        //$this->db->limit(5);
        $this->db->where('SUBSTRING(tanggal,1,7)', $str);
        $this->db->where('status','1');
        $this->db->order_by('tanggal', 'ASC');
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function getAll2($tahun, $bulan) {
        if($tahun == "0") $tahun = date("Y");
        if($bulan == "0") $bulan = date("m");
        $str = $tahun ."-" .$bulan;

        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->limit(5);
        $this->db->where('SUBSTRING(tanggal,1,7)', $str);
        $this->db->where('status','1');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->result();
    }

    function getRowsAll2($tahun, $bulan) {
        if($tahun == "0") $tahun = date("Y");
        if($bulan == "0") $bulan = date("m");
        $str = $tahun ."-" .$bulan;

        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->limit(5);
        $this->db->where('SUBSTRING(tanggal,1,7)', $str);
        $this->db->where('status','1');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function getArray($tahun, $bulan) {
        if($tahun == "0") $tahun = date("Y");
        if($bulan == "0") $bulan = date("m");
        $str = $tahun ."-" .$bulan;

        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->where('SUBSTRING(tanggal,1,7)', $str);
        $this->db->where('status','1');
        $this->db->order_by('tanggal', 'ASC');
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->result_array();
    }

    function by_kebun($id, $tgl){
        $query = $this->db->query('SELECT (SUM(realisasi)) realisasi FROM produksi WHERE kebun = "' . $id . '" AND tanggal = "'. $tgl .'"');
        return $query->result_array();
    }

    function get_details_afd($kebun, $tgl){
        //if($tgl == "0") $tgl = date("Y-mm-dd");

        $this->db->select('kebun, telling, afdeling, estimasi, realisasi, brondolan, sisa, curah_hujan, hk_dinas, hk_bhl');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $this->db->order_by('afdeling', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_total_details($tgl){
        $this->db->select('SUM(telling) as telling, SUM(afdeling) as afdeling, SUM(estimasi) as estimasi, SUM(realisasi) as realisasi, SUM(brondolan) as brondolan, SUM(sisa) as sisa, SUM(curah_hujan) as curah_hujan, SUM(hk_dinas) as hk_dinas, SUM(hk_bhl) as hk_bhl');
        $this->db->from('produksi');
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->row();
    }

    function get_tahun_produksi() {
        $query = $this->db->query('SELECT DISTINCT SUBSTRING(tanggal,1,4) AS tahun FROM produksi');
        return $query->result();
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
    
    function get_data($kebun,$tanggal)
    {
        //if($kebun == 0) $kebun = '080.03';
        if($tanggal == 0) $tanggal = date('Y-m-d');
        //$query = $this->db->query('SELECT * FROM produksi WHERE kebun = "'.$kebun.'" AND tanggal = "'.$tanggal.'" ORDER BY afdeling');
        $query = $this->db->query('SELECT m.afdeling, p.kebun, p.telling, p.estimasi, p.realisasi, p.brondolan, p.sisa, p.curah_hujan, hk_dinas, hk_bhl FROM member AS m LEFT JOIN (SELECT * FROM produksi WHERE kebun = "'.$kebun.'" AND tanggal = "'.$tanggal.'") AS p ON m.afdeling = p.afdeling WHERE m.kebun_unit = "'.$kebun.'" ORDER BY m.register');
        return $query->result();
    }

    function get_data_per_kebun($kebun){
        $query = $this->db->query('SELECT SUM(estimasi) estimasi, SUM(realisasi) realisasi, tanggal FROM produksi WHERE kebun = "'.$kebun.'" GROUP BY TANGGAL ORDER BY tanggal LIMIT 5');
        return $query->result();
    }

    function get_data_per_kebun_row($kebun){
        $query = $this->db->query('SELECT SUM(estimasi) estimasi, SUM(realisasi) realisasi, tanggal FROM produksi WHERE kebun = "'.$kebun.'" GROUP BY TANGGAL ORDER BY tanggal LIMIT 5');
        return $query->num_rows();
    }
    
    function insert_info($num, $text){
        $this->no_ponsel = $num;
        $this->text = $text;
        
        $this->db->insert('info', $this);
    }
    
    /************************* Get Data Produksi ***************************/
    function get_prod_kebun($kebun, $afd, $tgl){
        $this->db->select('telling, estimasi, realisasi, brondolan, hk_dinas, hk_bhl, curah_hujan, sisa');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afd);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->row();
    }
    function get_prod_kebun_row($kebun, $afd, $tgl){
        $this->db->select('estimasi, realisasi, brondolan, hk_dinas, hk_bhl');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afd);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_prod_kebun_all($kebun, $tgl){
        $this->db->select('afdeling, realisasi');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_prod_kebun_all_row($kebun, $tgl){
        $this->db->select('realisasi');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_luas_afdeling($kebun, $afdeling, $tanggal){
        $this->db->select('luas');
        $this->db->from('luas_afdeling');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afdeling);
        $this->db->where('tahun', substr($tanggal, 0, 4));
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_hr_kerja($tgl){
        $bulan = substr($tgl, 5, 2);
        $tahun = substr($tgl, 0, 4);
        
        $this->db->select('jlh_hari');
        $this->db->from('hk');
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();
        return $query->row();
    }

    function get_jlh_afd($no_rek){
        $this->db->select('no_rek');
        $this->db->from('kebun');
        $this->db->where('no_rek', $no_rek);
        return $query->num_rows();
    }
    /********************** End of Get Data Produksi ***********************/
    
    function get_user(){
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_afd_from_member($num){
        $this->db->select('afdeling');
        $this->db->from('member');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_toplevelman($num){
        $this->db->select('register');
        $this->db->from('management');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // approval to publish production data
    function get_ponsel_kebun($num){
        $this->db->select('no_rek');
        $this->db->from('kebun');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_kebun_manager($num){
        $this->db->select('no_rek');
        $this->db->from('kebun');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->row();
    }

    function get_ponsel_manager($kebun){
        $this->db->select('no_ponsel');
        $this->db->from('kebun');
        $this->db->where('no_rek', $kebun);
        $query = $this->db->get();
        return $query->row();
    }
    
    function set_approve($kebun, $tgl){
        $data = array(
            'status' => '1'
        );
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $this->db->update('produksi', $data);
    }

    function cek_tgl_prod($kebun, $tgl){
        $this->db->select('tanggal');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function cek_status_prod($kebun, $tgl){
        $query = $this->db->query('SELECT DISTINCT status FROM produksi WHERE kebun = "'.$kebun.'" AND tanggal = "'.$tgl.'"');
        return $query->row();
    }

    function after_send($kebun, $afd, $tgl){
        $data = array(
            'status' => '1'
        );
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afd);
        $this->db->where('tanggal', $tgl);
        $this->db->update('produksi', $data);
    }

    function check_afd($kebun, $tgl){
        $this->db->select('kebun, afdeling');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $this->db->where('status', '0');
        $this->db->where('telling IS NOT NULL', null);
        $this->db->where('estimasi IS NOT NULL', null);
        $this->db->where('realisasi IS NOT NULL', null);
        $this->db->where('brondolan IS NOT NULL', null);
        $this->db->where('sisa IS NOT NULL', null);
        $this->db->where('curah_hujan IS NOT NULL', null);
        $this->db->where('hk_dinas IS NOT NULL', null);
        $this->db->where('hk_bhl IS NOT NULL', null);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_data_kebun($kebun, $tgl){
        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $this->db->where('status', '0');
        $this->db->where('telling IS NOT NULL', null);
        $this->db->where('estimasi IS NOT NULL', null);
        $this->db->where('realisasi IS NOT NULL', null);
        $this->db->where('brondolan IS NOT NULL', null);
        $this->db->where('sisa IS NOT NULL', null);
        $this->db->where('curah_hujan IS NOT NULL', null);
        $this->db->where('hk_dinas IS NOT NULL', null);
        $this->db->where('hk_bhl IS NOT NULL', null);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_not_app(){
        $query = $this->db->query('SELECT DISTINCT tanggal FROM produksi WHERE status = 0');
        return $query->result();
    }

    function get_kebun_afd($num){
        $this->db->select('kebun_unit, afdeling');
        $this->db->from('member');
        $this->db->where('no_ponsel', $num);
        $query = $this->db->get();
        return $query->row();
    }

    function get_prod_afd_row($kebun, $afd, $tgl){
        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afd);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_prod_afd($kebun, $afd, $tgl){
        $this->db->select('*');
        $this->db->from('produksi');
        $this->db->where('kebun', $kebun);
        $this->db->where('afdeling', $afd);
        $this->db->where('tanggal', $tgl);
        $query = $this->db->get();
        return $query->row();
    }

    function set_back_status($kebun, $tgl){
        $data = array(
            'status' => '0'
        );
        $this->db->where('kebun', $kebun);
        $this->db->where('tanggal', $tgl);
        $this->db->update('produksi', $data);
    }
}
?>
