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
