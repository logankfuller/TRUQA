<?php

/*
*   When controller.php is accessed for the first time
*/

if (empty($_POST['page'])) {
    include ('view_startpage.php');  // StartPage
    exit;
}

/*
*   When commands come from StartPage or MainPage
*/

require ('module.php');  // connect to MySQL database
require ('module_users.php');  // functions to use Users table
require ('module_questions.php');  // functions to use Questions table
require ('module_answers.php');  // functions to use Answers table

session_start();

$page = $_POST['page'];
$command = $_POST['command'];

if ($page == 'StartPage') 
{
    switch ($command) {
            
    case '':
            include("view_startpage.php");
            exit();
            
    case 'SignIn':
            if (empty($_POST['username']))
                $message = '<p class="alert alert-danger">Please enter a valid username.</p>';
            else
                $username = $_POST['username'];

            if (empty($_POST['password']))
                $message = '<p class="alert alert-danger">Please enter a valid password.</p>';
            else
                $password = $_POST['password'];
            
            if (empty($message))
            {
                $result = signIn();
                if($result) {
                    $message = '<p class="alert alert-success">You have successfully signed in.</p>';
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $_SESSION['signedin'] = 'YES';  // session variable
                    $_SESSION['username'] = $username;  // session variable
                    $_SESSION['password'] = $password;  // session variable
                    include ('view_mainpage.php');  // MainPage
                } else {
                    $message = '<p class="alert alert-danger">There was an error with signing in.</p>';
                    //include("view_startpage.php");
                }  
            }
            else
            {
                $message = '<p class="alert alert-danger">There was an error with signing in.</p>';
                //include("view_startpage.php");
            }
            break;
    
    case 'Join':
            // Regex
            $password = $_POST['password'];
            $pattern_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{6,10}$/';
            if(!preg_match($pattern_password, $password)) {
                $message = '<p class="alert alert-danger">Please make sure you enter valid information.</p>';
                include("view_startpage.php");
            }
            
            if (empty($_POST['username']))
                $message = '<p class="alert alert-danger">Please enter a valid username.</p>';
            else
                $username = $_POST['username'];

            if (empty($_POST['password']))
                $message = '<p class="alert alert-danger">Please enter a valid password.</p>';
            else
                $password = $_POST['password'];
            
            if (empty($_POST['email']))
                $message = '<p class="alert alert-danger">Please enter a valid email.</p>';
            else
                $email = $_POST['email'];

            if (empty($_POST['full-name']))
                $message = '<p class="alert alert-danger">Please enter a valid name.</p>';
            else
                $fullName = $_POST['full-name'];
            if (empty($message))
            {
                $result = insertUser();
                if($result) {
                    $message = '<p class="alert alert-success">You have successfully joined.</p>';
                } else {
                    $message = '<p class="alert alert-danger">There was an error with joining.</p>';
                }
                include("view_startpage.php");
            }
            else
            {
                $message = '<p class="alert alert-danger">Please make sure you enter valid information.</p>';
                include("view_startpage.php");
            }
            break;
    case 'Unsubscribe':
            if(empty($_POST['username']))
                $message = '<p class="alert alert-danger">Please enter a valid username.</p>';
            else
                $username = $_POST['username'];
            
            if(empty($_POST['password']))
                $message = '<p class="alert alert-danger">Please enter a valid password.</p>';
            else
                $password = $_POST['password'];
            
            if(empty($message)) {
                $result = unsubscribe();
                if($result) {
                    $message = '<p class="alert alert-success">You have successfully unsubscribed. Sorry to see you go!</p>';
                } else {
                    $message = '<p class="alert alert-danger">There was an error with unsubscribing. Try again after making sure you want to leave.</p>';
                }
                include('view_startpage.php');
            }
            break;
            
    }
}

else if ($page == 'MainPage') 
{
    if (!isset($_SESSION['signedin'])) {
        include ('view_startpage.php');  // StartPage
        exit;
    }
    
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    switch ($command) {
        case 'SignOut':  // 'SignOut' menu item, or timeout
            $message = '<p class="alert alert-success">You successfully signed out.</p>';
            session_unset();
            session_destroy();  // It does not unset session variables. session_unset() is needed.
            include ('view_startpage.php');
            break;
        case 'SearchQuestions':
            $searchTerms = $_POST['searchTerms'];
            $searchResultsTable = searchQuestions();
            echo $searchResultsTable;
            break;
        case 'FetchAnswers':
            fetchAnswers();
            break;
        case 'DeleteAnswer':
            $answerID = $_POST['answerID'];
            deleteAnswer();
            break;
        case 'DeleteQuestion':
            $questionID = $_POST['questionID'];
            deleteRow();
            break;
        case 'AnswerQuestion':
            $questionID = $_POST['questionID'];
            $answer = $_POST['answer'];
            answerQuestion();
            break;
        case 'AskQuestion':
            $question = $_POST['question'];
            askQuestion();
            break;
        case 'FetchQuestions':
            $fetchedQuestionsTable = fetchQuestions();
            echo $fetchedQuestionsTable;
            break;
        case 'FetchAnsweredQuestions':
            fetchAnsweredQuestions();
            break;
        default:
            echo 'Unknown command = ' . $command . '<br>';
            break;
    }
}
?>
