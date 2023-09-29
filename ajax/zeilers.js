// Function to show the modal with Zeiler details
$(document).ready(function(){
    $("#zeilerOpslaan").click(function(){
        var voornaam = $("#voornaam").val();
        var achternaam = $("#achternaam").val();
        var emailadres = $("#emailadres").val();
        var role = $("#role").val();
        if (!voornaam || !achternaam || !emailadres || !role){
            alert("Niet alles is ingevuld")
        } else {
            console.log("adding new user");
            $.post("php/newZeiler.php",
            {
            voornaam: voornaam,
            achternaam: achternaam,
            emailadres: emailadres,
            role: role
            },
            function(data,status){
                console.log(status);
                $("#fromNote").text(data);
                $("#voornaam").val("");
                $("#achternaam").val("");
                $("#emailadres").val("");
                $("#role").val("zeiler");
                reloadZeilers();
            });
        }
        
        setTimeout(function() {
            // Your code to execute after 8 seconds goes here
            $("#fromNote").text("");
        }, 5000);
    });
});

function showDetails(zeiler) {
    var modal = document.getElementById('zeiler-modal');
    var naamSpan = document.getElementById('modal-naam');
    var emailSpan = document.getElementById('modal-email');
    var roleSpan = document.getElementById('modal-role');
    var idSpan = document.getElementById('modal-id');

    naamSpan.textContent = zeiler.voornaam + ' ' + zeiler.achternaam;
    emailSpan.textContent = zeiler.email;
    roleSpan.textContent = zeiler.role;
    idSpan.textContent = zeiler.id;

    modal.style.display = 'block';

    // Add click event listener to the "Remove Zeiler" button in the modal
    var removeButton = document.getElementById('remove-zeiler');
    removeButton.addEventListener('click', function () {
        // Handle the removal of the Zeiler here (e.g., call a function to remove it)
        modal.style.display = 'none';
        if (confirm('Zeker dat u ' + zeiler.voornaam + ' ' + zeiler.achternaam + ' wilt verwijderen?')) {
            $.post("php/removeZeiler.php",
            {
            id: zeiler.id,
            achternaam: zeiler.achternaam
            },
            function(data,status){
                console.log(data);
                console.log(status);
                if (data == 500){
                    alert(zeiler.voornaam + " " + zeiler.achternaam + " kan niet verwijderd worden.");
                }
                reloadZeilers();
            });
        } else {
            console.log("You pressed Cancel!");
        }
    });

    // Add click event listener to the "Close" button in the modal
    var closeButton = document.getElementById('close-modal');
    closeButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });
}

function reloadZeilers() {
    // Create an AJAX request to fetch the Zeilers data
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/loadZeilers.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var zeilers = JSON.parse(xhr.responseText);
            var zeilersTableBody = document.querySelector('#zeilers-table tbody');

            // Clear the current table content
            zeilersTableBody.innerHTML = '';

            // Populate the table with Zeilers data
            zeilers.forEach(function (zeiler) {
                var row = document.createElement('tr');
                row.id = zeiler.id;

                var naamCell = document.createElement('td');
                var actionCell = document.createElement('td');

                naamCell.textContent = zeiler.voornaam + " " + zeiler.achternaam;

                var detailsButton = document.createElement('button');
                detailsButton.textContent = 'Details';

                detailsButton.addEventListener('click', function () {
                    showDetails(zeiler);
                });

                actionCell.appendChild(detailsButton);

                row.appendChild(naamCell);
                row.appendChild(actionCell);

                zeilersTableBody.appendChild(row);
            });
        }
    };

    // Send the AJAX request
    xhr.send();
}

// Call the reloadZeilers function when the document is ready
document.addEventListener('DOMContentLoaded', function () {
    reloadZeilers();
});