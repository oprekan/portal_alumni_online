<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Authlib {

	var $CI = NULL;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->database();
		$this->CI->load->helper('url');
		$this->CI->load->library('encrypt');
		$this->CI->load->library('firephp');
		session_start();
	}
	
	//---- Login Function
    function login($login = NULL)
	{
		if(!isset($login))
			return FALSE;
		if(count($login) != 2)
			return FALSE;
		$username = $login[0];
		$pass = $login[1];
		$resp = $this->cekpass($username,md5($pass));
		if (!is_object($resp)) 
		{
			return $resp;			
		} else {
			$sesProfile = $this->create_native_session($username);
			//-- create CI session
            $this->CI->session->set_userdata('logged', 'yes');
			$this->CI->session->set_userdata('userid', $this->CI->encrypt->encode($resp->iduser));
			$this->CI->session->set_userdata('username', $resp->username);
            $this->CI->session->set_userdata('group', $resp->grup);
            $this->CI->session->set_userdata('validator', $resp->validator);
            $this->CI->session->set_userdata('idsite', $resp->idsite);
            $this->CI->session->set_userdata('head', $resp->grouphead);
            $this->CI->session->set_userdata('email', $resp->emailaddress);
            $this->CI->session->set_userdata('row', $resp->maxrow);
            $this->CI->session->set_userdata('userProfile', $sesProfile);
			//-- create native session
			$_SESSION["sesLoged"] 		= "yes";
			$_SESSION["sesUserId"] 		= $resp->iduser;   // Di pakai untuk Default Pemilihan User
			$_SESSION["sesUserName"] 	= $resp->username; 	// DI pakai untuk Welcome
			$_SESSION["sesUserGroup"] 	= $resp->grup; // Di pakai untuk Welcome
			$_SESSION["sesValidator"]	= $resp->validator;
			$_SESSION["sesSite"]		= $resp->idsite;
			$_SESSION["sesHead"]		= $resp->grouphead;
			$_SESSION["sesEmail"]		= $resp->emailaddress;
			$_SESSION["sesRow"]			= $resp->maxrow;
			$_SESSION["sesUserProfile"]	= $sesProfile;
			return TRUE;
		}
	}
/*
 * Logout function / delete Cookie 
 */	
	function logout() 
	{
    	$this->CI->session->sess_destroy(); //-- destroy CI session
		session_destroy();//-- destroy native session 
		redirect('auth');
	}
    
/*
 * Login authentification check
 */

	function isLogin()
	{
		$cek = $this->CI->session->userdata('userid');
		if (!$cek) {
			/* if (isset($_SESSION['sesUserId'])) {//-- if native session exist then create CI session
				$logged		= $_SESSION["sesLoged"];
				$userid 	= $_SESSION["sesUserId"];
				$username	= $_SESSION["sesUserName"];
				$group 		= $_SESSION["sesUserGroup"];
				$validator	= $_SESSION["sesValidator"];
				$site		= $_SESSION["sesSite"];
				$head 		= $_SESSION["sesHead"];
				$email		= $_SESSION["sesEmail"];
				$row		= $_SESSION["sesRow"];
				$userProfile= $_SESSION["sesUserProfile"];
				$this->CI->session->set_userdata('logged', 'yes');
				$this->CI->session->set_userdata('userid', $this->CI->encrypt->encode($userid));
				$this->CI->session->set_userdata('username', $username);
				$this->CI->session->set_userdata('group', $group);
				$this->CI->session->set_userdata('idsite', $site);
				$this->CI->session->set_userdata('head', $head);
				$this->CI->session->set_userdata('validator', $validator);
				$this->CI->session->set_userdata('email', $email);
				$this->CI->session->set_userdata('row', $row);
				$this->CI->session->set_userdata('userProfile', $userProfile);
			} 
			else { */
				redirect('auth');
			//}
		}
		$username = $this->CI->encrypt->decode($this->CI->session->userdata('userid'));
		if (!empty($username)) {
			// $pass = $this->CI->encrypt->decode($this->CI->session->userdata('pass'));
			// $resp = $this->cekpass($username,$pass);
			// if (!is_object($resp)) 
			// {
				// redirect('hid');
			// } else {
				return TRUE;
			// }
		} else {
			redirect('auth');
		}
	}

    
/*
 * Check Username,Password on database
 */
	function cekpass($username,$pass)
	{
		$query = $this->CI->db->query("SELECT a.*,b.descriptions AS grup FROM tbluser a 
										INNER JOIN tblusergroup AS b ON b.idusergroup = a.idusergroup
										WHERE a.iduser = '$username'
                                      ");
		if ($query->num_rows() == 1) {
			$hasil = $query->result();
			if ($hasil[0]->pswd == $pass)
			{
                return $hasil[0];
			} else {
				return "wrongpass";
			}
		} else {
			return "nousername";
		}
	}

/*
* create native session
*/
	function create_native_session($username) {
		$query2 = $this->CI->db->query("SELECT c.reader,c.adds,c.updates,c.deletes,d.pagename
										FROM tbluser  a 
										INNER JOIN tblusergroup AS b ON b.idusergroup = a.idusergroup
										INNER JOIN tbluserprofile AS c ON c.iduser = a.iduser
										INNER JOIN tblpage AS d ON d.idpage = c.idpage
										WHERE a.iduser = '$username'
									  ");
		if ($query2->num_rows() > 0) {
			$data = $query2->result_array();
			$pg = array();
			foreach ($data AS $row) {
				$priv = array();
				foreach ($row AS $key => $val) {
					if ($key == 'pagename') {
						$pg[$val] = $priv;
						$priv = array();
					}
					else {
						$priv = array_merge(array($key => $val), $priv);
					}
				}
			}
		} else {
			$pg = "";
		}
		return $pg;
	}

	
/*
 * debug with firephp when deploy is false
*/	

	function log($data) {
		$deploy = $this->CI->config->item('is_production');
		if (!$deploy) {
			$this->CI->firephp->log($data);
		}
	}
	
/*
 * debug last query with firephp when deploy is false
*/	

	function last_query() {
		$deploy = $this->CI->config->item('is_production');
		if (!$deploy) {
			$this->CI->firephp->log($this->CI->db->last_query());
		}
	}
	
/*
 * debug with print_r when deploy is false
*/	
	function print_r($data) {
		$deploy = $this->CI->config->item('is_production');
		return (!$deploy) ? print_r($data) : "";
	}
	
/*
 * function to get session from CI cookie
*/
	function getSessionData() {
		$cek = $this->CI->session->userdata('userid');
		if ($cek) {
			$data = array();
			$data['userid'] 	= $this->CI->encrypt->decode($this->CI->session->userdata('userid'));
			$data['username'] 	= $this->CI->session->userdata('username');
			$data['group']		= $this->CI->session->userdata('group');
			$data['validator']	= $this->CI->session->userdata('validator');
			$data['idsite']		= $this->CI->session->userdata('idsite');
			$data['logged']		= $this->CI->session->userdata('logged');
			$data['head']		= $this->CI->session->userdata('head');
			$data['email']		= $this->CI->session->userdata('email');
			$data['row']		= $this->CI->session->userdata('row');
			$data['userProfile']= $this->CI->session->userdata('userProfile');
			return $data;
		} 
		else {
			return "";
		}
	}
}

/* End of file */