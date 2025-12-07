
const slides = document.querySelectorAll(".slide");
const dotsContainer = document.querySelector(".slider-dots");
let index = 0;

/* ===== Create Dots Dynamically ===== */
slides.forEach((_, i) => {
    let dot = document.createElement("span");
    dot.onclick = () => showSlide(i);
    dotsContainer.appendChild(dot);
});
const dots = dotsContainer.querySelectorAll("span");
dots[0].classList.add("active-dot");

/* ===== Show Slide Function ===== */
function showSlide(i) {
    slides.forEach(s => s.classList.remove("active"));
    dots.forEach(d => d.classList.remove("active-dot"));

    slides[i].classList.add("active");
    dots[i].classList.add("active-dot");

    index = i;
}

/* ===== Auto Slide ===== */
function autoSlide() {
    index = (index + 1) % slides.length;
    showSlide(index);
}
setInterval(autoSlide, 4500); // every 4.5 seconds

/* ===== Arrow Controls ===== */
document.querySelector(".prev").onclick = () => {
    index = (index - 1 + slides.length) % slides.length;
    showSlide(index);
};

document.querySelector(".next").onclick = () => {
    index = (index + 1) % slides.length;
    showSlide(index);
};
