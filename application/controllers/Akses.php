<?php
class Akses extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Akses_model', 'akses', TRUE);
        $this->load->model('Pegawai_model', 'pegawai', TRUE);
    }

    function index()
    {
        if ($this->session->userdata('login') != TRUE) {
            redirect('login');
        } else {
            $this->load->helper('url');
            $data = array(
                'title'     => 'Data Akses',
                'main_view' => 'akses/akses',
                'form_view' => 'akses/akses_form',
            );

            $pegawais = $this->pegawai->get_list_pegawai();
            $opt_pegawai = array('' => 'All Pegawai');
            foreach ($pegawais as $i => $v) {
                $opt_pegawai[$i] = $v;
            }

            $data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
            $data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
            $data['options_pegawai'] = $opt_pegawai;
            $this->load->view('admin/template', $data);
        }
    }

    public function ajax_list()
    {
        $this->load->helper('url');
        $list = $this->akses->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $akses) {
            $no++;
            $row = array();

            $row[] = '<input type="checkbox" class="data-check" value="' . $akses->id_akses . '">';
            $row[] = $no;
            $row[] = $akses->nama_pegawai;
            $row[] = $akses->package_name;
            $row[] = $akses->status;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_akses(' . "'" . $akses->id_akses . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_akses(' . "'" . $akses->id_akses . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw"                 => $_POST['draw'],
            "recordsTotal"         => $this->akses->count_all(),
            "recordsFiltered"     => $this->akses->count_filtered(),
            "data"                 => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->akses->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'id_pegawai' => $this->input->post('id_pegawai', TRUE),
            'package_name' => $this->input->post('package_name', TRUE),
            'status' => $this->input->post('status', TRUE),
        );
        $insert = $this->akses->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function android_add()
    {
        $arr = array();
        if ($this->input->post('id_pegawai') == "")
            $arr[] = "";
        if ($this->input->post('package_name') == "")
            $arr[] = "";

        if (count($arr) == 0) {
            $id_pegawai = $this->input->post('id_pegawai', TRUE);
            $qry = $this->db->query("select * from akses where id_pegawai=$id_pegawai");
            if ($qry->num_rows() == 0) {
                $data = array(
                    'id_pegawai' => $this->input->post('id_pegawai', TRUE),
                    'package_name' => $this->input->post('package_name', TRUE),
                    'status' => 0,
                );
                $this->akses->save($data);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            echo json_encode(array("status" => false));
        }
    }

    public function android_cek()
    {
        $arr = array();
        if ($this->input->post('id_pegawai') == "")
            $arr[] = "";

        if (count($arr) == 0) {
            $id_pegawai = $this->input->post('id_pegawai');
            $qry = $this->db->query("select * from akses where id_pegawai=$id_pegawai");
            if ($qry->num_rows() > 0) {
                $row = $qry->row();
                if ($row->status == 0) {
                    echo json_encode(array("status" => false));
                } else {
                    echo json_encode(array("status" => true));
                }
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            echo json_encode(array("status" => false));
        }
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'id_pegawai' => $this->input->post('id_pegawai', TRUE),
            'package_name' => $this->input->post('package_name', TRUE),
            'status' => $this->input->post('status', TRUE),
        );
        $this->akses->update(array('id_akses' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        if ($this->input->post('id', TRUE) != "")
            $id = $this->input->post('id', TRUE);

        $this->akses->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->akses->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;


        if ($this->input->post('id_pegawai') == '') {
            $data['inputerror'][] = 'id_pegawai';
            $data['error_string'][] = 'Jenis akses  is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('package_name') == '') {
            $data['inputerror'][] = 'package_name';
            $data['error_string'][] = 'Jam akses is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('status') == '') {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'Detail akses is required';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
// END akses Class
/* End of file akses.php */
/* Location: ./sytem/application/controlers/akses.php */
