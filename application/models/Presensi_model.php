<?php
class Presensi_model extends CI_Model
{

	var $table = 'presensi';
	
	var $column_order = array(null, null, 'tgl_presensi','jenis_presensi.nama_jenis_presensi','instansi.nama_instansi', 'pegawai.nama_pegawai','status_presensi.nama_status_presensi',null);
	var $column_search = array('instansi.nama_instansi', 'pegawai.nama_pegawai');
	var $order = array('id_presensi' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('presensi.*, 
			jenis_presensi.nama_jenis_presensi, 
			pegawai.id_instansi, 
			pegawai.nip, 
			pegawai.nama_pegawai, 
			instansi.nama_instansi, 
			status_presensi.nama_status_presensi'
		);
		
		$this->db->from($this->table);
		$this->db->join('jenis_presensi', 'presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
		$this->db->join('pegawai', 'presensi.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('status_presensi', 'presensi.id_status_presensi=status_presensi.id_status_presensi');
				
		if($this->input->post('id_jenis_presensi'))
        {
            $this->db->where('presensi.id_jenis_presensi', $this->input->post('id_jenis_presensi'));
        }
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('presensi.id_pegawai', $this->input->post('id_pegawai'));
        }
				
        if ($this->session->userdata('use_level_id') == 1)
		{
			$column_search = $this->column_search;
		}	
		else
		{
			if ($this->session->userdata('user_level_id')==5)
			{
				$this->db->where('presensi.id_pegawai', $this->session->userdata('pegawai_id'));		
			}
			$this->db->where('pegawai.id_instansi', $this->session->userdata('instansi_id'));
			$column_search = array('pegawai.nama_pegawai');
		}

		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="" )
			$this->db->where('tgl_presensi=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="" )
			$this->db->where('tgl_selesai=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="" )
		{
			$this->db->where('tgl_presensi>=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_presensi<=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
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
		$this->db->select('presensi.*, 
			jenis_presensi.nama_jenis_presensi, 
			pegawai.id_instansi, 
			pegawai.nip, 
			pegawai.nama_pegawai, 
			instansi.nama_instansi, 
			status_presensi.nama_status_presensi'
		);
		$this->db->from($this->table);
		$this->db->join('jenis_presensi', 'presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
		$this->db->join('pegawai', 'presensi.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('status_presensi', 'presensi.id_status_presensi=status_presensi.id_status_presensi');
				
		if($this->input->post('id_jenis_presensi'))
        {
            $this->db->where('presensi.id_jenis_presensi', $this->input->post('id_jenis_presensi'));
        }
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('presensi.id_pegawai', $this->input->post('id_pegawai'));
        }
				
		if($this->input->post('id_status_presensi'))
        {
            $this->db->where('presensi.id_status_presensi', $this->input->post('id_status_presensi'));
        }

        if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="" )
			$this->db->where('tgl_presensi=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="" )
			$this->db->where('tgl_selesai=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="" )
		{
			$this->db->where('tgl_presensi>=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_presensi<=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		}

		$this->db->where('presensi.id_verifikator', $this->session->userdata('pegawai_id'));		
		$column_search = array('pegawai.nama_pegawai');
		
				
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
		$this->db->select('presensi.*, 
			jenis_presensi.nama_jenis_presensi, 
			pegawai.id_instansi, 
			pegawai.nip, 
			pegawai.nama_pegawai, 
			instansi.nama_instansi, 
			status_presensi.nama_status_presensi'
		);
		
		$this->db->from($this->table);
		$this->db->join('jenis_presensi', 'presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
		$this->db->join('pegawai', 'presensi.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('status_presensi', 'presensi.id_status_presensi=status_presensi.id_status_presensi');
				
		if($this->input->post('id_jenis_presensi'))
        {
            $this->db->where('presensi.id_jenis_presensi', $this->input->post('id_jenis_presensi'));
        }
				
        $this->db->where('presensi.id_pegawai', $this->session->userdata('pegawai_id'));
				
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) =="" )
			$this->db->where('tgl_presensi=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
		if ($this->input->post('tgl_selesai', TRUE) !="" && $this->input->post('tgl_mulai', TRUE) =="" )
			$this->db->where('tgl_selesai=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		if ($this->input->post('tgl_mulai', TRUE) !="" && $this->input->post('tgl_selesai', TRUE) !="" )
		{
			$this->db->where('tgl_presensi>=', date('Y-m-d', strtotime($this->input->post('tgl_mulai', TRUE))));
			$this->db->where('tgl_presensi<=', date('Y-m-d', strtotime($this->input->post('tgl_selesai', TRUE))));
		}

		$column_search = array('pegawai.nama_pegawai');
				
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

	function get_datatables2()
	{
		$this->_get_datatables_query2();
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

	function get_laporan()
	{
		$this->_get_laporan_query();
		$query = $this->db->get();
		return $query;
	}

	private function _get_laporan_query()
	{	
		$this->db->select('presensi.*, jenis_presensi.nama_jenis_presensi, pegawai.id_instansi, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi, status_presensi.nama_status_presensi');
		$this->db->from($this->table);
		$this->db->join('jenis_presensi', 'presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
		$this->db->join('pegawai', 'presensi.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('status_presensi', 'presensi.id_status_presensi=status_presensi.id_status_presensi');
		
		if($this->input->post('id_instansi'))
        {
            $this->db->where('pegawai.id_instansi', $this->input->post('id_instansi'));
        }

		if($this->input->post('id_jenis_presensi'))
        {
            $this->db->where('presensi.id_jenis_presensi', $this->input->post('id_jenis_presensi'));
        }
				
		if($this->input->post('id_pegawai'))
        {
            $this->db->where('presensi.id_pegawai', $this->input->post('id_pegawai'));
        }
				
		if($this->input->post('id_status_presensi'))
        {
            $this->db->where('presensi.id_status_presensi', $this->input->post('id_status_presensi'));
        }
        $query = $this->db->order_by('tgl_presensi');
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

	public function count_all($id="")
	{
		$this->db->from($this->table);
		if ($id!="")
		{
			if (is_array($id))
				$this->db->where($id);
		}
		
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('presensi.*, jenis_presensi.nama_jenis_presensi, pegawai.nip, pegawai.nama_pegawai, instansi.id_instansi, instansi.nama_instansi, status_presensi.nama_status_presensi');
		$this->db->from($this->table);
		$this->db->join('jenis_presensi', 'presensi.id_jenis_presensi=jenis_presensi.id_jenis_presensi');
		$this->db->join('pegawai', 'presensi.id_pegawai=pegawai.id_pegawai');
		$this->db->join('instansi', 'pegawai.id_instansi=instansi.id_instansi');
		$this->db->join('status_presensi', 'presensi.id_status_presensi=status_presensi.id_status_presensi');
		
		$this->db->where('id_presensi',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_presensi()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_by_id2($id)
	{
		$this->db->from($this->table);
		
		if (is_array($id))
			$this->db->where($id);
		else 
			$this->db->where('id_presensi', $id);

		$query = $this->db->get();

		return $query->row();
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
		$this->db->where('id_presensi', $id);
		$this->db->delete($this->table);
	}	

	public function get_list_presensi()
    {
        $this->db->select('id_presensi, nama_presensi');
        $this->db->from($this->table);
        $this->db->order_by('nama_presensi','asc');
        $query = $this->db->get();
        $result = $query->result();

        $presensis = array();
        foreach ($result as $row) 
        {
            $presensis[$row->id_presensi] = $row->nama_presensi;
        }
        return $presensis;
    }			
}
		