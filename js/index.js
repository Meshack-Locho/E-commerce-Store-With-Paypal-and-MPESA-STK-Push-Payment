let containerEl = document.querySelector(".container")
let itemsOnCart = 0
let itemsOnCartText = document.getElementById("items-count")
let addToCartForm = document.getElementById("add-to-cart")
let removingItemForm = document.getElementById("remove-items-form")

function updateItemCount() {
    fetch("s.php")
     .then(response=>response.text())
     .then(data => {
        itemsOnCartText.textContent = data
     })
}

updateItemCount()

function preventRel(event) {
    event.preventDefault()
}


addToCartForm.addEventListener("submit", (event)=>{
    event.preventDefault()
    updateItemCount()
})

removingItemForm.onsubmit = function (e) {
    e.preventDefault()
    updateItemCount()
}



