<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pre_voting extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('nim'))
		{
			redirect("login_voting");
		}
		$this->load->model('mquesioner');
	}
	
	public function index() {
		$resVar = $this->mquesioner->getVariable();
		$arrQuestion = Array();
		$arrQ = Array();
		$resQuestion = $this->mquesioner->getQuestion("6");
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
				'variable_id'=>"6",
				'variable' => "Pra Voting",
				'question' => $tes
			);
			unset($tes);
		}
		$this->session->set_userdata(array('question'=>$arrQ));
		
		//-- Check NIM
		$resNim = $this->mquesioner->checkNim($this->session->userdata('nim'));
		$isExist = ($resNim->num_rows() > 0)?'yes':'no';
		
		$data = array(
			'page'=>'online_voting/pre_voting_form',
			'question'=>$arrQuestion,
			'nama' => $this->session->userdata('nama'),
			'nim' => $this->session->userdata('nim'),
			'angkatan' => $this->session->userdata('angkatan'),
			'prodi' => $this->session->userdata('prodi'),
			'divisi' => $this->session->userdata('divisi'),
			'exist' => $isExist
		);
		
		$this->parser->parse('online_voting/template',$data);
	}
}