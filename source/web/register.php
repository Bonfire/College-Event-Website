<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Register</title>

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
            <button class="btn btn-warning mr-2 my-sm-0" type="button">Sign In</button>
        </a>
        <a href="register.php">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="button">Register</button>
        </a>
    </form>
</nav>

<?php
if(!isset($_SESSION)){
    session_start();
}

include('database.inc.php');

$userExistsAlert = "
        <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
        This email is already taken! <a href=\"login.php\" class=\"alert-link\">Click here to login</a>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

$registrationSuccessAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Account successfully created! Redirecting to login...
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

$alreadyLoggedInAlert = "
        <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
        Already logged in! Redirecting...
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

if (isset($_SESSION['id'])) {
    echo $alreadyLoggedInAlert;
    ob_end_flush();
    flush();

    sleep(3);

    echo "<script type=\"text/javascript\">window.location.href='dashboard.php';</script>";
}

// Check database connection
if (!$conn) {
    echo $errorConnectingAlert;
    die();
}

if (isset($_POST)
    && isset($_POST['inputFirstName'])
    && isset($_POST['inputLastName'])
    && isset($_POST['inputEmail'])
    && isset($_POST['inputConfirmEmail'])
    && isset($_POST['inputPassword'])
    && isset($_POST['inputConfirmPassword'])) {
    $firstName = $_POST['inputFirstName'];
    $lastName = $_POST['inputLastName'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
}

if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
    if ($query = $conn->prepare('SELECT * FROM users WHERE email = :email')) {
        $query->execute(array(':email' => $email));

        // This means that there already exists someone with this email!
        if ($row = $query->fetch()) {
            echo $userExistsAlert;
        } // Create the user
        else {
            if ($query = $conn->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (:firstName, :lastName, :email, :password)')) {
                if ($query->execute(array(':firstName' => $firstName, ':lastName' => $lastName, ':email' => $email, ':password' => $password))) {
                    echo $registrationSuccessAlert;

                    ob_end_flush();
                    flush();

                    sleep(3);

                    echo "<script type=\"text/javascript\">window.location.href='login.php';</script>";
                } else {
                    echo $errorConnectingAlert;
                }
            }
        }
    }
}
?>

<!-- Register Form -->
<div class="container-fluid">
    <form id="registration_form" action="" method="post">
        <div class="row">
            <div class="container col-6 col-md-4 card p-3 bg-dark shadow" style="margin-top: 5%;">
                <div style="text-align: center;" class="text-light"><h4>Register Here</h4></div>
                <hr>
                <form class="container was-validated" action="" method="POST" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstName" class="text-light">First Name</label>
                            <input type="text" class="form-control" name="inputFirstName" id="inputFirstName"
                                   placeholder="John" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLastName" class="text-light">Last Name</label>
                            <input type="text" class="form-control" name="inputLastName" id="inputLastName"
                                   placeholder="Smith" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="text-light">Email</label>
                        <input type="text" class="form-control" name="inputEmail" id="inputEmail"
                               placeholder="name@email.com" required
                               pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                        <div class="invalid-feedback" class="text-light">Please provide a valid email.</div>
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmEmail" class="text-light">Confirm Email</label>
                        <input type="text" class="form-control" name="inputConfirmEmail" id="inputConfirmEmail"
                               placeholder="name@email.com"
                               required>

                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="text-light">Password</label>
                        <input type="password" class="form-control" name="inputPassword" id="inputPassword" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        <small id="passwordRequirement" class="form-text text-light">Your password must be at least 8
                            characters long, contain uppercase letters, lowercase letters, and numbers.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmPassword" class="text-light">Confirm Password</label>
                        <input type="password" class="form-control" name="inputConfirmPassword"
                               id="inputConfirmPassword" required>
                    </div>

                    <button type="submit" class="btn btn-warning text-dark" id="register">Register
                    </button>
                </form>
                <hr>
            </div>
        </div>
    </form>
</div>
</body>
</html>
