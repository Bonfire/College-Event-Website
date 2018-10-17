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

<!-- Events Form -->
<form action="" method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#addEventModal">Add Event
                            </button>
                            <button type="button" class="btn btn-danger disabled" id="removeEventButton">Remove Event
                            </button>
                        </div>
                        <div class="form-group col-6">
                            <input type="text" class="form-control" id="inputFilter" placeholder="Filter">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Add Event Modal -->
            <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="newEventLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newEventLabel">Event Window</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formAddEvent">
                                <div class="form-group">
                                    <label for="inputEventName">Name</label>
                                    <input type="text" class="form-control" id="inputEventName"
                                           placeholder="Art Exhibit" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputState">Event Category</label>
                                    <select id="inputState" class="form-control">
                                        <option selected value=""></option>
                                        <option value="edu">Educational</option>
                                        <option value="fun">Fun</option>
                                        <option value="rel">Religious</option>
                                        <option value="vol">Volunteer</option>
                                    </select>
                                </div>

                                 <div class="form-group">
                                    <label for="inputPublicity">Event Publicity</label>
                                    <select id="inputPublicity" class="form-control">
                                        <option selected value=""></option>
                                        <option value="All">Open For All</option>
                                        <option value="Students">University Students Only</option>
                                        <option value="Members">RSO Members Only</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputRSO">RSO</label>
                                    <select id="inputRSO" class="form-control">
                                        <option selected value=""></option>
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

    $id = 3;
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
                                    <input type="text" class="form-control" id="inputEventDescription"
                                           placeholder="This art exhibit...">
                                </div>
                                <div class="form-group">
                                    <label for="inputEventTime">Time</label>
                                    <input type="text" class="form-control" id="inputEventTime" placeholder="1400">
                                </div>
                                <div class="form-group">
                                    <label for="inputEventDate">Date (mm/dd/yyyy)</label>
                                    <input type="text" class="form-control" id="inputEventDate"
                                           placeholder="12/25/2018">
                                </div>
                                <div class="form-group">
                                    <label for="inputLocation">Location</label>
                                    <input type="text" class="form-control" id="inputLocation"
                                           placeholder="Address">

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="inputContactPhone">Contact Phone</label>
                                        <input type="text" class="form-control" id="inputContactPhone"
                                               placeholder="123 456 7890">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="inputContactEmail">Contact Email</label>
                                        <input type="text" class="form-control" id="inputContactEmail"
                                               placeholder="john@web.com">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close Window</button>
                            <button type="button" class="btn btn-primary" id="addEventButton" disabled=true>Save
                                Changes
                            </button>
                        </div>
                    </div>
                </div>
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

    $id = 3;
    //$_SESSION['id'];

    $sql="SELECT name,id FROM organizations where organizations.owner_id ='$id'";
    $result= $conn->query($sql);

    foreach ($result as $row){

        echo "<tr>
                <td>Jill</td>
                <td>Smith</td>
                <td>50</td>
                <td>Jill</td>
                <td>Smith</td>
                <td>50</td>
                <td>Jill</td>
                <td>Smith</td>
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
