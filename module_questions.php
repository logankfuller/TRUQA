<?php

	function createQuestionsTable()
	{
		global $conn;
		$sql = 'CREATE TABLE Questions (
			QuestionId INT AUTO_INCREMENT PRIMARY KEY,
			UserId INT NOT NULL,
			Question VARCHAR(1024) NOT NULL,
			Date INT NOT NULL
		)';
		if(mysqli_query($conn, $sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    function deleteRow() {
        global $conn, $questionID;
        $sql = "DELETE FROM Questions WHERE QuestionId='" .$questionID . "'";
        $result = mysqli_query($conn, $sql);
        
        // Delete all associated answers
        $sql = "DELETE FROM Answers WHERE QuestionId='" . $questionID . "'";
        $result = mysqli_query($conn, $sql);
    }

    function fetchQuestions() {
        global $conn, $username;
        $sql = "SELECT * 
                FROM Questions INNER JOIN Users 
                ON Questions.UserId = Users.UserId
                WHERE Username='" . $username . "'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) != 0) {
            $table = "<table id='topQuestion' class='table table-hover'>";
            $table .= "<thead><tr><th class='col-md-1'>Username</th><th class='col-md-5'>Question</th><th class='col-md-1'>Date</th><th class='col-md-5'>Commands</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $table .= "<tr class='question' id=" . $row['QuestionId'] . "><td>" . $username . "</td>";
                $table .= "<td>" . $row['Question'] . "</td>";
                $table .= "<td>" . $row['Date'] . "</td>";
                $table .= "<td><input type='button' class='btn btn-default row-delete' value='Delete'/><input type='button' class='btn btn-default answer-question' data-toggle='modal' href='#modal-answer-question' value='Answer Question'/><input type='button' class='btn btn-default view-answers' value='View Answers'/></td>";
                $table .= "</tr>";
            }
            $table .= "</tbody></table>";
            return $table;
        } else {
            echo '<p class="alert alert-warning">You have not yet asked a question. Why don\'t you try asking one?</p>';
        }
    }
    /*
    function fetchAnsweredQuestions() {
        global $conn, $username;
        $sql = "SELECT * 
                FROM Questions INNER JOIN Users 
                ON Questions.UserId = Users.UserId
                WHERE Username='" . $username . "'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) != 0) {
            $table = "<table class='table table-hover'>";
            $table .= "<thead><tr><th>Username</th><th>Question</th><th>Date</th><th>Options</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $table .= "<tr id=" . $row['QuestionId'] . " data-toggle='collapse' data-target='#answers'><td>" . $username . "</td>";
                $table .= "<td>" . $row['Question'] . "</td>";
                $table .= "<td>" . $row['Date'] . "</td>";
                $table .= "<td><input type='button' class='row-delete' value='Delete'/><input type='button' class='answer-question' data-toggle='modal' href='#modal-answer-question' value='Answer Question'/></td>";
                $table .= "</tr>";
            }
            $table .= "</tbody></table>";
            return $table;
        } else {
            echo '<p class="alert alert-warning">You have not yet answered a question. Why don\'t you try answering one?</p>';
        }
    }
    */

    function askQuestion() {
        global $conn, $question, $username;
        $currentDate = date('Ymd');
        $sql = "SELECT UserId FROM Users WHERE Username='" . $username . "'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) != 0) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row['UserId'];
        }
        
        $sql = "INSERT INTO Questions(UserId, Question, Date) 
                VALUES ('$userID', '$question', '$currentDate')";
        mysqli_query($conn, $sql);
    }

    function getUsernameFromQuestions($uid) {
        global $conn;
        $sql = "SELECT Username FROM Users WHERE UserId='" . $uid . "'";
        $result = mysqli_query($conn, $sql);
        $assocArray = mysqli_fetch_assoc($result);
        $un = $assocArray['Username'];
        echo "<script>alert($un)</script>";
        return $un;
    }

    function searchQuestions() {
        global $conn, $searchTerms;
        $sql = "SELECT *
                FROM Questions
                WHERE Question LIKE '%" . $searchTerms . "%'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) != 0) {
            $table = "<table class='table table-hover'>";
            $table .= "<thead><tr><th class='col-md-1'>Username</th><th class='col-md-5'>Question</th><th class='col-md-1'>Date</th><th class='col-md-5'>Commands</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $questionUsername = getUsernameFromQuestions($row['UserId']);
                $table .= "<tr id=" . $row['QuestionId'] . "><td>" . $questionUsername . "</td>";
                $table .= "<td>" . $row['Question'] . "</td>";
                $table .= "<td>" . $row['Date'] . "</td>";
                $table .= "<td><input type='button' class='btn btn-default row-delete' value='Delete'/><input type='button' class='btn btn-default answer-question' data-toggle='modal' href='#modal-answer-question' value='Answer Question'/><input type='button' class='btn btn-default view-answers' value='View Answers'/></td>";
                $table .= "</tr>";
            }
            $table .= "</tbody></table>";
            return $table;
        } else {
            echo '<p class="alert alert-warning">You have not yet asked a question. Why don\'t you try asking one?</p>';
        }
    }

?>