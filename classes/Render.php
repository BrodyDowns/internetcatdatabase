<?php

	class Render {

		/*generates comment table given list of usernames/comments*/
		public static function renderComments($rows) {
			session_start();
			$table = "
			<table id ='commenttable'>
			<thead>
				<tr>
				<th>User</th>
				<th>Comment</th>";


			$table .= "
				<th></th>"; //delete comment


			$table .= "
				</tr>
			</thead>
			<tbody>";

			foreach($rows as $row) {
				$table .= "<tr>
					<td>" . $row['username'] . "</td>" .
					"<td>" . $row['comment'] . "</td>";

				if($_SESSION['user']['admin'] || $row['username'] == $_SESSION['user']['username'])
					$table .= "
						<td><span class='deleteCommentLink' data-action=" . $row['id'] . ">Delete</a></td>";

				$table .="</tr>";
			}

			$table .= "</tbody></table>";
			echo $table;

		}


/*generates table to display all cats*/
		public static function renderTable ($rows) {
			$dao = new Dao();

			$table ="
			<table id='catlist'>
				<thead>
				<tr>
					<th id='thRank'>Rank</th>
					<th id='thCat'>Cat</th>
					<th id='thVotes'>Weekly Votes</th>
					<th id='thYourVotes'>Your Votes</th>
				</tr>
				</thead>";
			$i = 1;
			foreach($rows as $row) {
				$table .= "<tr>
					<td>" . $i . "</td>" .
					"<td><a href='/allcats/" . $row['cat'] . "'>" . "<img class='smallCatProfile' src='images/" . $row['cat'] . "/profile.jpg'>" . $row['name'] . "</a></td>" .
					"<td>" . $row['weeklyVotes'] . "</td>" .
					"<td>" . $dao->getUserVoteForCat($_SESSION['user']['id'], $row['cat']) . "</td></tr>";
				$i++;
			}
			$table .= "</table>";
			echo $table;
		}
	}
