<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">

    <title>College Events - Manage Users</title>

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
            <li class="nav-item">
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
<!-- Events Form -->
<form action="events.php " method="post">
    <div class="card w-75 mx-auto container-fluid p-3 bg-light shadow" style="margin-top: 5%">
        <div class="card-body">
            <div style="margin-bottom: 3%">
                <form class="form-inline">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <a href="newUser.php">
                                <button type="button" class="btn btn-success">Add User</button>
                            </a>
                            <button type="button" class="btn btn-danger disabled" id="removeUser">Remove User
                            </button>
                        </div>
                        <div class="form-row" style="padding-left: 18px">
                            <div class="form-row" style="padding-right: 20px">
                                <input type="text" class="form-control" id="inputFilter" placeholder="Filter">
                            </div>
                            <div class="form-row" style="height: 20px">
                                <button type="submit" class="btn btn-primary" id="filterButton">Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" style="white-space: nowrap">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">University</th>
                        <th scope="col">Permission Level</th>
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

    $sql="SELECT * FROM users";

    if($query= $conn->prepare($sql))
    {
        $query->execute();

        foreach ($query as $row)
        {
            if($row)
            {
                $University = "SELECT name FROM universities where universities.id = '$row[university_id]' LIMIT 0,1";

                if($query2 = $conn->prepare($University))
                {
                    $query2->execute();
                    $University = $query2->fetch(PDO::FETCH_ASSOC);
                }

                if(($row['permission_level']) == 0){
                    $level = "General User";
                }
                else if(($row['permission_level']) == 1){
                    $level = "Admin";
                }
                else{
                    $level = "Super Admin";
                }
                    
                echo "
                    <tr>
                        <td>$row[first_name] $row[last_name]</td>
                        <td>$row[email]</td>
                        <td>$University[name]</td>
                        <td>$level</td>
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
