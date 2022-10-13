// Category Switch Var
const keycapsCard = document.getElementById('keycaps-card');
const keycapsBtn = document.getElementById('keycaps-btn');
const switchCard = document.getElementById('switch-card');
const switchBtn = document.getElementById('switch-btn');
const switchBar = document.getElementById('switch-bar');
const keycapsBtnWidth = keycapsBtn.offsetWidth;
const switchBtnWidth = switchBtn.offsetWidth;

// Hero Slider Var
const imgSlider = document.getElementsByClassName('img__slider');
const prev = document.getElementById("prev");
const next = document.getElementById("next");

let step = 0;

let imgNumber = imgSlider.length;

function deleteActive() {
    for (let i = 0; i < imgNumber; i++) {
        imgSlider[i].classList.remove("active");
    }
}

next.addEventListener('click', function () {
    step++;
    if (step >= imgNumber) {
        step = 0;
    }
    deleteActive();
    imgSlider[step].classList.add("active");
})

prev.addEventListener('click', function () {
    step--;
    if (step < 0) {
        step = imgNumber - 1;
    }
    deleteActive();
    imgSlider[step].classList.add("active");
})

setInterval(function () {
    step++;
    if (step >= imgNumber) {
        step = 0;
    }
    deleteActive();
    imgSlider[step].classList.add("active");
}, 6000)

// Category Switch
switchBar.style.width = keycapsBtnWidth + "px";

keycapsBtn.addEventListener('click', () => {
    if (!switchCard.classList.contains("active")) return;
    switchCard.classList.remove("active");
    keycapsCard.classList.add("active");
    switchBar.style.width = keycapsBtnWidth + "px";
    switchBar.style.marginLeft = null;
    keycapsBtn.style.opacity = 1;
    switchBtn.style.opacity = .7;
});

switchBtn.addEventListener('click', () => {
    if (!keycapsCard.classList.contains("active")) return;
    keycapsCard.classList.remove("active");
    switchCard.classList.add("active");
    switchBar.style.width = switchBtnWidth + "px";
    switchBar.style.marginLeft = 'calc(100% - '+switchBtnWidth +'px )'
    switchBtn.style.opacity = 1;
    keycapsBtn.style.opacity = .7;
});