<?php
class Jabatan_model extends CI_Model
{

	var $table = 'jabatan';
	
	var $column_order = array('nama_jabatan',null);
	var $column_search = array('nama_jabatan',);
	var $order = array('urutan' => 'asc'); // default order 

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
		$this->db->where('id_jabatan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_jabatan()
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
		$this->db->where('id_jabatan', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_jabatan()
    {
        $this->db->select('id_jabatan, nama_jabatan');
        $this->db->from($this->table);
        $this->db->order_by('nama_jabatan','asc');
        $query = $this->db->get();
        $result = $query->result();

        $jabatans = array();
        foreach ($result as $row) 
        {
            $jabatans[$row->id_jabatan] = $row->nama_jabatan;
        }
        return $jabatans;
    }

    public function get_nama_jabatan($id_jabatan)
	{
		$this->db->from($this->table);
		$this->db->where('id_jabatan', $id_jabatan);
		$query = $this->db->get();
		$nama_jabatan = '';
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama_jabatan = $row->nama_jabatan;	
		}
		return $nama_jabatan;
	}			
}
		