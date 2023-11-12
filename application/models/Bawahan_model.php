<?php
class Bawahan_model extends CI_Model
{

	var $table = 'bawahan';
	
	var $column_order = array(null, null, 'instansi.nama_instansi', 'pegawai.nama_pegawai', null,null,null,null);
	var $column_search = array('instansi.nama_instansi', 'pegawai.nama_pegawai');
	var $order = array('id_bawahan' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('bawahan.*, pegawai.id_instansi, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'bawahan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }

		if($this->input->post('id_pegawai'))
        {
            $this->db->where('bawahan.id_pegawai', $this->input->post('id_pegawai'));
        }
		
        if ($this->session->userdata('user_level_id')==1)
        {    	
        	$column_search = $this->column_search;
        }
        else
        {
        	$column_search = array('pegawai.nama_pegawai');
        	$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
        }
		$i = 0;
	
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
		$this->db->select('bawahan.*, pegawai.id_instansi, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'bawahan.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->where('id_bawahan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_bawahan()
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
		$this->db->where('id_bawahan', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_bawahan()
    {
        $this->db->select('id_bawahan, nama_bawahan');
        $this->db->from($this->table);
        $this->db->order_by('nama_bawahan','asc');
        $query = $this->db->get();
        $result = $query->result();

        $bawahans = array();
        foreach ($result as $row) 
        {
            $bawahans[$row->id_bawahan] = $row->nama_bawahan;
        }
        return $bawahans;
    }			
}
		