const toggleBtn = document.getElementById("menuToggle");
const menu = document.getElementById("menu");
const iconOpen = document.getElementById("iconOpen");
const iconClose = document.getElementById("iconClose");

// Toggle menu open/close
toggleBtn.addEventListener("click", () => {
  menu.classList.toggle("hidden");
  iconOpen.classList.toggle("hidden");
  iconClose.classList.toggle("hidden");
});

// Scroll links
const scrollLinks = document.querySelectorAll("[data-scroll]");

scrollLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    e.preventDefault();

    const targetId = link.getAttribute("data-scroll");
    const target = document.getElementById(targetId);

    // Check if device is mobile
    const isMobile = window.innerWidth < 768;

    // Scroll to the section
    if (target) {
      target.scrollIntoView({ 
        behavior: "smooth", 
        block: isMobile ? "start" : "center"
      });
    }

    // Remove active class from all
    scrollLinks.forEach(l => {
      l.classList.remove("text-amber-600");
      l.classList.add("text-gray-700");
    });

    // Add active class to current
    link.classList.add("text-amber-600");
    link.classList.remove("text-gray-700");

    // Close mobile menu
    menu.classList.add("hidden");
    iconOpen.classList.remove("hidden");
    iconClose.classList.add("hidden");
  });
});

// 👇 Remove highlight on manual scroll
let scrollTimeout;
window.addEventListener("scroll", () => {
  clearTimeout(scrollTimeout);
  scrollTimeout = setTimeout(() => {
    scrollLinks.forEach(link => {
      link.classList.remove("text-amber-600");
      link.classList.add("text-gray-700");
    });
  }, 1000); // thoda delay rakhna zaroori hota
});

const swiper = new Swiper(".review-slider", {
  loop: true,
  spaceBetween: 15,
  slidesPerView: 1,
  speed: 600,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1.2,
      spaceBetween: 15,
      centeredSlides: true,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 15,
      centeredSlides: true,
    },
    1200: {
      slidesPerView: 3,
      spaceBetween: 15,
      centeredSlides: false,
    },
    1400: {
      slidesPerView: 4,
      spaceBetween: 15,
      centeredSlides: false,
    },
  },
});

const swiper1 = new Swiper(".team-slider", {
  loop: true,
  spaceBetween: 15,
  slidesPerView: 1,
  speed: 600,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1.2,
      spaceBetween: 15,
      centeredSlides: true,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 15,
      centeredSlides: true,
    },
    1200: {
      slidesPerView: 4,
      spaceBetween: 15,
      centeredSlides: false,
    },
    1400: {
      slidesPerView: 5,
      spaceBetween: 15,
      centeredSlides: false,
    },
  },
});


const swiper2 = new Swiper(".footer-slider", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 1,
  speed: 600,
  effect: "fade",
  fadeEffect: {
    crossFade: true,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
});