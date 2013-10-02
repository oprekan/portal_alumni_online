<?php
class Monline_voting extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getKandidat ($nim=null) {
		if ($nim != null) {
			$this->db->select('kandidat_ketua.*,data_alumni.nama');
			$this->db->from('kandidat_ketua');
			$this->db->join('data_alumni','kandidat_ketua.nim=data_alumni.nim','inner');
			$this->db->where('kandidat_ketua.nim',$nim);
			$this->db->order_by('ts','asc');
			$res = $this->db->get();
		} else {
			$this->db->select('kandidat_ketua.*,data_alumni.nama');
			$this->db->from('kandidat_ketua');
			$this->db->join('data_alumni','kandidat_ketua.nim=data_alumni.nim','inner');
			$this->db->order_by('ts','asc');
			$res = $this->db->get();
		}
		//echo $this->db->last_query();
		return ($res->num_rows() > 0)?$res->result_array():false;
	}
	function saveVoting ($nimPemilih, $nimKandidat) {
		$data = array(
		   'nim_pemilih' => $nimPemilih,
		   'kandidat' => $nimKandidat
		);
		$qry = $this->db->insert('hasil_voting', $data);
		
		return ($qry) ? "Voting Saved" : $this->db->_error_message();
	}
	
	function getVotingResult () {
		/*$res = $this->db->query('SELECT hv.kandidat as nim_kandidat, da.nama as nama_kandidat ,COUNT(*) total_vote
								FROM hasil_voting hv
								LEFT JOIN data_alumni da on hv.kandidat = da.nim
								GROUP BY hv.kandidat');*/
								
		$res = $this->db->query('select hv.kandidat as nim_kandidat, da.nama as nama_kandidat ,case when hv.kandidat is null then 0 else COUNT(*) end as total_vote 
								from kandidat_ketua kk
								inner join data_alumni da on kk.nim = da.nim
								left join hasil_voting hv on kk.nim = hv.kandidat
								group by da.nim;');
		
		return ($res->num_rows() > 0)?$res->result_array():false;
	}
	
	function checkNim ($nim) {
		$this->db->select('*');
		$this->db->from('hasil_voting');
		$this->db->where('nim_pemilih',$nim);
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