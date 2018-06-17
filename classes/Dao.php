<?php

	/*Data Access Object*/
	Class Dao {
                private $host = "";
                private $db = "";
                private $user = "";
                private $pass = "";


		public function getConnection() {
			try {
				$conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
			} catch (Exception $e) {
				echo $e;
				exit;
			}
			return $conn;
		}

		/*Select * on a single cat*/
		public function getCatInfo($name) {

			$conn = $this->getConnection();
			$stmt = $conn->prepare("SELECT * FROM cats WHERE cat='$name' LIMIT 1");
			$stmt->execute();
			return $stmt->fetch();
		}

		/*Get ordered list of cats*/
		public function getAllCats() {
			$conn = $this->getConnection();
			return $conn->query("select * from cats order by votecount desc");
		}

		/*get user by username*/
		public function getUserUsername($name) {
			$conn = $this->getConnection();
			$stmt = $conn->prepare("SELECT * FROM user WHERE username='$name' LIMIT 1");
			$stmt->execute();
			return $stmt->fetch();
		}

		/*get user by email*/
		public function getUserEmail($email) {
			$conn = $this->getConnection();
			$stmt = $conn->prepare("SELECT * FROM user WHERE email='$email' LIMIT 1");
			$stmt->execute();
			return $stmt->fetch();
		}

		/*add user to database*/
		public function saveUser($user) {
			$conn = $this->getConnection();
			$query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
			$q = $conn->prepare($query);
			$q->bindParam(":username", $user['name']);
			$q->bindParam(":email", $user['email']);
			$q->bindParam(":password", $user['password']);
			$q->execute();
			$user = $this->getUserUsername($user['name']);
			$this->addcatxuser($user['id']);
		}

		/*add user to catxuser table*/
		public function addcatxuser($id) {
			$conn = $this->getConnection();
			$query = "alter table catxuser add u$id int default 0";
			$q = $conn->prepare($query);
			$q->execute();
		}

		/*increment votes on a cat*/
		public function incCat($cat) {
			$conn = $this->getConnection();
			$query = "update cats set votecount = votecount + 1 where cat = :cat";
			$q = $conn->prepare($query);
			$q->bindParam(":cat", $cat);
			$q->execute();
		}

		/*decrement available votes for user*/
		public function decUser($user) {
			$conn = $this->getConnection();
			$query = "update user set votecount = votecount - 1 where username = :user";
			$q = $conn->prepare($query);
			$q->bindParam(":user", $user);
			$q->execute();
		}

		/*add url to user pic to database*/
		public function adduserpic($id, $file) {
			echo "hello";
			echo $id;
			echo $file;
			$conn = $this->getConnection();
			$query = "update user set profilepic = :file where id = :id";
			$q = $conn->prepare($query);
			$q->bindParam(":id", $id);
			$q->bindParam(":file", $file);
			print_r($q);
			$q->execute();
			echo "has been executed";
		}

		/*get available votes for a user*/
		public function getUserVotecount($user) {
			$conn = $this->getConnection();
			$query = "select votecount from user where username = :user";
			$q = $conn->prepare($query);
			$q->bindParam(":user", $user);
			$q->execute();
			$array = $q->fetch();
			return $array['votecount'];
		}

		/*gets top 5 cats by votecount*/
		public function topFive() {
			$conn = $this->getConnection();
			$query = "select * from cats order by votecount desc limit 5";
			$q = $conn->prepare($query);
			$q->execute();
			return $q;
		}

		/*gets the amount of votes a user has used on a cat*/
		public function getUserVoteForCat($id, $cat) {
			$conn = $this->getConnection();
			$query = "select u$id from catxuser where cat = :cat";
			$q = $conn->prepare($query);

			$q->bindParam(":cat", $cat);
			$q->execute();
			$array = $q->fetch();
			return $array[0];
		}

		/*increases the amount of votes a user has used on a cat*/
		public function inccatxuser($cat, $id) {
			$conn = $this->getConnection();
			$query = "update catxuser set u$id = u$id + 1 where cat = :cat";
			$q = $conn->prepare($query);
			$q->bindParam(":cat", $cat);
			$q->execute();

		}

		/*inserts comment into database*/
		public function saveComment($comment, $cat, $user) {
			$conn = $this->getConnection();
			$query = "insert into comments (username, cat, comment) values (:user, :cat, :comment)";
			$q = $conn->prepare($query);
			$q->bindParam(":user", $user);
			$q->bindParam(":cat", $cat);
			$q->bindParam(":comment", $comment);
			$q->execute();
		}

		/*gets comments for a single cat*/
		public function getComments($cat) {
			$conn = $this->getConnection();
			$query = "select * from comments where cat = :cat order by time desc";
			$q = $conn->prepare($query);
			$q->bindParam(":cat", $cat);
			$q->execute();
			return $q;
		}

		/*gets the top 3 cats for a single user*/
		public function getFaves($id) {
			$conn = $this->getConnection();
			$query = "select cats.cat, name, u$id from catxuser join cats on catxuser.cat = cats.cat order by u$id desc limit 3";
			$q = $conn->prepare($query);
			$q->execute();
			return $q;
		}

}
