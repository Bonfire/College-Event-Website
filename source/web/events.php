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
<body>
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

<script type='text/javascript'>
 
     $(document).ready(function(){
     $('#addEventModal').on('click', '.btn-primary', function(e){
     var eventName = $('#inputEventName').val();
     var state = $('#inputState').val();
     var publicity = $('#inputPublicity').val();
     var description = $('#inputEventDescription').val();
     var time = $('#inputEventTime').val();
     var date = $('#inputEventDate').val();
     var location = $('#inputLocation').val();
     var phone = $('#inputContactPhone').val();
     var email = $('#inputContactEmail').val();
     var RSO = $('#inputRSO').val();
     
            $.post("events.php", 
               { 
                  inputEventName:eventName,
                  inputState:state,
                  inputPublicity:publicity,
                  inputEventDescription:description,
                  inputEventTime:time,
                  inputEventDate:date,
                  inputLocation:location,
                  inputContactPhone:phone,
                  inputContactEmail:email,
                  inputRSO:RSO,
               },
            function(response,status){ 
             $("#events").html(response);
             
          });
           
     $('#addEventModal').modal('hide');
   });
   });
         
  </script>

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
    && isset($_POST['inputContactEmail'])) {

    $eventName = $_POST['inputEventName'];
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

if (!empty($eventName) && !empty($state) && !empty($publicity) && !empty($description) &&
    !empty($time) && !empty($date) && !empty($location) && !empty($phone) && !empty($email)) {

    $sql="SELECT university_id FROM `users` WHERE university_id = '$id'";
    $result= $conn->query($sql);
    $value = mysql_fetch_object($result);
    

    if ($query = $conn->prepare('
        INSERT INTO events (name, description, category, address, publicity_level, organization_id, event_time, event_date, contact_number, contact_email) 
        VALUES (:name, :description, :category, :address, :publicity_level, :organization_id, :event_time, :event_date, :contact_number, :contact_email)')) {
        if ($query->execute(array(':name' => $eventName, ':description' => $description, ':category' => $state, ':address' => $location, ':publicity_level' => $publicity, ':organization_id' => $RSO, ':event_time' => $time, ':event_date' => $date, ':contact_number' => $phone, ':contact_email' => $email ))) {
            echo $eventCreationSuccessAlert;

            ob_end_flush();
            flush();
        } else {
            echo $errorConnectingAlert;
        }
    }

}
?>

<!-- Events Form -->
<form action="events.php " method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <a href="newEvent.php">
                                <button type="button" class="btn btn-success">Add Event</button>
                            </a>
                            <button type="button" class="btn btn-danger disabled" id="removeEventButton">Remove Event
                            </button>
                        </div>
                        <div class="form-group col-6">
                            <input type="text" class="form-control" id="inputFilter" placeholder="Filter">
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" style="white-space: nowrap">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Time</th>
                        <th scope="col">Date</th>
                        <th scope="col">Location</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                       <!--  <th scope="col">Select</th> This is for the check box -->
                    </tr>
                    </thead>

                    <tbody id="tableEvents">
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

    //$all = 0;
    //$Students =1;
    //$rso = 2;
    //$id = 3;
    //$_SESSION['id'];

    $sql="SELECT * FROM `events` E";


    /*where E.publicity_level = '$all'
            JOIN
            SELECT * FROM `events` E, `users` U, `memberships` M  where E.publicity_level='$Students'
            AND E.university_id = U.university_id AND U.id = '$id')
            JOIN
            SELECT * FROM events E, users U, memberships M  where(E.publicity_level='Members' AND E.university_id =U.university_id AND U.id = '$id' AND M.user_id = U.id AND M.organization_id = E.organization_id)
        */

    $result= $conn->query($sql);

    foreach ($result as $row){

       // $university = "SELECT name FROM universities U where U.id = '$row[university_id]' ";
       // $result2 = $conn->query($university);

        echo "<tr>
                <td>$row[name]</td>
                <td>$row[category]</td>
                <td>$row[description]</td>
                <td>$row[event_time]</td>
                <td>$row[event_date]</td>
                <td>$row[address]</td>
                <td>$row[contact_number]</td>
                <td>$row[contact_email]</td>
            </tr>"; 
        }
?>
                            
                </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
</body>
</html>
