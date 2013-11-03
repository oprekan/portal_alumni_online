<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quesioners extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mquesioner');
	}
	
	public function index()
	{
		if ($this->session->userdata('nim') == TRUE)
		{
			$resVar = $this->mquesioner->getVariable();
			$arrQuestion = Array();
			$arrQ = Array();
			if ($resVar) {
				foreach ($resVar as $var) {
					$resQuestion = $this->mquesioner->getQuestion($var['id']);
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
			$resNim = $this->mquesioner->checkNim($this->session->userdata('nim'));
			$isExist = ($resNim->num_rows() > 0)?'yes':'no';
			
			$data = array(
				'page'=>'quesioner/quesioner_form',
				'question'=>$arrQuestion,
				'nama' => $this->session->userdata('nama'),
				'nim' => $this->session->userdata('nim'),
				'angkatan' => $this->session->userdata('angkatan'),
				'prodi' => $this->session->userdata('prodi'),
				'divisi' => $this->session->userdata('divisi'),
				'exist' => $isExist
			);
			
			$this->parser->parse('quesioner/template',$data);
			// $this->parser->parse('quesioner/quesioner_form',$data);
		}
		else {
			redirect("login");
		}
	}
	
	function save () {
		$jwb = isset($_POST['jawab'])?$_POST['jawab']:null;
		$nim = $this->input->post('nim');
		$question = $this->session->userdata('question');
		$question = array_unique($question);
		
		$arrKey = Array();
		
		if ($jwb != null) {
			foreach ($jwb as $key => $val) {
				if ($val != '') {
					array_push($arrKey,$key);
				}
			}

			
			//-- Find empty fields or rows
			$arrEmptyField = array_diff($question,$arrKey);
			
			if (empty($arrEmptyField)) {
				$resSave = $this->mquesioner->saveAnswer($jwb,$nim);
				if ($resSave == 'success') {
					$res['status'] = 'true';
					$res['msg'] = 'Your answers have been sent';
					$res['field'] = "";
				} else {
					$res['status'] = 'false';
					$res['msg'] = $resSave;
					$res['field'] = "";
				}
			} else {
				$res['status'] = 'false';
				$res['msg'] = 'Please fill all fields';
				$res['field'] = $arrEmptyField;
			}
		} else {
			$res['status'] = 'false';
			$res['msg'] = 'Please fill all fields';
			$res['field'] = "";
		}
		
		echo json_encode($res);
	}

	// -- Special case for Yes / No & Comment type
	function saveYt () {
		$jwb = isset($_POST['jawab'])?$_POST['jawab']:null;
		$nim = $this->input->post('nim');
		$question = $this->session->userdata('question');
		$question = array_unique($question);
		
		$arrKey = Array();
		if ($jwb != null) {
			$indexJwb = 0;
			foreach ($jwb as $key => $val) {
				if ($val != '') {
					array_push($arrKey,$key);
				}
				
				$questionType = explode("-", $key);
				$type = $questionType[0];
				$question_id = $questionType[1];
				$isComment = isset($questionType[2]) ? $questionType[2] : null;

				if ($type == "YT") {
					if ($isComment == "komen") {
						if ($jwb[$type."-".$question_id] == 't') {
							
							if (trim($val) == "") {
								$res['status'] = 'false';
								$res['msg'] = 'Please fill all fields';
								$res['field'] = $key;
								echo json_encode($res);
								exit;
							}
						}
					} else {
						if (trim($val) == "") {
							$res['status'] = 'false';
							$res['msg'] = 'Please fill all fields';
							$res['field'] = $key;
							echo json_encode($res);
							exit;
						}
					}
				}
				$indexJwb++;
			}

			$resSave = $this->mquesioner->saveAnswer($jwb,$nim);
			if ($resSave == 'success') {
				$res['status'] = 'true';
				$res['msg'] = 'Your answers have been sent';
				$res['field'] = "";
			} else {
				$res['status'] = 'false';
				$res['msg'] = $resSave;
				$res['field'] = "";
			}
		} else {
			$res['status'] = 'false';
			$res['msg'] = 'Please fill all fields';
			$res['field'] = "";
		}
		
		echo json_encode($res);
	}
}