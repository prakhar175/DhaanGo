<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendify-Social</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style9.css">
<style>
    .preview {
        border:none;
        border-radius: 0px;
        min-width:100%;
        height:auto;
        max-height:300px;   
         

    }
    .images{
        display: none;
        position: absolute;
        top:50%;
        left:50%;
        transform: translate(-50%, -50%);  
        background-color: #333;
        width:26%;
padding:8px;
z-index: 5;
border-radius: 12px;
border:3px solid grey
    }
    .images button{
        width:100%;
        bordeR:1px solid white;
        margin-top:6%
    }
    .images.active{
        display: block;
    }
    .images .cross{

    }
    .cross{
        margin-lefT:97%;
        font-size:150%;
color:white;
cursor: pointer;
    }
    body{
        transition: background-color 0.6s;
    }
    .faded{
        background-color: rgba(0,0,0,0.4);
    }

    @media screen and (max-width:500px){
        .images{
width:98%
        }
    }
    .circleloader {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
            border: 4px solid #0000;
            border-radius: 50%;
            border-right-color: #25b09b;
            animation: l15 1s infinite linear;
            
        }

        .circleloader::before,
        .circleloader::after {
            content: "";
            grid-area: 1/1;
            margin: 2px;
            border: inherit;
            border-radius: 50%;
            animation: l15 2s infinite;
        }

        .circleloader::after {
            margin: 8px;
            animation-duration: 3s;
        }

        @keyframes l15 {
            100% {
                transform: rotate(1turn)
            }
        }
</style>
</head>

<body>
    <?php
require "session.php";
// echo $_SESSION['unique_id'];
if (isset($_SESSION['unique_id'])){
    header("Location: users.php");
}
else{
    header("Location: index.php");
}
?>
    <div class="wrapper">
        <section class="form signup">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="logo">
                </div>
                <div>Friendify Chats</div>
            </header>
            <div class="links">
                <a href="https://unsensitive-pints.000webhostapp.com/website1/">Friendify-Social</a>
                <a href="https://friendify-posts.000webhostapp.com/post/">Friendify-Posts</a>
            </div>
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label for="first-name">First Name</label>
                        <input type="text" name="fname" id="first-name" placeholder="First name" aria-label="First name" required>
                    </div>
                    <div class="field input">
                        <label for="last-name">Last Name</label>
                        <input type="text" name="lname" id="last-name" placeholder="Last name" aria-label="Last name" required>
                    </div>
                    <div class="field input">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Email address" aria-label="Email address" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" aria-label="Password" required>
                    </div>
                    <div class="field image">
                        <label for="image">Select Image</label>
                        <input type="file" name="image" id="image" aria-label="Select image" accept="image/*" hidden>
                    </div>
                    <div class="images">
                        <div class="cross">&times;</div>
                    <img class="preview" alt="Image Preview" style="display:none    "/>
                    <button class="yes">Proceed</button>
                    
                    </div>
                    <div class="field button">
                        <button type="submit">
                            <span id="buttonText">Continue to chat</span>
                            <div class="loader" style="display:none;"></div>
                            <div class="loadercircle" style="display:none;"></div>
                        </button>
                    </div>
                    <div class="link">Already signed up? <a href="login.php">Login now</a></div>
                </div>
            </form>
        </section>
        <footer>
            Created by Aditya Kurani
        </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const imageInput = document.querySelector(".image input");
            const preview = document.querySelector(".preview");
            const images=document.querySelector(".images")
            imageInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        preview.style.borderRadius="4%"
                        images.classList.toggle("active")
                        document.body.classList.add("faded")
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });

            const form = document.querySelector("form");
            // const continueButton = form.querySelector("button");    
            const errorTxt = document.querySelector(".error-txt");
            const buttonText = document.querySelector("span");
            const loader = document.querySelector(".loader");
            const loaderCircle = document.querySelector(".loadercircle");
            const proceed=document.querySelector(".images button")
            proceed.addEventListener("click",function(){
                images.classList.toggle("active")
            })
            document.querySelector(".cross").addEventListener("click",()=>{
                images.classList.toggle("active")
                document.body.classList.remove("faded")
            })
            form.onsubmit = (e) => {
                e.preventDefault(); // Prevent default form submission behavior

                loaderCircle.style.display = "block";
                buttonText.style.display = "none";

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "signup.php", true);
                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            let data = xhr.responseText;
                            if (data.trim() === "User registered successfully.") {
                                buttonText.style.display = "none";
                                loader.style.display = "block";
                                window.location.href = "users.php"; // Redirect to a success page
                            } else {
                                errorTxt.textContent = data;
                                errorTxt.style.display = "block"; // Display error message
                                loaderCircle.style.display = "none";
                                buttonText.style.display = "block";
                            }
                        }
                    }
                };

                let formData = new FormData(form); // Construct FormData object with form data
                xhr.send(formData); // Send form data to signup.php
            };
        });
    </script>
</body>

</html>
