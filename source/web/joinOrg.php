<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Join Organizations</title>

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
            <li class="nav-item ">
                <a class="nav-link" href="events.php">Events </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="organizations.php">Organizations<span class="sr-only">(current)</span></a>
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
<!-- Join -->
<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline" action="" method="POST">
                    <div class="form-row">
                        <span class="mx-auto"><h4>Join Organizations</h4></span>
                        <a href="organizations.php">
                            <button type="button" class="btn btn-secondary">Back</button>
                        </a>
                    </div>
                    <hr class="bg-light">
                   <div class="form-group">
                        <label for="inputOrg">Organizations</label>
                        <select id="inputOrg" class="form-control"  name="inputOrg" required="">
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

    $sql="SELECT name,id FROM organizations where organizations.university_id ='$_SESSION[univ]'";

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
                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" id="addButton">Join
                    </button>
                </div>
            </div>

<?php

if(!isset($_SESSION)){
    session_start();
}

include('database.inc.php');

$eventCreationSuccessAlert = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        organization Joined!
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";

$eventAlreadyJoined = "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Already a Member of Organization!
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
    && isset($_POST['inputOrg'])
){
    $Org = $_POST['inputOrg'];
}

if (!empty($Org))
{
    $sql = "SELECT * FROM memberships WHERE memberships.user_id = $_SESSION[id] AND memberships.organization_id = $Org ";
    if ($query = $conn->prepare($sql)) {
        $query->execute();
    }
    // This means that there already exists someone with this email!
    if ($row = $query->fetch()) {
        echo $eventAlreadyJoined;
    } // Create the user
    else {
        if ($query = $conn->prepare('
            INSERT INTO memberships (user_id, organization_id)
            VALUES (:user_id, :organization_id)')) 
        {  
            
            if ($query->execute(array(':user_id' => $_SESSION['id'], ':organization_id' => '$Org'))) {
                echo $eventCreationSuccessAlert;

                ob_end_flush();
                flush();
                sleep(3);

                echo "<script type=\"text/javascript\">window.location.href='joinOrg.php';</script>";
            }
            else {
                echo $errorConnectingAlert;
            }
        }
    }
}
?>

<!-- Table -->
            <div class="form-row">
                <span class="mx-auto"><h4>My Memberships</h4></span>
            </div>
            <hr class="bg-light">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" style="width: 100%;" >
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
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

    $sql="SELECT * FROM `memberships` m WHERE m.user_id = '$_SESSION[id]'";

    if($query= $conn->prepare($sql))
    {
      $query->execute();

        foreach ($query as $row)
        {
            if($row)
            {  
                $org = "SELECT * FROM organizations where organizations.id = '$row[organization_id]' LIMIT 0,1";

                if($query2 = $conn->prepare($org))
                {
                    $query2->execute();
                    $org = $query2->fetch(PDO::FETCH_ASSOC);
                }      

                echo "<tr>
                          <td style=\"max-width: 30px\">$org[name]</td>
                          <td>Description Field to be added</td>
                      </tr>
                ";
            }
        }
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
