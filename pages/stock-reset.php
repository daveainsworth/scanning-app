<?php
include_once("../resources/header.php");

// Functionality to clear down the Inventory Database.
$truncate_query = $conn->prepare("DELETE FROM inventory");
$truncate_query->execute();


if ($truncate_query){
    flash('success', 'All data removed from system.', 'alert alert-success');
    redirect("../pages/stock-take.php");
    exit();
}

?>

<p class="red">Something went wrong, best contact IT.</p>