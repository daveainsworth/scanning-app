<?php
include_once("../resources/header.php");
include_once("../functions/stock-functions.php");
?>


<div class="container mt-2">
    <?php
    flash('failure');
    flash('success');
    ?>
    <form action="../pages/stock-take.php" method="post">
        <div class="form-group">
            <!-- <label for="inputName">Please Entery your name:</label> -->
            <input type="text" class="form-control display-4" id="inputLocation" name="inputLocation" placeholder="Please scan the location..." autofocus>
        </div>
        <div class="button-layout">
            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Confirm</button>
            <a class='btn btn-secondary btn-lg' href='../admin/login.php'>Change Name</a>
        </div>

    </form>
</div>

<?php scanLocation($conn); ?>


<a class='btn btn-outline-danger btn-admin' href='../pages/stock-admin.php'>Admin Functions</a>
<?php
include_once("../resources/footer.php");
?>