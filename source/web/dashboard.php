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
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">Dashboard </a>
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

<!-- Account Info Card -->
<div class="container-fluid">
    <form id="accountCard">
        <div class="row">
            <div class="card w-75 mx-auto container-fluid p-3 bg-dark shadow" style="margin-top: 10%;">              
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

    $sql = "SELECT * FROM `users` where users.id = '$_SESSION[id]'";
    $University = "SELECT name FROM universities where universities.id = '$_SESSION[univ]'";

    if($query = $conn->prepare($sql))
    {
        $query->execute();
        $entry = $query->fetch(PDO::FETCH_ASSOC);
    }

    if($query2 = $conn->prepare($University))
    {
        $query2->execute();
        $University = $query2->fetch(PDO::FETCH_ASSOC);
    }

    if($entry){

        if(($_SESSION['perm']) == 0){
                    $level = "General User";
                }
                else if($_SESSION['perm'] == 1){
                    $level = "Admin";
                }
                else{
                    $level = "Super Admin";
                }

        echo "
            <span class=\"mx-auto text-light\"><h4>Welcome, $entry[first_name] $entry[last_name]</h4></span>
            <hr class=\"bg-light\">
                <div class=\"form-group\">
                    <label for=\"accountEmail\" class=\"text-light\">Account Email: </label>
                    <label for=\"accountEmail\" class=\"text-light\">$entry[email]</label>
                    <span id=\"accountEmail\" class=\"text-light\"></span>
                </div>
                <div class=\"form-group\">
                    <label for=\"accountType\" class=\"text-light\">Account Type: </label>
                    <label for=\"accountType\" class=\"text-light\">$level</label>
                    <span id=\"accountType\" class=\"text-light\"></span>
                </div>
                <div class=\"form-group\">
                    <label for=\"accountUni\" class=\"text-light\">University: </label>
                    <label for=\"accountUni\" class=\"text-light\">$University[name]</label>
                    <span id=\"accountUni\" class=\"text-light\"></span>
                </div>
            <hr class=\"bg-light\">";
    }

?> 
<!-- Table -->
            <div class="form-row">
            <span class="mx-auto text-light"><h4>My Memberships</h4></span>
            </div>
            <hr class="bg-light">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" style="width: 100%; background-color: white;" >
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
    </form>
</div>
<?php
    include('database.inc.php');

    if(!isset($_SESSION)){
        session_start();
    }

    //admin = 1
    //super admin =2
    if($_SESSION['perm'] == 1 || $_SESSION['perm'] == 2)
    {
        echo "
            <div class=\"container-fluid\">
            <form id=\"accountCard\">
                <div class=\"row\">
                    <div class=\"card w-75 mx-auto container-fluid p-3 bg-dark shadow\" style=\"margin-top: 10%; width: 100%\">
                        <span class=\"mx-auto text-light\"><h4>Administration Tools</h4></span>
                        <hr class=\"bg-light\">

                        <div class=\"form-row mx-auto\">
                            <div>
                                <a href=\"users.php\">
                                    <button type=\"button\" class=\"btn btn-warning mr-2 my-sm-0\">Manage Users</button>
                                </a>
                            </div>
                            <hr class=\"bg-light\">
                        </div>
                    </div>
                </form>
            </div>
        ";
    }
?>
</body>
</html>
