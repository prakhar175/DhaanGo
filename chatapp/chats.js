const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendBtn = form.querySelector("button");
const chatBox = document.getElementById("chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // Prevent form from submitting traditionally
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "insertchat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data); // For debugging purposes

                // Append the new message to the chat box
                const newMessage = document.createElement('div');
                newMessage.classList.add('chat', 'outgoing');
                newMessage.innerHTML = `<div class="details"><p>${inputField.value}</p></div>`;
                chatBox.appendChild(newMessage);

                // Clear the input field after the message is sent
                inputField.value = '';

                // Optionally, scroll to the bottom of the chat box
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = () => {
    chatBox.classList.add("active")
}
chatBox.onmouseleave = () => {
    chatBox.classList.remove("active")
}
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrolltobottom();
                }
            }
        }
    }
    let formData = new FormData(form)
    xhr.send(formData);
}, 500);
function scrolltobottom() {
    chatBox.scrollTop = chatBox.scrollHeight
}



const uploadLabel = document.querySelector(".upload");
const imageInput = document.querySelector(".images");
const cross=document.querySelector(".cross")
uploadLabel.addEventListener("click", () => {
    let svg = uploadLabel.querySelector("svg");
    svg.classList.toggle("rotate");
    imageInput.classList.toggle("display")
});


