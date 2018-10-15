<?php

    include('database.inc.php');

    // Get action from GET, and data from POST
    $action = $_GET['action'];
    $data = file_get_contents('php://input');

    // See if the request has set an action
    if(!isset($action))
    {
        // Kill the script if no action is set
        echo "No action set";
        die();
    }

    // Check database connection
    if(!$conn)
    {
        echo "Error connecting to the database";
        die();
    }

    if($action === "login")
    {
        $email = $data['inputEmail'];
        $password = $data['inputPassword'];

        if($query = $conn->prepare('SELECT id, username, permission_level  FROM users WHERE email = :email AND password = :password'))
        {
            $query->execute(array(':email' => $email, ':password' => $password));

            // See if the user with these credentials exists
            if($row = $query->fetch())
            {
                session_start();
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['username'];
                $_SESSION['perm'] = $row['permission_level'];
            }
            else
            {
                echo "Invalid email or password";
            }
        }
        else
        {
            echo "Error querying the database";
        }
    }




?>