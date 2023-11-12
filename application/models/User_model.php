<?php
class User_model extends CI_Model
{

	var $table = 'user';
	var $column_order = array('instansi.nama_instansi','pegawai.nama_pegawai','user_name','user_level_name', 'user.aktif', null); //set column field database for datatable orderable
	var $column_search = array('pegawai.nama_pegawai'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('user_id' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	private function _get_datatables_query($user_id)
	{	
		$this->db->select('user.*, pegawai.photo as photo_pegawai, pegawai.id_instansi, pegawai.nama_pegawai, pegawai.nip, instansi.nama_instansi, user_level.user_level_name');
		$this->db->join('pegawai', 'user.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('user_level', 'user.user_level_id=user_level.user_level_id');
		$this->db->from($this->table);
		
		if ($this->session->userdata('user_level_id') == 1)
		{	
		}
		else
		{
			$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
		}
		
		if ($this->input->post('id_instansi')!="")
		{
			$this->db->where('pegawai.id_instansi', $this->input->post('id_instansi', TRUE));
		}

		if ($this->input->post('id_pegawai')!="")
		{
			$this->db->where('user.id_pegawai', $this->input->post('id_pegawai', TRUE));
		}

		if ($this->session->userdata('user_level_id') == 1)
		{
		}
		else
		{
			if ($this->session->userdata('user_level_id')==5)
			{
				$this->db->where('user.id_pegawai', $this->session->userdata('pegawai_id'));		
			}
			if ($user_id!="") 
			{
				$this->db->where('user_id', $user_id);
			}
		}
		
		
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
				{
					$this->db->group_end(); //close bracket
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

	function get_datatables($user_id="")
	{
		$this->_get_datatables_query($user_id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($user_id="")
	{
		$this->_get_datatables_query($user_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($user_id="")
	{
		$this->db->from($this->table);

		if ($user_id!="")
		{
			if (is_array($user_id))
				$this->db->where($user_id);
			else
				$this->db->where('user_id', $user_id);
		}
		
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('user.*, 
			user_level.user_level_name, 
			pegawai.nip, pegawai.nama_pegawai, pegawai.tempat_lahir, pegawai.tgl_lahir, pegawai.jenis_kelamin, pegawai.no_telp, pegawai.email, pegawai.id_status_pegawai, pegawai.id_instansi, pegawai.id_golongan, pegawai.id_pangkat, pegawai.id_jabatan, pegawai.password, pegawai.pin, pegawai.aktif, pegawai.photo, 
			status_pegawai.nama_status_pegawai, 
			instansi.nama_instansi, 
			golongan.nama_golongan, 
			pangkat.nama_pangkat, 
			jabatan.nama_jabatan, 
			verifikator.verifikator
		');

		$this->db->from($this->table);
		$this->db->join('user_level','user.user_level_id=user_level.user_level_id', 'left');
		$this->db->join('pegawai', 'user.id_pegawai=pegawai.id_pegawai', 'left');
		$this->db->join('status_pegawai', 'pegawai.id_status_pegawai=status_pegawai.id_status_pegawai', 'left');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi', 'left');
		$this->db->join('golongan', 'pegawai.id_golongan=golongan.id_golongan', 'left');
		$this->db->join('pangkat', 'pegawai.id_pangkat=pangkat.id_pangkat', 'left');
		$this->db->join('jabatan', 'pegawai.id_jabatan=jabatan.id_jabatan', 'left');
		$this->db->join('verifikator', 'pegawai.id_pegawai=verifikator.id_pegawai', 'left');
		
		if (is_array($id))
			$this->db->where($id);
		else 
			$this->db->where('user.user_id',$id);
		
		$query = $this->db->get();

		return $query->row();
	}

	public function get_user($id="")
	{
		$this->db->select('user.*, 
			user_level.user_level_name, 
			pegawai.nip, pegawai.nama_pegawai, pegawai.tempat_lahir, pegawai.tgl_lahir, pegawai.jenis_kelamin, pegawai.no_telp, pegawai.email, pegawai.id_status_pegawai, pegawai.id_instansi, pegawai.id_golongan, pegawai.id_pangkat, pegawai.id_jabatan, pegawai.password, pegawai.pin, pegawai.aktif, pegawai.photo, 
			status_pegawai.nama_status_pegawai, 
			instansi.nama_instansi, 
			golongan.nama_golongan, 
			pangkat.nama_pangkat, 
			jabatan.nama_jabatan, 
			verifikator.verifikator
		');

		$this->db->from($this->table);
		$this->db->join('user_level','user.user_level_id=user_level.user_level_id', 'left');
		$this->db->join('pegawai', 'user.id_pegawai=pegawai.id_pegawai', 'left');
		$this->db->join('status_pegawai', 'pegawai.id_status_pegawai=status_pegawai.id_status_pegawai', 'left');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi', 'left');
		$this->db->join('golongan', 'pegawai.id_golongan=golongan.id_golongan', 'left');
		$this->db->join('pangkat', 'pegawai.id_pangkat=pangkat.id_pangkat', 'left');
		$this->db->join('jabatan', 'pegawai.id_jabatan=jabatan.id_jabatan', 'left');
		$this->db->join('verifikator', 'pegawai.id_pegawai=verifikator.id_pegawai', 'left');
		
		if ($id!="") 
		{
			if (is_array($id))
				$this->db->where($id);
			else 
				$this->db->where('user_id',$id);
		}
		
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
		$this->db->where('user_id', $id);
		$this->db->delete($this->table);
	}	

	public function check_user($user_name, $user_password)
	{
		$query = $this->db->get_where($this->table, array('user_name' => $user_name, 'user_password' => $user_password), 1, 0);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}										
}