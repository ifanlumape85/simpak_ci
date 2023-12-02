<?php
class Kegiatan_harian extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Kegiatan_harian_model', 'kegiatan_harian', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Jenis_kuantitas_model', 'jenis_kuantitas', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Verifikator_model', 'verifikator', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Kegiatan harian',
				'main_view' => 'kegiatan_harian/kegiatan_harian',
				'form_view' => 'kegiatan_harian/kegiatan_harian_form',
			);

			if ($this->session->userdata('user_level_id') == 1)
				$instansis = $this->instansi->get_list_instansi();
			else
				$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));

			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_kuantitas = $this->jenis_kuantitas->get_jenis_kuantitas();
			$opt_jenis_kuantitas = array('' => 'Semua Jenis Kuantitas');
			foreach ($jenis_kuantitas as $v) {
				$opt_jenis_kuantitas[$v->id_jenis_kuantitas] = $v->nama_jenis_kuantitas;
			}
			$data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas2" class="form-control"');
			$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;
			$this->load->view('admin/template', $data);
		}
	}

	function sebagai_atasan()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Kegiatan harian',
				'main_view' => 'kegiatan_harian/kegiatan_harian_sebagai_atasan',
				'form_view' => 'kegiatan_harian/kegiatan_harian_sebagai_atasan_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_kuantitas = $this->jenis_kuantitas->get_jenis_kuantitas();
			$opt_jenis_kuantitas = array('' => 'Semua Jenis Kuantitas');
			foreach ($jenis_kuantitas as $v) {
				$opt_jenis_kuantitas[$v->id_jenis_kuantitas] = $v->nama_jenis_kuantitas;
			}
			$data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas2" class="form-control"');
			$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;
			$this->load->view('admin/template', $data);
		}
	}

	function sebagai_pegawai()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Kegiatan harian',
				'main_view' => 'kegiatan_harian/kegiatan_harian_sebagai_pegawai',
				'form_view' => 'kegiatan_harian/kegiatan_harian_sebagai_pegawai_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_kuantitas = $this->jenis_kuantitas->get_jenis_kuantitas();
			$opt_jenis_kuantitas = array('' => 'Semua Jenis Kuantitas');
			foreach ($jenis_kuantitas as $v) {
				$opt_jenis_kuantitas[$v->id_jenis_kuantitas] = $v->nama_jenis_kuantitas;
			}
			$data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas2" class="form-control"');
			$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;
			$this->load->view('admin/template', $data);
		}
	}

	function laporan()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Kegiatan harian',
				'main_view' => 'kegiatan_harian/laporan',
				'form_view' => 'kegiatan_harian/laporan_form',
			);

			$instansis = $this->instansi->get_list_instansi();
			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_kuantitass = $this->jenis_kuantitas->get_list_jenis_kuantitas();
			$opt_jenis_kuantitas = array('' => 'All Jenis Kuantitas ');
			foreach ($jenis_kuantitass as $i => $v) {
				$opt_jenis_kuantitas[$i] = $v;
			}

			$data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2', $opt_jenis_kuantitas, '', 'id="id_jenis_kuantitas2" class="form-control"');
			$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;

			$this->load->view('admin/template', $data);
		}
	}

	function laporan_kegiatan()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE);
		$id_pegawai = $this->input->post('id_pegawai', TRUE);
		$tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal', TRUE))) ?? date('Y-m-d');
		$tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir', TRUE))) ?? date('Y-m-d');

		$sql = "
		SELECT
			kegiatan_harian.*,
			jenis_kuantitas.nama_jenis_kuantitas,
			pegawai.id_instansi, pegawai.nama_pegawai
		FROM
			kegiatan_harian
			LEFT JOIN jenis_kuantitas ON kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas
			LEFT JOIN pegawai ON kegiatan_harian.id_pegawai=pegawai.id_pegawai

		";

		if ($tgl_awal != "" && $tgl_akhir == "") {
			$sql .= " WHERE kegiatan_harian.tgl_kegiatan = '$tgl_awal'";
		} elseif ($tgl_awal == "" && $tgl_akhir != "") {
			$sql .= " WHERE kegiatan_harian.tgl_kegiatan = '$tgl_akhir'";
		} else {
			$sql .= " WHERE kegiatan_harian.tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		}

		if ($id_instansi != "") {
			if ($tgl_awal != "" || $tgl_akhir != "") {
				$sql .= " AND pegawai.id_instansi=$id_instansi";
			} else {
				$sql .= " WHERE pegawai.id_instansi=$id_instansi";
			}
		}
		if ($id_pegawai != "") {
			$sql .= " AND kegiatan_harian.id_pegawai=$id_pegawai";
		}

		$html = '
		<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
	 		<tr>
	 			<th>No.</th>
                <th>ASN</th>
                <th>HARI/TANGGAL</th>
				<th>URAIAN KINERJA</th>
				<th>OUTPUT</th>
			</tr>
        </thead>

        <tbody>';

		$qry = $this->db->query($sql);

		if ($qry->num_rows() > 0) {
			$i = 1;
			foreach ($qry->result() as $value) {

				$html .= '
    			<tr>
    				<td>' . $i . '</td>
    				<td>' . $value->nama_pegawai . '</td>
    				<td>' . tgl_indonesia($value->tgl_kegiatan) . '</td>
    				<td>' . $value->kegiatan . '</td>
    				<td>' . $value->kuantitas . ' ' . $value->nama_jenis_kuantitas . '</td>
    			</tr>';
				$i++;
			}
		}

		$html .= '</tbody>
        <tfoot>
	 		<tr>
	 			<td></td>
	 			<td>ASN</td>
	 			<td>HARI/TANGGAL</td>
				<td>URAIAN KEGIATAN</td>
				<td>OUTPUT</td>
			</tr>
       </tfoot>
   </table>
		';

		echo $html;
	}

	function tahun_anggaran($str)
	{
		$bulan = date('n', strtotime($str));
		$tahun_anggaran = getBulan($bulan);
		return $tahun_anggaran;
	}

	function download_laporan()
	{
		$id_pegawai = $this->input->post('id_pegawai', TRUE);
		$tgl_mulai = $this->input->post('tgl_awal', TRUE);
		$tgl_selesai = $this->input->post('tgl_akhir', TRUE);
		echo anchor(base_url("kegiatan_harian/laporan_pdf/"
			. decode($id_pegawai) . "/" . decode(str_replace('-', '', $tgl_mulai)) . "/" . decode(str_replace('-', '', $tgl_selesai))), "Download Disini", 'target="_blank"');
	}

	function format_ke_tanggal($str)
	{
		$tgl = substr($str, 0, 2);
		$bln = substr($str, 2, 2);
		$thn = substr($str, 4, 4);
		return $thn . '-' . $bln . '-' . $tgl;
	}

	function laporan_pdf()
	{
		// $this->load->library('pdf');
		$this->load->library('pdfgenerator');
		$id_pegawai = $this->uri->segment(3);
		$tgl_mulai = $this->uri->segment(4);
		$tgl_mulai = date('Y-m-d', strtotime($tgl_mulai));
		// $tgl_mulai = $this->format_ke_tanggal($tgl_mulai);
		$tgl_selesai = $this->uri->segment(5);
		$tgl_selesai = date('Y-m-d', strtotime($tgl_selesai));
		// $tgl_selesai = $this->format_ke_tanggal($tgl_selesai);

		$sql = "
		select
			kegiatan_harian.*,
			jenis_kuantitas.nama_jenis_kuantitas
		from
			kegiatan_harian
			left join jenis_kuantitas on kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas
		where
			kegiatan_harian.id_pegawai='$id_pegawai' and (kegiatan_harian.tgl_kegiatan between '$tgl_mulai' and '$tgl_selesai')
		";

		// echo $sql;

		$qry = $this->db->query($sql);
		$kegiatan_harians = $qry->result();

		$verifikator = $this->verifikator->get_verifikator_pegawai($id_pegawai);
		$pegawai = $this->pegawai->get_by_id($id_pegawai);
		$atasan_langsung = $this->pegawai->get_by_id($verifikator);

		$data = array(
			'kegiatan_harians' 	=> $kegiatan_harians,
			'tahun_anggaran' 	=> $this->tahun_anggaran($tgl_mulai),
			'nama_pegawai'		=> $pegawai->nama_pegawai,
			'nip'				=> $pegawai->nip,
			'nama_jabatan'		=> $pegawai->nama_jabatan,
			'nama_instansi'		=> $pegawai->nama_instansi,
			'nama_atasan'		=> @$atasan_langsung->nama_pegawai,
			'nip_atasan'		=> @$atasan_langsung->nip,
			'jabatan_atasan'	=> @$atasan_langsung->nama_jabatan
		);

		// filename dari pdf ketika didownload
		$file_pdf = 'laporan_kinerja';
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('kegiatan_harian/laporan_kinerja_pdf', $data, true);

		// run dompdf
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

		// $this->pdf->load_view('kegiatan_harian/laporan_kinerja_pdf', $data);
		// $this->pdf->render();
		// $this->pdf->stream("laporan_kinerja.pdf");
	}

	function laporan_nilai_pdf()
	{
		$id_instansi = "2";
		$bulan = "7";
		$qry = $this->db->query("
		SELECT
			pegawai.id_pegawai, pegawai.nama_pegawai, pegawai.nip, pegawai.id_jabatan,
			(SELECT sum(kuantitas) FROM kegiatan_harian WHERE
			id_pegawai=pegawai.id_pegawai AND MONTH(tgl_kegiatan)='" . $bulan . "') k,
			jabatan.urutan
		FROM
			pegawai
			LEFT JOIN jabatan ON pegawai.id_jabatan=jabatan.id_jabatan
		WHERE
			pegawai.id_instansi=" . $id_instansi . "
		ORDER BY
			jabatan.urutan
		");

		$html = '
		<table>
			<tr>
				<td rowspan="2">No</td>
				<td rowspan="2">Nama / NIP</td>
				<td>Indikator Kerja 60%</td>
				<td rowspan="2">Total (%)</td>
			</tr>
			<tr>
			<td>Jumlah Bobot Nilai</td>
			</tr>
		';
		if ($qry->num_rows() > 0) {

			$i = 1;
			foreach ($qry->result() as $rest) {
				$html .= '<tr>
					<td>' . $i . '</td>
					<td>' . strtoupper($rest->nama_pegawai) . '/' . $rest->nip . '</td>
					<td>' . $rest->k . '</td>
					<td>100%</td>
				</tr>';
				$i++;
			}
		}
		$html .= '<tr><td></td><td></td><td></td><td></td></tr></table>';
		echo $html;
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_harian->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_harian) {
			$no++;
			$row = array();

			$status = $kegiatan_harian->status;
			if ($status == '0')
				$lbl_status = '<small class="label label-warning">Menunggu</label>';
			elseif ($status == '1')
				$lbl_status = '<small class="label label-success">Disetujui</label>';
			else
				$lbl_status = '<small class="label label-danger">Ditolak</label>';

			$row[] = '<input type="checkbox" class="data-check" value="' . $kegiatan_harian->id_kegiatan_harian . '">';
			$row[] = $no;
			$row[] = $kegiatan_harian->nama_pegawai;
			$row[] = $kegiatan_harian->nama_instansi;
			$row[] = tgl_indonesia2($kegiatan_harian->tgl_kegiatan);
			$row[] = $kegiatan_harian->kegiatan;
			$row[] = $kegiatan_harian->kuantitas . ' ' . $kegiatan_harian->nama_jenis_kuantitas;
			$row[] = $lbl_status;
			$row[] = $kegiatan_harian->jam_mulai . ' s/d ' . $kegiatan_harian->jam_selesai;


			if ($kegiatan_harian->photo)
				$row[] = '<a href="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" target="_blank"><img src="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';
			//add html for action

			if ($kegiatan_harian->kunci == '1') {
				$row[] = '<a class="btn btn-sm btn-success btn-flat" href="javascript:void(0)" title="Edit" onclick="detail_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Detail</a>';
			} else {
				$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->kegiatan_harian->count_all(),
			"recordsFiltered" 	=> $this->kegiatan_harian->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list3()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_harian->get_datatables3();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_harian) {
			$no++;
			$row = array();

			$status = $kegiatan_harian->status;
			if ($status == '0')
				$lbl_status = '<small class="label label-warning">Menunggu</label>';
			elseif ($status == '1')
				$lbl_status = '<small class="label label-success">Disetujui</label>';
			else
				$lbl_status = '<small class="label label-danger">Ditolak</label>';

			$row[] = '<input type="checkbox" class="data-check" value="' . $kegiatan_harian->id_kegiatan_harian . '">';
			$row[] = $no;
			$row[] = $kegiatan_harian->nama_pegawai;
			$row[] = $kegiatan_harian->nama_instansi;
			$row[] = tgl_indonesia2($kegiatan_harian->tgl_kegiatan);
			$row[] = $kegiatan_harian->kegiatan;
			$row[] = $kegiatan_harian->kuantitas . ' ' . $kegiatan_harian->nama_jenis_kuantitas;
			$row[] = $lbl_status;
			$row[] = $kegiatan_harian->jam_mulai . ' s/d ' . $kegiatan_harian->jam_selesai;


			if ($kegiatan_harian->photo)
				$row[] = '<a href="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" target="_blank"><img src="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';
			//add html for action

			if ($kegiatan_harian->kunci == '1') {
				$row[] = '<a class="btn btn-sm btn-success btn-flat" href="javascript:void(0)" title="Edit" onclick="detail_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Detail</a>';
			} else {
				$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->kegiatan_harian->count_all(),
			"recordsFiltered" 	=> $this->kegiatan_harian->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list2()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_harian->get_datatables2();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_harian) {
			$no++;
			$row = array();

			$status = $kegiatan_harian->status;
			if ($status == '0')
				$lbl_status = '<small class="label label-warning">Menunggu</label>';
			elseif ($status == '1')
				$lbl_status = '<small class="label label-success">Disetujui</label>';
			else
				$lbl_status = '<small class="label label-danger">Ditolak</label>';

			$row[] = $no;
			$row[] = $kegiatan_harian->nama_pegawai;
			$row[] = $kegiatan_harian->nama_instansi;
			$row[] = tgl_indonesia2($kegiatan_harian->tgl_kegiatan);
			$row[] = $kegiatan_harian->kegiatan;
			$row[] = $kegiatan_harian->kuantitas . ' ' . $kegiatan_harian->nama_jenis_kuantitas;
			$row[] = $lbl_status;
			$row[] = $kegiatan_harian->jam_mulai . ' s/d ' . $kegiatan_harian->jam_selesai;


			if ($kegiatan_harian->photo)
				$row[] = '<a href="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" target="_blank"><img src="' . base_url('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo) . '" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';
			//add html for action


			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_harian(' . "'" . $kegiatan_harian->id_kegiatan_harian . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Verifikasi</a>';



			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->kegiatan_harian->count_all(),
			"recordsFiltered" 	=> $this->kegiatan_harian->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id = "")
	{
		if ($this->input->post('id', TRUE))
			$id = $this->input->post('id', TRUE);

		$data = $this->kegiatan_harian->get_by_id($id);
		$data->tgl_kegiatan = ($data->tgl_kegiatan == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_kegiatan)); // if 0000-00-00 set tu empty for datepicker compatibility

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'id_verifikator' => $this->input->post('id_verifikator', TRUE),
			'tgl_kegiatan' => date('Y-m-d', strtotime($this->input->post('tgl_kegiatan', TRUE))),
			'kegiatan' => $this->input->post('kegiatan', TRUE),
			'kuantitas' => $this->input->post('kuantitas', TRUE),
			'id_jenis_kuantitas' => $this->input->post('id_jenis_kuantitas', TRUE),
			'jam_mulai' => $this->input->post('jam_mulai', TRUE),
			'jam_selesai' => $this->input->post('jam_selesai', TRUE),
			'tgl_input' => date('Y-m-d'),
			'tgl_update' => date('Y-m-d'),
		);

		$this->kegiatan_harian->save($data);
		echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
	}

	public function android_add()
	{
		$error = array();
		if ($this->input->post('id_pegawai') == null)
			$error[] = '';
		if ($this->input->post('id_verifikator') == null)
			$error[] = '';
		if ($this->input->post('kegiatan') == null)
			$error[] = '';
		if ($this->input->post('kuantitas') == null)
			$error[] = '';
		if ($this->input->post('id_jenis_kuantitas') == null)
			$error[] = '';
		if ($this->input->post('tgl_kegiatan') == null)
			$error[] = '';


		if (count($error) == 0) {
			$tgl_kegiatan = date('Y-m-d', strtotime($this->input->post('tgl_kegiatan', TRUE)));
			$id_pegawai = $this->input->post('id_pegawai', TRUE);
			$presensis = $this->db->query("select * from presensi where tgl_presensi='$tgl_kegiatan' and id_pegawai='$id_pegawai'");

			if ($presensis->num_rows() > 0) {

				$data = array(
					'id_pegawai' => $id_pegawai,
					'id_verifikator' => $this->input->post('id_verifikator', TRUE),
					'tgl_kegiatan' => $tgl_kegiatan,
					'kegiatan' => $this->input->post('kegiatan', TRUE),
					'kuantitas' => $this->input->post('kuantitas', TRUE),
					'id_jenis_kuantitas' => $this->get_jenis_kuantitas($this->input->post('id_jenis_kuantitas', TRUE)),
					'tgl_input' => date('Y-m-d'),
					'tgl_update' => date('Y-m-d'),
				);

				$insert = $this->kegiatan_harian->save($data);
				echo json_encode(array("status" => TRUE, "code" => 1, "tanggal" => 1,  "message" => "Sukses"));
			} else {
				echo json_encode(array("status" => FALSE, "code" => 2, "tanggal" => 2, "message" => "Tidak ada catatan absen anda pada tgl ini."));
			}
		} else {
			echo json_encode(array("status" => FALSE, "code" => 2, "tanggal" => 2, "message" => "Gagal. Form isian tidak lengkap"));
		}
	}

	function get_jenis_kuantitas($nama_jenis_kuantitas)
	{
		$qry = $this->db->query("select * from jenis_kuantitas where nama_jenis_kuantitas like '%$nama_jenis_kuantitas%' limit 1");
		$id_jenis_kuantitas = 1;
		if ($qry->num_rows() > 0) {
			$row = $qry->row();
			$id_jenis_kuantitas = $row->id_jenis_kuantitas;
		}

		return $id_jenis_kuantitas;
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'id_verifikator' => $this->input->post('id_verifikator', TRUE),
			'tgl_kegiatan' => date('Y-m-d', strtotime($this->input->post('tgl_kegiatan', TRUE))),
			'kegiatan' => $this->input->post('kegiatan', TRUE),
			'kuantitas' => $this->input->post('kuantitas', TRUE),
			'id_jenis_kuantitas' => $this->input->post('id_jenis_kuantitas', TRUE),
			'jam_mulai' => $this->input->post('jam_mulai', TRUE),
			'jam_selesai' => $this->input->post('jam_selesai', TRUE),
			'tgl_update' => date('Y-m-d'),
		);

		if ($this->input->post('revisi', TRUE))
			$data['revisi'] = $this->input->post('revisi', TRUE);
		if ($this->input->post('status', TRUE))
			$data['status'] = $this->input->post('status', TRUE);
		if ($this->input->post('kunci', TRUE))
			$data['kunci'] = $this->input->post('kunci', TRUE);
		if ($this->input->post('keterangan', TRUE))
			$data['keterangan'] = $this->input->post('keterangan', TRUE);

		if ($this->input->post('remove_photo')) // if remove photo checked
		{
			if (file_exists('upload/kegiatan_harian/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')) {
				unlink('upload/kegiatan_harian/' . $this->input->post('remove_photo'));
				unlink('upload/kegiatan_harian/thumbs/' . $this->input->post('remove_photo'));
			}
			$data['photo'] = '';
		}

		if (!empty($_FILES['photo']['name'])) {
			$upload = $this->_do_upload();

			//delete file
			$kegiatan_harian = $this->kegiatan_harian->get_by_id($this->input->post('id'));
			if (file_exists('upload/kegiatan_harian/' . $kegiatan_harian->photo) && $kegiatan_harian->photo) {
				unlink('upload/kegiatan_harian/' . $kegiatan_harian->photo);
				unlink('upload/kegiatan_harian/thumbs/' . $kegiatan_harian->photo);
			}

			$data['photo'] = $upload;
		}

		if ($this->kegiatan_harian->update(array('id_kegiatan_harian' => $this->input->post('id')), $data))
			echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Sukses"));
		else
			echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Proses update gagal"));
	}

	public function android_update()
	{
		$error = array();
		if ($this->input->post('id_pegawai') == null)
			$error[] = 'ID Pegawai';
		if ($this->input->post('id_verifikator') == null)
			$error[] = 'Verifikator';
		if ($this->input->post('kegiatan') == null)
			$error[] = 'Kegiatan';
		if ($this->input->post('kuantitas') == null)
			$error[] = 'Kuantitas';
		if ($this->input->post('id_jenis_kuantitas') == null)
			$error[] = 'Jenis Kuantitas';
		if ($this->input->post('tgl_kegiatan') == null)
			$error[] = 'Tgl Kegiatan';


		if (count($error) == 0) {
			$data = array(
				'id_pegawai' => $this->input->post('id_pegawai', TRUE),
				'id_verifikator' => $this->input->post('id_verifikator', TRUE),
				'tgl_kegiatan' => date('Y-m-d', strtotime($this->input->post('tgl_kegiatan', TRUE))),
				'kegiatan' => $this->input->post('kegiatan', TRUE),
				'kuantitas' => $this->input->post('kuantitas', TRUE),
				'id_jenis_kuantitas' => $this->get_jenis_kuantitas($this->input->post('id_jenis_kuantitas', TRUE)),
				'tgl_update' => date('Y-m-d'),
			);

			if ($this->kegiatan_harian->update(['id_kegiatan_harian' => $this->input->post('id')], $data)) {
				echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Sukses"));
			} else {
				echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Tidak ada data yang berubah."));
			}
		} else {
			$field_error = '';
			foreach ($error as $key => $value) {
				$field_error .= $value . ' ';
			}
			echo json_encode(array("status" => FALSE, "code" => 2, "message" => $field_error . " Kosong."));
		}
	}

	public function ajax_update2()
	{
		$revisi = $this->input->post('revisi', TRUE);
		$status = $this->input->post('status', TRUE);
		$kunci = $this->input->post('kunci', TRUE);
		$id = $this->input->post('id', TRUE);
		$keterangan = $this->input->post('keterangan', TRUE);

		if ($revisi != "" && $status != "" && $kunci != "") {
			$data = array(
				'revisi' => $revisi,
				'status' => $status,
				'kunci' => $kunci,
				'keterangan' => $keterangan,
				'tgl_update' => date('Y-m-d'),
			);

			$this->kegiatan_harian->update(array('id_kegiatan_harian' => $id), $data);
			echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
		} else {
			echo json_encode(array("status" => TRUE, "code" => 0, "message" => "Gagal"));
		}
	}

	public function verifikasi()
	{
		$data = array(
			'revisi' => $this->get_revisi($this->input->post('revisi', TRUE)),
			'status' => $this->get_status($this->input->post('status', TRUE)),
			'kunci' => $this->get_kunci($this->input->post('kunci', TRUE)),
			'keterangan' => $this->input->post('keterangan', TRUE),
			'tgl_update' => date('Y-m-d'),
		);

		$this->kegiatan_harian->update(array('id_kegiatan_harian' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
	}

	function get_revisi($v)
	{

		$idx = strtoupper(trim($v));
		$revisi = array('TIDAK' => '0', 'YA' => '1');
		return $revisi[$idx];
	}

	function get_status($v)
	{

		$idx = strtoupper(trim($v));
		$revisi = array('MENUNGGU' => 0, 'DITOLAK' => '1', 'DISETUJUI' => '2');
		return $revisi[$idx];
	}

	function get_kunci($v)
	{

		$idx = strtoupper(trim($v));
		$revisi = array('TIDAK' => '0', 'YA' => '1');
		return $revisi[$idx];
	}

	public function ajax_delete($id = "")
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->kegiatan_harian->delete_by_id($id);
		echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->kegiatan_harian->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']    = 'upload/kegiatan_harian/';
		$config['allowed_types']  = 'gif|jpg|png';
		$config['max_size']       = 1024; //set max size allowed in Kilobyte
		$config['max_width']      = 1000; // set max width image allowed
		$config['max_height']     = 1000; // set max height allowed
		$config['file_name']      = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('photo')) //upload and validate
		{
			$data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: ' . $_FILES['photo']['type'] . ' ' . $this->upload->display_errors('', ''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		$file 		= $this->upload->data();
		$nama_file 	= $file['file_name'];


		$config = array(
			'source_image' 	=> $file['full_path'],
			'new_image' 		=> './upload/kegiatan_harian/thumbs/',
			'maintain_ration' => TRUE,
			'width' 			=> 110,
			'height' 			=> 82
		);

		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

		return $nama_file;
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('id_pegawai') == '') {
			$data['inputerror'][] = 'id_pegawai';
			$data['error_string'][] = 'Pegawai is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_verifikator') == '') {
			$data['inputerror'][] = 'id_verifikator';
			$data['error_string'][] = 'Verifikator is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tgl_kegiatan') == '') {
			$data['inputerror'][] = 'tgl_kegiatan';
			$data['error_string'][] = 'Tgl Kegiatan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('kegiatan') == '') {
			$data['inputerror'][] = 'kegiatan';
			$data['error_string'][] = 'Kegiatan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('kuantitas') == '') {
			$data['inputerror'][] = 'kuantitas';
			$data['error_string'][] = 'Kuantitas is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_jenis_kuantitas') == '') {
			$data['inputerror'][] = 'id_jenis_kuantitas';
			$data['error_string'][] = 'Jenis Kuantitas  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jam_mulai') == '') {
			$data['inputerror'][] = 'jam_mulai';
			$data['error_string'][] = 'Jam Mulai is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jam_selesai') == '') {
			$data['inputerror'][] = 'jam_selesai';
			$data['error_string'][] = 'Jam Selesai is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function kinerja_pegawai()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		// $id=296;
		// $query='';
		// $limit=5;
		// $start=0;

		$sql = "SELECT kegiatan_harian.*, jenis_kuantitas.nama_jenis_kuantitas, pegawai.nama_pegawai, pegawai.photo as photo_pegawai FROM kegiatan_harian LEFT JOIN jenis_kuantitas ON kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas LEFT JOIN pegawai on kegiatan_harian.id_pegawai=pegawai.id_pegawai WHERE kegiatan_harian.id_pegawai='$id'";

		if ($query != '') {
			$sql .= " AND (kegiatan_harian.tgl_kegiatan LIKE '%$query%' OR kegiatan_harian.kegiatan LIKE '%$query%')";
		}

		$sql .= " ORDER BY kegiatan_harian.id_kegiatan_harian DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$kegiatans = array();
			foreach ($qry->result() as $row) {
				array_push(
					$kegiatans,
					array(
						"id"                    => $row->id_kegiatan_harian,
						"id_pegawai"            => $row->id_pegawai,
						"nama_pegawai"          => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"id_verifikator"        => $row->id_verifikator,
						"nama_verifikator"      => $this->pegawai->get_nama_pegawai($row->id_verifikator),
						"tgl_kegiatan"          => $row->tgl_kegiatan,
						"tgl_kegiatan_"          => tgl_indonesia2($row->tgl_kegiatan),
						"kegiatan"              => $row->kegiatan,
						"kuantitas"             => $row->kuantitas,
						"id_jenis_kuantitas"    => $row->id_jenis_kuantitas,
						"nama_jenis_kuantitas"  => $row->nama_jenis_kuantitas,
						"jam_mulai"             => $row->jam_mulai,
						"jam_selesai"           => $row->jam_selesai,
						"photo"                 => $row->photo_pegawai,
						"revisi"                => $row->revisi,
						"status"                => $row->status,
						"kunci"                 => $row->kunci,
						"keterangan"            => $row->keterangan,
						"tgl_input"             => $row->tgl_input,
						"tgl_update"            => $row->tgl_update
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $kegiatans, "kinerjas" => $kegiatans)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function kinerja_bawahan()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		// $id=296;
		// $query='';
		// $limit=5;
		// $start=0;

		$sql = "SELECT kegiatan_harian.*, jenis_kuantitas.nama_jenis_kuantitas, pegawai.nama_pegawai, pegawai.photo as photo_pegawai FROM kegiatan_harian LEFT JOIN jenis_kuantitas ON kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas LEFT JOIN pegawai on kegiatan_harian.id_pegawai=pegawai.id_pegawai WHERE kegiatan_harian.id_verifikator='$id'";


		if ($query != '') {
			$sql .= " AND (kegiatan_harian.tgl_kegiatan LIKE '%$query%' OR kegiatan_harian.kegiatan LIKE '%$query%')";
		}

		$sql .= " ORDER BY kegiatan_harian.id_kegiatan_harian DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			$kegiatans = array();
			foreach ($qry->result() as $row) {
				array_push(
					$kegiatans,
					array(
						"id"                    => $row->id_kegiatan_harian,
						"id_pegawai"            => $row->id_pegawai,
						"nama_pegawai"          => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"id_verifikator"        => $row->id_verifikator,
						"nama_verifikator"      => $this->pegawai->get_nama_pegawai($row->id_verifikator),
						"tgl_kegiatan"          => $row->tgl_kegiatan,
						"tgl_kegiatan_"         => tgl_indonesia2($row->tgl_kegiatan),
						"kegiatan"              => $row->kegiatan,
						"kuantitas"             => $row->kuantitas,
						"id_jenis_kuantitas"    => $row->id_jenis_kuantitas,
						"nama_jenis_kuantitas"  => $row->nama_jenis_kuantitas,
						"jam_mulai"             => $row->jam_mulai,
						"jam_selesai"           => $row->jam_selesai,
						"photo"                 => $row->photo_pegawai,
						"revisi"                => $row->revisi,
						"status"                => $row->status,
						"kunci"                 => $row->kunci,
						"keterangan"            => $row->keterangan,
						"tgl_input"             => $row->tgl_input,
						"tgl_update"            => $row->tgl_update
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $kegiatans, "kinerjas" => $kegiatans)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function get_jumlah()
	{
		$id = $this->input->post('id', TRUE);

		if ($id != "") {
			$n = date('n');
			$qry = $this->db->query("select count(kuantitas) as jml from kegiatan_harian where id_pegawai='$id' and month(tgl_kegiatan)=$n");
			if ($qry->num_rows() > 0) {
				$row = $qry->row();
				echo json_encode(array('message' => $row->jml));
			} else {
				echo json_encode(array('message' => 0));
			}
		} else {
			echo json_encode(array('message' => 0));
		}
	}
}
// END Kegiatan_harian Class
/* End of file kegiatan_harian.php */
/* Location: ./sytem/application/controlers/kegiatan_harian.php */
