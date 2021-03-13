<?php
include_once("../resources/header.php");
include_once("../functions/stock-functions.php");
?>


<div class="container mt-2">
    <?php
    flash('failure');
    flash('success');
    ?>
    <h1>Location : <?php echo $_SESSION['location']; ?></h1>
    <form action="../pages/stock-take-location.php" method="post">
        <div class="form-group">
            <!-- <label for="inputName">Please Entery your name:</label> -->
            <input type="text" class="form-control display-4" id="inputItem" name="inputItem" placeholder="Please scan the Product..." autofocus>
        </div>
        <div class="button-layout">
            <button type="submit" name="submit" class="btn btn-primary btn-lg">Confirm</button>
            <a class='btn btn-secondary btn-lg' href='../pages/stock-take.php'>Go Back</a>
        </div>
    </form>

    <?php showProductInLocation($conn); ?>
</div>

<?php scanItem($conn); ?>




<?php
include_once("../resources/footer.php");

?>