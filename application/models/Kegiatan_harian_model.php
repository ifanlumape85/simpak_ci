<?php
class Kegiatan_harian_model extends CI_Model
{

	var $table = 'kegiatan_harian';
	
	var $column_order = array(null, null, 'pegawai.nama_pegawai', 'instansi.nama_instansi', null,'kegiatan_harian.tgl_kegiatan', null,null,null, null,null, null);
	var $column_search = array('pegawai.nama_pegawai', 'instansi.nama_instansi');
	var $order = array('id_kegiatan_harian' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('kegiatan_harian.*, pegawai.nip, pegawai.nama_pegawai, jenis_kuantitas.nama_jenis_kuantitas, instansi.id_instansi, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_harian.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
				
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('kegiatan_harian.id_pegawai', $this->input->post('id_pegawai'));
        }

        if ($this->session->userdata('user_level_id') > 1)
		{
			$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
			$this->db->where('kegiatan_harian.id_pegawai', $this->session->userdata('pegawai_id'));
			$column_search = array('kegiatan_harian.kegiatan');
		}

		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="" )
			$this->db->where('tgl_kegiatan=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="" )
			$this->db->where('tgl_selesai=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="" )
		{
			$this->db->where('tgl_kegiatan>=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_kegiatan<=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
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

	private function _get_datatables_query3()
	{	
		$this->db->select('kegiatan_harian.*, pegawai.nip, pegawai.nama_pegawai, jenis_kuantitas.nama_jenis_kuantitas, instansi.id_instansi, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_harian.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
				
		
        $this->db->where('kegiatan_harian.id_pegawai', $this->session->userdata('pegawai_id'));
        

        if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="")
			$this->db->where('tgl_kegiatan =', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="")
			$this->db->where('tgl_selesai =', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="")
		{
			$this->db->where('tgl_kegiatan >=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_kegiatan <=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
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

	private function _get_datatables_query2()
	{	
		$this->db->select('
			kegiatan_harian.*, 
			pegawai.nip, 
			pegawai.nama_pegawai, 
			jenis_kuantitas.nama_jenis_kuantitas, 
			instansi.id_instansi, 
			instansi.nama_instansi'
		);

		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_harian.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
				
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('kegiatan_harian.id_pegawai', $this->input->post('id_pegawai'));
        }

        if($this->input->post('status'))
        {
            $this->db->where('kegiatan_harian.status', $this->input->post('status'));
        }

        
		$this->db->where('kegiatan_harian.id_verifikator', $this->session->userdata('pegawai_id'));
		$column_search = array('kegiatan_harian.kegiatan');
		

		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="" )
			$this->db->where('tgl_kegiatan=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="" )
			$this->db->where('tgl_selesai=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="" )
		{
			$this->db->where('tgl_kegiatan>=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_kegiatan<=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
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

	function get_datatables3()
	{
		$this->_get_datatables_query3();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables2()
	{
		$this->_get_datatables_query2();
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

	function count_filtered2()
	{
		$this->_get_datatables_query2();
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
		$this->db->select('kegiatan_harian.*, pegawai.id_pegawai, pegawai.nip, pegawai.nama_pegawai, jenis_kuantitas.nama_jenis_kuantitas, instansi.id_instansi, instansi.nama_instansi');
		$this->db->from($this->table);
		$this->db->join('pegawai', 'kegiatan_harian.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('jenis_kuantitas', 'kegiatan_harian.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas');
		$this->db->where('id_kegiatan_harian',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_kegiatan_harian()
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
		$this->db->where('id_kegiatan_harian', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_kegiatan_harian()
    {
        $this->db->select('id_kegiatan_harian, nama_kegiatan_harian');
        $this->db->from($this->table);
        $this->db->order_by('nama_kegiatan_harian','asc');
        $query = $this->db->get();
        $result = $query->result();

        $kegiatan_harians = array();
        foreach ($result as $row) 
        {
            $kegiatan_harians[$row->id_kegiatan_harian] = $row->nama_kegiatan_harian;
        }
        return $kegiatan_harians;
    }			
}
		