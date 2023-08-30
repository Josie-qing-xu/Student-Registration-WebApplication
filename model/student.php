<?php
	class Student{		

		private $id;
		private $firstName;
		private $lastName;
		private $country;
		private $studentNumber;
		private $pic;
		private $date;
				
		function __construct($id, $firstName, $lastName, $country, $studentNumber, $pic, $date){
			$this->setId($id);
			$this->setFirstName($firstName);
			$this->setLastName($lastName);
			$this->setCountry($country);
			$this->setStudentNumber($studentNumber);
			$this->setPic($pic);
			$this->setDate($date);
			}		
		
		public function getFirstName(){
			return $this->firstName;
		}
		
		public function setFirstName($firstName){
			$this->firstName = $firstName;
		}
		
		public function getLastName(){
			return $this->lastName;
		}
		
		public function setLastName($lastName){
			$this->lastName = $lastName;
		}
		
		public function getCountry(){
			return $this->country;
		}
		
		public function setCountry($country){
			$this->country = $country;
		}

		public function getStudentNumber(){
			return $this->studentNumber;
		}

		public function setStudentNumber($studentNumber){
			$this->studentNumber = $studentNumber;
		}

		public function getPic(){
			return $this->pic;
		}

		public function setPic($pic){
			$this->pic = $pic;
		}

		public function getDate(){
			return $this->date;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>