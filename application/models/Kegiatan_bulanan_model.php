<?php
class Kegiatan_bulanan_model extends CI_Model
{

	var $table = 'kegiatan_bulanan';
	
	var $column_order = array(null, null, 'kegiatan_tahunan.tahun', 'instansi.nama_instansi', 'pegawai.nama_pegawai', null, null, null, null, null);
	var $column_search = array('kegiatan_tahunan.tahun', 'instansi.nama_instansi', 'pegawai.nama_pegawai');
	var $order = array('id_kegiatan_bulanan' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('kegiatan_bulanan.*, kegiatan_tahunan.kegiatan as kegiatan_tahunan, kegiatan_tahunan.tahun, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi, jenis_kuantitas.nama_jenis_kuantitas');
		$this->db->from($this->table);
		$this->db->join('kegiatan_tahunan', 'kegiatan_bulanan.id_kegiatan_tahunan=kegiatan_tahunan.id_kegiatan_tahunan');
		$this->db->join('pegawai', 'kegiatan_tahunan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_bulanan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
		
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
				
		if($this->input->post('id_kegiatan_tahunan'))
        {
            $this->db->where('kegiatan_bulanan.id_kegiatan_tahunan', $this->input->post('id_kegiatan_tahunan'));
        }
				
		$i = 0;
		
		if ($this->session->userdata('user_level_id') == 1)
		{
			$column_search = $this->column_search;	
		}
		else
		{
			
			$column_search = array('kegiatan_tahunan.tahun', 'pegawai.nama_pegawai');
			if ($this->session->userdata('user_level_id')==5)
			{
				$this->db->where('kegiatan_tahunan.id_pegawai', $this->session->userdata('pegawai_id'));
			}
			$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
		}

		foreach ($column_search as $item) // loop column 
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
		$this->db->select('kegiatan_bulanan.*, kegiatan_tahunan.id_kegiatan_tahunan, kegiatan_tahunan.kegiatan as kegiatan_tahunan, kegiatan_tahunan.tahun, pegawai.id_pegawai, pegawai.nip, pegawai.nama_pegawai, instansi.id_instansi, instansi.nama_instansi, jenis_kuantitas.nama_jenis_kuantitas');
		$this->db->from($this->table);
		$this->db->join('kegiatan_tahunan', 'kegiatan_bulanan.id_kegiatan_tahunan=kegiatan_tahunan.id_kegiatan_tahunan');
		$this->db->join('pegawai', 'kegiatan_tahunan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_bulanan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
		$this->db->where('id_kegiatan_bulanan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_kegiatan_bulanan()
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
		$this->db->where('id_kegiatan_bulanan', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_kegiatan_bulanan()
    {
        $this->db->select('id_kegiatan_bulanan, kegiatan');
        $this->db->from($this->table);
        $this->db->order_by('id_kegiatan_bulanan','desc');
        $query = $this->db->get();
        $result = $query->result();

        $kegiatan_bulanans = array();
        foreach ($result as $row) 
        {
            $kegiatan_bulanans[$row->id_kegiatan_bulanan] = $row->kegiatan;
        }
        return $kegiatan_bulanans;
    }			
}
		