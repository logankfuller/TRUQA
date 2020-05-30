<?php

    function createUsersTable()
	{
		global $conn;
		$sql = 'CREATE TABLE Users (
			UserId INT AUTO_INCREMENT PRIMARY KEY,
			Username VARCHAR(32) NOT NULL,
			Password VARCHAR(32) NOT NULL,
			Fullname VARCHAR(64) NOT NULL,
			Email VARCHAR(64) NOT NULL,
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

    function insertUser()
    {
        global $conn, $username, $password, $fullName, $email;
        $current_date = date('Ymd');
        
        // Check to see if user already exists.
        $sql = mysqli_query($conn, "SELECT Username FROM Users WHERE Username='" . $username . "'");
        if(mysqli_num_rows($sql) != 0)
        {
            return false;
        }
        else
        {
            $current_date = date("Ymd");
            $sql = "INSERT INTO Users(Username, Password, Fullname, Email, Date) VALUES ('$username', '$password', '$fullName', '$email', '$current_date')";
            if(mysqli_query($conn, $sql) or die(mysqli_error($conn))) 
            {
                return true;
            }
            else 
            {
                return false;
            }
        }
    }

    function signIn()
    {
        global $conn, $username, $password;
        $sql = mysqli_query($conn, "SELECT * FROM Users WHERE Username='" . $username . "' AND Password='" . $password . "'") or die(mysqli_error($conn));
        if(mysqli_num_rows($sql) != 0)
        {
            return true;
        }
        else
        {
            $error_msg_password = "Wrong username/password";
            return false;
        }
    }

    function unsubscribe()
    {
        global $conn, $username, $password, $fullName, $email;
        $sql = mysqli_query($conn, "SELECT * FROM Users WHERE Username='" . $username . "' AND Password='" . $password . "'") or die(mysqli_error($conn));
        if(mysqli_num_rows($sql) != 0)
        {
            mysqli_query($conn, "DELETE FROM Users WHERE Username='" . $username . "' AND Password='" . $password . "'") or die(mysqli_error($conn));
            return true;
        }
        else
        {
            $error_msg_password = "Wrong username/password";
            return false;
        }
    }
?>