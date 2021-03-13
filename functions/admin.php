<?php

// Administration functions.

function loginUser($conn)
{

    // function to check to see if user exists, then to allow log in.
    if (isset($_POST['submit'])) {

        // capture input box content.
        $name = $_POST['inputName'];

        // ensure the input box is not empty:
        if (strlen($name) < 3) {

            // respond to client that no attributes found.
            flash('failure', 'Please enter a name to continue.', 'alert alert-danger');
            redirect("../admin/login.php");
            exit();
        }

        // check to see if name exists in database:
        $query = $conn->prepare("SELECT * FROM users WHERE username = :name");
        $query->bindParam(':name', $name, PDO::PARAM_STR );
        $query->execute();

        // ensure the task was returned from the database:
        $rowCount = $query->rowCount();

        // add the name to the database if it does not exist
        if ($rowCount === 0) {

            // PDO Prepare statement structure
            $insert_query = $conn->prepare("INSERT INTO users (username, Locked, status, created, updated) 
                                      VALUES(:name, 'N', 1, now(), now() )");

            // setup the statement using named parameters:
            $insert_query->bindParam(":name", $name, PDO::PARAM_STR);

            // run the prepared statement:
            $insert_query->execute();

            // check to make sure it worked:
            if (!$insert_query) {
                // set the flash message
                flash('failure', 'Sorry, something went wrong.');

                //once insert has been completed redirect back to the Thaw Price page.
                redirect("../admin/login.php");
                exit();
            }
        }

        // add the name as a session variable.
        $_SESSION['name'] = $name;

        // launch Inventory page
        redirect("../pages/stock-take.php");
    }
}
