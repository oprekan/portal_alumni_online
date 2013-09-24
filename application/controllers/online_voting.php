<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Online_voting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('monline_voting');
	}
	
	public function index()
	{
		if ($this->session->userdata('nim') == TRUE)
		{
			$resAllKandidat = $this->monline_voting->getKandidat();
			$arrKandidat = Array();
			foreach ($resAllKandidat as $kandidat) {
				$arrKandidat[] = array(
					'nim' => $kandidat['nim'],
					'nama' => $kandidat['nama'],
					'visi' => $kandidat['visi'],
					'misi' => $kandidat['misi'],
					'foto_kandidat_ketua' => $kandidat['foto_kandidat_ketua']
				);
			}
			
			//-- Check NIM 
			$resNim = $this->monline_voting->checkNim($this->session->userdata('nim'));
			$isExist = ($resNim->num_rows() > 0)?'yes':'no';
			
			$data = array(
				'page'=>'online_voting/voting_form',
				'all_kandidat'=>$arrKandidat,
				'nama' => $this->session->userdata('nama'),
				'nim' => $this->session->userdata('nim'),
				'angkatan' => $this->session->userdata('angkatan'),
				'prodi' => $this->session->userdata('prodi'),
				'divisi' => $this->session->userdata('divisi'),
				'exist' => $isExist
			);
			
			$this->parser->parse('online_voting/template',$data);
			// $this->parser->parse('quesioner/quesioner_form',$data);
		}
		else {
			redirect("login_voting");
		}
	}
	
	public function getKandidatByNim () {
		$nim = $this->input->post('nim');
		$kandidat = $this->monline_voting->getKandidat($nim);
		$arrKandidat = Array();
		if ($kandidat) {
			foreach ($kandidat as $row) {
				$arrKandidat['data'][] = array(
					'nim' => $row['nim'],
					'nama' => $row['nama'],
					'visi' => $row['visi'],
					'misi' => $row['misi'],
					'foto_kandidat_ketua' => $row['foto_kandidat_ketua']
				);
			}
		} else {
			$arrKandidat['data'] = Array();
		}
		echo json_encode($arrKandidat);
	}
	
	public function index1()
	{
		if ($this->session->userdata('nim') == TRUE)
		{
			$resVar = $this->monline_voting->getVariable();
			$arrQuestion = Array();
			$arrQ = Array();
			if ($resVar) {
				foreach ($resVar as $var) {
					$resQuestion = $this->monline_voting->getQuestion($var['id']);
					if ($resQuestion) {
						foreach ($resQuestion as $question){
							$tes[] = array(
								'question_id' => $question['id'],
								'tipe_id' => $question['tipe_id'],
								'question' => $question['pertanyaan']
							);
							if ($question['tipe_id'] == 'R' || $question['tipe_id'] == 'K') {
								array_push($arrQ,$question['tipe_id']."-". $question['id']);
							} else {
								array_push($arrQ,$question['tipe_id']."-". $question['id']);
								array_push($arrQ,$question['tipe_id']."-". $question['id']."-komen");
							}
						}
						$arrQuestion[] = array(
							'variable_id'=>$var['id'],
							'variable' => $var['variable'],
							'question' => $tes
						);
						unset($tes);
					}
				}
			}
			$this->session->set_userdata(array('question'=>$arrQ));
			
			//-- Check NIM
			$resNim = $this->monline_voting->checkNim($this->session->userdata('nim'));
			$isExist = ($resNim->num_rows() > 0)?'yes':'no';
			
			$data = array(
				'page'=>'online_voting/voting_form',
				'question'=>$arrQuestion,
				'nama' => $this->session->userdata('nama'),
				'nim' => $this->session->userdata('nim'),
				'angkatan' => $this->session->userdata('angkatan'),
				'prodi' => $this->session->userdata('prodi'),
				'divisi' => $this->session->userdata('divisi'),
				'exist' => $isExist
			);
			
			$this->parser->parse('online_voting/template',$data);
			// $this->parser->parse('quesioner/quesioner_form',$data);
		}
		else {
			redirect("login_voting");
		}
	}
}