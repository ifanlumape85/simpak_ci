<?php
class Golongan_pangkat_model extends CI_Model
{

	var $table = 'golongan_pangkat';
	
	var $column_order = array(null, null, 'instansi.nama_instansi', 'pegawai.nama_pegawai', null, null, null);
	var $column_search = array('pegawai.nama_pegawai', 'pegawai.nip', 'golongan.nama_golongan', 'pangkat.nama_pangkat');
	var $order = array('id_golongan_pangkat' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('golongan_pangkat.*, pegawai.nama_pegawai, pegawai.nip, instansi.nama_instansi, golongan.nama_golongan, pangkat.nama_pangkat');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'golongan_pangkat.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('golongan', 'golongan_pangkat.id_golongan=golongan.id_golongan');
		$this->db->join('pangkat', 'golongan_pangkat.id_pangkat=pangkat.id_pangkat');
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('golongan_pangkat.id_pegawai', $this->input->post('id_pegawai'));
        }
				
		if($this->input->post('id_golongan'))
        {
            $this->db->where('golongan_pangkat.id_golongan', $this->input->post('id_golongan'));
        }
				
		if($this->input->post('id_pangkat'))
        {
            $this->db->where('golongan_pangkat.id_pangkat', $this->input->post('id_pangkat'));
        }
				
		$i = 0;
	
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
		$this->db->select('golongan_pangkat.*, pegawai.id_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'golongan_pangkat.id_pegawai=pegawai.id_pegawai');
		$this->db->where('id_golongan_pangkat',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_golongan_pangkat()
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
		$this->db->where('id_golongan_pangkat', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_golongan_pangkat()
    {
        $this->db->select('id_golongan_pangkat, nama_golongan_pangkat');
        $this->db->from($this->table);
        $this->db->order_by('nama_golongan_pangkat','asc');
        $query = $this->db->get();
        $result = $query->result();

        $golongan_pangkats = array();
        foreach ($result as $row) 
        {
            $golongan_pangkats[$row->id_golongan_pangkat] = $row->nama_golongan_pangkat;
        }
        return $golongan_pangkats;
    }			
}
		