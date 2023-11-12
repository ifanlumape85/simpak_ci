<?php
class Surat_masuk_model extends CI_Model
{

	var $table = 'surat_masuk';
	
	var $column_order = array('tgl_terima','no_agenda','no_surat','tgl_surat','isi_ringkas','id_instansi','nama_pegawai','tgl_entri','jam_entri','id_user_entri','jam_update','tgl_update','id_user_update',null);
	var $column_search = array('tgl_terima','no_agenda','no_surat','tgl_surat','isi_ringkas','id_instansi','nama_pegawai','tgl_entri','jam_entri','id_user_entri','jam_update','tgl_update','id_user_update',);
	var $order = array('id_surat_masuk' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->from($this->table);
		$this->db->join('instansi', 'surat_masuk.id_instansi=instansi.id_instansi');
				
		if($this->input->post('id_instansi'))
        {
            $this->db->where('surat_masuk.id_instansi', $this->input->post('id_instansi'));
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
		$this->db->where('id_surat_masuk',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_surat_masuk()
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
		$this->db->where('id_surat_masuk', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_surat_masuk()
    {
        $this->db->select('id_surat_masuk, nama_surat_masuk');
        $this->db->from($this->table);
        $this->db->order_by('nama_surat_masuk','asc');
        $query = $this->db->get();
        $result = $query->result();

        $surat_masuks = array();
        foreach ($result as $row) 
        {
            $surat_masuks[$row->id_surat_masuk] = $row->nama_surat_masuk;
        }
        return $surat_masuks;
    }			
}
		