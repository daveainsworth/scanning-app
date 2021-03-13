<?php
// Thaw Production
define("DSN", "mysql:host=localhost;dbname=pmt");
define("USERNAME", "root");
define("PASSWORD", "");

$error_logging = 'full'; // logging level to be reported on front end.

$options = array(PDO::ATTR_PERSISTENT => true);

try {

    $conn = new PDO(DSN, USERNAME, PASSWORD, $options);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "<br> Database connection to PMT Database successful <br>";

} catch (PDOException $ex) {

    if ($error_logging == 'full') {

        echo "A database connection error occurred " . $ex->getMessage();
    } else {

        echo "An error occured.";
    }
}
