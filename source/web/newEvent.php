<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Dashboard</title>

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
        Event Created!
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
    && isset($_POST['inputEventName'])
    && isset($_POST['inputState'])
    && isset($_POST['inputPublicity'])
    && isset($_POST['inputRSO'])
    && isset($_POST['inputEventDescription'])
    && isset($_POST['inputEventTime'])
    && isset($_POST['inputEventDate'])
    && isset($_POST['inputLocation'])
    && isset($_POST['inputContactPhone'])
    && isset($_POST['inputContactEmail'])
){

    $eventName = $_POST["inputEventName"];
    $state = $_POST['inputState'];
    $publicity = $_POST['inputPublicity'];
    $description = $_POST['inputEventDescription'];
    $time = $_POST['inputEventTime'];
    $date = $_POST['inputEventDate'];
    $location = $_POST['inputLocation'];
    $phone = $_POST['inputContactPhone'];
    $email = $_POST['inputContactEmail'];
    $RSO = $_POST['inputRSO'];
}

$id = 2;
    //$_SESSION['id'];

if (!empty($eventName) && !empty($RSO))

    /*&& !empty($state) && !empty($publicity) && !empty($description) &&
    !empty($time) && !empty($date) && !empty($location) && !empty($phone) && !empty($email))
    */
    {

    //$sql="SELECT university_id FROM `users` WHERE university_id = '$id'";
    //$result= $conn->query($sql);
    //$value = mysql_fetch_object($result);


    if ($query = $conn->prepare('
        INSERT INTO events (name, description, category, address, publicity_level, organization_id, event_time, event_date, contact_number, contact_email)
        VALUES (:name, :description, :category, :address, :publicity_level, :organization_id, :event_time, :event_date, :contact_number, :contact_email)')) {
        if ($query->execute(array(':name' => $eventName, ':description' => $description, ':category' => $state, ':address' => $location, ':publicity_level' => $publicity, ':organization_id' => $RSO, ':event_time' => $time, ':event_date' => $date, ':contact_number' => $phone, ':contact_email' => $email ))) {
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

}
?>
<div class="container-fluid">
<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline" action="" method="POST">

                    <div class="form-group">
                        <label for="inputEventName">Name</label>
                        <input type="text" class="form-control" name="inputEventName" id="inputEventName" required=""
                                placeholder="Art Exhibit" >
                    </div>

                    <div class="form-group">
                        <label for="inputState">Event Category</label>
                        <select id="inputState" class="form-control" name="inputState">
                            <option selected value=""></option>
                            <option value="edu">Educational</option>
                            <option value="fun">Fun</option>
                            <option value="rel">Religious</option>
                            <option value="vol">Volunteer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputPublicity">Event Publicity</label>
                        <select id="inputPublicity" class="form-control" name="inputPublicity">
                            <option selected value=""></option>
                            <option value="0">Open For All</option>
                            <option value="1">University Students Only</option>
                            <option value="2">RSO Members Only</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputRSO">RSO</label>
                        <select id="inputRSO" class="form-control"  name="inputRSO" required="">
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

    $id = 2;
    //$_SESSION['id'];

    $sql="SELECT name,id FROM organizations where organizations.owner_id ='$id'";
    $result= $conn->query($sql);

    foreach ($result as $row){

        echo "<option value=\"$row[id]\">$row[name]</option>";
        }
?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputEventDescription">Description</label>
                        <input type="text" class="form-control" id="inputEventDescription" name="inputEventDescription" placeholder="This art exhibit...">
                    </div>
                    <div class="form-group">
                        <label for="inputEventTime">Time</label>
                        <input type="text" class="form-control" id="inputEventTime" placeholder="1400" name="inputEventTime">
                    </div>
                    <div class="form-group">
                        <label for="inputEventDate">Date (mm/dd/yyyy)</label>
                        <input type="text" class="form-control" id="inputEventDate"
                               placeholder="12/25/2018" name="inputEventDate">
                    </div>
                    <div class="form-group">
                        <label for="inputLocation">Location</label>
                        <input type="text" class="form-control" id="inputLocation" name="inputLocation" placeholder="Address">

                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="inputContactPhone">Contact Phone</label>
                            <input type="text" class="form-control" id="inputContactPhone" name="inputContactPhone" placeholder="123 456 7890">
                        </div>
                        <div class="form-group col-6">
                            <label for="inputContactEmail">Contact Email</label>
                            <input type="text" class="form-control" id="inputContactEmail" name="inputContactEmail" placeholder="john@web.com">
                        </div>
                    </div>
                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="events.php">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    </a>
                    <button type="submit" class="btn btn-primary" id="addEventButton">Save
                        Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

</body>
</html>
