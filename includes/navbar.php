<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="wedstreiden.php">wedstreiden</a>
    <?php
    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'comite' || $_SESSION['role'] == 'admin')) {
    ?>
        <a href="zeilers.php">Zeiler</a>
    <?php
    }
    if (isset($_SESSION["id"])) {
    ?>
        <a href="php/logout.php">Loguit</a>
    <?php
    }
    ?>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>