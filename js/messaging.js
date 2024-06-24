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
                   const messageId = event.target.getAttribute('data-message-id');
                   const messageColor = event.target.getAttribute('data-message-color');
                   console.log(messageId, messageColor)
        
                    // Sending the message ID and color to the server to update the status
                    markAsRead(messageId, messageColor);
               }


        })
})
        
closeMessageBoxBtn.addEventListener("click", ()=>{
    messageDisplay.classList.remove("active")
    setTimeout(()=>{
        window.location.reload(true)
    }, 2000)
})



//MARKING READ MESSAGES AS READ

function markAsRead(messageId, messageColor) {
    // Make an AJAX request to update the message status
    fetch('update_message_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `message_id=${encodeURIComponent(messageId)} & message_color=${encodeURIComponent(messageColor)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(`Message marked as read.`);
            //updating the UI to reflect the read status
            document.querySelector(`[data-message-id='${messageId}']`).classList.add('read');
        } else {
            alert('Error updating message status:', data.message);
        }
    })
    .catch(error => alert('Message Update Request failed', error));
}


fetch('unread-messages.php')// LINK CARRYING THE DATA, I.E THE UNREAD MESSAGES
        .then(response => response.json()) // GIVEN RESPONSE CONVERTED TO JSON
        .then(data => {
            const unreadCount = data //THE DATA
            const notificationDot = document.querySelector('.notification-dot');

            $("#unread-messages").text(`(${data}) Unread`)
            if (unreadCount > 0) {
                notificationDot.classList.remove('hide');
            } else {
                notificationDot.classList.add('hide');
            }
        })
        .catch(error => alert('Error fetching unread messages:', error));

const mobileMenu = document.querySelector(".mobile-menu")
let menuToggle = document.querySelectorAll(".menu-toggle")
const options = document.querySelector(".options")
let submenuToggle = document.querySelectorAll(".submenu-toggle")

for (let i = 0; i < menuToggle.length; i++) {
    menuToggle[i].addEventListener("click", ()=>{
        mobileMenu.classList.toggle("active")
    })
    
}

let itemsOnCartText = document.querySelectorAll(".items-count")
function updateItemCount() {
    fetch("http://localhost:8080/mysite/ec-website/s.php")
     .then(response=>response.text())
     .then(data => {
        for (let i = 0; i < itemsOnCartText.length; i++) {
            itemsOnCartText[i].textContent = data
        }
     })
}

updateItemCount()

for (let i = 0; i < submenuToggle.length; i++) {
    submenuToggle[i].addEventListener("click", ()=>{
        options.classList.toggle("active")
    })
}