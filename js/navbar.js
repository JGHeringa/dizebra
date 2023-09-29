function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
// Get the current URL
var currentUrl = window.location.href;
// Select the navbar links (change the selector as needed)
var navbarLinks = document.querySelectorAll('.topnav a');
// Loop through the navbar links and add the "active" class to the current page's link
navbarLinks.forEach(function(link) {
    if (link.href === currentUrl || (currentUrl.endsWith('/') && link.href.endsWith('index.php'))) {
        link.classList.add('active');
    }
});