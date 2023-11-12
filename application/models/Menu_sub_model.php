<?php
class Menu_sub_model extends CI_Model
{

	var $table = 'menu_sub';
	var $column_order = array('menu_sub.menu_sub_name','menu.menu_name',null); //set column field database for datatable orderable
	var $column_search = array('menu_sub.menu_sub_name', 'menu.menu_name',); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('menu_sub_id' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('menu_sub.*, menu.menu_name');
		$this->db->from($this->table);
		$this->db->join('menu', 'menu_sub.menu_id=menu.menu_id');
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
		$this->db->where('menu_sub_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_menu_id($id)
	{
		$this->db->select('menu_sub_id, menu_id');
		$this->db->from($this->table);
		$this->db->where('menu_sub_id', $id);
		$query = $this->db->get();
		$row = $query->row();
		return $row->menu_id;
	}

	public function get_menu_sub()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_menu($id)
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
		$this->db->where('menu_sub_id', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_menu_sub()
    {
    	$this->db->select('menu_sub.*, menu.menu_name');
        $this->db->from($this->table);
        $this->db->join('menu', 'menu.menu_id=menu_sub.menu_id');
        $this->db->order_by('menu.menu_name','asc');
        $query = $this->db->get();
        $result = $query->result();

        $menu_subs = array();
        foreach ($result as $row) 
        {
            $menu_subs[$row->menu_sub_id] = $row->menu_name.' > '.$row->menu_sub_name;
        }
        return $menu_subs;
    }	

    public function get_sub_menu($menu_id)
    {
    	$this->db->from($this->table);
        $this->db->where('menu_id', $menu_id);
        $this->db->order_by('menu_sub_position','asc');
        $query = $this->db->get();
        return $query;
    }					
}