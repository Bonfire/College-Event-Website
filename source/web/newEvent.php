<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - New Event</title>

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
    && isset($_POST['inputLength'])
){

    $eventName = $_POST["inputEventName"];
    $state = $_POST['inputState'];
    $publicity = $_POST['inputPublicity'];
    $description = $_POST['inputEventDescription'];
    $length = $_POST['inputLength'];
    $time = $_POST['inputEventTime'];
    $date = $_POST['inputEventDate'];
    $location = $_POST['inputLocation'];
    $phone = $_POST['inputContactPhone'];
    $email = $_POST['inputContactEmail'];
    $RSO = $_POST['inputRSO'];
}

$id = $_SESSION['id'];
$univ = $_SESSION['univ'];

if (!empty($eventName) && !empty($RSO))
{

    $date = $date. "-";
    $date = $date. $time;
    $timezone = new DateTimeZone( "UTC" );

    if(!empty($length)){
        $length = $length * 60; 
    }
   

    $date = DateTime::createFromFormat('Y-m-d-G:i', $date, $timezone);

    $sql="SELECT * FROM users where users.id = '$id'";
    if(empty($email)){
        if($query = $conn->prepare($sql))
        {
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $email = $result['email'];
        }  
    }

    if ($query = $conn->prepare('
        INSERT INTO events (name, description, category, address, publicity_level, organization_id, event_time, event_date, contact_number, contact_email, university_id)
        VALUES (:name, :description, :category, :address, :publicity_level, :organization_id, :event_length, :event_date, :contact_number, :contact_email, :university_id)')) 
    {  
        
        if ($query->execute(array(':name' => $eventName, ':description' => $description, ':category' => $state, ':address' => $location, ':publicity_level' => $publicity, ':organization_id' => $RSO, ':event_length' => $length, ':event_date' => $date->format('U'), ':contact_number' => $phone, ':contact_email' => $email, ':university_id' => $univ  ))) {
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
                    <span class="mx-auto"><h4>New Event</h4></span>
                    <hr class="bg-light">
                    <div class="form-group">
                        <label for="inputEventName">Name</label>
                        <input type="text" class="form-control" name="inputEventName" id="inputEventName" required="" placeholder="Art Exhibit" >
                    </div>

                    <div class="form-group">
                        <label for="inputState">Event Category</label>
                        <select id="inputState" class="form-control" name="inputState">
                            <option selected value=""></option>
                            <option value="Educational">Educational</option>
                            <option value="Fun">Fun</option>
                            <option value="Religious">Religious</option>
                            <option value="Volunteer">Volunteer</option>
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

    $sql="SELECT name,id FROM organizations where organizations.owner_id ='$_SESSION[id]'";

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
                        <label for="inputEventDescription">Description</label>
                        <input type="text" class="form-control" id="inputEventDescription" name="inputEventDescription" placeholder="This art exhibit...">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="inputEventTime">Time</label>
                            <input type="time" class="form-control" id="inputEventTime" placeholder="1400" name="inputEventTime" required="">
                        </div>
                        <div class="form-group col-6">
                            <label for="inputLength">Event Length (hours)</label>
                            <input type="text" class="form-control" id="inputLength" placeholder="1.5" name="inputLength" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEventDate">Date (mm/dd/yyyy)</label>
                        <input type="date" class="form-control" id="inputEventDate"
                               placeholder="12/25/2018" name="inputEventDate" required="">
                    </div>
                    <div class="form-group">
                        <label for="inputLocation">Location</label>
                         <div  id="Map" style="height:300px"></div>

<script src="OpenLayers.js"></script>
<script>
    var map, vectors, controls;

                map = new OpenLayers.Map('Map');
                var mapnik = new OpenLayers.Layer.OSM();
                var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
                renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;

                vectors = new OpenLayers.Layer.Vector("Vector Layer", {
                    renderers: renderer
                });

                map.addLayers([mapnik, vectors]);

                var fromProjection = new OpenLayers.Projection("EPSG:4326");
                var toProjection   = new OpenLayers.Projection("EPSG:900913");
                var position       = new OpenLayers.LonLat(-81.200108, 28.601966).transform( fromProjection, toProjection);

                var markers = new OpenLayers.Layer.Markers( "Markers" );
                map.addLayer(markers);
                map.setCenter(position, 15);

                map.events.register("click", map, function(e) 
                {
                    var position = map.getLonLatFromPixel(e.xy);
                    var position= new OpenLayers.LonLat(position.lon.toFixed(3) , position.lat.toFixed(3));
                    markers.clearMarkers();
                    markers.addMarker(new OpenLayers.Marker(position));
                    document.getElementById("inputLocation").value = position.lon.toFixed(3) + " " +position.lat.toFixed(3) ;
                });

</script>
                        <input  type="text" class="form-control" id="inputLocation" name="inputLocation" placeholder="Location">

                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="inputContactPhone">Contact Phone</label>
                            <input type="text" class="form-control" id="inputContactPhone" name="inputContactPhone" placeholder="1234567890">
                        </div>
                        <div class="form-group col-6">
                            <label for="inputContactEmail">Contact Email</label>
                            <input type="email" class="form-control" id="inputContactEmail" name="inputContactEmail" placeholder="john@web.com">
                        </div>
                    </div>
                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="events.php">
                        <button type="button" class="btn btn-secondary">Back</button>
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
