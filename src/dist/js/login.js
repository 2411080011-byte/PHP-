const container = document.getElementById("container");
const button_right = document.getElementById("button-right");
const button_left = document.getElementById("button-left");

button_right.addEventListener('click', ()=>{
    container.classList.toggle("activo");
})

button_left.addEventListener('click', ()=>{
    container.classList.remove("activo");
})
