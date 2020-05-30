<!DOCTYPE html>

<?php
if (!isset($_SERVER['HTTPS'])) {
    $url = 'https://' . $_SERVER['HTTP_HOST'] .
           $_SERVER['REQUEST_URI'];  // start with /...
    header("Location: " . $url);  // Redirect - 302
    exit;                         // should be before any output
  }                               
?>

    <html>

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
        </script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles.css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
        </script>

        <title>MainPage</title>
    </head>

    <body>
        <!-- for sending commands -->

        <div style='display:none'>
            <!-- should not be displayed -->
            <!-- form for SignOut -->
            <form action='controller.php' id='form-signout' method='post' name="form-signout">
                <input name='page' type='hidden' value='MainPage'>
                <input name='command' type='hidden' value='SignOut'>
                <input type='submit' value='Submit'>
            </form>

            <form action='controller.php' id='form-fetch-questions' method='post' name="form-fetch-questions">
                <input name='page' type='hidden' value='MainPage'>
                <input name='command' type='hidden' value='FetchQuestions'>
                <input type='submit' value='Submit'>
            </form>
        </div>

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">TRUQA</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class='nav navbar-nav navbar-right'>
                        <li>
                            <a href="#">Hello,
                                <?php echo $username ?>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions <span class="caret"></span></a>
                            <ul class='dropdown-menu'>
                                <li id="menu-fetch">
                                    <a href="#">List questions that I posted</a>
                                </li>

                                <li>
                                    <a data-toggle="modal" href='#modal-search-questions'>Search questions</a>
                                </li>
                                <!--
                                <li id="viewAnsweredQuestions">
                                    <a href="#">View answered questions</a>
                                </li>
                                -->
                                <li id='menu-signout'>
                                    <a href='#'>Signout</a>
                                </li>

                                <li>
                                    <a data-toggle="modal" href="#modal-ask-question">Ask Question</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class='container'>
            <div class="row">
                <div class="col-md-12">
                    <h1 id="hiddenQuestions" style='display: none'>Questions</h1>
                    <div id="result-pane">

                    </div>
                </div>
            </div>

            <div class="row">
                <div class='col-md-12'>
                    <h1 id="hiddenAnswers" style='display: none'>Answers</h1>
                    <div id="answers">

                    </div>
                </div>
            </div>

        </div>

        <!-- Modal for SearchQuestions -->
        <div class="modal fade" id="modal-search-questions">
            <!-- modal -->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Search Questions</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-about' method='post'>
                            <input name='page' type='hidden' value='MainPage'>
                            <input name='command' type='hidden' value='SearchQuestions'>

                            <div class="form-group">
                                <label for="search-terms">Search terms:</label>
                                <input class="form-control" id="searchTerms" name='searchTerms' type="text" required>
                            </div>
                            <button type="button" class="btn btn-default" id="submitSearchTerms">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for AskQuestion -->
        <div id="modal-ask-question" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ask a Question</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-ask-question' method='post'>
                            <input type='hidden' name='page' value='MainPage'>
                            <input type='hidden' name='command' value='AskQuestion'>
                            <div class="form-group">
                                <label for="question">Question:</label>
                                <input type="text" class="form-control" id="question" name='question' required>
                            </div>
                            <button type="button" class="btn btn-default" id="submitAskQuestions">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for AnswerQuestion -->
        <div id="modal-answer-question" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Answer a Question</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-answer-question' method='post'>
                            <input type='hidden' name='page' value='MainPage'>
                            <input type='hidden' name='command' value='AnswerQuestion'>
                            <div class="form-group">
                                <label for="answer">Answer:</label>
                                <input type="text" class="form-control" id="answer" name='answer' required>
                            </div>
                            <button type="button" class="btn btn-default" id="answerQuestion">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var qID;
            $(document).ready(function () {
                $(window).keydown(function (event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            });

            /*
             * Sign out
             */
            $('#menu-signout').click(function () {
                $('#form-signout').submit();
            });

            /*
             * Ask a question
             */
            $('#submitAskQuestions').click(function () {
                var questionToAsk = $('#question').val();
                $('#modal-ask-question').modal('toggle');
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'MainPage',
                        command: 'AskQuestion',
                        question: questionToAsk
                    },
                    success: function (result) {
                        console.log("Asked a question :)");
                        $('#menu-fetch')[0].click();
                    },
                    error: function (result) {
                        console.log("Oh no! Asking a question did not work!");
                    }
                });
            });

            /*
             * Fetch answers when clicking on a question
             */
            $(document).on("click", '.view-answers', function (event) {
                qID = $(this).closest('tr').attr('id');
                console.log(qID);
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'MainPage',
                        command: 'FetchAnswers',
                        questionID: qID
                    },
                    success: function (result) {
                        console.log("Updating answers div");
                        console.log(result);
                        $('#answers').html(result);
                        $("#hiddenAnswers").css("display", "block");
                    }
                });
            });

            $(document).on("click", '.answer-delete', function (event) {
                if (confirm('Are you sure you wish to delete this row?')) {
                    var answerID = $(this).closest('tr').attr('id');
                    console.log("Deleting answer with id: " + answerID);
                    $.ajax({
                        url: 'controller.php',
                        type: 'POST',
                        data: {
                            page: 'MainPage',
                            command: 'DeleteAnswer',
                            'answerID': answerID

                        },
                        success: function (result) {
                            var $row = $(this).closest('tr');
                            $row.remove();
                            console.log("Deleted answer");
                        }
                    });
                }
            });

            /*
             * Fetch all questions you have posted.
             */
            $('#menu-fetch').click(function () {
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'MainPage',
                        command: 'FetchQuestions',
                    },
                    success: function (result) {
                        console.log(result);
                        document.getElementById("result-pane").innerHTML = result;
                        $("#hiddenQuestions").css("display", "block");
                    }
                });
            });

            $(document).on("click", ".row-delete", function (event) {
                if (confirm('Are you sure you wish to delete this row?')) {
                    qID = $(this).closest('tr').attr('id');
                    var $row = $(this).closest('tr');
                    $.ajax({
                        url: 'controller.php',
                        type: 'POST',
                        data: {
                            page: 'MainPage',
                            command: 'DeleteQuestion',
                            questionID: qID
                        },
                        success: function (result) {
                            $row.remove();
                        },
                        error: function (result) {
                            alert("Oh no!");
                        }
                    });
                } else {
                    return false;
                }
            });

            $(document).on("click", ".answer-question", function (event) {
                qID = $(this).closest('tr').attr('id');
            });

            $(document).on("click", "#answerQuestion", function (event) {
                var answer = document.getElementById("answer").value;
                console.log("Answering a question with qID: " + qID + " | answer: " + answer);
                $('#modal-answer-question').modal('toggle');

                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'MainPage',
                        command: 'AnswerQuestion',
                        questionID: qID,
                        'answer': answer
                    },
                    success: function (result) {

                    }
                });
            });

            $('#submitSearchTerms').click(function () {
                $('#modal-search-questions').modal('toggle');
                var sTerms = document.getElementById("searchTerms").value;
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'MainPage',
                        command: 'SearchQuestions',
                        searchTerms: sTerms
                    },
                    success: function (result) {
                        document.getElementById("result-pane").innerHTML = result;
                        $("#hiddenQuestions").css("display", "block");
                    }
                });
            });

            var timer = setTimeout(timeout, 1 * 60 * 1000);
            window.addEventListener('mousemove', function () {
                clearTimeout(timer);
                timer = setTimeout(timeout, 1 * 60 * 1000);
            });
            window.addEventListener('keydown', function () {
                clearTimeout(timer);
                timer = setTimeout(timeout, 1 * 60 * 1000);
            });
            window.addEventListener('unload', function () {
                clearTimeout(timer);
                timeout();
            });

            function timeout() {
                document.getElementById('form-signout').submit();
            }
        </script>
    </body>

    </html>