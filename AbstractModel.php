<?php

class AbstractModel 
{
	public $dbh;
	public $data = array(
		"id" => false,
		"name" => false,
		"email" => false
	);

	public function __construct()
	{
		$host = "localhost";
		$dbname = "test";
		$user = "root";
		$pass = "newpass";
		
		$this->dbh = new mysqli($host, $user, $pass, $dbname);
		if ($this->dbh->connect_error) {
			die ($this->dbh->connect_error);
		}

		return $this;
	}

	public function save()
	{
		// this is probably a new piece of data to insert
		if (!$this->data['id']) {
			$sql = $this->dbh->real_escape_string("insert into contacts (name, email) values (?, ?)");
			$sth = $this->dbh->prepare($sql);
			$sth->bind_param('ss', $this->data['name'], $this->data['email']);
			$sth->execute();
			$sth->close();
			$this->data['id'] = $this->dbh->insert_id;
		// we have a valid id in $data, use update
		} else {
			$sql = $this->dbh->real_escape_string("update contacts set name = ?, email = ? where id = ?");
			$sth = $this->dbh->prepare($sql);
			$sth->bind_param('ssi', $this->data['name'], $this->data['email'], $this->data['id']);
			$sth->execute();
			$sth->close();
		}

		return $this;
	}

	public function load($id)
	{
		// prepare() and execute() sequence isn't necessary, should probably use query() here
		$sql = $this->dbh->real_escape_string("select id, name, email from contacts where id = ?");
		$sth = $this->dbh->prepare($sql);
		$sth->bind_param('i', $id);
		$sth->execute(); 

		$sth->bind_result($this->data['id'], $this->data['name'], $this->data['email']);
		$sth->fetch();
		$sth->close();
		
		return $this;

	}

	public function delete()
	{
		$sql = $this->dbh->real_escape_string("delete from contacts where id = ?");
		$sth = $this->dbh->prepare($sql);
		$sth->bind_param('i', $this->data['id']);
		$sth->execute();
		$sth->close();

		// delete from contacts where id = $id;
		return $this;
	}

	public function getData($key=false)
	{
		if ($key)
			return $this->data[$key];
		else
			return $this->data;

	}

	public function setData($arr, $value=false)
	{
		if (!is_array($arr)) {
			$this->data[$arr] = $value;
		} else {
			foreach ($arr as $key => $value) {
				$this->data[$key] = $value;
			}
		}
		return $this;
	}
}

?>
