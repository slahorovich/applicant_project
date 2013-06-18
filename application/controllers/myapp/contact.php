<?php 
class Contact extends CI_Controller
{
	public function view(){
		$contact = $this->load->model("myapp/contact");
		$contact_id = $this->input->get("id", true);
		$contact->load( $contact_id );
		if( is_null($contact->getData("id")) )
			die("Could not find a contact with id: " + $contact_id);
		$this->load->view('myapp/view', $contact);
	}
}