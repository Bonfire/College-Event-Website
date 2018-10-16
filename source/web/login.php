<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
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

<?php
include('database.inc.php');

session_start();

$invalidLoginAlert = "
        <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
        Invalid email or password!
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

$errorConnectingAlert = "
        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        Error querying the database
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";


$successfulLoginAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Successfully logged in! Redirecting...
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

$alreadyLoggedInAlert = "
        <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
        Already logged in! Redirecting...
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

if(isset($_SESSION['user']))
{
    echo $alreadyLoggedInAlert;
    ob_end_flush();
    flush();

    sleep(3);

    echo "<script type=\"text/javascript\">window.location.href='dashboard.php';</script>";
}

// Check database connection
if(!$conn)
{
    echo $errorConnectingAlert;
    die();
}

if(isset($_POST) && isset($_POST['inputEmail']) && isset($_POST['inputPassword']))
{
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
}

if(!empty($email) && !empty($password)) {
    if ($query = $conn->prepare('SELECT id, username, permission_level  FROM users WHERE email = :email AND password = :password')) {
        $query->execute(array(':email' => $email, ':password' => $password));

        // See if the user with these credentials exists
        if ($row = $query->fetch()) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['user'] = $row['username'];
            $_SESSION['perm'] = $row['permission_level'];

            echo $successfulLoginAlert;
            ob_end_flush();
            flush();

            sleep(3);

            echo "<script type=\"text/javascript\">window.location.href='dashboard.php';</script>";

        }
        else
        {
            echo $invalidLoginAlert;
        }
    } else {
        echo $errorConnectingAlert;
    }
}
?>

<!-- Login Form -->
<div class="container-fluid">
    <form id="login_form" action="" method="post">
        <div class="row">
            <div class="container col-6 col-md-4 card p-3 bg-dark shadow" style="margin-top: 10%;">
                <span class="mx-auto text-light"><h4>Please Sign In</h4></span>
                <hr class="bg-light">
                <div class="form-group">
                    <label for="inputEmail" class="text-light">Email</label>
                    <input type="text" class="form-control" name="inputEmail" id="inputEmail" aria-describedby="emailHelp" placeholder="name@email.com" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="text-light">Password</label>
                    <input type="password" class="form-control" name="inputPassword" id="inputPassword">
                </div>
                <input type="hidden" name="action" value="login" />
                <button type="submit" class="btn btn-warning" value="login">Sign In</button>
                <hr class="bg-light">
            </div>
        </div>
    </form>
</div>
<div style="width: 100%; text-align: center">
    <br><br>
    <text>made by <b>Group 5</b></text>
</div>
</body>
</html>
