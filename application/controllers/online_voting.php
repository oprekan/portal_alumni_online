<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Online_voting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('nim'))
		{
			redirect("login_voting");
		}
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
			
			// Delete token session if user has voted before
			if ($isExist == 'yes') {
				$this->session->set_userdata('token','');
				$this->session->set_userdata('token-expiration',0);
			}
			$data = array(
				'page'=>'online_voting/voting_form',
				'all_kandidat'=>$arrKandidat,
				'nama' => $this->session->userdata('nama'),
				'nim' => $this->session->userdata('nim'),
				'angkatan' => $this->session->userdata('angkatan'),
				'prodi' => $this->session->userdata('prodi'),
				'divisi' => $this->session->userdata('divisi'),
				'token' => $this->session->userdata('token'),
				'tokenexp' => $this->session->userdata('token-expiration'),
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
	
	public function sendVoting () {
		$nimPemilih = $this->input->post('nim_pemilih');
		$nimKandidat = $this->input->post('nim_kandidat');
		$supplied_token = $this->input->post('token');
		
		// Check whether POS value empty or not
		if (empty($nimPemilih) || empty($nimKandidat) || empty($supplied_token)) {
			echo "Upps, Bad access bro :P";
			exit;
		}

		// Retrieve token & token expiration time from session
		$token = $this->session->userdata('token');
		$token_exp = $this->session->userdata('token-expiration');

		// Compare token in session & token from POS data
		if (($token_exp < time()) || ($token != $supplied_token)) {
			echo "Token is invalid / expired";
			exit;
		} else {
			$response = $this->monline_voting->saveVoting($nimPemilih, $nimKandidat);
		
			$result = Array();
			if ($response == "Voting Saved") {
				$result = array (
					'status' => true,
					'msg' => 'Voting Anda Berhasil'
				);

				// Reset token if voting has succeed
				$this->session->set_userdata('token','');
				$this->session->set_userdata('token-expiration',0);
			} else {
				$result = array (
					'status' => false,
					'msg' => $response
				);
			}
			
			echo json_encode($result);
		}
	}
	
	public function generateVotingResult()
	{
		$result = $this->monline_voting->getVotingResult();
		$total_vote = 0;
		$kandidat = Array();
		
		if ($result) {
			foreach ($result as $row) {
				$total_vote = $total_vote+$row['total_vote'];
				$kandidat['data'][] = array(
					'nim_kandidat' => $row['nim_kandidat'],
					'nama_kandidat' => $row['nama_kandidat'],
					'vote' => $row['total_vote']
				);
				
			}
		}
		
		$data = array(
			'page'=>'online_voting/voting_result',
			'voting_result'=>$kandidat,
			'total_vote' => $total_vote,
			'nama' => $this->session->userdata('nama'),
			'nim' => $this->session->userdata('nim'),
			'angkatan' => $this->session->userdata('angkatan'),
			'prodi' => $this->session->userdata('prodi'),
			'divisi' => $this->session->userdata('divisi')
		);
		
		$this->parser->parse('online_voting/template',$data);
	}
}