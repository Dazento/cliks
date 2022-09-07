const header = document.getElementById("header");
const bugerMenu = document.getElementById("burger-menu");
const navLinks = document.getElementById("nav-links");
const bugerIcon = document.getElementById("burger-icon");
const activePage = window.location.pathname;


const navLinksLi = document.querySelectorAll('.test').forEach(link => {
  if (link.href.includes(`${activePage}`)) {
    console.log(link);
    link.classList.add("active");
  }
});

window.addEventListener("scroll", function () {
  if (window.screenY >= 0) {
      header.classList.add("scrolled");
  } else {
      header.classList.remove("scrolled")
  }
});

bugerMenu.addEventListener("click", () => {
  navLinks.classList.toggle('mobile-menu')
  bugerMenu.classList.toggle('opened');
})