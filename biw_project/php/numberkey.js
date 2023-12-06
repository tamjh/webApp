const inputQuantity = document.getElementsByClassName("inputQuantity")[0];
const incre = document.getElementsByClassName("q2")[0];
const decre = document.getElementsByClassName("q1")[0];

let quantity = parseInt(inputQuantity.value);

incre.addEventListener("click", function(event){
    event.preventDefault();
    quantity++;
    inputQuantity.value = quantity.toString();
})

decre.addEventListener("click", function(event){
    event.preventDefault();
    if(quantity > 0){
        quantity--;
        inputQuantity.value = quantity.toString();
    }
})

document.addEventListener("keydown", function (event) {
    if (event.key == "ArrowDown" || event.key == "ArrowUp") {
        event.preventDefault();
        event.stopPropagation(); 
    }
});

document.addEventListener("keyup", function (event) {
    if (event.key == "ArrowDown" || event.key == "ArrowUp") {
        event.preventDefault();
        event.stopPropagation(); 
    }
});

inputQuantity.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        quantity = parseInt(inputQuantity.value);
        inputQuantity.value = quantity.toString();
    }
});