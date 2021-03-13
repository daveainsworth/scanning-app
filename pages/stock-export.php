<?php
include_once("../resources/header.php");
include_once("../functions/stock-functions.php");
// functionality to generate a file from the data in the databse.

$pathFile = '../data/stock-export.csv';

// check to see if the file already exists:
if(file_exists($pathFile)) {

    // remove the file:
    unlink($pathFile);
}




// create a file:
$fh = fopen($pathFile, 'a');

// write the headers into the file:
fwrite($fh, 'Location,Barcode,User,DateScanned' . "\n");

// Database query to obtain records from Inventory table:
$query = selectInventory($conn);

while ($results = $query->fetch()) {

    
    $location   = $results['location'];
    $barcode    = $results['barcode'];
    $sku        = $results['sku'];
    $user       = $results['user'];
    $updated    = $results['updated'];

    $values = $location . ',' . $barcode . ',' . $user . ',' . $updated . "\n";

    fwrite($fh, $values);

}

fclose($fh);



flash('success', 'Data File Generated.', 'alert alert-success');
redirect("../pages/stock-admin.php");
exit();






