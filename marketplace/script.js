/*===== MENU SHOW =====*/
const showMenu = (toggleId, navId) => {
  const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId);

  if (toggle && nav) {
      toggle.addEventListener("click", () => {
          nav.classList.toggle("show");
      });
  }
};

showMenu("nav-toggle", "nav-menu");

/*===== REMOVE MENU =====*/
const navLink = document.querySelectorAll(".nav__link"),
    navMenu = document.getElementById("nav-menu");

function linkAction() {
  navMenu.classList.remove("show");
}

navLink.forEach(n => n.addEventListener("click", linkAction));

/*===== SCROLL SECTIONS ACTIVE LINK =====*/
const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", scrollActive);

function scrollActive() {
  const scrollY = window.pageYOffset;

  sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 50;
      const sectionId = current.getAttribute("id");

      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
          document.querySelector(".nav__menu a[href*=" + sectionId + "]").classList.add("active");
      } else {
          document.querySelector(".nav__menu a[href*=" + sectionId + "]").classList.remove("active");
      }
  });
}

/*===== CHANGE COLOR HEADER =====*/
window.onscroll = () => {
  const nav = document.getElementById("header");
  if (window.scrollY >= 200) nav.classList.add("scroll-header");
  else nav.classList.remove("scroll-header");
};

/*===== CART FUNCTIONALITY =====*/
let cart = [];
let total = 0;

function updateCart() {
  const cartItemsContainer = document.querySelector('.cart-items');
  const cartTotal = document.querySelector('.cart-total');
  cartItemsContainer.innerHTML = '';

  cart.forEach(item => {
      const itemElement = document.createElement('div');
      itemElement.textContent = `${item.name} - Rs. ${item.price}`;
      cartItemsContainer.appendChild(itemElement);
  });

  cartTotal.textContent = `Total: Rs. ${total}`;
}

function addToCart(event) {
  event.preventDefault();
  const button = event.target.closest('.add-to-cart');
  const name = button.getAttribute('data-name');
  const price = parseInt(button.getAttribute('data-price'));

  cart.push({ name, price });
  total += price;

  updateCart();
  document.querySelector('.cart-count').textContent = cart.length;
}

const addToCartButtons = document.querySelectorAll('.add-to-cart');
addToCartButtons.forEach(button => {
  button.addEventListener('click', addToCart);
});

function toggleCart() {
  const cartModal = document.querySelector('.cart-modal');
  cartModal.classList.toggle('show');
}
function toggleCart() {
  const cartModal = document.querySelector('.cart-modal');
  cartModal.classList.toggle('show');
}


document.querySelector('.cart-icon').addEventListener('click', toggleCart);
