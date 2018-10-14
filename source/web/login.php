<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <?php

    if(!isset($_SESSION)){
        session_start();
    }

    include('database.inc.php');

    if(!empty($_POST))
    {
        if(!isset($_POST['inputEmail']) && !isset($_POST['inputPassword'])) {
            $email = $_POST['inputEmail'];
            $password = $_POST['inputPassword'];

            $query = $conn->prepare('SELECT * FROM users WHERE email = :email and password = :password');
            $result = $query->execute([':email' => $email, ':password' => $password]);

            if ($result) {
                $_SESSION['email'] = $email;
                $_SESSION['userID'] = $result['id'];
            }

            echo $result['id'];
        }
    }
    else{
        echo "Post empty";
    }
    ?>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand">
            <span class="ml-2 text-light" style="display: inline-block;">Collee Events</span>
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
                    <span class="mx-auto text-light"><h4>Please Sign In</h4></span>
                    <hr class="bg-light">
                    <div class="form-group">
                        <label for="inputEmail" class="text-light">Email</label>
                        <input type="text" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="name@email.com" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="text-light">Password</label>
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                    <button type="submit" class="btn btn-warning" value="login">Sign In</button>
                    <hr class="bg-light">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
