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

<!-- Facebook Share JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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

<div class="container-fluid">
<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline" action="" method="POST">
                    <div class="form-row">

                        <div class="fb-share-button" data-href="
<?php
    echo"http://206.189.228.110/viewEvent.php?event=$_GET[event]";
?>
                        " ata-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F206.189.228.110%2FviewEvent.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>

                        <span class="mx-auto"><h4>Event</h4></span>

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

    $sql="SELECT DISTINCT * FROM `events` E where E.id = '$_GET[event]' ";

    if($query= $conn->prepare($sql))
    {
      $query->execute();
      $result= $query->fetch(PDO::FETCH_ASSOC);

      $sql="SELECT DISTINCT * FROM `organizations` O where '$result[organization_id]' = O.id ";

        if($query= $conn->prepare($sql))
        {
            $query->execute();
            $result= $query->fetch(PDO::FETCH_ASSOC);

            if($_SESSION['id'] == $result['owner_id'])
            {
                echo "
                     <a href=\"editEvent.php?event=$_GET[event]\">
                        <button type=\"button\" class=\"btn btn-secondary\">Edit Event</button>
                    </a>
                ";
            }
        }
    }
?>
                    </div>
                    <hr class="bg-light">
                    <div class="form-group">
                        <label for="inputEventName">Name</label>
                        <input type="text" class="form-control" name="inputEventName" id="inputEventName" >
                    </div>

                     <div class="form-group">
                        <label for="inputUniversity">Event University</label>
                        <input id="inputUniversity" class="form-control" name="inputUniversity">
                    </div>

                    <div class="form-group">
                        <label for="inputState">Event Category</label>
                        <input id="inputState" class="form-control" name="inputState">
                    </div>

                    <div class="form-group">
                        <label for="inputPublicity">Event Publicity</label>
                        <input id="inputPublicity" class="form-control" name="inputPublicity">
                    </div>

                    <div class="form-group">
                        <label for="inputRSO">RSO</label>
                        <input id="inputRSO" class="form-control"  name="inputRSO" required="">
                    </div>

                    <div class="form-group">
                        <label for="inputEventDescription">Description</label>
                        <input type="text" class="form-control" id="inputEventDescription" name="inputEventDescription">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="inputEventTime">Time</label>
                            <input type="text" class="form-control" id="inputEventTime">
                        </div>
                        <div class="form-group col-6">
                            <label for="inputLength">Event Length (hours)</label>
                            <input type="text" class="form-control" id="inputLength">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEventDate">Date (mm/dd/yyyy)</label>
                        <input type="text" class="form-control" id="inputEventDate"
                               name="inputEventDate">
                    </div>
                    <div class="form-group">
                        <label for="inputLocation">Location</label>
                         <div  id="Map" style="height:300px"></div>
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

    $sql="SELECT DISTINCT * FROM `events` E where E.id = '$_GET[event]' ";

    if($query= $conn->prepare($sql))
    {
        $query->execute();
        $result= $query->fetch(PDO::FETCH_ASSOC);

        $lonLat = explode(" ", $result['address']);

        if(count($lonLat) == 2){
            $lon = (float) $lonLat[0];
            $lat = (float) $lonLat[1]; 
            $flag = 0;
        }

        echo "
          <script src=\"OpenLayers.js\"></script>
          <script>
                map = new OpenLayers.Map('Map');
                var mapnik = new OpenLayers.Layer.OSM();
                var markers = new OpenLayers.Layer.Markers( \"Markers\" );

                map.addLayers([mapnik, markers]);
                var position = new OpenLayers.LonLat($lon, $lat);

                map.setCenter(position, 14);
                markers.addMarker(new OpenLayers.Marker(position));
          </script>";
    }

?>

                        <input  type="text" class="form-control" id="inputLocation" name="inputLocation">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="inputContactPhone">Contact Phone</label>
                            <input type="text" class="form-control" id="inputContactPhone" name="inputContactPhone" >
                        </div>
                        <div class="form-group col-6">
                            <label for="inputContactEmail">Contact Email</label>
                            <input type="email" class="form-control" id="inputContactEmail" name="inputContactEmail">
                        </div>
                    </div>
                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="events.php">
                        <button type="button" class="btn btn-secondary">Back</button>
                    </a>
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

    $sql="SELECT DISTINCT * FROM `events` E where E.id = '$_GET[event]' ";

    if($query= $conn->prepare($sql))
    {
      $query->execute();
      $result= $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $RSO = "SELECT name FROM organizations where organizations.id = '$result[organization_id]' LIMIT 0,1";
            $University = "SELECT name FROM universities where universities.id = '$result[university_id]' LIMIT 0,1";

            if($query2 = $conn->prepare($RSO))
            {
                $query2->execute();
                $RSO = $query2->fetch(PDO::FETCH_ASSOC);
            }

            if($query2 = $conn->prepare($University))
            {
                $query2->execute();
                $University = $query2->fetch(PDO::FETCH_ASSOC);
            }

            $timezone = new DateTimeZone( "UTC" );
            $date = DateTime::createFromFormat('U', $result['event_time'], $timezone);
            $time = $date->format('h:i a');
            $date = $date->format('m-d-y');
            
            $length = $result['event_length'] / 60;


            if(($result['publicity_level']) == 0){
                $level = "Open For All";
            }
            else if(($result['publicity_level']) == 1){
                $level = "University Students Only";
            }
            else{
                $level = "RSO Members Only";
            }

            


            echo "
                <script>
                    document.getElementById(\"inputEventName\").value = \"$result[name]\";
                    document.getElementById(\"inputUniversity\").value = \"$University[name]\";
                    document.getElementById(\"inputState\").value = \"$result[category]\";
                    document.getElementById(\"inputPublicity\").value = \"$level\";
                    document.getElementById(\"inputEventDescription\").value = \"$result[description]\";
                    document.getElementById(\"inputLength\").value = \"$length\";
                    document.getElementById(\"inputEventTime\").value = \"$time\";
                    document.getElementById(\"inputEventDate\").value = \"$date\";
                    document.getElementById(\"inputLocation\").value = \"$result[address]\";
                    document.getElementById(\"inputContactPhone\").value = \"$result[contact_number]\";
                    document.getElementById(\"inputContactEmail\").value = \"$result[contact_email]\";
                    document.getElementById(\"inputRSO\").value = \"$RSO[name]\";
                </script>
            ";
        }
    }
?>
            </div>
        </div>
    </div>
</form>


<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline" action="" method="POST">
                    <div class="form-row">
                <span class="mx-auto"><h4>Comments</h4></span>
                </div>
                <hr class="bg-light">
                <div class="table-responsive">

                        <div class="form-group col-6">
                            <label for="inputContactPhone">Comment</label>
                            <input type="text" class="form-control" id="inputComment" name="inputComment" >
                             <button type="submit" class="btn btn-primary" id="addCommentButton">Comment</button>
                        </div>

<?php

if(!isset($_SESSION)){
    session_start();
}

include('database.inc.php');

$eventCreationSuccessAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Comment Inserted!
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

    $comments = $_POST["inputComment"];
}

if (!empty($comments))
{
    if ($query = $conn->prepare('
        INSERT INTO comments ( event_id, user_id, comment)
        VALUES (:event_id, :user_id, :comment)')) 
    {  
        
        if ($query->execute(array(':event_id' => $_GET['event'], ':user_id' => $_SESSION['id'], ':comment' => $comments))) {

            ob_end_flush();
            flush();

            echo "<script type=\"text/javascript\">window.location.href='viewEvent.php?event= '$_GET[event]'';</script>";
        }
        else {
            echo $errorConnectingAlert;
        }
    }
}
?>

                    <table id="dataTable" class="table table-bordered table-hover" style="width: 100%;" >
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Modify</th>
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

    $sql="SELECT * FROM `comments` c WHERE c.event_id = $_GET[event]";

    if($query= $conn->prepare($sql))
    {
      $query->execute();

        foreach ($query as $row)
        {
            if($row)
            {  
                $name = "SELECT * FROM users where users.id = '$row[user_id]' LIMIT 0,1";

                if($query2 = $conn->prepare($name))
                {
                    $query2->execute();
                    $name = $query2->fetch(PDO::FETCH_ASSOC);
                }      

                echo "<tr>
                          <td style=\"min-width: 25%\">$name[first_name] </td>
                          <td>$row[comment]</td>
                          <td>
                            <a type=\"button\" class=\"btn btn-primary\" id=\"editComment\" href='editComment.php?comment=$row[Id]';>Edit</a>
                          </td>
                      </tr>
                ";
            }
        }
    }
?>  
                    </tbody>
                    </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

</div>
</body>
</html>
