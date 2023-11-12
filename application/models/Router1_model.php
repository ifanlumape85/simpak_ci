<?php
class Router1_model extends CI_Model
{

	var $table = 'router1';
	
	var $column_order = array(null,null,'nama_router1','ip_address','mac_address','instansi.nama_instansi',null);
	var $column_search = array('nama_router1','ip_address','mac_address','instansi.nama_instansi',);
	var $order = array('id_router1' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('router1.*, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('instansi', 'router1.id_instansi=instansi.id_instansi');
				
		if($this->input->post('id_instansi'))
        {
            $this->db->where('router1.id_instansi', $this->input->post('id_instansi'));
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
		if ($id!=""){
			if (is_array($id))
				$this->db->where($id);
			else 
				$this->db->where('id_router1',$id);
		}
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);

		if (is_array($id))
			$this->db->where($id);
		else 
			$this->db->where('id_router1',$id);

		$query = $this->db->get();

		return $query->row();
	}

	public function get_router1()
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
		$this->db->where('id_router1', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_router1()
    {
        $this->db->select('id_router1, nama_router1');
        $this->db->from($this->table);
        $this->db->order_by('nama_router1','asc');
        $query = $this->db->get();
        $result = $query->result();

        $router1s = array();
        foreach ($result as $row) 
        {
            $router1s[$row->id_router1] = $row->nama_router1;
        }
        return $router1s;
    }			
}
		