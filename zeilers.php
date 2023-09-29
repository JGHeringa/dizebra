<?php
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to a login page or show an access denied message
    header('Location: ../'); // Redirect to your login page
    exit(); // Make sure to exit to prevent further execution
}
$title = "Zeilers";
include_once 'includes/header.php';
?>

<body>
    <?php
    include_once 'includes/navbar.php';
    ?>
    <div class="container">
        <div class="formDiv">
            <div class="row">
                <div class="col-25">
                    <label for="voornaam">Voornaam</label>
                </div>
                <div class="col-75">
                    <input type="text" id="voornaam" placeholder="Uw voornaam..">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="achternaam">Achternaam</label>
                </div>
                <div class="col-75">
                    <input type="text" id="achternaam" placeholder="Uw achternaam..">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="emailadres">Email adres</label>
                </div>
                <div class="col-75">
                    <input type="email" id="emailadres" placeholder="Uw email adres..">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="role">Role</label>
                </div>
                <div class="col-75">
                    <select id="role">
                        <option value="zeiler">Zeiler</option>
                        <option value="comite">Comite</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <button id="zeilerOpslaan" class="oplsaanBtn">Zeiler Toevoegen</button>
            </div>
            <span id="fromNote"></span>
        </div>
        <table id="zeilers-table">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="zeiler-modal" class="modal">
            <div class="modal-content">
                <h2>Zeiler Details</h2>
                <p><strong>Naam:</strong> <span id="modal-naam"></span></p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>role:</strong> <span id="modal-role"></span></p>
                <p><strong>ID:</strong> <span id="modal-id"></span></p>
                <button id="remove-zeiler">Remove Zeiler</button>
                <button id="close-modal">Close</button>
            </div>
        </div>

        <!-- Modal for displaying Zeiler details -->
        <div id="zeiler-modal" class="modal">
            <div class="modal-content">
                <h2>Zeiler Details</h2>
                <p><strong>Naam:</strong> <span id="modal-naam"></span></p>
                <button id="remove-zeiler">Remove Zeiler</button>
            </div>
        </div>
    </div>
    <script src="js/navbar.js"></script>
    <script src="ajax/zeilers.js"></script>
    <!-- <script src="ajax/newZeiler.js"></script> -->
</body>

</html>