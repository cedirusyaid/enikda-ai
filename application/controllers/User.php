<?php
use phpDocumentor\Reflection\Types\Null_;

defined('BASEPATH') or exit('No direct script access allowed');
// defined('basename(path)EPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		
	}
	
	
	public function index() {
		
	}
	
			
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		// create the data object

		$data['stdclass'] = new stdClass();
		if(isset($_GET['site'])) {$site_asal = $_GET['site'];} else {$site_asal = "/";} 
		// $data['site_asal']=$site_asal;
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('nip', 'NIP', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			// $this->load->view('layout/header');
			// $this->template->view('template','user/login/login');
            // $data['title']='Halaman login';
            // $this->template->load('login-template','user/login/login');
			$data['hidden_sidebar'] = true;

			$this->load->view('template/header', $data);
			$this->load->view('user/login/login');
			$this->load->view('template/footer');
			// $this->load->view('layout/footer');

			
		} else {
			
			// set variables from the form
			$nip = $this->input->post('nip');
			$password = $this->input->post('password');
			
			// $resolve_user_login=$this->input->server(SITE_API.'user_auth/?username='.$nip.'&password='.$password);
      		$resolve_user_login = file_get_contents(SITE_API.'user_auth/?username='.$nip.'&password='.$password);
			// $resolve_user_login = file_get_contents(SITE_API.'user_auth/?username='.$nip.'&password='.$password);

			if ($resolve_user_login==1) {
				
				// $nip = $this->user_model->get_user_id_from_username($nip);
				// $user    = $this->user_model->get_user($nip);
				
				$user=json_decode(file_get_contents(SITE_API.'data_pegawai/?nip='.$nip));
				// $_SESSION=$user;

				$_SESSION['nip']      = (int)$user->nip;
				$_SESSION['unit_id']      = (int)$user->unit_id;
				$_SESSION['jabatan_id']      = (int)$user->jabatan_id;
				$_SESSION['nama']     = (string)$user->nama;
				$_SESSION['is_logged_in']    = (bool)true;
				$_SESSION['admin_kabupaten'] = $user->admin_kabupaten;
				$_SESSION['jabatan_atasan_id'] = $user->jabatan_atasan_id;

				
				if($_SESSION['admin_kabupaten']>0) 
					{
						$_SESSION['admin_unit'] = $_SESSION['admin_kabupaten']; 
					}	
					else {
						$_SESSION['admin_unit'] = (bool)$user->admin_unit;
					}
				if($_SESSION['admin_unit']==1) 
							{$_SESSION['status']='Admin OPD';}
							else
							{$_SESSION['status']='User';}
				if($_SESSION['admin_kabupaten']>0) 
					{
						$_SESSION['status']='Admin Kabupaten';
					}	

				
				// user login ok
				// $this->load->view('layout/header');
				// $this->load->view('user/login/login_success', $data);
            	// $this->template->load('template','user/login/login_success', $data);

				// $this->load->view('layout/footer');
				header('Location: ' . base_url());
				
			} else {
				// $user=file_get_contents(SITE_API.'pegawai_data/'.$nip);
			// echo "$resolve_user_login = ".$resolve_user_login;
				
				// login failed
				$data->error = 'Wrong username or password.';

				
				// send error to the view
	            // $this->template->load('login-template','user/login/login');
			$data['hidden_sidebar'] = true;

			$this->load->view('template/header', $data);
			$this->load->view('user/login/login');
			$this->load->view('template/footer');

            	// $this->template->load('template','user/login');
				// $this->load->view('layout/header');
				// $this->load->view('user/login/login', $data);
				// $this->load->view('layout/footer');
				
			}
			
		}
		
	}
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			//$this->load->view('layout/header');
			//$this->load->view('user/logout/logout_success', $data);
			//$this->load->view('layout/footer');
			redirect('/');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');
			
		}
		
	}

	public function all() {
		// $data = new stdClass();
		
		if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true && $_SESSION['is_admin'] > 0 ) {
			
			// 	
				// $data["user_all"] = $this -> menembak_model -> user_all();
				$data["user_all"] = $this -> pegawai_model -> user_all();
				$user_data = $this -> pegawai_model -> user_data($this->session->userdata('username'));
				// $user_data = $this -> menembak_model -> user_data($this->session->userdata('username'));
				if (isset($_GET['edit'])) {$data['edit'] = $_GET['edit'];} else {$data['edit'] = 0;}
				if ($this->session->userdata('is_admin') > 0) {$data["bisaedit"] = 1;} else {$data["bisaedit"] = 0;}
				$data['judul'] = 'Registrasi';
				$data['cont'] = $this -> uri -> segment(1);
				$data["username"] = $this->session->userdata('username');
				if ($this->session->userdata('is_logged_in') > 0) {$data["logged_in"] = 1;} else {$data["logged_in"] = 0;}
				if ($this->session->userdata('is_admin') > 0) {$data["is_admin"] = 1;} else {$data["is_admin"] = 0;}
				// if ($this->session->userdata('Username') == $kejuaraan_data['kejuaraan_user']) {$data["is_admin"] = 1;} 
			// 
			$this->load->view('layout/header');
			$this->load->view('user/all', $data);
			$this->load->view('layout/footer');
			
		} else {

			redirect('/');
			
		}
	}



}
