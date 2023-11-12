<?php
class Pengaturan_instansi_model extends CI_Model
{

	var $table = 'pengaturan_instansi';
	
	var $column_order = array(null,null,'nama_instansi','nama_jenis_presensi','mulai','akhir','tanggal',null);
	var $column_search = array('nama_instansi','nama_jenis_presensi','mulai','akhir','tanggal',);
	var $order = array('id_pengaturan_instansi' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->from($this->table);
		$this->db->join('instansi', 'pengaturan_instansi.id_instansi=instansi.id_instansi');
						$this->db->join('jenis_presensi', 'pengaturan_instansi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
				
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pengaturan_instansi.id_instansi', $this->input->post('id_instansi'));
        }
        else
        {
        	if ($this->session->userdata('user_level_id') > 1)
	        	$this->db->where('pengaturan_instansi.id_instansi', $this->session->userdata('instansi_id'));	
        }
				
		if($this->input->post('id_jenis_presensi'))
        {
            $this->db->where('pengaturan_instansi.id_jenis_presensi', $this->input->post('id_jenis_presensi'));
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

		if (is_array($id))
			$this->db->where($id);
		else 
			$this->db->where('id_pengaturan_instansi',$id);
		
		$query = $this->db->get();

		return $query->row();
	}

	public function get_pengaturan_instansi()
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
		$this->db->where('id_pengaturan_instansi', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_pengaturan_instansi()
    {
        $this->db->select('id_pengaturan_instansi, nama_pengaturan_instansi');
        $this->db->from($this->table);
        $this->db->order_by('nama_pengaturan_instansi','asc');
        $query = $this->db->get();
        $result = $query->result();

        $pengaturan_instansis = array();
        foreach ($result as $row) 
        {
            $pengaturan_instansis[$row->id_pengaturan_instansi] = $row->nama_pengaturan_instansi;
        }
        return $pengaturan_instansis;
    }			
}
		