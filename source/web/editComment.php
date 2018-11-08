<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Event</title>

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
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="events.php">Events <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="organizations.php">Organizations</a>
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

$eventCreationSuccessAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Comment Updated!
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


// Check database connection
if (!$conn) {
    echo $errorConnectingAlert;
    die();
}

if (isset($_POST)
    && isset($_POST['inputComment'])
){
    $comment = $_POST["inputComment"];
}

if (!empty($comment))
{

    $sql = "
        UPDATE comments 
        SET comment = '$comment'
        WHERE id = '$_GET[comment]'
        ";

    if ($conn->query($sql)) {
        echo $eventCreationSuccessAlert;

        ob_end_flush();
        flush();
        sleep(3);

        echo "<script type=\"text/javascript\">window.location.href='events.php';</script>";
    }
    else {
        echo $errorConnectingAlert;
    }
}
?>
<div class="container-fluid">
<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline" action="" method="POST">
                    <div class="form-row">
                        <span class="mx-auto"><h4>Edit Comment</h4></span>
                    </div>
                    <hr class="bg-light">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputComment">Comment</label>
                        <input type="text" class="form-control" id="inputComment" name="inputComment" placeholder="This art exhibit...">
                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="events.php">
                        <button type="button" class="btn btn-secondary">Back</button>
                    </a>
                    <button type="submit" class="btn btn-primary" id="addEventButton">Save
                        Changes
                    </button>
                </div>

<?php
    include('database.inc.php');

    if(!isset($_SESSION)){
        //session_start();
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

    $sql="SELECT DISTINCT * FROM `comments` c where c.id = '$_GET[comment]' ";

    if($query= $conn->prepare($sql))
    {
      $query->execute();
      $result= $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {

            echo "
                <script>
                    document.getElementById(\"inputComment\").value = \"$result[comment]\";
                </script>
            ";
        }
    }
?>
            </div>
        </div>
    </div>
</form>
</div>
</body>
</html>
