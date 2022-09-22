const header = document.getElementById("header");
const bugerMenu = document.getElementById("burger-menu");
const navLinks = document.getElementById("nav-links");
const bugerIcon = document.getElementById("burger-icon");
const activePage = window.location.pathname;
const searchBar = document.getElementById("search");
const searchInput = document.getElementById("form_search");

const navLinksLi = document.querySelectorAll('.link').forEach(link => {
  if (link.href !== window.location.href) return;
  link.classList.add("active");
});

window.addEventListener("scroll", function () {
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled")
  }
});

bugerMenu.addEventListener("click", () => {
  navLinks.classList.toggle('mobile-menu')
  bugerMenu.classList.toggle('opened');
})

// Search Bar on click
searchBar.addEventListener("click", () => {
searchInput.classList.toggle('active');
searchInput.focus();
})