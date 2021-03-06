<?php

	/*Data Access Object*/
	Class Dao {
    private $host;
    private $db;
    private $user;
    private $pass;


	  public function __construct(){
			$this->host = getenv("DB_HOST");
			$this->db = getenv("DB_DB");
			$this->user = getenv("DB_USER");
			$this->pass = getenv("DB_PASS");
		}

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
			return $conn->query("select cat, name, weeklyVotes from cats order by weeklyVotes desc");
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
			$query = "update cats set votecount = votecount + 1, weeklyVotes = weeklyVotes + 1 where cat = :cat";
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
			$query = "select name, cat, weeklyVotes from cats order by weeklyVotes desc limit 5";
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
			return $conn->lastInsertId();
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

		/*Enter reset password hash */
		public function insertResetPasswordHash($id, $hash) {
			$conn = $this->getConnection();
			$query = "INSERT INTO pwd_reset (user_id, pwd_hash) VALUES (:id, :hash)";
			$q = $conn->prepare($query);
			$q->bindParam(":id", $id);
			$q->bindParam(":hash", $hash);
			$q->execute();
		}

		/*checks if user exists in reset password table*/
		public function userExistPasswordReset($id) {
			$conn = $this->getConnection();
			$stmt = $conn->prepare("SELECT user_id FROM pwd_reset WHERE user_id='$id' LIMIT 1");
			$stmt->execute();
			return $stmt->fetch();

		}

		/*checks if hash is alid in password reset table */
		public function isValidHash($hash) {
			$conn = $this->getConnection();
			$query = "SELECT user_id FROM pwd_reset WHERE pwd_hash=:hash LIMIT 1";
			$q = $conn->prepare($query);
			$q->bindParam(":hash", $hash);
			$q->execute();
			$array = $q->fetch();
			if(isset($array['user_id']))
				return true;
			else {
				return false;
			}
		}

		/*gets user ID based on hash*/
		public function getUserIDHash($hash) {
			$conn = $this->getConnection();
			$query = "SELECT user_id FROM pwd_reset WHERE pwd_hash=:hash LIMIT 1";
			$q = $conn->prepare($query);
			$q->bindParam(":hash", $hash);
			$q->execute();
			$array = $q->fetch();
			return $array['user_id'];
		}

		/*updates password*/
		public function updatePassword($id, $password) {
			$conn = $this->getConnection();
			$query = "UPDATE user SET password=:password where id=:id";
			$q = $conn->prepare($query);
			$q->bindParam(":password", $password);
			$q->bindParam(":id", $id);
			$q->execute();
		}

		/*remove user from reset password table*/
		public function removeResetPasswordHash($id) {
			$conn = $this->getConnection();
			$query = "DELETE FROM pwd_reset WHERE user_id=:id";
			$q = $conn->prepare($query);
			$q->bindParam(":id", $id);
			$q->execute();
		}

		/*get userID from comment ID*/
		public function getUserIDfromCommentID($commentID) {
			$conn = $this->getConnection();
			$query = "SELECT user.id FROM user JOIN comments on comments.username=user.username where comments.id=:commentID";
			$q = $conn->prepare($query);
			$q->bindParam(":commentID", $commentID);
			$q->execute();
			$array = $q->fetch();
			return $array['id'];
		}

		/*delete comment */
		public function deleteComment($commentID) {
			$conn = $this->getConnection();
			$query = "DELETE FROM comments where id=:commentID";
			$q = $conn->prepare($query);
			$q->bindParam(":commentID", $commentID);
			$q->execute();
		}

		/*select the top 3 cats of the week*/
		public function topThreeCats() {
			$conn = $this->getConnection();
			$query = "select cat, weeklyVotes from cats order by weeklyVotes desc limit 3";
			$q = $conn->prepare($query);
			$q->execute();
			return $q;
		}


		/*inserts the top 3 cats of the week to DB*/
		public function submitWeeklyLeaders($cat1, $cat2, $cat3) {
			$conn = $this->getConnection();
			$query = "insert into weeklyleaders (cat1, cat1votes, cat2, cat2votes, cat3, cat3votes, week)
values (:cat1, :cat1votes, :cat2, :cat2votes, :cat3, :cat3votes, :week)";
			$q = $conn->prepare($query);
			$q->bindParam(":cat1", $cat1[cat]);
			$q->bindParam(":cat1votes", $cat1[weeklyVotes]);
			$q->bindParam(":cat2", $cat2[cat]);
			$q->bindParam(":cat2votes", $cat2[weeklyVotes]);
			$q->bindParam(":cat3", $cat3[cat]);
			$q->bindParam(":cat3votes", $cat3[weeklyVotes]);
			$week = $this->getWeekNumber();
			$q->bindParam(":week", $week);
			$q->execute();

			$query = "UPDATE cats SET weeklyVotes = 0";
			$q = $conn->prepare($query);
			$q->execute();
		}

	/*get the next week for the weekly leaders*/
		public function getWeekNumber() {
			$conn = $this->getConnection();
			$query = "select count(week) from weeklyLeaders";
			$q = $conn->prepare($query);
			$q->execute();
			$array = $q->fetch();
			return $array[0] + 1;
		}

	/*Checks that its been a week since the date of the latest weekly winner
		Heroku Events run once every day so it checks that it has been at least 6.5 days
	*/
		public function checkLastDate() {
			$conn = $this->getConnection();
			$query = "SELECT date FROM weeklyleaders WHERE date >= NOW() - INTERVAL 156 HOUR";
			$q = $conn->prepare($query);
			$q->execute();
			$array = $q->fetch();
			return isset($array['date']);
		}

		/*get list of all weekly leaders*/
		public function getWeeklyLeaders() {
			$conn = $this->getConnection();
			$query = "SELECT * from weeklyleaders ORDER BY week desc";
			$q = $conn->prepare($query);
			$q->execute();
			return $q;
		}

		public function getCatName($cat) {
			$conn = $this->getConnection();
			$query = "SELECT name from cats where cat=:cat";
			$q = $conn->prepare($query);
			$q->bindParam(":cat", $cat);
			$q->execute();
			$array = $q->fetch();
			return $array['name'];
		}


}
