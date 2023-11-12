<?php
class Pegawai_model extends CI_Model
{

	var $table = 'pegawai';
	
	var $column_order = array(null, null, 'jabatan.nama_jabatan', 'pegawai.nip','pegawai.nama_pegawai','status_pegawai.nama_status_pegawai','instansi.nama_instansi', null, null, null);
	var $column_search = array('pegawai.nip','pegawai.nama_pegawai');
	var $order = array('pegawai.id_pegawai' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('pegawai.*, jabatan.nama_jabatan, status_pegawai.nama_status_pegawai, instansi.nama_instansi, status_pegawai.nama_status_pegawai, pangkat.nama_pangkat, golongan.nama_golongan');
		$this->db->from($this->table);
		$this->db->join('jabatan', 'pegawai.id_jabatan=jabatan.id_jabatan', 'left');
		$this->db->join('status_pegawai', 'pegawai.id_status_pegawai=status_pegawai.id_status_pegawai', 'left');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi', 'left');
		$this->db->join('pangkat', 'pegawai.id_pangkat=pangkat.id_pangkat', 'left');
		$this->db->join('golongan', 'pegawai.id_golongan=golongan.id_golongan', 'left');

		if($this->input->post('id_status_pegawai'))
        {
            $this->db->where('pegawai.id_status_pegawai', $this->input->post('id_status_pegawai'));
        }
				
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }

        if($this->input->post('id_jabatan'))
        {
            $this->db->where('pegawai.id_jabatan', $this->input->post('id_jabatan'));
        }

        if ($this->session->userdata('user_level_id') == 1)
        {
        	$column_search = $this->column_search;
        }
        else
        {
        	$column_search = array('pegawai.nama_pegawai');
        	if ($this->session->userdata('user_level_id')==5)
        	{
        		$this->db->where('pegawai.id_pegawai', $this->session->userdata('pegawai_id'));
        	}
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
		$this->db->from($this->table);
		$this->db->join('jabatan', 'pegawai.id_jabatan=jabatan.id_jabatan', 'left');
		$this->db->join('status_pegawai', 'pegawai.id_status_pegawai=status_pegawai.id_status_pegawai', 'left');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi', 'left');

		if (is_array($id))
			$this->db->where($id);
		else 
			$this->db->where('id_pegawai',$id);
		
		$query = $this->db->get();

		return $query->row();
	}

	public function get_id($id)
	{
		$this->db->from($this->table);
		$this->db->like('nama_pegawai',$id);
		$query = $this->db->get();

		$id_pegawai = '';
		if ($query->num_rows() > 0)
		{
			$q = $query->row();
			$id_pegawai = $q->id_pegawai;
		}
		return $id_pegawai;
	}

	public function get_pegawai()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_nama_pegawai($id_pegawai)
	{
		$this->db->from($this->table);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		
		$nama_pegawai = '';
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama_pegawai = $row->nama_pegawai;	
		}
		

		return $nama_pegawai;
	}

	public function get_nip_pegawai($id_pegawai)
	{
		$this->db->from($this->table);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();

		$nip = '';
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$nip = $row->nip;	
		}
		
		return $nip;
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
		$this->db->where('id_pegawai', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_pegawai($id="")
    {
        $this->db->select('id_pegawai, nama_pegawai');
        $this->db->from($this->table);
        if ($id!="")
        {
        	if (is_array($id))
        		$this->db->where($id);
        	else 
        		$this->db->where('id_pegawai', $id);
        }
        
        $this->db->order_by('nama_pegawai','asc');
        $query = $this->db->get();
        $result = $query->result();

        $pegawais = array();
        foreach ($result as $row) 
        {
            $pegawais[$row->id_pegawai] = $row->nama_pegawai;
        }
        return $pegawais;
    }			
}
		