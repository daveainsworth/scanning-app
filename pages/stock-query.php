<?php
include_once("../resources/header.php");
include_once("../functions/stock-functions.php");
?>


<div class="container mt-2">
    <?php
    flash('failure');
    flash('success');
    ?>
    <h1>Stock Location Query</h1>

    <form action="../pages/stock-query.php" method="post">
        <div class="form-group">
            <!-- <label for="inputName">Please Entery your name:</label> -->
            <input type="text" class="form-control display-4" id="inputLocation" name="inputLocation" placeholder="Please scan the location..." autofocus>
        </div>
        <div class="button-layout">
            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Confirm</button>
            <a class='btn btn-secondary btn-lg' href='../pages/stock-admin.php'>Go Back</a>
        </div>

    </form>

    <?php
    showProductInLocationQuery($conn);