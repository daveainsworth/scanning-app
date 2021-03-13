<?php
include_once("../resources/header.php");
include_once("../functions/admin.php");
?>

    <div class="container mt-2">
    <?php
    flash('failure');
    flash('success');
    ?>
        <form action="../admin/login.php" method="post">
            <div class="form-group">
                <!-- <label for="inputName">Please Entery your name:</label> -->
                <input type="text" class="form-control display-4" id="inputName" name="inputName" placeholder="Enter your name...">
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
        </form>
    </div>


<?php loginUser($conn); ?>


<!-- header("Location: ../pages/stock-take.php");  -->



<?php
include_once("../resources/footer.php");
?>