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


//DISPLAYING NOTIFICATIONS DOT

fetch('unread-messages.php')// LINK CARRYING THE DATA, I.E THE UNREAD MESSAGES
        .then(response => response.json()) // GIVEN RESPONSE CONVERTED TO JSON
        .then(data => {
            const unreadCount = data //THE DATA
            const notificationDot = document.querySelector('.notification-dot');

            if (unreadCount > 0) {
                notificationDot.classList.remove('hide');
            } else {
                notificationDot.classList.add('hide');
            }
        })
        .catch(error => alert('Error fetching unread messages:', error));

      
