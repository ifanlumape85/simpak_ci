<?php
class Kegiatan_tahunan_model extends CI_Model
{

	var $table = 'kegiatan_tahunan';
	
	var $column_order = array(null, null, 'instansi.nama_instansi', 'pegawai.nama_pegawai', 'tahun', null, null, null, null);
	var $column_search = array('instansi.nama_instansi' , 'pegawai.nama_pegawai', 'tahun');
	var $order = array('id_kegiatan_tahunan' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('kegiatan_tahunan.*, pegawai.nama_pegawai, instansi.nama_instansi, jenis_kuantitas.nama_jenis_kuantitas');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_tahunan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_tahunan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
		
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }

		if($this->input->post('id_pegawai'))
        {
            $this->db->where('kegiatan_tahunan.id_pegawai', $this->input->post('id_pegawai'));
        }
				
		if($this->input->post('tahun'))
        {
            $this->db->where('kegiatan_tahunan.tahun', $this->input->post('tahun'));
        }
				
		$i = 0;
	
		if ($this->session->userdata('user_level_id') == 1)
		{
			$column_search = $this->column_search;
		}
		else
		{
			$column_search = array('pegawai.nama_pegawai', 'tahun');
			if ($this->session->userdata('user_level_id')==5)
			{
				$this->db->where('kegiatan_tahunan.id_pegawai', $this->session->userdata('pegawai_id'));
			}
			else
			{
				$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
			}
		}

		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					//$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
				{
					//$this->db->group_end(); //close bracket
				}
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('kegiatan_tahunan.*, pegawai.nama_pegawai, pegawai.nip, jenis_kuantitas.nama_jenis_kuantitas');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_tahunan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('jenis_kuantitas', 'kegiatan_tahunan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
		$this->db->where('id_kegiatan_tahunan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_kegiatan_tahunan()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}	

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_kegiatan_tahunan', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_kegiatan_tahunan()
    {
        $this->db->select('id_kegiatan_tahunan, kegiatan');
        $this->db->from($this->table);
        $this->db->order_by('id_kegiatan_tahunan','desc');
        $query = $this->db->get();
        $result = $query->result();

        $kegiatan_tahunans = array();
        foreach ($result as $row) 
        {
            $kegiatan_tahunans[$row->id_kegiatan_tahunan] = $row->kegiatan;
        }
        return $kegiatan_tahunans;
    }			
}
		