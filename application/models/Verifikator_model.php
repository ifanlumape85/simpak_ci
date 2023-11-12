<?php
class Verifikator_model extends CI_Model
{

	var $table = 'verifikator';
	
	var $column_order = array(null,null,'instansi.nama_instansi', 'pegawai.nama_pegawai',null,null);
	var $column_search = array('instansi.nama_instansi', 'pegawai.nama_pegawai');
	var $order = array('id_verifikator' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('verifikator.*, pegawai.nip, pegawai.id_instansi, pegawai.nama_pegawai, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'verifikator.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }

		if($this->input->post('id_pegawai'))
        {
            $this->db->where('verifikator.id_pegawai', $this->input->post('id_pegawai'));
        }

        if ($this->session->userdata('user_level_id') > 1)
        {
        	$this->db->where('verifikator.id_pegawai', $this->session->userdata('pegawai_id'));	
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

	public function count_all($id="")
	{
		$this->db->from($this->table);
		if ($id!="")
		{
			if (is_array($id))
				$this->db->where($id);
		}
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('verifikator.*, pegawai.nip, pegawai.id_instansi, pegawai.nama_pegawai, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'verifikator.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->where('id_verifikator',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_verifikator()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_verifikator_pegawai($id_pegawai)
	{
		$this->db->from($this->table);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$verifikator='';
		if ($query->num_rows() > 0)
		{
			$q = $query->row();
			$verifikator = $q->verifikator;
		}
		return $verifikator;
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
		$this->db->where('id_verifikator', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_verifikator()
    {
        $this->db->select('id_verifikator, nama_verifikator');
        $this->db->from($this->table);
        $this->db->order_by('nama_verifikator','asc');
        $query = $this->db->get();
        $result = $query->result();

        $verifikators = array();
        foreach ($result as $row) 
        {
            $verifikators[$row->id_verifikator] = $row->nama_verifikator;
        }
        return $verifikators;
    }			
}
		