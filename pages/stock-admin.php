<?php
include_once("../resources/header.php");
include_once("../functions/stock-functions.php");
?>


<div class="container mt-2">
    <?php
    flash('failure');
    flash('success');
    ?>
    <h1>Stock Admin</h1>

    <div class="button-admin-layout">
        <a class='btn btn-primary p-3 mb-3' href='../pages/stock-query.php'>Query Location</a>
        <a class='btn btn-primary p-3 mb-3' href='../pages/stock-export.php'>Export Data</a>

        <?php
        // check to see if a file exists:
        if (file_exists('../data/stock-export.csv')) {
            echo "<a class='btn btn-primary p-3 mb-3' href='../pages/file-download.php'>Download data</a>";

        } else {
            echo "<a class='btn btn-primary p-3 mb-3 disabled' href='../pages/file-download.php'>Download data</a>";
        }
        ?>
        <a class='btn btn-primary p-3 mb-3' href='../pages/stock-reset.php'>Reset All</a>
        <a class='btn btn-secondary p-3 mb-3' href='../pages/stock-take.php'>Go Back</a>
    </div>
</div>

<?php scanLocation($conn); ?>



<?php
include_once("../resources/footer.php");
?>