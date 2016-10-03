<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galeria extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('seo');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['um'] = $this->uri->segment(1);
		$this->load->view('galeria',$d);
	}
	public function evento01()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['um'] = $this->uri->segment(1);
		$d['dois'] = $this->uri->segment(2);
		$this->load->view('galeria01',$d);
	}
	public function evento02()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['um'] = $this->uri->segment(1);
		$d['dois'] = $this->uri->segment(2);
		$this->load->view('galeria02',$d);
	}
	public function evento03()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['um'] = $this->uri->segment(1);
		$d['dois'] = $this->uri->segment(2);
		$this->load->view('galeria03',$d);
	}
	public function evento04()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['um'] = $this->uri->segment(1);
		$d['dois'] = $this->uri->segment(2);
		$this->load->view('galeria04',$d);
	}

}