<?php

// functions for managing stock.
function scanLocation($conn)
{
    // function to scan location barcode:
    if (isset($_POST['submit'])) {

        // Obtain text from form:
        $location = $_POST['inputLocation'];
        $location = parseInput($location);


        // ensure there is a value that has been scanned:
        if (strlen($location) < 4) {
            // respond to client that the location was missed.
            flash('failure', 'Please scan the location again.', 'alert alert-danger');
            redirect("../pages/stock-take.php");
            exit();
        }

        // store the location scanned into a Session variable:
        $_SESSION['location'] = $location;

        // check if location already exists in the database:
        $query = $conn->prepare("SELECT * FROM inventory WHERE location = :location");
        $query->bindParam(':location', $location, PDO::PARAM_STR);
        $query->execute();

        $rowCount = $query->rowCount();

        // if the location is in the database warn entries will be removed:
        if ($rowCount > 0) {
            echo "
            <div class='container mt-2'>
            <p class='red'>This location already exists, if you continue the content of this location
                will be removed.
            </p>";
            echo "<a class='btn btn-warning' href='../pages/stock-take.php?action=delete&location=$location' data-toggle='tooltip' title='Empty location'>Continue</a>
            
            </container>
            ";
            exit();
        }

        // load next page:
        redirect("../pages/stock-take-location.php");
    }
}

// obtain query strings from URL
if (isset($_GET)) {

    if (isset($_GET['action']) && isset($_GET['location'])) {

        $delLocation = $_GET['location'];
        $delLocation = parseInput($delLocation);

        // store the location scanned into a Session variable:
        $_SESSION['location'] = $delLocation;

        // remove location from database
        $delete_query = $conn->prepare("DELETE FROM inventory WHERE location = :location");
        $delete_query->bindParam(':location', $delLocation, PDO::PARAM_STR);
        $delete_query->execute();

        // redirect onto next page:
        redirect("../pages/stock-take-location.php");
    }

    if (isset($_GET['action']) && isset($_GET['barcode'])) {

        $delBarcode = $_GET['barcode'];
        $delBarcode = parseInput($delBarcode);

        // obtain location from session
        $location = $_SESSION['location'];
        $location = parseInput($location);

        // remove Barcode from database
        $delete_query = $conn->prepare("DELETE FROM inventory WHERE location = :location AND barcode = :barcode");
        $delete_query->bindParam(':location', $location, PDO::PARAM_STR);
        $delete_query->bindParam(':barcode', $delBarcode, PDO::PARAM_STR);
        $delete_query->execute();

        // redirect onto next page:
        flash('success', 'Scanned item removed from location.', 'alert alert-success');
        redirect("../pages/stock-take-location.php");
        exit();
    }
}


function showProductInLocation($conn)
{

    // function to show the products in a location.

    // obtain location from Session variable:
    $location = $_SESSION['location'];
    $location = parseInput($location);

    // query database, obtainin all rows for given location:
    $query = $conn->prepare("SELECT * FROM inventory WHERE location = :location");
    $query->bindParam(':location', $location, PDO::PARAM_STR);
    $query->execute();

    // count rows returned:
    $rowCount = $query->rowCount();

    // Show the table if there are records in the database:
    if ($rowCount > 0) {

        // create HTML table to show results:
        $table_head = ("
            <table class='table table-striped table-sm'>
                <thead class='thead-light'>
                    <tr>
                        <th scope='col'>Location</th>
                        <th scope='col'>Barcode</th>
                        <th scope='col'>ST Code</th>
                        <th scope='col'>Qty</th>
                        <th scope='col'>Person</th>
                        <th scope='col' class='content-to-hide'>Date/Time</th>
                        <th scope='col'>Actions</th>
                    <tr>
                </thead>
                <tbody>
            ");

        echo $table_head;

        //show table:
        while ($results = $query->fetch()) {


            $location   = $results['location'];
            $barcode    = $results['barcode'];
            $sku        = $results['sku'];
            $qty        = $results['qty'];
            $user       = $results['user'];
            $updated    = $results['updated'];

            $updated = substr($updated, 0, 10);

            // button to remove row if required:
            $button = "<a class='btn btn-danger btn-sm btn-smaller' href='../pages/stock-take-location.php?action=delete&barcode=$barcode' data-toggle='tooltip' title='Remove item from location'>Remove</a>";


            $table_row = ("
                        <tr>
                            <td>{$location}</td>
                            <td>{$barcode}</td>
                            <td>{$sku}</td>
                            <td>{$qty}</td>
                            <td>{$user}</td>
                            <td class='content-to-hide'>{$updated}</td>
                            <td>$button</td>
        
                        </tr>
                        ");

            echo $table_row;
        }

        $table_footer = (" </tbody>
                    </table>");

        echo $table_footer;
    }
}

function showProductInLocationQuery($conn)
{

    // function to show the products in a location.

    if (isset($_POST['submit'])) {

        $location = $_POST['inputLocation'];
        $location = parseInput($location);

        // query database, obtainin all rows for given location:
        $query = $conn->prepare("SELECT * FROM inventory WHERE location = :location");
        $query->bindParam(':location', $location, PDO::PARAM_STR);
        $query->execute();

        // count rows returned:
        $rowCount = $query->rowCount();

        // Show the table if there are records in the database:
        if ($rowCount > 0) {

            // create HTML table to show results:
            $table_head = ("
            <table class='table table-striped table-sm'>
                <thead class='thead-light'>
                    <tr>
                        <th scope='col'>Location</th>
                        <th scope='col'>Barcode</th>
                        <th scope='col'>ST Code</th>
                        <th scope='col'>Qty</th>
                        <th scope='col'>Person</th>
                        <th scope='col'>Date/Time</th>
                        <th scope='col'>Actions</th>
                    <tr>
                </thead>
                <tbody>
            ");

            echo $table_head;

            //show table:
            while ($results = $query->fetch()) {


                $location   = $results['location'];
                $barcode    = $results['barcode'];
                $sku        = $results['sku'];
                $qty        = $results['qty'];
                $user       = $results['user'];
                $updated    = $results['updated'];

                $updated = substr($updated, 0, 10);

                // button to remove row if required:
                $button = "<a class='btn btn-danger btn-sm btn-smaller' href='../pages/stock-take-location.php?action=delete&barcode=$barcode' data-toggle='tooltip' title='Remove item from location'>Remove</a>";


                $table_row = ("
                        <tr>
                            <td>{$location}</td>
                            <td>{$barcode}</td>
                            <td>{$sku}</td>
                            <td>{$qty}</td>
                            <td>{$user}</td>
                            <td>{$updated}</td>
                            <td>$button</td>
        
                        </tr>
                        ");

                echo $table_row;
            }

            $table_footer = (" </tbody>
                    </table>");

            echo $table_footer;
        } else {
            flash('failure', 'Location not found.', 'alert alert-warning');
            redirect("../pages/stock-take-location.php");
            exit();
        }
    }
}

function scanItem($conn)
{

    // Function to add item into location

    // obtain the item code:
    if (isset($_POST['submit'])) {

        // obtain values
        $barcode = $_POST['inputItem'];
        $barcode = parseInput($barcode);

        $qty = $_POST['inputQty'];
        $qty = parseInput($qty);

        // Set Qty to 1 and negatives are not cool.
        if ($qty < 1){
            $qty =1;
        }

        $name = $_SESSION['name'];
        $name = htmlspecialchars($name);
        $location = $_SESSION['location'];
        $location = htmlspecialchars($location);

        // ccheck for valid length
        if (strlen($barcode) < 4) {
            flash('failure', 'Please scan the Product again.', 'alert alert-danger');
            redirect("../pages/stock-take-location.php");
            exit();
        }

        // Store Item in Database:
        $insert_query = $conn->prepare("INSERT INTO inventory (location, barcode, qty, user, created, updated)
                                        VALUES (:location, :barcode, :qty, :user, now(), now() ) ");
        $insert_query->bindParam(':location', $location, PDO::PARAM_STR);
        $insert_query->bindParam(':barcode', $barcode, PDO::PARAM_STR);
        $insert_query->bindParam(':qty', $qty, PDO::PARAM_INT);
        $insert_query->bindParam(':user', $name, PDO::PARAM_STR);
        $insert_query->execute();

        // validate success
        if ($insert_query) {
            flash('success', 'Scanned item added to location.', 'alert alert-success');
            redirect("../pages/stock-take-location.php");
            exit();
        }
    }
}

// Function to return all inventory rows:
function selectInventory($conn)
{

    // query database, obtainin all rows for given location:
    $query = $conn->prepare("SELECT * FROM inventory");
    $query->execute();

    // count rows returned:
    $rowCount = $query->rowCount();

    // validate success
    if ($rowCount === 0) {
        flash('failure', 'No data in the database to export.', 'alert alert-danger');
        redirect("../pages/stock-take.php");
        exit();
    }

    return $query;
}

// Function to cleanse string, keep things safe.
function parseInput($string) {

    // remove any whitespace before / after:
    $cleanString = trim($string);

    // remove any command type characters, prevent SQL injection and XSS
    $cleanString = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

    return $cleanString;
}