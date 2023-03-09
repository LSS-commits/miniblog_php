/* GLOBAL JS */
let dB = document.body;
let dEl = document.documentElement;

// back to top anchor
let anchor = document.getElementById("backToTopId");
// hamburger nav
let hamburger = document.getElementById("hamburgerId");
let menu = document.getElementById("hamburgerNavId");


// when the user scrolls down 20px from the top of the document, show the anchor and the hamburger
window.onscroll = () => {
    showButtons();
};
showButtons = () => {
    anchor.style.display = (dB.scrollTop > 20 || dEl.scrollTop > 20) ? "block" : "none";
    hamburger.style.display = (dB.scrollTop > 20 || dEl.scrollTop > 20) ? "block" : "none";
    
}


// When the user clicks on the button, scroll to the top of the document
scrollTopFunction = () => {
    dB.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    dEl.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
if (anchor != undefined) {
    anchor.addEventListener("click", scrollTopFunction);
}

// When the user clicks on the icon, toggle navigation (fixed hamburger nav)
toggleNav = () => {
    menu.style.display = (menu.style.display == "block") ? "none" : "block";
}
// FOR TOUCH DEVICES: change opacity of hamburger
changeOpacity = () => {
    hamburger.style.opacity = (hamburger.style.opacity == 1) ? .5 : 1;
}
if (hamburger != undefined) {
    hamburger.addEventListener("click", toggleNav);
    hamburger.addEventListener("touchstart", changeOpacity);
}

// counters (for article actions) => bubbling method
document.addEventListener('click', function (event) {
    if (event.target.dataset.counterup != undefined) { // if attr exists
        event.target.value++;
    }
});
document.addEventListener('click', function (event) {
    if (event.target.dataset.counterdown != undefined) { // if attr exists
        event.target.value--;
    }
});