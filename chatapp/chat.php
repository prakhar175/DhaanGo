<?php
// Start the session at the top
require "details.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendify-Social</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="stylemain.css">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style7.css">
    <style>
        .profiledetails.active {
            display: block;
            animation: slide 1.2s ease;
        }

        @keyframes slide {
            from {
                top: 14%;
                opacity: 0.4;
            }

            to {
                top: 40%;
                opacity: 1;
            }
        }

        .profiledetails {
            top: 40%
        }

        @media screen and (max-width:450px) {
            @keyframes slide {
                from {
                    top: 14%;
                }

                to {
                    top: 40%
                }
            }

            .profiledetails {
                top: 27%;
                width: 80%
            }

            .images {
                margin-top: -31%
            }

        }

        .profiledetails {
            top: 40%
        }

        .detail {
            /* color:red; */
            margin-top: 6%
        }

        .statusraec {
            color: Red;
            font-weight: bold;
        }

        .profiledetails img {
            width: 56px;
            height: 55px
        }
        .details{
            margin-left:10%
        }
    </style>
</head>

<body>
    <div class="profiledetails">
        <div class="image1">

            <!-- <div> -->

            <img src="images/<?php echo $userImg; ?>">
            <!-- </div> -->
            <div class="detail">
                <p class="username"><?php echo $username . " " . $last; ?></p>
            </div>
            <div class="cross">&times;</div>

        </div>
        <!-- <br> -->
        <div class="bio">
            <h3>Intro</h3>
            <?php echo $bio ?>
            <hr>
            <hr>
            <hr>
            <p>Hobbies: <?php echo $hobbies; ?></p>
            <p>Movies: <?php echo $movies; ?> </p>
            <p>Music: <?php echo $music; ?></p>
            <p>TV Shows: <?php echo $tvshows; ?> </p>
            <p>Books: <?php echo $book ?></p>
        </div>
    </div>
    <div class="wrapper">

        <section class="chat-area">
            <header>
                <div class="content">
                    <div class="backward">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" fill="currentColor"
                            class="bi bi-arrow-left-short" viewBox="0 0 16 16" role="button" aria-label="Go back">
                            <path fill-rule="evenodd"
                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                        </svg>
                    </div>

                    <div class="profileimage">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                        </svg>

                    </div>

                    <div class="details">
                        <span><?php echo htmlspecialchars($username); ?></span>
                        <p class="status"><?php echo htmlspecialchars($status); ?></p>
                        <div class="incoming-id" style="display:none;">
                            <?php echo htmlspecialchars($_GET['incoming_id']); ?>
                        </div>

                    </div>
                    <div class="profile">
                        <p>Profile</p>
                    </div>

                </div>
            </header>

            <div class="chat-box" id="chat-box">
                <!-- Messages will be loaded here via JavaScript -->
            </div>
            <form class="typing-area" id="messageForm">
                <input type="hidden" name="outgoing_id" value="<?php echo htmlspecialchars($_SESSION['unique_id']); ?>">
                <input type="hidden" name="incoming_id" value="<?php echo htmlspecialchars($_GET['incoming_id']); ?>">
                <div class="upload" id="uploadButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" class="bi bi-plus-lg"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"
                            stroke-width="2" />
                    </svg>
                </div>
                <div class="images" id="imagesMenu">
                    <label for="image">
                        <div id="photosVideos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                <path
                                    d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                            </svg>
                            Photos and Videos
                        </div>
                    </label>
                </div>
                <input type="text" name="text" class="input-field" placeholder="Message..." required>
                <button type="submit" class="submit">Send

                </button>
            </form>
        </section>

        <div class="imagesfinal" id="imagesfinal" style="display:none;">
            <div class="cross">&times;</div>
            <form method="post" enctype="multipart/form-data" id="uploadForm">
                <input type="file" name="image" id="image" hidden>
                <img id="preview" src="" alt="Image Preview" style="width: 100%; display:none;">
                <br>
                <input type="text" value="<?php echo htmlspecialchars($_GET['incoming_id']); ?>" name="incoming_id"
                    hidden>
                <button type="button" class="imagesub">
                    <span>Send</span>
                    <div class="loader"></div>
                </button>
            </form>
        </div>
    </div>

    <div id="error" style="display:none;color: red;"></div>


    <script src="chats.js"></script>
    <script src="imageupload.js">

    </script>
    <script>

        const statusMain = document.querySelector(".details .status");
        const incomingIdElement = document.querySelector(".details .incoming-id").textContent.trim();

        setInterval(() => {


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.responseText.trim(); // Trimming the response to remove unwanted whitespace
                        statusMain.textContent = data; // Update the status text
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };

            xhr.onerror = () => {
                console.error("Request failed");
            };

            xhr.send("incoming_id=" + encodeURIComponent(incomingIdElement));

        }, 3000)
        // Update status immediately when the page loads
        // updateStatus();

        // Set an interval to update the status every 5 seconds (5000 milliseconds)
        // setInterval(updateStatus(), 5000);

        document.querySelector(".imagesfinal button").addEventListener("click", () => {
            document.querySelector(".imagesfinal button span").style.display = "none";
            document.querySelector(".loader").style.display = "block"
        })
    </script>
    <script>
        const profileimage = document.querySelector(".profile")
        profileimage.addEventListener("click", () => {
            document.querySelector(".profiledetails").classList.toggle("active")
        })
        document.querySelector(".cross").addEventListener("click", () => {
            document.querySelector(".profiledetails").classList.remove("active")
        })
    </script>
</body>

</html>