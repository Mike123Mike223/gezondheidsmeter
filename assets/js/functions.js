function toggleMenu() {
    var x = document.querySelector(".menu");
    if (window.innerWidth <= 600) { 
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    } else {
        x.style.display = "flex";
    }
}


window.addEventListener('resize', function() {
    var x = document.querySelector(".menu");
    if (window.innerWidth > 600) {
        x.style.display = "flex";
    } else if (x.style.display === "flex") {
        x.style.display = "none"; 
    }
});
