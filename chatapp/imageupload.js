document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const imagesFinal = document.getElementById("imagesfinal");
    const uploadButton = document.querySelector(".imagesub");
    const uploadForm = document.getElementById('uploadForm');
    const chatBox = document.getElementById("chat-box");
    const imagesMenu = document.querySelector(".images")
    
    const plussvg=document.querySelector(".upload svg")

    const back=document.querySelector(".backward svg")
    let status = "";

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                imagesFinal.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelector(".cross").addEventListener("click", () => {
        imagesFinal.style.display = "none";
        preview.style.display = 'none';
        preview.src = '';
        imageInput.value = '';
    });

    uploadButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "insertchat.php", true);

        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {


                    // Handle success scenario
                    imagesFinal.style.display = 'none';
                    preview.style.display = 'none';
                    preview.src = '';
                    imageInput.value = '';
                    imagesMenu.classList.toggle("display")
                    plussvg.classList.toggle("rotate")
                    status = "good";
                    scrollToBottom();
                    document.querySelector(".imagesfinal button").addEventListener("click",()=>{
                        document.querySelector(".imagesfinal button span").style.display="block";
                        document.querySelector(".loader").style.display="none"
                    })
                }
            }
        };

        let formData = new FormData(uploadForm);
        xhr.send(formData);
    });

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

back.addEventListener("click",()=>{
    window.location.href="users.php"
})

});