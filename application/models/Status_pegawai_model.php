<?php
class Status_pegawai_model extends CI_Model
{

	var $table = 'status_pegawai';
	
	var $column_order = array(null, null, 'nama_status_pegawai',null);
	var $column_search = array('nama_status_pegawai',);
	var $order = array('id_status_pegawai' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->from($this->table);

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
		$this->db->from($this->table);
		$this->db->where('id_status_pegawai',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_status_pegawai()
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
		$this->db->where('id_status_pegawai', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_status_pegawai()
    {
        $this->db->select('id_status_pegawai, nama_status_pegawai');
        $this->db->from($this->table);
        $this->db->order_by('nama_status_pegawai','asc');
        $query = $this->db->get();
        $result = $query->result();

        $status_pegawais = array();
        foreach ($result as $row) 
        {
            $status_pegawais[$row->id_status_pegawai] = $row->nama_status_pegawai;
        }
        return $status_pegawais;
    }	

    public function get_nama_status_pegawai($id_status_pegawai)
	{
		$this->db->from($this->table);
		$this->db->where('id_status_pegawai', $id_status_pegawai);
		$query = $this->db->get();
		$row = $query->row();
		return $row->nama_status_pegawai;
	}		
}
		