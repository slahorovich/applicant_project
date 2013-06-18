<?php

// this goes in models/myapp/
class AbstractModel extends CI_Model
{

	public function __construct()
	{
		// root / newpass
		parent::__construct();
	}

	public function save()
	{
		// this is probably a new piece of data to insert
		if (!$this->id) {
			$sth = $this->db->real_escape_string->query("insert into contacts (name, email) values (?, ?)", $this->name, $this->email);
			$this->id = $this->db->insert_id();
		// we have a valid id in $data, use update
		} else {
			$sth = $this->db->real_escape_string->query("update contacts set name = ?, email = ? where id = ?", $this->name, $this->email, $this->id);
		}
		return $this;
	}

	public function load($id)
	{
		$sth = $this->db->real_escape_string->query("select id, name, email from contacts where id = ?", $id)->result_array();
		$this->setData($sth);
		return $this;
	}

	public function delete()
	{
		$sth = $this->db->real_escape_string->query("delete from contacts where id = ?", $this->id);
		return $this;
	}

	public function getData($key=false)
	{
		if ($key)
			return $this->$key;
		else
			return $this->data;

	}

	public function setData($arr, $value=false)
	{
		if (!is_array($arr)) {
			$this->$arr = $value;
		} else {
			foreach ($arr as $key => $value) {
				$this->$key = $value;
			}
		}
		return $this;
	}
}

?>
