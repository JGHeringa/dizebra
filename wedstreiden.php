<?php
session_start();
$title = "Wedstreiden";
include_once 'includes/header.php';
?>

<body>
    <?php
    include_once 'includes/navbar.php';
    ?>
    <div class="container">
        <?php
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'comite' || $_SESSION['role'] == 'admin')) {
        ?>
            <div class="formDiv">
                <div class="row">
                    <div class="col-25">
                        <label for="datum">Datum</label>
                    </div>
                    <div class="col-75">
                        <input type="date" id="datum">
                        <input type="hidden" id="zeiler-id" value="<?= $_SESSION['id'] ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <button id="datumOpslaan" class="oplsaanBtn">Toevoegen</button>
                </div>
                <span id="fromNote"></span>
            </div>
        <?php
        }
        ?>
    </div>
    <script src="js/navbar.js"></script>
</body>

</html>