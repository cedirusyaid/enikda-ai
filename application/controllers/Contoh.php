
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contoh extends CI_Controller {

    public function index()
    {
        $this->load->view('contoh_tabel');
    }
}
