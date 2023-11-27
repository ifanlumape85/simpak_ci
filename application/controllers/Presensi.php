<?php
class Presensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Makassar');
		$this->load->model('Presensi_model', 'presensi', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Status_presensi_model', 'status_presensi', TRUE);
		$this->load->model('Verifikator_model', 'verifikator', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Presensi',
				'main_view' => 'presensi/presensi',
				'form_view' => 'presensi/presensi_form',
			);

			if ($this->session->userdata('user_level_id') > 1)
				$instansis = $this->instansi->get_list_instansi(array('id_instansi' => $this->session->userdata('instansi_id')));
			else
				$instansis = $this->instansi->get_list_instansi();

			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'Pilih Jenis Presensi');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'Pilih Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$status_presensis = $this->status_presensi->get_list_status_presensi();
			$opt_status_presensi = array('' => 'Pilih Status Presensi');
			foreach ($status_presensis as $i => $v) {
				$opt_status_presensi[$i] = $v;
			}

			$data['form_status_presensi'] = form_dropdown('id_status_presensi', $opt_status_presensi, '', 'id="id_status_presensi" class="form-control"');
			$data['form_status_presensi2'] = form_dropdown('id_status_presensi2', $opt_status_presensi, '', 'id="id_status_presensi2" class="form-control"');
			$data['options_status_presensi'] = $opt_status_presensi;
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
				'title' 	=> 'Data Presensi',
				'main_view' => 'presensi/presensi_sebagai_atasan',
				'form_view' => 'presensi/presensi_sebagai_atasan_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;

			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'All Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;

			$status_presensis = $this->status_presensi->get_list_status_presensi();
			$opt_status_presensi = array('' => 'All Status Presensi ');
			foreach ($status_presensis as $i => $v) {
				$opt_status_presensi[$i] = $v;
			}

			$data['form_status_presensi'] = form_dropdown('id_status_presensi', $opt_status_presensi, '', 'id="id_status_presensi" class="form-control"');
			$data['form_status_presensi2'] = form_dropdown('id_status_presensi2', $opt_status_presensi, '', 'id="id_status_presensi2" class="form-control"');
			$data['options_status_presensi'] = $opt_status_presensi;
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
				'title' 	=> 'Data Presensi',
				'main_view' => 'presensi/presensi_sebagai_pegawai',
				'form_view' => 'presensi/presensi_sebagai_pegawai_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'All Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$status_presensis = $this->status_presensi->get_list_status_presensi();
			$opt_status_presensi = array('' => 'All Status Presensi ');
			foreach ($status_presensis as $i => $v) {
				$opt_status_presensi[$i] = $v;
			}

			$data['form_status_presensi'] = form_dropdown('id_status_presensi', $opt_status_presensi, '', 'id="id_status_presensi" class="form-control"');
			$data['form_status_presensi2'] = form_dropdown('id_status_presensi2', $opt_status_presensi, '', 'id="id_status_presensi2" class="form-control"');
			$data['options_status_presensi'] = $opt_status_presensi;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->presensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $presensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $presensi->id_presensi . '">';
			$row[] = $no;
			$row[] = $presensi->nama_instansi;
			$row[] = $presensi->nama_pegawai;
			$row[] = tgl_indonesia2($presensi->tgl_presensi);
			$row[] = $presensi->nama_jenis_presensi;
			$row[] = $presensi->nama_status_presensi;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_presensi(' . "'" . $presensi->id_presensi . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_presensi(' . "'" . $presensi->id_presensi . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->presensi->count_all(),
			"recordsFiltered" 	=> $this->presensi->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list2()
	{
		$this->load->helper('url');
		$list = $this->presensi->get_datatables2();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $presensi) {
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $presensi->nama_instansi;
			$row[] = $presensi->nama_pegawai;
			$row[] = tgl_indonesia2($presensi->tgl_presensi);
			$row[] = $presensi->nama_jenis_presensi;
			$row[] = $presensi->nama_status_presensi;

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->presensi->count_all(),
			"recordsFiltered" 	=> $this->presensi->count_filtered2(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list3()
	{
		$this->load->helper('url');
		$list = $this->presensi->get_datatables3();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $presensi) {
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $presensi->nama_instansi;
			$row[] = $presensi->nama_pegawai;
			$row[] = tgl_indonesia2($presensi->tgl_presensi);
			$row[] = $presensi->nama_jenis_presensi;
			$row[] = $presensi->nama_status_presensi;

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->presensi->count_all(),
			"recordsFiltered" 	=> $this->presensi->count_filtered2(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->presensi->get_by_id($id);
		$data->tgl_presensi = ($data->tgl_presensi == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_presensi)); // if 0000-00-00 set tu empty for datepicker compatibility

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'tgl_presensi' => date('Y-m-d', strtotime($this->input->post('tgl_presensi', TRUE))),
			'id_jenis_presensi' => $this->input->post('id_jenis_presensi', TRUE),
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'id_status_presensi' => $this->input->post('id_status_presensi', TRUE),
		);
		$insert = $this->presensi->save($data);
		echo json_encode(array("status" => TRUE));
	}


	function insert_data_absensi()
	{

		$this->load->model('Verifikator_model', 'verifikator', TRUE);
		$this->load->model('Pengaturan_presensi_model', 'pengaturan_presensi', TRUE);
		$this->load->model('Pengaturan_instansi_model', 'pengaturan_instansi', TRUE);
		$this->load->model('Pengaturan_jadwal_model', 'pengaturan_jadwal', TRUE);
		$this->load->model('Router1_model', 'router1', TRUE);

		$version = $this->input->post('version');
		$id_instansi = $this->input->post('id_instansi');
		$jam_sekarang = date('H:i:s');
		$tgl_sekarang = date('Y-m-d');
		$id_pegawai = $this->input->post('id_pegawai', TRUE);
		$id_verifikator = $this->input->post('id_verifikator', TRUE);
		$lon = $this->input->post('lat', TRUE);
		$lat = $this->input->post('lon', TRUE);
		$id_jenis_presensi = $this->input->post('id_jenis_presensi', TRUE);
		$id_status_presensi = $this->input->post('id_status_presensi', TRUE);

		if ($version == "" || $version != "2.0.0") {
			echo json_encode(array("code" => 2, 'message' => 'Versi tidak didukung lagi.'));
			return;
		}

		if (date('l', strtotime($tgl_sekarang)) == 'Saturday' || date('l', strtotime($tgl_sekarang)) == 'Sunday') {
			echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sabtu dan Minggu tidak termasuk.'));
			return;
		}


		if ($id_jenis_presensi == "5")
			$id_status_presensi = "9";

		$data = array(
			'tgl_presensi' => $tgl_sekarang,
			'jam_presensi' => $jam_sekarang,
			'id_jenis_presensi'	=> $id_jenis_presensi,
			'id_status_presensi' => $id_status_presensi,
			'id_pegawai' => $id_pegawai,
			'id_verifikator' => $id_verifikator,
			'lat' => $lat,
			'lon' => $lon,
		);

		$qryCek = $this->db->query("
		SELECT
			*
		FROM
			presensi
		WHERE
            tgl_presensi='" . $data['tgl_presensi'] . "' AND
			id_jenis_presensi=" . $data['id_jenis_presensi'] . " AND
			id_pegawai=" . $data['id_pegawai'] . "
        ");

		$cek = $qryCek->num_rows();

		if ($cek > 0) {
			echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sudah dilakukan sebelumnya.'));
			return;
		}

		if (date('l', strtotime($tgl_sekarang)) == 'Friday' and ($id_jenis_presensi == "5" || $id_jenis_presensi == "13")) {
			$data['terlambat'] = $this->terlambat("11:00:00", $jam_sekarang); //selisih_jam("11:00:00", $jam_sekarang);
			if (selisih_jam("11:00:00", $jam_sekarang) < 0) {
				echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
			} else {
				$insert = $this->presensi->save($data);
			}

			return;
		}

		if (
			$data['lat'] != "" &&
			$data['lon'] != "" &&
			$data['id_verifikator'] != "" &&
			$data['id_pegawai'] != "" &&
			$data['id_status_presensi'] != "" &&
			$data['id_jenis_presensi'] != ""
		) {
			$pengaturan_presensi = $this->pengaturan_presensi->get_by_id(array('id_jenis_presensi' => $data['id_jenis_presensi']));

			$mulai = '';
			$akhir = '';
			$cek_perangkat = 'N';
			$cek_lokasi = 'N';
			$ikut_jadwal = 'N';
			$penyesuaian_instansi = 'N';
			$longitude = '';
			$latitude = '';

			if (
				$this->pengaturan_presensi->count_all([
					'id_jenis_presensi' => $data['id_jenis_presensi']
				]) > 0
			) {
				$row_ppresensi = $pengaturan_presensi;
				$mulai = $row_ppresensi->mulai;
				$akhir = $row_ppresensi->akhir;
				$cek_perangkat = $row_ppresensi->cek_perangkat;
				$cek_lokasi = $row_ppresensi->cek_lokasi;
				$ikut_jadwal = $row_ppresensi->ikut_jadwal;
				$penyesuaian_instansi = $row_ppresensi->penyesuaian_instansi;
				$longitude = $row_ppresensi->longitude;
				$latitude = $row_ppresensi->latitude;

				$cek_penyesuaian_instansis = $this->pengaturan_instansi->get_by_id(array(
					'id_jenis_presensi' => $data['id_jenis_presensi'],
					'tanggal' => $data['tgl_presensi'],
					'id_instansi' => $id_instansi
				));

				$cek_jadwals = $this->pengaturan_jadwal->get_by_id(array(
					'id_jenis_presensi' => $data['id_jenis_presensi'],
					'tgl_presensi' => $data['tgl_presensi']
				));


				// CEK PERANGKAT
				if ($cek_perangkat == 'Y') {
					// PENYESUAIAN INSTANSI
					if ($penyesuaian_instansi == 'Y') {
						if ($cek_penyesuaian_instansis->num_rows() > 0) {
							$cek_penyesuaian_instansi = $cek_penyesuaian_instansis->row();

							if ($cek->num_rows() == 0) {
								if ($cek_penyesuaian_instansi->mulai != "" && $cek_penyesuaian_instansi->akhir != "") {
									$data['terlambat'] = $this->terlambat($cek_penyesuaian_instansi->mulai, $jam_sekarang);
									if (selisih_jam($cek_penyesuaian_instansi->mulai, $jam_sekarang) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
									} elseif (selisih_jam($jam_sekarang, $cek_penyesuaian_instansi->akhir) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
									} else {
										$x = $this->presensi->count_all(array('tgl_presensi' => date('Y-m-d'), 'id_jenis_presensi'	=> $this->input->post('id_jenis_presensi', TRUE), 'id_status_presensi' => $this->input->post('id_status_presensi', TRUE), 'id_pegawai' => $this->input->post('id_pegawai', TRUE)));

										if ($x > 0) {
											echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
										} else {
											$insert = $this->presensi->save($data);
											if ($insert) {
												echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
											} else {
												echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
											}
										}
									}
								} else {
									echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #1.'));
								}
							} else {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sudah pernah dilakukan pada hari ini.'));
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi tidak dapat dilakukan. Harus diatur instansi.'));
						}
					}

					// END PENYESUAIAN INSTANSI

					// MENGIKUTI JADWAL
					elseif ($ikut_jadwal == 'Y') {
						// jika jadwal sudah diatur
						if ($cek_jadwals->num_rows() > 0) {
							$cek_jadwal = $cek_jadwals->row();

							if ($cek == 0) {
								if ($cek_jadwal->mulai != "" && $cek_jadwal->akhir != "") {
									$data['terlambat'] = $this->terlambat($cek_jadwal->mulai, $jam_sekarang);
									if (selisih_jam($cek_jadwal->mulai, $jam_sekarang) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
									} elseif (selisih_jam($jam_sekarang, $cek_jadwal->akhir) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
									} else {
										$x = $this->presensi->count_all(array('tgl_presensi' => date('Y-m-d'), 'id_jenis_presensi'	=> $this->input->post('id_jenis_presensi', TRUE), 'id_status_presensi' => $this->input->post('id_status_presensi', TRUE), 'id_pegawai' => $this->input->post('id_pegawai', TRUE)));

										if ($x > 0) {
											echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
										} else {
											$insert = $this->presensi->save($data);
											if ($insert) {
												echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
											} else {
												echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
											}
										}
									}
								} else {
									echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #2.'));
								}
							} else {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sudah pernah dilakukan pada hari ini.'));
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Jadwal absensi belum diatur.'));
						}
					}
					// END MENGIKUTI JADWAL
					else {
						if ($mulai != "" && $akhir != "") {
							$data['terlambat'] = $this->terlambat($mulai, $jam_sekarang);
							if (selisih_jam($mulai, $jam_sekarang) < 0) {
								echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
							} elseif (selisih_jam($jam_sekarang, $akhir) < 0) {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
							} else {
								// $x = $this->presensi->count_all(array('tgl_presensi' => date('Y-m-d'), 'id_jenis_presensi'	=> $this->input->post('id_jenis_presensi', TRUE), 'id_status_presensi' => $this->input->post('id_status_presensi', TRUE), 'id_pegawai' => $this->input->post('id_pegawai', TRUE)));

								if ($cek > 0) {
									echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
								} else {
									$insert = $this->presensi->save($data);
									if ($insert) {
										echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
									} else {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
									}
								}
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #2.'));
						}
					}
				}

				// END CHECK PERANGKAT
				else {
					// PENYESUAIAN INSTANSI
					if ($penyesuaian_instansi == 'Y') {
						if ($cek_penyesuaian_instansis->num_rows() > 0) {
							$cek_penyesuaian_instansi = $cek_penyesuaian_instansis->row();

							if ($cek < 1) {
								if ($cek_penyesuaian_instansi->mulai != "" && $cek_penyesuaian_instansi->akhir != "") {
									$data['terlambat'] = $this->terlambat($cek_penyesuaian_instansi->mulai, $jam_sekarang);
									if (selisih_jam($cek_penyesuaian_instansi->mulai, $jam_sekarang) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
									} elseif (selisih_jam($jam_sekarang, $cek_penyesuaian_instansi->akhir) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
									} else {
										if ($cek > 0) {
											echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
										} else {
											$insert = $this->presensi->save($data);
											if ($insert) {
												echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
											} else {
												echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
											}
										}
									}
								} else {
									echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #3.'));
								}
							} else {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sudah pernah dilakukan pada hari ini.'));
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi tidak dapat dilakukan. Harus diatur instansi.'));
						}
					}
					// END PENYESUAIAN INSTANSI


					// MENGIKUTI JADWAL
					elseif ($ikut_jadwal == 'Y') {
						// jika jadwal sudah diatur
						if ($cek_jadwals->num_rows() > 0) {
							$cek_jadwal = $cek_jadwals->row();

							if ($cek == 0) {
								if ($cek_jadwal->mulai != "" && $cek_jadwal->akhir != "") {
									$data['terlambat'] = $this->terlambat($cek_jadwal->mulai, $jam_sekarang);
									if (selisih_jam($cek_jadwal->mulai, $jam_sekarang) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
									} elseif (selisih_jam($jam_sekarang, $cek_jadwal->akhir) < 0) {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
									} else {
										if ($cek > 0) {
											echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
										} else {
											$insert = $this->presensi->save($data);
											if ($insert) {
												echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
											} else {
												echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
											}
										}
									}
								} else {
									echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #5.'));
								}
							} else {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sudah pernah dilakukan pada hari ini.'));
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Jadwal absensi belum diatur.'));
						}
					}
					// END MENGIKUTI JADWAL

					else {
						if ($mulai != "" && $akhir != "") {
							$data['terlambat'] = $this->terlambat($mulai, $jam_sekarang);
							if (selisih_jam($mulai, $jam_sekarang) < 0) {
								echo json_encode(array("code" => 2, 'message' => 'Presensi gagal. Belum waktu absensi.'));
							} elseif (selisih_jam($jam_sekarang, $akhir) < 0) {
								echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Melewati batas waktu absensi.'));
							} else {
								if ($cek > 0) {
									echo json_encode(array("code" => 2, 'message' => 'Sudah absen sebelumnya.'));
								} else {
									$insert = $this->presensi->save($data);
									if ($insert) {
										echo json_encode(array("code" => 1, 'message' => 'Absensi berhasil.', 'id' => $this->db->insert_id()));
									} else {
										echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Sistem bermasalah.'));
									}
								}
							}
						} else {
							echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #2.'));
						}
					}
				}
			} else {
				echo json_encode(array("code" => 2, 'message' => 'Absensi gagal. Pengaturan Presensi belum diatur admin #6.'));
			}
		} else {
			echo json_encode(array("code" => 2, 'message' => 'Pilih Atasan Langsung terlebih dahulu. Setting > Atasan Langsung.'));
		}
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'tgl_presensi'		=> date('Y-m-d', strtotime($this->input->post('tgl_presensi', TRUE))),
			'id_jenis_presensi'	=> $this->input->post('id_jenis_presensi', TRUE),
			'id_pegawai'		=> $this->input->post('id_pegawai', TRUE),
			'id_status_presensi' => $this->input->post('id_status_presensi', TRUE),
		);
		$this->presensi->update(array('id_presensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->presensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->presensi->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('tgl_presensi') == '') {
			$data['inputerror'][] = 'tgl_presensi';
			$data['error_string'][] = 'Tgl Presensi is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_jenis_presensi') == '') {
			$data['inputerror'][] = 'id_jenis_presensi';
			$data['error_string'][] = 'Jenis Presensi  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_pegawai') == '') {
			$data['inputerror'][] = 'id_pegawai';
			$data['error_string'][] = 'Pegawai is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_status_presensi') == '') {
			$data['inputerror'][] = 'id_status_presensi';
			$data['error_string'][] = 'Status Presensi  is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function cek_presensi()
	{
		$id_pegawai = $this->input->post('id', TRUE);
		$tgl_presensi = date('Y-m-d');
		$sql = $this->presensi->count_all(array('id_pegawai' => $id_pegawai, 'tgl_presensi' => $tgl_presensi));
		$response = array();
		if ($sql > 0) {
			$response['code'] = 0;
			$response['message'] = '';
			$response['exists'] = TRUE;
			$response['err_msg'] = '';
		} else {
			$response['code'] = 1;
			$response['message'] = 'Pilih Jenis Absen.';
			$response['exists'] = FALSE;
			$response['err_msg'] = 'Anda belum absensi hari ini.';
		}

		echo json_encode($response);
	}

	function cek_presensi_ajax($id_pegawai = "")
	{
		if ($this->input->post('id_pegawai', TRUE))
			$id_pegawai = $this->input->post('id_pegawai', TRUE);

		$tgl_presensi = date('Y-m-d');
		$sql = $this->presensi->count_all(array('id_pegawai' => $id_pegawai, 'tgl_presensi' => $tgl_presensi));
		$response = array();
		if ($sql > 0) {
			$response['exists'] = TRUE;
		} else {
			$response['exists'] = FALSE;
		}

		echo json_encode($response);
	}

	function presensi_pegawai()
	{
		// update disini
		$id = $_POST['id'] ?? 2523;
		$query = $_POST['query'] ?? '';
		$limit = $_POST['limit'] ?? 10;
		$start = $_POST['start'] ?? 0;

		$sql = "
			SELECT
				absensi.*,
				jenis_presensi.nama_jenis_presensi,
				pegawai.nama_pegawai, pegawai.photo as photo_pegawai, pegawai.nip,
				status_presensi.nama_status_presensi
			FROM
				presensi as absensi
				LEFT JOIN jenis_presensi ON absensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
				LEFT JOIN pegawai on absensi.id_pegawai=pegawai.id_pegawai
				LEFT JOIN status_presensi on absensi.id_status_presensi=status_presensi.id_status_presensi
			";

		if ($query != '') {
			$sql .= " where (absensi.tgl_presensi LIKE '%$query%' OR jenis_presensi.nama_jenis_presensi LIKE '%$query%' OR status_presensi.nama_status_presensi LIKE '%$query%') and absensi.id_pegawai='$id'";
		} else {
			$sql .= " where absensi.id_pegawai='$id'";
		}

		$sql .= " ORDER BY absensi.id_presensi DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$presensis = array();
			foreach ($qry->result() as $row) {
				array_push(
					$presensis,
					array(
						"id" => $row->id_presensi,
						"tgl_presensi" => $row->tgl_presensi,
						"tgl_presensi_" => tgl_indonesia2($row->tgl_presensi),
						"jam_presensi" => $row->jam_presensi,
						"id_jenis_presensi" => $row->id_jenis_presensi,
						"nama_jenis_presensi" => $row->nama_jenis_presensi,
						"id_pegawai" => $row->id_pegawai,
						"nama_pegawai" => $row->nama_pegawai,
						"nip" => $row->nip,
						"id_status_presensi" => $row->id_status_presensi,
						"nama_status_presensi" => $row->nama_status_presensi,
						"photo" => $row->photo_pegawai,
						"id_verifikator" => $row->id_verifikator,
						"lat" => $row->lat,
						"lon" => $row->lon
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $presensis, "absensis" => $presensis)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function presensi_bawahan()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		$bawahans = $this->db->query("select * from verifikator where verifikator='$id'");
		$in = "";
		$jml_bawahan = $bawahans->num_rows();
		if ($jml_bawahan > 0) {
			$i = 1;
			foreach ($bawahans->result() as $row) {
				if ($i == $jml_bawahan) {
					$in .= "'" . $row->id_pegawai . "'";
				} else {
					$in .= "'" . $row->id_pegawai . "', ";
				}
				$i++;
			}
		}

		if ($in == "") {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
			return;
		}


		$sql = "
			SELECT
				absensi.*,
				jenis_presensi.nama_jenis_presensi,
				pegawai.nama_pegawai, pegawai.photo as photo_pegawai,
				status_presensi.nama_status_presensi
			FROM
				presensi as absensi
				LEFT JOIN jenis_presensi ON absensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
				LEFT JOIN pegawai on absensi.id_pegawai=pegawai.id_pegawai
				LEFT JOIN status_presensi on absensi.id_status_presensi=status_presensi.id_status_presensi
			WHERE
				absensi.id_pegawai IN ($in)";

		if ($query != '') {
			$sql .= " AND (absensi.tgl_presensi LIKE '%$query%' OR jenis_presensi.nama_jenis_presensi LIKE '%$query%' OR pegawai.nama_pegawai LIKE '%$query%')";
		}

		$sql .= " ORDER BY absensi.id_presensi DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$presensis = array();
			foreach ($qry->result() as $row) {
				array_push(
					$presensis,
					array(
						"id" => $row->id_presensi,
						"tgl_presensi" => $row->tgl_presensi,
						"tgl_presensi_" => tgl_indonesia2($row->tgl_presensi),
						"jam_presensi" => $row->jam_presensi,
						"id_jenis_presensi" => $row->id_jenis_presensi,
						"nama_jenis_presensi" => $this->jenis_presensi->get_nama_jenis_presensi($row->id_jenis_presensi),
						"id_pegawai" => $row->id_pegawai,
						"nama_pegawai" => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"nip" => $this->pegawai->get_nip_pegawai($row->id_pegawai),
						"id_status_presensi" => $row->id_status_presensi,
						"nama_status_presensi" => $this->status_presensi->get_nama_status_presensi($row->id_status_presensi),
						"photo" => $row->photo_pegawai,
						"id_verifikator" => $row->id_verifikator,
						"lat" => $row->lat,
						"lon" => $row->lon
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $presensis, "absensis" => $presensis)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function laporan()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Presensi',
				'main_view' => 'presensi/laporan',
				'form_view' => 'presensi/laporan_form',
			);

			$instansis = $this->instansi->get_list_instansi();
			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'All Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$status_presensis = $this->status_presensi->get_list_status_presensi();
			$opt_status_presensi = array('' => 'All Status Presensi ');
			foreach ($status_presensis as $i => $v) {
				$opt_status_presensi[$i] = $v;
			}

			$data['form_status_presensi'] = form_dropdown('id_status_presensi', $opt_status_presensi, '', 'id="id_status_presensi" class="form-control"');
			$data['form_status_presensi2'] = form_dropdown('id_status_presensi2', $opt_status_presensi, '', 'id="id_status_presensi2" class="form-control"');
			$data['options_status_presensi'] = $opt_status_presensi;
			$this->load->view('admin/template', $data);
		}
	}

	function laporan_pdf()
	{
		$this->load->library('pdf');
		$id_pegawai = $this->uri->segment(3);
		$tgl_mulai = $this->uri->segment(4);
		$tgl_mulai = date('Y-m-d', strtotime($tgl_mulai));
		// $tgl_mulai = $this->format_ke_tanggal($tgl_mulai);
		$tgl_selesai = $this->uri->segment(5);
		$tgl_selesai = date('Y-m-d', strtotime($tgl_selesai));
		// $tgl_selesai = $this->format_ke_tanggal($tgl_selesai);

		$sql = "
		select
			presensi.*,
			jenis_presensi.nama_jenis_presensi
		from
			presensi
			left join jenis_presensi on presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
		where
			presensi.id_pegawai='$id_pegawai' and
			(presensi.tgl_presensi between '$tgl_mulai' and '$tgl_selesai')
		";

		// echo $sql;

		$qry = $this->db->query($sql);
		$presensis = $qry->result();

		$verifikator = $this->verifikator->get_verifikator_pegawai($id_pegawai);
		$pegawai = $this->pegawai->get_by_id($id_pegawai);
		$atasan_langsung = $this->pegawai->get_by_id($verifikator);

		$data = array(
			'presensis' 	=> $presensis,
			'tahun_anggaran' 	=> $this->tahun_anggaran($tgl_mulai),
			'nama_pegawai'		=> $pegawai->nama_pegawai,
			'nip'				=> $pegawai->nip,
			'nama_jabatan'		=> $pegawai->nama_jabatan,
			'nama_instansi'		=> $pegawai->nama_instansi,
			'nama_atasan'		=> @$atasan_langsung->nama_pegawai,
			'nip_atasan'		=> @$atasan_langsung->nip,
			'jabatan_atasan'	=> @$atasan_langsung->nama_jabatan
		);

		$this->pdf->load_view('presensi/laporan_presensi_pdf', $data);
		$this->pdf->render();
		$this->pdf->stream("laporan_presensi.pdf");
	}

	function tahun_anggaran($str)
	{
		$bulan = date('n', strtotime($str));
		$tahun_anggaran = getBulan($bulan);
		return $tahun_anggaran;
	}

	function laporan_presensi()
	{
		if ($this->session->userdata('login') == TRUE) {
			$sql = "
			select
				presensi.*,
				instansi.nama_instansi,
				pegawai.nama_pegawai, pegawai.nip,
				jenis_presensi.nama_jenis_presensi,
				status_presensi.nama_status_presensi
			from
				presensi
				left join pegawai on presensi.id_pegawai=pegawai.id_pegawai
				left join instansi on pegawai.id_instansi=instansi.id_instansi
				left join jenis_presensi on presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
				left join status_presensi on presensi.id_status_presensi=status_presensi.id_status_presensi
			";

			$arr = array();

			$id_instansi = $this->input->post('id_instansi', TRUE);
			$id_jenis_presensi = $this->input->post('id_jenis_presensi', TRUE);
			$id_status_presensi = $this->input->post('id_status_presensi', TRUE);
			$id_pegawai = $this->input->post('id_pegawai', TRUE);
			$tgl_mulai = date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE)));
			$tgl_selesai = date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE)));

			if ($id_instansi != "") {
				$arr[] = "pegawai.id_instansi='$id_instansi'";
			}

			if ($id_jenis_presensi != "") {
				$arr[] = "presensi.id_jenis_presensi='$id_jenis_presensi'";
			}

			if ($id_status_presensi != "") {
				$arr[] = "presensi.id_status_presensi='$id_status_presensi'";
			}

			if ($id_pegawai != "") {
				$arr[] = "presensi.id_pegawai='$id_pegawai'";
			}

			if ($tgl_mulai != "") {
				$arr[] = "presensi.tgl_presensi>='$tgl_mulai'";
			}

			if ($tgl_selesai != "") {
				$arr[] = "presensi.tgl_presensi<='$tgl_selesai'";
			}

			if (count($arr) > 0) {
				$i = 1;
				foreach ($arr as $key => $value) {

					if ($key == 0) {
						$sql .= " where $value";
					} else {
						$sql .= " and $value";
					}

					$i++;
				}
			}

			$html = '
				<table id="table" class="table table-striped table-bordered">
					<tr>
						<th>Instansi</th>
						<th>Pegawai</th>
						<th>Tanggal</th>
						<th>Jenis</th>
						<th>Status</th>
					</tr>
			';

			if (count($arr) > 0) {
				$laporan_presensis = $this->db->query($sql);
				if ($laporan_presensis->num_rows() > 0) {

					foreach ($laporan_presensis->result() as $laporan_presensi) {
						$html .= '
						<tr>
							<td>' . $laporan_presensi->nama_instansi . '</td>
							<td>' . $laporan_presensi->nama_pegawai . '<br />' . $laporan_presensi->nip . '</td>
							<td>' . tgl_indonesia($laporan_presensi->tgl_presensi) . '</td>
							<td>' . $laporan_presensi->nama_jenis_presensi . '</td>
							<td>' . $laporan_presensi->nama_status_presensi . '</td>
						</tr>';
					}
				}
			}
			echo $html .= '</table>';
		}
	}

	function laporan_presensi_2()
	{
		$tanggal = "2021-07-01";
		$qry = $this->db->query("
		SELECT date_field
		FROM
		(
			SELECT MAKEDATE(YEAR('$tanggal'),1) +
			INTERVAL (MONTH('$tanggal')-1) MONTH +
			INTERVAL daynum DAY date_field
			FROM
			(
				SELECT t*10+u daynum FROM
				(SELECT 0 t UNION SELECT 1 UNION SELECT 2 UNION SELECT 3) A,
				(SELECT 0 u UNION SELECT 1 UNION SELECT 2 UNION SELECT 3
				UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
				UNION SELECT 8 UNION SELECT 9) B ORDER BY daynum
			) as AA
		) as AB WHERE MONTH(date_field) = MONTH('$tanggal')
		");

		foreach ($qry->result() as $rest) {
			echo $rest->date_field . '<br />';
		}
	}

	function pegawai()
	{
		if ($this->session->userdata('login') == TRUE) {
			$sql = "
			select
				presensi.*,
				instansi.nama_instansi,
				pegawai.nama_pegawai,
				jenis_presensi.nama_jenis_presensi,
				status_presensi.nama_status_presensi
			from
				presensi
				left join pegawai on presensi.id_pegawai=pegawai.id_pegawai
				left join instansi on pegawai.id_instansi=instansi.id_instansi
				left join jenis_presensi on presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
				left join status_presensi on presensi.id_status_presensi=status_presensi.id_status_presensi
			";

			$arr = array();

			$id_instansi = $this->input->post('id_instansi', TRUE);
			$id_jenis_presensi = $this->input->post('id_jenis_presensi', TRUE);
			$tgl_presensi = $this->input->post('tgl_presensi', TRUE);

			if ($id_instansi != "") {
				if ($this->session->userdata('user_level_id') == 1)
					$arr[] = "pegawai.id_instansi='$id_instansi'";
				else
					$arr[] = "pegawai.id_pegawai='" . $this->session->userdata('pegawai_id') . "'";
			}

			if ($id_jenis_presensi != "") {
				$arr[] = "presensi.id_jenis_presensi='$id_jenis_presensi'";
			}

			if ($tgl_presensi != "") {
				if ($this->session->userdata('user_level_id') == 1)
					$arr[] = "presensi.tgl_presensi='$tgl_presensi'";
				else
					$arr[] = "month(presensi.tgl_presensi)='" . date('n') . "'";
			}

			if (count($arr) > 0) {
				$i = 1;
				foreach ($arr as $key => $value) {

					if ($key == 0) {
						$sql .= " where $value";
					} else {
						$sql .= " and $value";
					}

					$i++;
				}
			}

			$html = '
				<table id="table" class="table table-striped table-bordered">
					<tr>
						<th>Pegawai</th>
						<th>Tanggal</th>
						<th>Absensi</th>
						<th>Status</th>
					</tr>';
			if (count($arr) > 0) {
				$laporan_presensis = $this->db->query($sql);
				if ($laporan_presensis->num_rows() > 0) {

					foreach ($laporan_presensis->result() as $laporan_presensi) {
						$html .= '
						<tr>
							<td>' . $laporan_presensi->nama_pegawai . '</td>
							<td>' . tgl_indonesia($laporan_presensi->tgl_presensi) . '</td>
							<td>' . $laporan_presensi->nama_jenis_presensi . '</td>
							<td>' . $laporan_presensi->nama_status_presensi . '</td>
						</tr>';
					}
				}
			}
			// echo 'Jumlah : '.$laporan_presensis->num_rows();
			echo $html .= '</table>';
		}
	}

	function pegawai2()
	{
		if ($this->session->userdata('login') == TRUE) {
			$id_pegawai = $this->input->post('id_pegawai', TRUE);
			$tgl_mulai = $this->input->post('tgl_mulai', TRUE);
			$tgl_selesai = $this->input->post('tgl_selesai', TRUE);
			$id_jenis_presensi = $this->input->post('id_jenis_presensi', TRUE);

			$sql = "
			select
				presensi.*,
				pegawai.nip, pegawai.nama_pegawai, pegawai.id_instansi,
				instansi.nama_instansi,
				jenis_presensi.nama_jenis_presensi,
				status_presensi.nama_status_presensi
			from
				presensi
				left join pegawai on presensi.id_pegawai=pegawai.id_pegawai
				left join instansi on pegawai.id_instansi=instansi.id_instansi
				left join jenis_presensi on presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
				left join status_presensi on presensi.id_status_presensi=status_presensi.id_status_presensi
			";

			$arr = array();

			if ($id_pegawai != "") {
				$arr['presensi.id_pegawai'] = $id_pegawai;
			}

			if ($id_jenis_presensi != "") {
				$arr['presensi.id_jenis_presensi'] = $id_jenis_presensi;
			}

			if ($tgl_mulai != "" && $tgl_selesai != "") {
				$arr['presensi.tgl_presensi>'] = date('Y-m-d', strtotime($tgl_mulai));
				$arr['presensi.tgl_presensi<'] = date('Y-m-d', strtotime($tgl_selesai));
			}

			if (count($arr) > 0) {
				$i = 1;
				foreach ($arr as $key => $value) {
					if ($i == 1) {
						$sql .= " where $key='$value'";
					} else {
						$sql .= " and $key='$value'";
					}

					$i++;
				}
			}

			$html = '
			<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
				<table id="table" class="table table-striped table-bordered">
					<tr>
						<th>Pegawai</th>
						<th>Absen</th>
						<th>Tanggal</th>
						<th>Jam</th>
						<th><i class="glyphicon glyphicon-map-marker"><i/></th>
					</tr>';
			if (count($arr) > 0) {
				$laporan_presensis = $this->db->query($sql);
				if ($laporan_presensis->num_rows() > 0) {

					foreach ($laporan_presensis->result() as $laporan_presensi) {
						$html .= '
						<tr>
							<td>' . $laporan_presensi->nama_pegawai . '</td>
							<td>' . $laporan_presensi->nama_jenis_presensi . '</td>
							<td>' . tgl_indonesia($laporan_presensi->tgl_presensi) . '</td>
							<td>' . $laporan_presensi->jam_presensi . '</td>
							<td><a href="' . base_url('presensi/lokasi/' . decode($laporan_presensi->id_presensi) . '/' . url_title($laporan_presensi->nama_pegawai)) . '">' . $laporan_presensi->lon . ',' . $laporan_presensi->lat . '</a></td>
						</tr>';
					}
				}
			}
			// echo 'Jumlah : '.$laporan_presensis->num_rows();
			echo $html .= '</table></div></div></div>';

			// echo 'ada nda';
		}
	}

	function instansi()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE);
		$tgl_presensi = $this->input->post('tgl_presensi', TRUE);
		$id_jenis_presensi = $this->input->post('id_jenis_presensi', TRUE);

		$sql = "select presensi.*,
			jenis_presensi.nama_jenis_presensi,
			pegawai.nip,
			pegawai.nama_pegawai,
			pegawai.id_golongan,
			pegawai.id_jabatan,
			pegawai.id_instansi,
			golongan.nama_golongan,
			jabatan.nama_jabatan
		from
			presensi
			left join jenis_presensi on presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi
			left join pegawai on presensi.id_pegawai=pegawai.id_pegawai
			left join golongan on pegawai.id_golongan=golongan.id_golongan
			left join jabatan on pegawai.id_jabatan=jabatan.id_jabatan
		";

		$arr = array();
		if ($id_instansi != "")
			$arr['pegawai.id_instansi'] = $id_instansi;
		if ($tgl_presensi != "")
			$arr['presensi.tgl_presensi'] = date('Y-m-d', strtotime($tgl_presensi));
		if ($id_jenis_presensi != "")
			$arr['presensi.id_jenis_presensi'] = $id_jenis_presensi;

		if (count($arr) > 0) {
			$i = 1;
			foreach ($arr as $key => $value) {
				if ($i == 1)
					$sql .= " where $key='$value' ";
				else
					$sql .= " and $key='$value'";
				$i++;
			}
		}

		$sql .= " order by urutan asc";
		$qry = $this->db->query($sql);

		$html = '';
		if ($qry->num_rows() > 0) {
			$html .= '<div class="box box-primary">
				<div class="box-body">';
			foreach ($qry->result() as $row) {
				$photo = $row->photo;
				if ($photo == "")
					$img_src = base_url('upload/no_image_available.png');
				else
					$img_src = base_url('upload/pegawai/thumbs/' . $photo);

				$id_pegawai = $row->id_pegawai;
				$nama_pegawai = $row->nama_pegawai;
				$tgl_presensi = tgl_indonesia2($row->tgl_presensi);
				$jam_presensi = $row->jam_presensi;
				$nama_jabatan = $row->nama_jabatan;
				$html .= '
					<div class="user-block">
	                    <img class="img-circle img-bordered-sm" src="' . $img_src . '" alt="' . $nama_pegawai . '">
	                        <span class="username">
	                          <a href="' . base_url('presensi/v_pegawai/' . decode($id_pegawai) . '/' . url_title($nama_pegawai)) . '">' . $nama_pegawai . '</a>
	                          <span class="pull-right btn-box-tool">
	                          	<i class="glyphicon glyphicon-calendar"></i> ' . $tgl_presensi . '
	                          </span>
	                          <span class="pull-right btn-box-tool">
	                          	<i class="glyphicon glyphicon-time"></i> ' . $jam_presensi . '
	                          </span>
	                          <span class="btn-box-tool">
	                          	<a href="' . base_url('presensi/lokasi/' . decode($row->id_presensi) . '/' . url_title($nama_pegawai)) . '"><i class="glyphicon glyphicon-map-marker"></i></a></span>
	                          	</span>

	                    <span class="description">' . $nama_jabatan . '</span>
	                </div><br />
                ';
			}

			$html .= '</div>
			</div>';
		} else {
			$html .= 'Tidak ada yang absensi.';
		}

		echo $html;
	}

	function v_pegawai()
	{

		if ($this->session->userdata('login') == TRUE) {
			$id_pegawai = encode($this->uri->segment(3));
			$this->load->helper('url');
			$data = array(
				'title' => 'Dashboard',
				'id_pegawai' => $id_pegawai,
				'main_view' => 'admin/pegawai',
				'form_view' => 'admin/pegawai_form',
			);

			$pegawais = $this->pegawai->get_list_pegawai($id_pegawai);
			$opt_pegawai = array('' => 'All Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'Pilih Jenis Presensi');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;

			$this->load->view('admin/template', $data);
		} else {
			redirect(base_url());
		}
	}

	function lokasi()
	{
		if ($this->session->userdata('login') == TRUE) {
			$this->load->helper('url');

			$id_presensi = encode($this->uri->segment(3));
			$presensi = $this->presensi->get_by_id($id_presensi);

			$data = array(
				'title' => 'Lokasi',
				'main_view' => 'presensi/lokasi',
				'presensi'	=> $presensi,
				'form_view' => 'presensi/lokasi_form',
			);

			$this->load->view('admin/template', $data);
		} else {
			redirect(base_url());
		}
	}

	function finger()
	{
		echo 'Belum ada perangkat finger terhubung';
	}

	function get_jumlah()
	{
		$id = $this->input->post('id', TRUE);

		if ($id != "") {
			$n = date('n');
			$qry = $this->db->query("select count(*) as jml from presensi where id_pegawai='$id' and month(tgl_presensi)=$n");
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

	function upload_file()
	{
		$id = $this->input->post('id', TRUE);
		$photo = $this->input->post('photo', TRUE);

		if ($photo != null) {
			if ($id != "") {
				$this->db->query("update presensi set photo='" . $id . ".jpeg' where id_presensi='$id'");
				$path = "upload/presensi/thumbs/$id.jpeg";
				@file_put_contents($path, base64_decode($photo));
				print(json_encode(array('code' => 1, 'message' => 'Photo berhasil diupload.')));
			} else {
				print(json_encode(array('code' => 2, 'message' => 'ID tidak ditemukan.')));
			}
		} else {
			print(json_encode(array('code' => 2, 'message' => 'Photo kosong.')));
		}
	}

	public function terlambat($patokan, $pembanding)
	{
		$selisih = selisih_detik($patokan, $pembanding);
		$hasil = 0;
		if ($selisih > 59) {
			$hasil = $selisih / 60;
		}
		return $hasil;
	}

	public function cek()
	{
		echo $this->terlambat("08:00:00", "08:00:10");
	}
}
// END Presensi Class
/* End of file presensi.php */
/* Location: ./sytem/application/controlers/presensi.php */
