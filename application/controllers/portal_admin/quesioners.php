<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	---------------------------------------------
*	Desc 		: Controller for Question Management
*	Created By 	: Yagi Anggar Prahara
*	Date		: 07 Okt 2012
*	---------------------------------------------
*	All right reserved
**/
class Quesioners extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/mquesioner');
	}
	
	public function variable () {
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'variable_list'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/quesioners/variable'=>'Variable List'
				)
				,'title'=>'Question Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	public function question ($variable_id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'question'
				,'variable_id' => $variable_id
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/quesioners/variable'=>'Variable List',
					'portal_admin/quesioners/question/'.$variable_id =>'Question List'
				)
				,'title'=>'Question Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	public function get_question($variable_id) {
		
		$sort_name = $this->input->post('sortname')?$this->input->post('sortname'):'ts';
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->mquesioner->getQuestion($variable_id,$sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('pertanyaan_kuesioner');
		$data['page'] = $page;
		$no = $page_start;
		if ($res->num_rows() > 0) {
			foreach ($res->result_array() as $row) {
				$no++;
				if($no <= 9) $ino = '0'.$no;
				$data['rows'][] = array(
					'id' => $row['id'],
					'cell' => array(
						'no' => $no,
						'id' => $row['id'],
						'tipe_id' => $row['tipe_id'],
						'tipe' => $row['tipe'],
						'pertanyaan' => $row['pertanyaan'],
						'edit' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
						'delete' => "<input type='image' style='height:13px;' title='Trash' src='portal_assets/admin/images/icn_trash.png'>"
					)
				);
				//$no++;
			}
		} else {
			$data['rows'][] = array();
			$data['total'] = $res->num_rows();
		}
		echo json_encode($data);
	}
	
	public function get_variable() {
		
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->mquesioner->getVariable($sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('variable_kuesioner');
		$data['page'] = $page;
		$no = $page_start;
		if ($res->num_rows() > 0) {
			foreach ($res->result_array() as $row) {
				$no++;
				if($no <= 9) $ino = '0'.$no;
				$resTotal = $this->mquesioner->getQuestionByVarId($row['id']);
				$data['rows'][] = array(
					'id' => $row['id'],
					'cell' => array(
						'no' => $no,
						'id' => $row['id'],
						'variable' => $row['variable'],
						'total_question' => $resTotal->num_rows(),
						'manage' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
					)
				);
				//$no++;
			}
		} else {
			$data['rows'][] = array();
			$data['total'] = $res->num_rows();
		}
		echo json_encode($data);
	}
	
	function get_result () {
		$resVar = $this->mquesioner->getVariable();
		$resVar = ($resVar->num_rows()>0)?$resVar->result_array():false;
		$arrQuestion = Array();
		$arrQ = Array();

		if ($resVar) {
			foreach ($resVar as $var) {
				$resQuestion = $this->mquesioner->getQuestionByVarId($var['id']);
				$resQuestion =  ($resQuestion->num_rows()>0)?$resQuestion->result_array():false;
				if ($resQuestion) {
					foreach ($resQuestion as $question){
						$quesionerResult = $this->mquesioner->getResultRating($question['id'],$question['tipe_id']);
						// $this->authlib->log($quesionerResult);
						$tes[] = array(
							'question_id' => $question['id'],
							'tipe_id' => $question['tipe_id'],
							'question' => $question['pertanyaan'],
							'sts' => isset($quesionerResult['sts'])?$quesionerResult['sts']:0,
							'ts' => isset($quesionerResult['ts'])?$quesionerResult['ts']:0,
							'cs' => isset($quesionerResult['ts'])?$quesionerResult['cs']:0,
							's' => isset($quesionerResult['s'])?$quesionerResult['s']:0,
							'ss' => isset($quesionerResult['ss'])?$quesionerResult['ss']:0,
							'y' => isset($quesionerResult['y'])?$quesionerResult['y']:0,
							't' => isset($quesionerResult['y'])?$quesionerResult['t']:0,
							'total_komentar' => isset($quesionerResult['total_komentar'])?$quesionerResult['total_komentar']:null
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
		// $this->session->set_userdata(array('question'=>$arrQ));
		// $data = array(
            // 'question'=>$arrQuestion
		// );
		$data = array(
			'page'=>'quesioner_result'
			,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
			,'breadcumbs'=>array(
				'portal_admin/quesioners/get_result'=>'Quesioner Result'
			)
			,'question' => $arrQuestion
			,'title'=>'Quesioner Result');
		$this->parser->parse('portal_admin/template/main_template',$data);
	}
	
	function get_comment () {
		$tipe_id = $this->input->post('tipe_id');
		$question_id = $this->input->post('question_id');
		$resComment = $this->mquesioner->getComment($tipe_id,$question_id);
		$comment = Array();
		if ($resComment) {
			foreach ($resComment as $com) {
				$comment['data'][] = array(
					'nim' => $com['nim'],
					'komentar' => $com['komentar']
				);
			}
		} else {
			$comment['data'] = Array();
		}
		echo json_encode($comment);
	}
	
	function add_question ($variable_id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->mquesioner->getTipe();
			$resVar = $this->mquesioner->getVariableById($variable_id);
			$variable = ($resVar->num_rows() > 0)?$resVar->row()->variable:null;

			$data = array(
				'page'=>'question_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/quesioners/variable'=>'Variable List',
					'portal_admin/quesioners/question/'.$variable_id =>'Question List',
					'portal_admin/quesioners/add_question/'.$variable_id => 'Manage Question'
				)
				,'combo_tipe' => ($res->num_rows() > 0)?$res->result_array():null
				,'variable_id' => $variable_id
				,'variable' => $variable
				,'title'=>'Question Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function update_question($variable_id,$id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->mquesioner->getQuestionById($id);
			$rs = $res->result_array();
			$tipe = $this->mquesioner->getTipe();
			$resVar = $this->mquesioner->getVariableById($variable_id);
			$variable = ($resVar->num_rows() > 0)?$resVar->row()->variable:null;
			$data = array(
				'page'=>'question_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/quesioners/variable'=>'Variable List',
					'portal_admin/quesioners/question/'.$variable_id =>'Question List',
					'portal_admin/quesioners/add_question/'.$variable_id.'/'.$id => 'Update Question'
				)
				,'combo_tipe' => ($tipe->num_rows() > 0)?$tipe->result_array():null
				,'variable_id' => $variable_id
				,'variable' => $variable
				,'data' => $rs
				,'title'=>'Question Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function save_process(){
		$variable_id = trim($this->input->post('variable_id'));
		$tipe_id = trim($this->input->post('tipe_id'));
		$pertanyaan = mysql_real_escape_string(trim($this->input->post('pertanyaan')));
		$hidden_id = trim($this->input->post('hidden_id'));
		$res = $this->mquesioner->saveQuestion($variable_id,$tipe_id,$pertanyaan,$hidden_id);
		echo $res;
		// redirect('index.php/webadmin/users/');
	}
	
	function delete_question () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$res = $this->mquesioner->deleteQuestion($id);
			echo $res;
		}
		else {
			redirect("lapak_admin");
		}
	}
}