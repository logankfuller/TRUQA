<?php

	function createAnswersTable()
	{
		global $conn;
		$sql = 'CREATE TABLE Answers (
			AnswerId INT AUTO_INCREMENT PRIMARY KEY,
			QuestionId INT NOT NULL,
			UserId INT NOT NULL,
			Answer VARCHAR(1024) NOT NULL,
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

function answerQuestion() {
        global $conn, $questionID, $answer, $username;
        $currentDate = date('Ymd');
        
        $sql = "SELECT UserId FROM Users WHERE Username='" . $username . "'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) != 0) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row['UserId'];
        }
        
        $sql = "INSERT INTO Answers(QuestionId, UserId, Answer, Date)
                VALUES('$questionID', '$userID', '$answer', '$currentDate')";
        mysqli_query($conn, $sql);
    }

function getUsernameFromAnswers($answerUserId) {
    global $conn;
    $sql = "SELECT Username FROM Users WHERE UserId='" . $answerUserId . "'";
    $result = mysqli_query($conn, $sql);
    $assocArray = mysqli_fetch_assoc($result);
    $un = $assocArray['Username'];
    return $un;
}

function fetchAnswers() {
        global $conn;
        $qID = $_POST['questionID'];
        $sql = "SELECT Answers.*
                FROM Answers INNER JOIN Questions 
                ON Answers.QuestionId = Questions.QuestionId
                WHERE Answers.QuestionId='" . $qID . "'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) != 0) {            
            $answers = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th class='col-md-1'>Username</th>
                                <th class='col-md-5'>Answer</th>
                                <th class='col-md-1'>Date</th>
                                <th class='col-md-5'>Commands</th>
                        </thead>
                        <tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $answerUsername = getUsernameFromAnswers($row['UserId']);
                $answers .= "<tr id=" . $row['AnswerId'] . ">";
                $answers .= "<td>" . $answerUsername . "</td>";
                $answers .= "<td>" . $row['Answer'] . "</td>";
                $answers .= "<td>" . $row['Date'] . "</td>";
                $answers .= "<td><input type='button' class='btn btn-default answer-delete' value='Delete'/></td>";
                $answers .= "</tr>";
            }
            echo $answers;
        } else {
            echo '<p class="alert alert-danger">There are no answers to this question. Why don\'t you try answering it?</p>';
        }
    }

function deleteAnswer() {
        global $conn, $answerID;
        $sql = "DELETE FROM Answers WHERE AnswerId='" . $answerID . "'";
        $result = mysqli_query($conn, $sql);
    }

?>