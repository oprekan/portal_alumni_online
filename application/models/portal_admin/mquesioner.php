<?php
class Mquesioner extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getQuestion($variable_id,$sort_name,$sort_order,$limit,$page_start,$search,$query)
    {
		// $level = $this->session->userdata('level');
		// $username = $this->session->userdata('username');
		
		$this->db->select('pertanyaan_kuesioner.*,tipe_kuesioner.tipe',false);
		$this->db->from('pertanyaan_kuesioner');
		$this->db->join('tipe_kuesioner','pertanyaan_kuesioner.tipe_id = tipe_kuesioner.id','inner');
		$this->db->join('variable_kuesioner','pertanyaan_kuesioner.variable_id = variable_kuesioner.id','inner');
		$this->db->where('pertanyaan_kuesioner.variable_id',$variable_id);
		$this->db->like($search,$query);
		$this->db->order_by('ts','asc');
		$this->db->limit($limit,$page_start);
		$res = $this->db->get();
		return $res;
    }
	
	function getVariable($sort_name=null,$sort_order=null,$limit=null,$page_start=null,$search=null,$query=null)
    {
		if ($page_start != null) {
			$this->db->select('*',false);
			$this->db->from('variable_kuesioner');
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		} else {
			$this->db->select('*',false);
			$this->db->from('variable_kuesioner');
			$this->db->order_by('ts','asc');
			$res = $this->db->get();
			// $res = ($res->num_rows()>0)?$res->result_array():false;
		}
		return $res;
    }
	
	function getVariableById ($variable_id) {
		$this->db->select('*',false);
		$this->db->from('variable_kuesioner');
		$this->db->where('id',$variable_id);
		$res = $this->db->get();
		
		return $res;
	}
	
	function getQuestionByVarId($variable_id)
    {
		$this->db->select('*');
		$this->db->from('pertanyaan_kuesioner');
		$this->db->where('variable_id',$variable_id);
		$res = $this->db->get();
		return $res;
    }
	
	function getQuestionById($id) {
		$this->db->select('*');
		$this->db->from('pertanyaan_kuesioner');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function getTipe () {
		$this->db->select('*');
		$this->db->from('tipe_kuesioner');
		$sql = $this->db->get();
		return $sql;
	}
	
	function getResultRating ($pertanyaan_id,$tipe_id) {
		$res = Array();
		if ($tipe_id == "R") {
			// STS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'sts'";
			$resSts = $this->db->query($query);
			$res['sts'] = $resSts->row()->total;
			
			//TS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'ts'";
			$resTs = $this->db->query($query);
			$res['ts'] = $resTs->row()->total;
			
			//CS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'cs'";
			$resTs = $this->db->query($query);
			$res['cs'] = $resTs->row()->total;
			
			// S
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 's'";
			$resS = $this->db->query($query);
			$res['s'] = $resS->row()->total;
			
			// SS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'ss'";
			$resSs = $this->db->query($query);
			$res['ss'] = $resSs->row()->total;
		} else if ($tipe_id == "K") {
			$query = "select count(*) as totalKomentar
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban != 'sts' and jawaban != 'ts' and jawaban != 's' and jawaban != 'ss'";
			$resTs = $this->db->query($query);
			$res['total_komentar'] = $resTs->row()->totalKomentar;
		} else if ($tipe_id == "RK") {
			// STS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'sts'";
			$resSts = $this->db->query($query);
			$res['sts'] = $resSts->row()->total;
			
			//TS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'ts'";
			$resTs = $this->db->query($query);
			$res['ts'] = $resTs->row()->total;
			
			//CS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'cs'";
			$resTs = $this->db->query($query);
			$res['cs'] = $resTs->row()->total;
			
			// S
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 's'";
			$resS = $this->db->query($query);
			$res['s'] = $resS->row()->total;
			
			// SS
			$query = "select count(*) as total
				from jawaban_kuesioner
				where pertanyaan_id = '".$pertanyaan_id."' and jawaban = 'ss'";
			$resSs = $this->db->query($query);
			$res['ss'] = $resSs->row()->total;
			
			$query = "select count(*) as totalKomentar
				from jawaban_komentar
				where pertanyaan_id = '".$pertanyaan_id."'";
			$resTs = $this->db->query($query);
			$res['total_komentar'] = $resTs->row()->totalKomentar;
		}
		
		return $res;
	}
	
	function getComment ($tipe_id,$question_id) {
		if ($tipe_id == "K") {
			$query = "select nim,jawaban as komentar
				from jawaban_kuesioner
				where pertanyaan_id = '".$question_id."' and jawaban != 'sts' and jawaban != 'ts' and jawaban != 'cs' and jawaban != 's' and jawaban != 'ss'";
			$res = $this->db->query($query);
			// $res['total_komentar'] = $resTs->row()->totalKomentar;
		} else {
			$query = "select nim,komentar
				from jawaban_komentar
				where pertanyaan_id = '".$question_id."'";
			$res = $this->db->query($query);
			// $res['total_komentar'] = $resTs->row()->totalKomentar;
		}
		return ($res->num_rows()>0)?$res->result_array():false;
	}
	
	function saveQuestion ($variable_id,$tipe_id,$pertanyaan,$hidden_id) {
		$created_by = $this->session->userdata('username');
		if(!$hidden_id){
			$data = array(
			   'tipe_id' => $tipe_id,
			   'variable_id' => $variable_id,
			   'pertanyaan' => $pertanyaan,
			   'created_by' => '30107126'
			);
			$qry = $this->db->insert('pertanyaan_kuesioner', $data);
		}
		else {
			$data = array(
			   'tipe_id' => $tipe_id,
			   'variable_id' => $variable_id,
			   'pertanyaan' => $pertanyaan,
			   'modified_by' => '30107126'
			);
			$this->db->where('id', $hidden_id);
			$qry = $this->db->update('pertanyaan_kuesioner', $data); 
		}
		
		return ($qry)?'success':$this->db->_error_message();
	}
	
	function deleteQuestion($id) {
		$qry = $this->db->delete('pertanyaan_kuesioner', array('id' => $id)); 
		return ($qry)?'success':$this->db->_error_message();
	}
}