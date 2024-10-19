<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="status4.css">
    <style>
        .status-slide {
            border-radius: 12px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90%;
            margin-left: 5%
        }

        .status-slide p {
            /* color:green; */
            /* margin-top:-40px; */
            margin-bottom: 0px;
            color: white
        }

        .status-slide img {
            width: 90%;
            margin-left: 5%;
            z-index: 1;
        }

        .status-slide .statustext {
            margin-bottom: 30%;
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            /* overflow: auto; */
            /* flex-wrap: wrap; */
            flex-direction: column;
            max-width:80%;
            word-wrap: break-word;
            margin-top:30%
            
        }
        .status-slide p{
            text-align: center;
        }

        .assd{
            z-index: 9;
        }
        form{
            border:5px solid green
        }
        input{
            bordeR:4px solid red
        }
        
    </style>
</head>

<body>
    <div class="wrapper">
        <a href="users.php">
            <div class="back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                </svg>
            </div>
        </a>
        <h3>Friendify-Messenger</h3>
        <div class="carousel">
            <!-- Images will be dynamically loaded here -->
        </div>
    </div>

    <script src="statusview.js">


    </script>
</body>

</html>