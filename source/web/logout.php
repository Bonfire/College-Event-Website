<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Logout</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
</head>
<body style="background: url('background.png')">
<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand">
        <span class="ml-2 text-light" style="display: inline-block;">College Events</span>
    </a>
    <form class="form-inline">
        <a href="login.php">
            <button class="btn btn-outline-warning mr-2 my-sm-0" type="button">Sign In</button>
        </a>
        <a href="register.php">
            <button class="btn btn-warning my-2 my-sm-0" type="button">Register</button>
        </a>
    </form>
</nav>

<!-- Login Form -->
<div class="container-fluid">
    <form id="login_form" action="" method="post">
        <div class="row">
            <div class="container col-6 col-md-4 card p-3 bg-dark shadow" style="margin-top: 10%;">
                <span class="mx-auto text-light"><h4>You have successfully signed out!</h4></span>
            </div>
        </div>
    </form>
</div>

<?php
session_start();

if (isset($_COOKIE['user'])) {
    setcookie(session_name(), “”, time() - 3600, “ / ”);
}

$_SESSION = array();

session_destroy();
ob_end_flush();
flush();

sleep(3);

echo "<script type=\"text/javascript\">window.location.href='login.php';</script>";
?>
</body>
</html>
