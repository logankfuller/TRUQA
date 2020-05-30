<!doctype html>

<?php
if (!isset($_SERVER['HTTPS'])) {
    $url = 'https://' . $_SERVER['HTTP_HOST'] .
           $_SERVER['REQUEST_URI'];  // start with /...
    header("Location: " . $url);  // Redirect - 302
    exit;                         // should be before any output
  }                               
?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>

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
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#modal-signin" data-toggle='modal'>Login</a></li>
                        <li><a href="#modal-join" data-toggle="modal">Join</a></li>
                        <li><a href="#modal-unsubscribe" data-toggle="modal">Unsubscribe</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
        <!--
        <div class='container'>
            <div class='row'>
                <div class='col-md-1'>
                    <div class="dropdown" style='top: 20px'>
                        
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-menu-hamburger"></span> Menu
                        </button>
                        <ul class="dropdown-menu">
                            
                            <li><a href='#modal-signin' data-toggle='modal'>Sign In</a></li>
                            <li><a href="#modal-join" data-toggle='modal'>Join</a></li>
                            <li><a href="#modal-unsubscribe" data-toggle='modal'>Unsubscribe</a></li>
                            <li class='divider'></li>
                            <li><a href="#modal-about" data-toggle='modal'>About Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class='col-md-11'>
                    <h1 style='text-align: center'>TRU Questions & Answers</h1>
                </div>
            </div>
-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if(!(empty($message))) echo $message; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin convallis arcu et molestie. Nullam vulputate tincidunt mi sit amet volutpat. Vestibulum vehicula ligula vel mi efficitur, et auctor purus tristique. Donec vel tellus laoreet nibh consequat facilisis in suscipit ante. Nunc nec justo imperdiet leo elementum venenatis nec eget arcu. Nullam eleifend dignissim bibendum. Fusce eget finibus tellus. Donec ornare volutpat suscipit. Integer nec scelerisque eros. Pellentesque auctor mattis fringilla. Nam ac volutpat ligula. Quisque elit nulla, volutpat ut augue et, fermentum semper diam. Integer tempor neque a nunc finibus, eget rutrum urna mattis. Nam euismod et nibh vel varius. Nulla consectetur gravida lorem eget cursus. Pellentesque tempor tellus quam, ut placerat erat pulvinar id. Maecenas tellus ex, placerat at tempor ac, auctor et neque. Integer at maximus eros, in suscipit orci. Duis sollicitudin ut lorem vitae egestas. Mauris et magna mi. Integer aliquet tortor eget neque bibendum, aliquam finibus turpis rutrum. Fusce tincidunt quam a feugiat malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In ac arcu at metus ullamcorper finibus ut vel lorem. Aenean gravida finibus tortor, in tincidunt arcu. Duis a sapien id ligula malesuada ultricies. Phasellus elementum nisi urna. Nullam sit amet consequat lectus. Phasellus consequat augue sem, ac fermentum neque cursus vitae. Curabitur consectetur dapibus hendrerit. Ut non lectus iaculis, auctor lectus eu, faucibus enim. Suspendisse vitae elit sit amet sapien volutpat dapibus. Pellentesque interdum pretium nibh, vel consectetur mauris mattis sed. Aenean et urna tempus, egestas neque ac, blandit sapien. Sed ornare nibh tellus, ut pellentesque dolor placerat nec. Proin in lectus pharetra, ullamcorper erat at, vehicula augue. Nam sit amet leo vitae purus rutrum tempus. Sed eget lobortis odio. Sed viverra facilisis mauris, ultrices molestie sem sodales a. Cras interdum eu purus eget sagittis. Integer vehicula hendrerit nulla, sit amet vestibulum libero. Integer ullamcorper convallis dignissim. Phasellus porttitor laoreet lacus et ullamcorper. Curabitur at pellentesque lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur eget ex eu nulla viverra dapibus id eu leo. Nullam et volutpat diam. Integer viverra sit amet mi eget tempus. Pellentesque aliquet fermentum libero vel scelerisque. Quisque suscipit sem sit amet luctus fringilla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed ultrices tellus et ligula iaculis, non sollicitudin est vulputate. Nunc nulla urna, euismod rutrum lacinia in, pharetra sed urna. Integer quis tempus sem.</p>
                </div>
            </div>
        </div>

        <!-- Modal for SignIn -->
        <div id="modal-signin" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sign In</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-signin' method='POST' action='controller.php'>
                            <input type='hidden' name='page' value='StartPage'>
                            <input type='hidden' name='command' value='SignIn'>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name='username' required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name='password' required>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Join -->
        <div id="modal-join" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Join</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-join' method='POST' action='controller.php'>
                            <input type='hidden' name='page' value='StartPage'>
                            <input type='hidden' name='command' value='Join'>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name='username' required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name='password' required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name='email' required>
                            </div>
                            <div class="form-group">
                                <label for="full-name">Full Name:</label>
                                <input type="text" class="form-control" id="full-name" name='full-name' required>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for SignIn -->
        <div id="modal-unsubscribe" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Unsubscribe</h4>
                    </div>

                    <div class="modal-body">
                        <form id='form-unsubscribe' method='POST' action='controller.php'>
                            <input type='hidden' name='page' value='StartPage'>
                            <input type='hidden' name='command' value='Unsubscribe'>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name='username' required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name='password' required>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for About -->
        <div class="modal fade" id="modal-about">
            <!-- modal -->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">About</h4>
                    </div>

                    <div class="modal-body">
                        <p>Please give me 10/10</p>
                    </div>
                </div>
            </div>
        </div>

    </body>