<?php
class Mquesioner extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getVariable () {
		$this->db->select('*');
		$this->db->from('variable_kuesioner');
		$this->db->order_by('ts','asc');
		$res = $this->db->get();
		return ($res->num_rows() > 0)?$res->result_array():false;
	}
	
	function getQuestion ($variable_id) {
		$this->db->select('*');
		$this->db->from('pertanyaan_kuesioner');
		$this->db->where('variable_id',$variable_id);
		$this->db->order_by('ts','asc');
		$res = $this->db->get();
		return ($res->num_rows() > 0)?$res->result_array():false;
	}
	
	function checkNim ($nim) {
		$this->db->select('*');
		$this->db->from('jawaban_kuesioner');
		$this->db->where('nim',$nim);
		$res = $this->db->get();
		return $res;
	}
	
	function saveAnswer ($jwb,$nim) {
		foreach($jwb as $index=>$value)
		{
			$arrIndex = explode('-',$index);
			$tipe_id = $arrIndex[0];
			$question_id = $arrIndex[1];
			$isComment = isset($arrIndex[2])?$arrIndex[2]:"";
			
			
			if ($isComment == "") {
				$data1 = array(
				   'pertanyaan_id' => $question_id,
				   'nim' => $nim,
				   'jawaban' => $value
				);
				$qry = $this->db->insert('jawaban_kuesioner', $data1);
				if (!$qry){
					return $this->db->_error_message();
				}
			} else {
				if ($jwb[$tipe_id."-".$question_id] == 'y') {
					$value = "";
				}
				$data2 = array(
				   'pertanyaan_id' => $question_id,
				   'nim' => $nim,
				   'komentar' => $value
				);
				$qry = $this->db->insert('jawaban_komentar', $data2);
				if (!$qry){
					return $this->db->_error_message();
				}
			}
			// echo"Jawaban : $nilai <br>";
			// echo"ID Pertanyaan : $indeks<br>";

			// $sql = "insert into detail_kuis set id_dk = '$id_dk', id_pertanyaan = '$indeks', jawaban = '$nilai'";
			// mysql_query($sql) or die("Gagal Query : ".mysql_error());
			// echo"ID Kuis : $indeks <br>";
			// echo"Jawaban : $nilai <br>";
		}
		return ($qry)?'success':$this->db->_error_message();
	}
}