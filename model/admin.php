<?php
class Admin
{

	private $email;
	private $password;

	function __construct($email, $password)
	{
		$this->setEmail($email);
		$this->setPassword($password);
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

}
?>