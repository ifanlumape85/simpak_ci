<?php
class Informasi_surat_model extends CI_Model
{

	var $table = 'informasi_surat';
	
	var $column_order = array('id_surat_masuk','id_status_surat','tgl_informasi_surat','jam_informasi_surat','tgl_entri','jam_entri','id_user_entri','tgl_update','jam_update','id_user_update',null);
	var $column_search = array('id_surat_masuk','id_status_surat','tgl_informasi_surat','jam_informasi_surat','tgl_entri','jam_entri','id_user_entri','tgl_update','jam_update','id_user_update',);
	var $order = array('id_informasi_surat' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->from($this->table);
		$this->db->join('surat_masuk', 'informasi_surat.id_surat_masuk=surat_masuk.id_surat_masuk');
						$this->db->join('status_surat', 'informasi_surat.id_status_surat=status_surat.id_status_surat');
				
		if($this->input->post('id_surat_masuk'))
        {
            $this->db->where('informasi_surat.id_surat_masuk', $this->input->post('id_surat_masuk'));
        }
				
		if($this->input->post('id_status_surat'))
        {
            $this->db->where('informasi_surat.id_status_surat', $this->input->post('id_status_surat'));
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
		$this->db->from($this->table);
		$this->db->where('id_informasi_surat',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_informasi_surat()
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
		$this->db->where('id_informasi_surat', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_informasi_surat()
    {
        $this->db->select('id_informasi_surat, nama_informasi_surat');
        $this->db->from($this->table);
        $this->db->order_by('nama_informasi_surat','asc');
        $query = $this->db->get();
        $result = $query->result();

        $informasi_surats = array();
        foreach ($result as $row) 
        {
            $informasi_surats[$row->id_informasi_surat] = $row->nama_informasi_surat;
        }
        return $informasi_surats;
    }			
}
		