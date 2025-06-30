<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Users_model');
	}

	public function index()
	{
		$data['contents'] = $this->load->view('register_view', '', true);
		$this->load->view('templates/auth_templates', $data);
	}

	public function submit()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('alert_danger', validation_errors());

			$data['contents'] = $this->load->view('register_view', '', true);
			$this->load->view('templates/auth_templates', $data);
		} else {
			$data = [
				'nama'       => $this->input->post('name', true),
				'email'      => $this->input->post('email', true),
				'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role'       => 'user',
				'created_at' => date('Y-m-d H:i:s')
			];

			$result = $this->Users_model->store($data);

			if ($result) {
				$this->session->set_flashdata('alert_success', 'Registrasi berhasil! Silakan login.');
				redirect('login');
			} else {
				$this->session->set_flashdata('alert_danger', 'Registrasi gagal! Silakan coba lagi.');

				$data['contents'] = $this->load->view('register_view', '', true);
				$this->load->view('templates/auth_templates', $data);
			}
		}
	}
}
