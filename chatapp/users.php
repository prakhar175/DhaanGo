<?php
require "detailsusers.php";
require "dbh.inc.php";
// session_start();

// Fetch the "last seen" status from the database
$lastSeenStatus = false; // Default value
$unique_id = $_SESSION['unique_id']; // Assuming the user ID is stored in the session

$query = "SELECT lastse FROM users_main WHERE unique_id = :unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":unique_id", $unique_id);
$stmt->execute();
// echo $unique_id;
$resultsta = $stmt->fetch();
$lastseen =0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="usersmain.css">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="users2.css">
    <link rel="stylesheet" href="statususers9.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <style>
        .previewimage img {
            width: 190px;
            height: 200px;
            border-radius: 10px;
        }

        input[type="file"] {
            display: none;
        }

        #statusmessage {
            display: none;
        }

        #statusmessage.display {
            display: block;
            background-color: #333;
            color: white;
            padding: 8px;
            border-radius: 8px;
            font-weight: 700;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border: 1px solid whitesmoke;
        }

        .previewimage::placeholder {
            opacity: 0.7;
            color: white;
        }

        .previewimage {
            display: flex;
            flex-direction: row;
            gap: 3px;
            /* border:1px solid blue */
        }

        .previewimage form {
            margin-top: 30%;
        }

        .previewimage button {
            margin-top: 20px;
            padding: 6px
        }

        .previewimage img {
            border: 3px solid grey
        }

        .previewimage {
            display: none;
        }

        .previewimage.active {
            display: block
        }

        .userimagesstatus {
            bordeR: 1px solid blue
        }

        .otherstatus {
            margin-left: auto
        }

        .otherstatus img {
            margin-left: 10px;
            padding: 3px;
            border: 3px solid green
        }

        .userimage {
            border-right: 2px solid #666
        }

        .statusview {
            border: 2px solid white;
            height: 60%
        }

        .otherstatus {
            /* border:2px solid red; */
            margin-left: 0%;
            width: auto;
            /* overflow: auto; */
        }

        .otherstatus ::-webkit-scrollbar {
            width: 100px;
        }

        /* ::webkit-scrollbar  */
        .status-container {
            /* max-height: 200px; Adjust the max height as needed */
            overflow-x: auto;
            /* border: 1px solid blue; Optional: Add a border to make it look nicer */
            padding: 0px;
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            height: 100px;
            /* width:1000px; */
            min-width: 280px;
            margin-top: -20px;
            /* border:1px solid green; */
            margin-left: -7px;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        .status-container img {
            display: block;
            margin: 10px 0;
            margin-left: 7px
        }

        .current-user img {
            margin-top: -0px;
            margin-left: -12px;
            border: 2px solid lightgreen;
            /* Optional: Different styling for current user */
        }

        .previewimage {
            /* border:3px solid red; */
            background-color: #333;
            width: 100%;
            position: absolute;
            top: 50%;
            /* height:570px; */
            left: 50%;
            transform: translate(-50%, -49%);
            border-radius: 12px;
            padding: 12px
        }

        .previewimage img {
            width: 100%;
            height: 70%;
            min-height: 40%;
            max-height: 70%;
            /* margin-top:30px; */
            /* bordeR:2px solid green */
        }

        .previewimage form {
            /* bordeR:2px solid blue; */
            margin-top: 0%;
            z-index: 5;
        }

        form input {
            width: 80%;
            margin-left: 10%;
        }

        .previewimage form button {
            width: 40%;
            margin-left: 29%;
            z-index: 2;
            /* border:1px solid blue */
        }

        .previewimage .cro {
            /* margin-top:-116%; */
            z-index: 7;
            position: relative;
            top: 0%;
            left: 0%;
            fill: white;
            stroke: white;
            /* bordeR:1px solid red; */

        }

        .icon {
            /* bordeR:1px solid red; */
            margin-left: auto;
        }

        .previewimage div {
            /* bordeR:1px solid green */
        }

        button[type="reset"] {
            display: block;
            background-color: red;
        }

        button[type="submit"] {
            background-color: #4ccb5a;
        }

        .previewimage .cross {
            display: none;
        }

        .previewimage .cross.active {
            display: block;
        }

        .status-container {
            /* border:3px solid blue; */
            width: 200px;
            height: 160px;
            font-size: 80%;
            margin-top: -19px;
            font-weight: 600;
        }

        .status-container::webkit-scrollbar {
            width: 10px
        }

        .status-container a {
            color: white;
        }

        .status-container p {
            margin-top: -7px;
            margin-left: 8px
        }

        .current-user {
            margin-top: 0px;
        }

        @media screen and (max-width:450px) {
            .statusview {
                height: 40%
            }
        }

        .statusinfo {
            width: 80%;
            font-weight: bold;
            font-size: 110%;
            opacity: 0.6;
            ;
            margin-top: 10%;
            padding: 23px
        }

        .note svg {
            /* border:1px solid red; */
            margin-left: 0%;
            /* margin-top:-20%;/ */
            height: 20px;
            height: 20px;

        }

        .note {
            margin-top: -20%;
            background-color: #555;
            border: 1px solid grey;
            border-radius: 12px;
            width: 10%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 90%;
            padding: 3px;
            height: 42px;
            cursor: pointer;
        }

        .statusnote {
            display: none
        }

        .statusnote.active {
            display: block;
            width: 26%;
            margin-left: 35%;
            
            height: 500px;
            /* background-color: #333; */
            position: absolute;
            top: 50%;
            left: 15%;
            transform: translate(-50%, -49%);
            border-radius: 17px;
        }

        .statusnote .cross {
            margin-left: 4%;

            color: white;
            width: 20px;
            height: 12px;
            font-size: 32px;
            cursor: pointer;
        }

        .statusnote svg {
            color: white;
            fill: white;
            stroke: white;
            stroke-width: 0px;
            width: 20px;
            height: 23px;
            /* margin-left:86%; */
            margin-top: 9%
        }

        .statusnote .icon {
            display: flex;
            flex-direction: row;
        }

        .statusnote .colorchange {
            margin-left: 84%;
            /* bordeR:1px solid red; */
            margin-top: 2.7%;
            cursor: pointer;
        }

        .statusnote textarea {
            background-color: transparent;
            display: block;
            margin-top: 40%;
            bordeR: none;
            padding: 8px;
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            border-radius: 12px;
            overflow-wrap: break-word;
            resize: none;
            box-sizing: border-box;
            height: 30%;
            width: 89%;
            margin-left: 5%;
            max-width: 88%;
            font-size: 120%;
        }

        /*  */
        /* } */
        .statusnote :: ::placeholder {

            color: white;

        }

        .statusnote button {
            margin-top: auto;
            width: 40%;
            margin-lefT: 29%;
            border-radius: 12px;
            border: none;
            height: 10%;
            padding: 10px;
            font-weight: bold;
            cursor: pointer;
            color: white
        }

        .statusnote form {
            margin-top: -20%;
        }

        .statusnote .error {
            color: red;
            width: 60%;
            margin-left: 18%;
            font-weight: bold;
            font-size: 100%;
            margin-top: 14%;
            /* border:1px solid red; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .updateinfo input {
            margin-left: 0%
        }

        .del button {
            background-color: red;
        }

        .statusnote {
            /* border:1px solid blue; */
            width: 120%
        }

        @media screen and (max-width:450px) {
            .statusnote.active {
                /* border:1px solid red; */
                width: 90%;
                /* min-height:500px     */
            }
        }

        .statusphone {
            /* bordeR:1px solid red; */
            margin-lefT: -7%;
            /* border-r */
        }

        .statusphone p {
            color: grey;
            margin-left: 4px
        }

        .content {
            /* border:1px solid blue; */
            width: 120%
        }

        body {}

        .statusinfo a {
            color: grey;
            text-decoration: underline;
        }

        /* .settingsdispl */
        .photo svg {
            margin-left: -26%;
            fill: white;
            stroke: white;
            stroke-width: 0.7px;
            cursor: pointer;
        }

        .editbox {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 1px solid white;
            background-color: #333;
            padding: 10px;
            border-radius: 16px;
            display: none;
            color: white;
            font-weight: 800;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            width: 18%;
            z-index: 10;
        }

        .editbox input {
            display: none;
        }

        .editbox button {
            width: 40%;
            margin-left: 30%;
            bordeR: none;
            color: white;
            font-weight: 700;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 6px;
            border-radius: 15px;
            margin-top: 10px;
            cursor: pointer;
            ;
        }


        .editbox .option {
            display: flex;
            flex-direction: row;
            justify-content: center;
            text-align: center;
            align-items: center;
            gap: 10%;


        }

        .option div {
            /* border:2px solid red; */
            /* margin-left: auto; */
        }

        .editbox img {
            width: 60px;
            height: 60px;
            border-radius: 48%;
        }

        .editbox .cross {
            margin-left: 96%;
            font-size: 120%;
            font-weight: 700;
            cursor: pointer;
        }

        .editbox.active {
            display: block;
        }

        @media screen and (max-width:450px) {
            .editbox {
                width: 70%;
            }

            .editbox .active {
                display: block;
                /* z-index: 99; */
                /* width:100% */
            }

        }

        .option .changed {
            height: 60px;
            width: 60px;
            border-radius: 47%;
            background-color: #333;
            border: 1px solid grey;
            /* background-image: url('newpic.png');
                background-position: center;
                background-repeat: no-repeat;
                display: flex;
                justify-content: center;
                align-items: center;
                background-size: cover; */
        }

        .content {
            /* margin-top:-20px; */
            /* border:1px solid red; */
            width: 120%;
            height: 60px;
            cursor: pointer;
            min-width: 105%;
        }
.content img{
    padding:1px;
    bordeR:2px solid grey;
    min-width:50px;
    min-height: 48px;
}


        .content .details {
            /* border:1px solid blue */
        }

        .content .details .mess {
            color: grey
        }

        .statusphone {
            margin-left: -10px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            /* gap:0px; */
            /* position: fixed; */
            /* left:10% */
        }

        .profilepi {
            width: 40px;
            height: 42px;
            bordeR: 5px solid grey;
            padding: 6px
        }

        .info1 img {
            border: 2px solid grey;
            height: 58px;
            width: 58px;
            padding: 2px
        }
        .profilesearch{
            /* border:3px solid green; */
            background-color: ;
            padding:0px;
            min-width:104%;
            height:53px;
            border-radius: 12px;
color:grey;
        }
        .profilesearch:hover{
            background-color: rgba(0,0,0,0.1);
        }
        .profilesearch img{
            margin-top:1.5%;
            height:70px;
            width:64px;
            border:2px solid grey;
            margin-left:2%;
            /* padding:2px; */
            /* margin-top: */
        }
        .profilesearch .contentsearch{
            /* margin-top:-20%; */
            /* bordeR:3px solid red; */
           
            margin-top:-50px;
        }
        .profilesearch .status{
            border:2px solid green;
            margin-left:80%;
            width:40px;
            margin-top:-70px;
            background-color: transparent;
        }
        .profilesearch span{
            color:black;
            margin-left:15%;
            margin-top:-20%;
            font-weight: 300;
        }
        .profilesearch .message
        {
        /*bordeR:1px solid red; */
            margin-left:15%;
            display: flex;
            flex-direction: row;
            gap:2%
        }
        .profilesearch .status
        {
            /* bordeR:1px solid green; */
            /* margin-left:0%; */
            margin-top:-40px;
            padding:1px
        }
        .profilesearch .status .online{
            background-color: green;
            
/* border:3px solid blue; */
width: 10px;
        height: 10px;
        }
        .profilesearch .status p{
            font-weight: bold;
            font-size: 70%;
            color:grey
        }
        .profilesearch p {
            font-size: 90%;
        }
        .profilesearch .statusphone{
            /* border:1px solid red; */
            width:20%;
            margin-left:80%;
            display: flex;
margin-top:-10%;
flex-direction: column;   
justify-content: center;
align-items:center;
text-align:center     }
.profilesearch .statusphone .online,.profilesearch .statusphone .offline{
    margin-left:8.7%
}
@media screen and (max-width:450px){
    .statusview{
        /* border:3px solid red; */
        height:400px
    }
}
.statusphone{   
    /* border:3px solid blue; */
    margin-left:-30px;
}
.statusphone .offline,.online{
    margin-left:10px
}
.statusview{
    /* border:3px solid blue */
}
.heading{
/* bordeR:1px solid red; */
display: flex;
min-width:280px;
align-items: center;
text-align: center;
justify-content: center;
}
.commitee a {
    color:black;
    font-weight:600;
    font-size: 18px;
    padding:10px
}
.heading{
    font-weight: bold;
    font-size: 20px;
    color:grey;
    text-decoration: underline;
}
svg{
    width:20px
}
.info1 svg{
    width:30px;
    height:30px;
    margin-top:13px
}
    </style>
</head>

<body>
    <div class="updateinfo">
        <div class="cross">
            Update and share your bio
            <div>&times;</div>
        </div>
        <form action="bioupdate.php" method="post">
            <input type="text" name="bio" placeholder="Update your bio">
            <input type="text" name="hobbies" placeholder="Enter a hobby">
            <input type="text" name="movies" placeholder="Enter movies you love">
            <input type="text" name="music" placeholder="Enter music you like to listen">
            <input type="text" name="tvshows" placeholder="Enter TV Shows you like">
            <input type="text" name="book" placeholder="Enter the books you like to read">
            <br>
            <button type="submit">Share</button>
        </form>
    </div>

    <div class="wrapper">
        <a href="../" class="heading">DhaanGo</a>
        <div class="profiledetails">
            <!-- <div class="cross">
                <h2>Friendify</h2>
                &times;
            </div> -->
            <div class="users">
                <div class="photo">
                    <img src="images/<?php echo htmlspecialchars($userphoto); ?>" alt="" class="profilepi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil" viewBox="0 0 16 16">
                        <path
                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                    </svg>
                </div>
                <div class="name">
                    <p><?php echo htmlspecialchars($username) . " " . htmlspecialchars($last); ?></p>
                </div>
            </div>
            <div class="bio">
                <div class="editinfo">
                    <h1>Intro</h1>
                    <button>Edit bio</button>
                </div>
                <p><?php echo htmlspecialchars($bio); ?></p>
                <hr>
                <p>Hobbies: <?php echo $hobbies; ?></p>
                <p>Movies: <?php echo $movies; ?> </p>
                <p>Music: <?php echo $music; ?></p>
                <p>TV Shows: <?php echo $tvshows; ?> </p>
                <p>Books: <?php echo $book ?></p>
            </div>
        </div>

        <section class="form signup">
            <header>
                <div class="content1">
                    <div class="details1">
                        <!-- <div class="heading">
                            <img src="logo.png" alt="">
                            <h1>Friendify-Messenger</h1>
                        </div> -->
                        <div class="info1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                            <span class="username"><?php echo htmlspecialchars($username); ?></span>
                        </div>
                    </div>

                    <div class="logoutsetting">
                        <!-- <button class="logout-button">Logout</button> -->
                        <div class="setting">
                            <!-- <div class="profile">
                                <p>Profile</p>
                            </div> -->
                            <!-- <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                    class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                </svg>
                            </div> -->
                        </div>
                    </div>
                </div>
            </header>
<div class="commitee">
    <a href="commitee">
    Chat with your commiunity
    </a>
</div>
            <div class="search">
                <input type="text" name="searchTerm" placeholder="Enter name to search ...">
                <button>Search</button>
            </div>
            <div class="users-list">
                <!-- Dynamic content will be loaded here -->
            </div>
            <!-- <div class="status">
                <div class="chat">Chats</div>
                <div class="stories">Status</div>
            </div> -->
        </section>

        <div class="logout">
            <p>Stay and talk... but if you want you can go </p>
            <button class="stay">Stay</button>
            <a
                href="logout.php?user_id=<?php echo htmlspecialchars($_SESSION['unique_id']); ?>"><button>Logout</button></a>
        </div>

        <div class="statusview">
            <div class="cro">&times;</div>
            <header>
                <h3>Updates</h3>
                <div class="icon">

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path
                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                        </svg>
                    </div>

                </div>

            </header>

            Status
            <div class="status">
                <div class="userimage">
                    <label for="status">
                        <img src="images/<?php echo $userphoto ?>" id="currentStatusImage">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                    </label>
                </div>
                <div class="otherstatus">
                    <!-- Other people's status -->
                </div>

            </div>
            <div class="statusinfo">
                Share stories with your friends and react to the other's stories
                <br>
                <!-- Try out our feeds app: -->
                <a href="https://friendify-posts.000webhostapp.com/post/">Try Post app<a>
                        <br>
                        <a href="https://unsensitive-pints.000webhostapp.com/website1/
">Try Social site</a>

            </div>
            <div class="note">
                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="23" fill="currentColor"
                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path
                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                </svg>
            </div>
            <div class="previewimage">
                <!-- <div class="cro">&times;</div> -->
<div class="error"></div>
                <div>


                    <form action="statusinfo.php" method="post" enctype="multipart/form-data">
                        <input type="file" id="status" name="image" hidden>
                        <input type="text" name="statusmessage" placeholder="Add a Caption" id="statusmessage">
                        <button type="submit">Share</button>
                        <button type="reset" class="cross">Cancel</button>
                    </form>
                </div>

            </div>
        </div>

        <div class="settingsdispl">
            <div class="last-seen">
                <p>Last seen</p>
                <label>
                    <input type="checkbox" id="last-seen-checkbox" <?php echo ($lastseen == "Active") ? 'checked' : ''; ?>
                        onclick="toggleLastSeen()">
                    <span class="toggle"></span>
                </label>
            </div>
            <div>
                <p>Dark Mode</p>
                <label>
                    <input type="checkbox" onclick="toggleDarkMode()">
                    <span class="toggle"></span>
                </label>
            </div>
            <div class="deleteoption">
                <p>Delete account</p>
                <button class="delete">Delete</button>
            </div>
        </div>

        <div class="del">
            Are you sure you wanna delete the account?
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg><br>
            All the messages and your account will be permanently deleted<br>
            We are sad to see you go (Please add a reason for leaving)
            <form action="delete.php" method="post">
                <br>
                <input type="text" name="delete" placeholder="Enter a reason you are leaving (optional)">
                <br>
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>
    <div id="errortxt"></div>
    <div class="statusnote">

        <div class="icon">
            <div class="colorchange">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-palette"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m4 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M5.5 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m.5 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                    <path
                        d="M16 8c0 3.15-1.866 2.585-3.567 2.07C11.42 9.763 10.465 9.473 10 10c-.603.683-.475 1.819-.351 2.92C9.826 14.495 9.996 16 8 16a8 8 0 1 1 8-8m-8 7c.611 0 .654-.171.655-.176.078-.146.124-.464.07-1.119-.014-.168-.037-.37-.061-.591-.052-.464-.112-1.005-.118-1.462-.01-.707.083-1.61.704-2.314.369-.417.845-.578 1.272-.618.404-.038.812.026 1.16.104.343.077.702.186 1.025.284l.028.008c.346.105.658.199.953.266.653.148.904.083.991.024C14.717 9.38 15 9.161 15 8a7 7 0 1 0-7 7" />
                </svg>
            </div>
            <div class="cross">&times;</div>

        </div>
        <div class="error"></div>
        <div class="statusform">
            <form action="statusinfo.php" method="post">
                <textarea type="text" name="statusmessage1" placeholder="Type a message ... "></textarea>
                <br>
                <button type="submit">Share</button>
            </form>
        </div>
    </div>
    <div class="editbox">
        <div class="logo">Friendify-Messenger</div>
        <div class="cross">&times;</div>
        <div class="option">
            <div class="current">
                <img src="images/<?php echo $userphoto ?>">
            </div>
            <div>Update to</div>
            <div class="changed">
                <label for="fileToUpload">
                    <img src="newpic.png" id="imagePreview">
                </label>
            </div>
        </div>
        <form action="updatepic.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" id="fileToUpload" hidden>
            <button type="submit">Upload</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector(".editbox form");
            const button = document.querySelector("button");

            form.onsubmit = (event) => {
                event.preventDefault();
                button.innerHTML = "Uploading..."; // Update button text
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "updatepic.php", true);
                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            let response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                document.querySelector(".editbox").classList.remove('active');
                                window.location.href = "users.php";
                                button.innerHTML = "Uploading..."
                                form.reset(); // Reset the form fields
                            } else {
                                console.error("Error: " + response.message); // Log error message
                                button.innerHTML = "Upload"; // Reset button text on error
                            }
                        }
                    }
                };
                let formData = new FormData(form);
                xhr.send(formData);
            };
            const fileInput = document.getElementById('fileToUpload');
            const imagePreview = document.getElementById('imagePreview');
            const label = document.querySelector('.changed label');

            label.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (event) => {
                if (event.target.files.length > 0) {
                    const file = event.target.files[0];
                    const newImagePreview = URL.createObjectURL(file);
                    imagePreview.src = newImagePreview;

                    imagePreview.onload = () => {
                        URL.revokeObjectURL(newImagePreview);
                    };
                }
            });
        });




    </script>

    <script src="usersmainone.js"></script>
    <script src="users3.js"></script>
    <script src="bio.js"></script>
    <script src="status8.js"></script>
    <script src="statusinfo.js"></script>
    <script>
        // const formsearch=document.querySelector(".sear")
        const searchBar5 = document.querySelector(".search input");
        const usersList7 = document.querySelector(".users-list");
        const buttons=document.querySelector(".search button")
        buttons.addEventListener("click", () => {
            let searchTerm = searchBar5.value;
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "search.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        usersList7.innerHTML = data;
                    }
                }
            };
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("searchTerm=" + searchTerm);
        });

    </script>
    <script src="status9.js">

    </script>
    <script>
        const threedots = document.querySelector(".icon svg")
        threedots.addEventListener("click", () => {
            const setting = document.querySelector(".settingsdispl")
            setting.classList.toggle("active")
            setting.style.border = "3px solid grey"
        })
        const edit = document.querySelector(".photo svg")
        edit.addEventListener("click", () => {
            const editbox = document.querySelector(".editbox")
            // document.body.style.backgroundColor="blue"
            editbox.classList.toggle("active")
        })
        const cross = document.querySelector(".editbox .cross")
        cross.addEventListener("click", () => {
            document.querySelector(".editbox").classList.toggle("active")
        })
        document.querySelector(".status .chat").addEventListener("click",()=>{
            window.location.href="users.php";
            // document.body.style.backgroundColor="green"
        })
    </script>
</body>

</html>