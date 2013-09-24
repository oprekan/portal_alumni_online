<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profiles extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mprofile');
	}
	
	function index () {
		if ($this->session->userdata('login') == TRUE)
		{
			$resProfile = $this->mprofile->getProfile($this->session->userdata('nim'));
			$tempatLahir = "";
			$tanggalLahir = "";
			$alamat = "";
			$noTelp1 = "";
			$noTelp2 = "";
			$email1 = "";
			$email2 = "";
			$ym = "";
			$fb = "";
			$twitter = "";
			if ($resProfile) {
				foreach ($resProfile as $prof) {
					$tempatLahir = $prof['tempat_lahir'];
					$tanggalLahir = $prof['tanggal_lahir'];
					$alamat = $prof['alamat'];
					$noTelp1 = $prof['no_telp1'];
					$noTelp2 = $prof['no_telp2'];
					$email1 = $prof['email_1'];
					$email2 = $prof['email_2'];
					$ym = $prof['yahoo_messanger'];
					$fb = $prof['facebook'];
					$twitter = $prof['twitter'];
				}
			}
			
			$data = array(
				'page'=>'profile/profile',
				'nama' => $this->session->userdata('nama'),
				'nim' => $this->session->userdata('nim'),
				'angkatan' => $this->session->userdata('angkatan'),
				'prodi' => $this->session->userdata('prodi'),
				'divisi' => $this->session->userdata('divisi'),
				'tempatLahir' => $tempatLahir,
				'tanggalLahir' => $tanggalLahir,
				'alamat' => $alamat,
				'noTelp1' => $noTelp1,
				'noTelp2' => $noTelp2,
				'email1' => $email1,
				'email2' => $email2,
				'ym' => $ym,
				'fb' => $fb,
				'twitter' => $twitter
			);
			$this->parser->parse('quesioner/template',$data);
		} else {
			redirect("login");
		}
	}
}