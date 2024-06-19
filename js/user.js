let itemsOnCartText = document.getElementById("items-count")
function updateItemCount() {
    fetch("http://localhost:8080/mysite/ec-website/s.php")
     .then(response=>response.text())
     .then(data => {
        itemsOnCartText.textContent = data
     })
}

updateItemCount()

const messagesContainer = document.querySelector(".inbox")
const messageDisplay = document.querySelector(".message-display")
let messageSender = document.querySelector(".message-display h4")
let messageSubject = document.getElementById("subject")
let messageTime = document.querySelector(".message-display h6")
let message = document.querySelector(".message-display p")
let closeMessageBoxBtn = document.querySelector(".close-message")

document.addEventListener("DOMContentLoaded", function() {
   messagesContainer.addEventListener("click", (event)=>{
       if (event.target && event.target.classList.contains('message')) {
           // The clicked element is a child with class 'message'

           messageSender.textContent = event.target.getElementsByTagName('h4')[0].textContent

           messageSubject.textContent = "Subject: " + event.target.getElementsByTagName('h5')[0].textContent

           console.log(event.target.getElementsByTagName('h5')[0].textContent)

           message.textContent = event.target.getElementsByTagName('p')[0].textContent

           messageTime.textContent = "Sent at: " + event.target.getElementsByTagName('h6')[0].textContent

           messageDisplay.classList.add("active")
       }
   })
})

closeMessageBoxBtn.addEventListener("click", ()=>{
   messageDisplay.classList.remove("active")
})
