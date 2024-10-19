<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendify-Social</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.png" type="image/x-icon">

    <Style>
        .links {
            color: grey;
            font-weight: 600;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 100%;
            color: black;
            gap: 10%;
            display: flex;

        }

        .links a {
            color: gray;
            text-decoration: underline;

        }

        .loader {
            --w: 10ch;
            font-weight: bold;
            font-family: monospace;
            font-size: 30px;
            line-height: 1.2em;
            letter-spacing: var(--w);
            width: var(--w);
            overflow: hidden;
            white-space: nowrap;
            color: white;
            animation: l17 2s infinite;
            font-size: 100%
        }

        .loader:before {
            content: "Loading...";
        }

        @keyframes l17 {
            0% {
                text-shadow:
                    calc(0*var(--w)) -1.2em white, calc(-1*var(--w)) -1.2em white, calc(-2*var(--w)) -1.2em white, calc(-3*var(--w)) -1.2em white, calc(-4*var(--w)) -1.2em white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            4% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) -1.2em white, calc(-2*var(--w)) -1.2em white, calc(-3*var(--w)) -1.2em white, calc(-4*var(--w)) -1.2em white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            8% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) -1.2em white, calc(-3*var(--w)) -1.2em white, calc(-4*var(--w)) -1.2em white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            12% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) -1.2em white, calc(-4*var(--w)) -1.2em white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            16% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) -1.2em white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            20% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) -1.2em white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            24% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) -1.2em white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            28% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) -1.2em white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            32% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 0 white, calc(-8*var(--w)) -1.2em white, calc(-9*var(--w)) -1.2em white
            }

            36% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 0 white, calc(-8*var(--w)) 0 white, calc(-9*var(--w)) -1.2em white
            }

            40%,
            60% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 0 white, calc(-8*var(--w)) 0 white, calc(-9*var(--w)) 0 white
            }

            64% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 0 white, calc(-8*var(--w)) 0 white, calc(-9*var(--w)) 1.2em white
            }

            68% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 0 white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            72% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 0 white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            76% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 0 white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            80% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 0 white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            84% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 0 white, calc(-4*var(--w)) 1.2em white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            88% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 0 white, calc(-3*var(--w)) 1.2em white, calc(-4*var(--w)) 1.2em white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            92% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 0 white, calc(-2*var(--w)) 1.2em white, calc(-3*var(--w)) 1.2em white, calc(-4*var(--w)) 1.2em white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            96% {
                text-shadow:
                    calc(0*var(--w)) 0 white, calc(-1*var(--w)) 1.2em white, calc(-2*var(--w)) 1.2em white, calc(-3*var(--w)) 1.2em white, calc(-4*var(--w)) 1.2em white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }

            100% {
                text-shadow:
                    calc(0*var(--w)) 1.2em white, calc(-1*var(--w)) 1.2em white, calc(-2*var(--w)) 1.2em white, calc(-3*var(--w)) 1.2em white, calc(-4*var(--w)) 1.2em white,
                    calc(-5*var(--w)) 1.2em white, calc(-6*var(--w)) 1.2em white, calc(-7*var(--w)) 1.2em white, calc(-8*var(--w)) 1.2em white, calc(-9*var(--w)) 1.2em white
            }
        }

        .loader {
            display: none;
            margin-left: 40%;
            font-size: 20px;
        }

        .loader.display {
            display: block;

        }

        button {
            color: white;
            background-color: #333;
            border: 1px solid grey;
            padding: 12px;
            font-weight: bold;
            border-radius: 12px;
            font-size: 90%;
            cursor: pointer;
        }

        .logo img {
            /* border:4px solid blue; */
            height: 80px;
            width: 79px;
            border-radius: 12px
        }

        header {
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
            gap: 30px;
        }

        footer {
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
            font-weight: 700;
            margin-top: -4%
        }

        /* HTML: <div class="loader"></div> */
        .circleloader {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
            border: 4px solid #0000;
            border-radius: 50%;
            border-right-color: #25b09b;
            animation: l15 1s infinite linear;
            display: none;
            
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
        button{
            display: flex;
            justify-content: center;
            text-align:center;
            align-items:center
        }
    </Style>
</head>

<body>
    <div class="wrapper">
        <section class="form login">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="logo">
                </div>
                <div>
                    Friendify Chats
                </div>
            </header>
            <div class="links">
                <a href="https://unsensitive-pints.000webhostapp.com/website1/">Friendify-Social</a>
                <a href="https://friendify-posts.000webhostapp.com/post/">Friendify-Posts</a>
            </div>
            <form action="loginback.php" method="post">
                <div class="error-txt"></div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password...">
                </div>
                <div class="field button">
                    <button>
                        <span>Continue to chat</span>
                        <div class="loader"></div>
                        <div class="circleloader"></div>
                    </button>
                    <!-- <button type="submit">continue to chat</button> -->
                </div>
            </form>
            <div class="link">Not yet signed up > <a href="index.php">Sign Up now</a></div>
        </section>
        <footer>
            Created by Aditya Kurani
        </footer>
    </div>

    <script>
        const form = document.querySelector("form");
        const continueButton = form.querySelector("button");
        const errorTxt = document.querySelector(".error-txt");
        const buttontext = continueButton.querySelector("span")
        const loader = continueButton.querySelector("div")
        const circleloader=document.querySelector(".circleloader")
        form.onsubmit = (e) => {
            e.preventDefault(); // Prevent default form submission behavior
        };
        continueButton.onclick = () => {
            // document.body.style.backgroundColor="red"
            circleloader.style.display="block";
            buttontext.style.display="none"
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "loginback.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data.trim() === "success") {
                            buttontext.style.display = "none"
                            loader.style.display = "block"
                            window.location.href = "users.php";
                        } else {
                            errorTxt.textContent = data;
                            errorTxt.style.display = "block"; // Fix typo here
                            circleloader.style.display="none";
                            buttontext.style.display="block"
                        }
                    }
                }
            };

            // Construct FormData object with form data
            let formData = new FormData(form);

            xhr.send(formData); // Send form data to loginback.php
        };


    </script>
</body>

</html>