<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - New User</title>

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
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <a class="navbar-brand">
        <span class="ml-2 text-light" style="display: inline-block;">College Events</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="events.php">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="organizations.php">Organizations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="universities.php">Universities</a>
            </li>
        </ul>
    </div>

    <form class="form-inline">
        <a href="logout.php">
            <button class="btn btn-outline-warning mr-2 my-sm-0" type="button">Sign Out</button>
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
        This email is already taken!
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

$registrationSuccessAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        New User Created
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";


if(!isset($_SESSION)){
    session_start();
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
    && isset($_POST['inputPassword'])
    && isset($_POST['inputConfirmPassword'])
    && isset($_POST['inputUniversity'])
    && isset($_POST['inputPerm'])) {
    $firstName = $_POST['inputFirstName'];
    $lastName = $_POST['inputLastName'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $university = $_POST['inputUniversity'];
    $perm = $_POST['inputPerm'];
}

if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
    if ($query = $conn->prepare('SELECT * FROM users WHERE email = :email')) {
        $query->execute(array(':email' => $email));

        // This means that there already exists someone with this email!
        if ($row = $query->fetch()) {
            echo $userExistsAlert;
        } // Create the user
        else {
            if ($query = $conn->prepare('INSERT INTO users (first_name, last_name, email, password, university_id, permission_level) VALUES (:firstName, :lastName, :email, :password, :university, :permission_level )')) {
                if ($query->execute(array(':firstName' => $firstName, ':lastName' => $lastName, ':email' => $email, ':password' => $password, ':university' => $university, ':permission_level' => $perm))) {
                    echo $registrationSuccessAlert;

                    ob_end_flush();
                    flush();

                    sleep(3);

                    echo "<script type=\"text/javascript\">window.location.href='users.php';</script>";
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
                        <label for="inputUniversity" class="text-light">University</label>
                        <select id="inputUniversity" class="form-control"  name="inputUniversity" required="">
                            <option selected value=""></option>
<?php
    include('database.inc.php');

    if(!isset($_SESSION)){
        session_start();
    }

    $errorConnectingAlert = "
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            Error querying the database
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
            </button>
            </div>";

    // Check database connection
    if (!$conn) {
        echo $errorConnectingAlert;
        die();
    }

    $sql="SELECT id, name FROM universities ";

    if($query= $conn->prepare($sql)){
        $query->execute();

        foreach ($query as $row){

            if($row)
            {

            echo "<option value=\"$row[id]\">$row[name]</option>"; 
            }

        }
    }
?>
                        </select>
                    </div>
                     <div class="form-group">
                        <label for="inputPerm" class="text-light" >User Level</label>
                        <select id="inputPerm" class="form-control" name="inputPerm">
                            <option selected value=""></option>
                            <option value="0">General User</option>
                            <option value="1">Admin</option>

<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SESSION['perm'] == 2)
    {
        echo "<option value=\"2\">Super Admin</option>";
    }
?>
                        </select>
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

                    <button type="submit" class="btn btn-warning text-dark" id="register">Create User
                    </button>
                </form>
                <hr>
            </div>
        </div>
    </form>
</div>
</body>
</html>
