<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('seo');
		$this->load->model('abrangenciaregional');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->load->view('home',$d);
	}
	public function regiao()
	{	
		$regiao = $this->uri->segment(3);
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['regiao'] = $regiao;
		$this->load->view('home',$d);
	}
}
