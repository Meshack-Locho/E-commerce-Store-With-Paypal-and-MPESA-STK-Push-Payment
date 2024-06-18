let itemsOnCartText = document.getElementById("items-count")
function updateItemCount() {
    fetch("http://localhost:8080/mysite/ec-website/s.php")
     .then(response=>response.text())
     .then(data => {
        itemsOnCartText.textContent = data
     })
}

updateItemCount()