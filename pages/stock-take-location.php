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

        <div class="input-layout">

            <div class="form-group flex-item-1">
                <label for="inputQty">Quantity:</label> 
                <input type="text" class="form-control display-4" id="inputQty" name="inputQty" placeholder="1">
            </div>

            <div class="form-group flex-item-2">
                <label for="inputName">Please scan the Product:</label>
                <input type="text" class="form-control display-4" id="inputItem" name="inputItem" placeholder="Barcode..." autofocus>
            </div>

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