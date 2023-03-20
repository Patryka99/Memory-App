<?php
    session_start();

    if(!isset($_SESSION["useruid"])){
        header("location: ../index.php");
        exit();
    }

    require_once '../Script/functions.inc.php';
    require_once '../Script/dbh.inc.php';

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Memory - </title>
    <link rel="stylesheet" href="../Style/gameStart.css">
    <link rel="stylesheet" href="../Style/flipCard.css">
    <link rel="stylesheet" href="../Style/Style.css">
    <script src="../JsScripts/flipCardScript.js" async></script>
    <script type="module" src="../JsScripts/main.js"></script>
</head>
<body>

    <!-- <div class="register-popup">
        <div class="close-btn register-close">&times;</div>
        <div class="swap-log-in"><span>Are you a member? <strong><span class="logIn text-black">LogIn</span></strong></span></div>
        <div class="form">
            <h2>Register</h2>
            <div class="form-elem">
                <input type="text" id="register-username" placeholder="Username" autocomplete="off">
                <span class="border"></span> 
            </div>
            <div class="form-elem">
                <input type="text" id="register-email" placeholder="Email" autocomplete="off"> 
            </div>
            <div class="form-elem">
                <input type="password" id="register-password" placeholder="Password" autocomplete="off"> 
            </div>
            <div class="form-elem">
                <input type="password" id="r-psername" placeholder="Repeat Password" autocomplete="off"> 
            </div>
            <div class="form-elem">
                <input type="checkbox" id="checkbox1"> 
                <label for="checkbox1">Contact me via e-mail</label>
            </div>
            <div class="form-elem">
                <input type="checkbox" id="checkbox2">
                <label for="checkbox2">I have read and accepted the Terms and Conditions and Privacy Policy</label> 
            </div>
            <div class="form-elem">
                <button>CREATE YOUR ACCOUNT</button>
            </div>
        </div>
    </div>

    <div class="login-popup">
        <div class="close-btn login-close">&times;</div>
        <div class="swap-log-in"><span>Not a member yet? <strong><span class="Register text-black">Register Now</span></strong></span></div>
        <div class="form">
            <h2>Sign In</h2>
            <div class="form-elem">
                <input type="text" id="username" placeholder="Username" autocomplete="off">
                <span class="border"></span> 
            </div>
            <div class="form-elem">
                <input type="password" id="password" placeholder="Password" autocomplete="off"> 
            </div>
            <div class="form-elem">
                <button>LOGIN NOW</button>
            </div>
        </div>
    </div> -->

    <div id="Head">
        <div class="header-main">
            <div class="box-left">
                
                <div class="item bt-menu">
                    <div class="ico-menu">
                        <div class="bar">
                            ::after
                        </div>
                        <div class="bar">
                            ::after
                        </div>
                        <div class="bar">
                            ::after
                        </div>
                    </div>
                    <span class="menu-txt">MENU</span>
                </div>
                
            </div>
            <div class="box-right">
                <div class="item login">
                    <!-- <span>Are you a member?</span>
                    <strong>
                        <span class="open-login text-black"> Register / Log in</span>
                    </strong> -->
                </div>
            </div>
        </div>
        <div class="logo-header">
        <a href=".."><svg width="141" height="75" viewBox="0 0 280 44.3">
                <path xmlns="http://www.w3.org/2000/svg" d="M6.53 0L-0.83 0L10.75-42.24L24.13-42.24L27.07-18.11L38.98-42.24L50.18-42.24L51.33-10.62L51.33-10.62Q51.58-4.35 54.66-2.43L54.66-2.43L54.66-2.43Q53.95-1.15 51.90 0.06L51.90 0.06L51.90 0.06Q49.86 1.28 47.14 1.28L47.14 1.28L47.14 1.28Q44.42 1.28 42.82 0.51L42.82 0.51L42.82 0.51Q41.22-0.26 40.32-1.54L40.32-1.54L40.32-1.54Q38.72-3.84 38.72-8.26L38.72-8.26L38.72-28.03L26.11 0L18.18 0L13.70-28.74L6.53 0ZM83.33-10.82L83.33-10.82L83.33-10.82Q84.93-9.73 84.93-7.33L84.93-7.33L84.93-7.33Q84.93-4.93 83.71-3.39L83.71-3.39L83.71-3.39Q82.50-1.86 80.51-0.83L80.51-0.83L80.51-0.83Q76.42 1.28 72 1.28L72 1.28L72 1.28Q67.58 1.28 64.99 0.32L64.99 0.32L64.99 0.32Q62.40-0.64 60.67-2.43L60.67-2.43L60.67-2.43Q57.28-5.82 57.28-12.03L57.28-12.03L57.28-12.03Q57.28-21.70 62.53-27.58L62.53-27.58L62.53-27.58Q68.16-33.92 77.95-33.92L77.95-33.92L77.95-33.92Q84.03-33.92 87.04-31.36L87.04-31.36L87.04-31.36Q89.28-29.44 89.28-26.30L89.28-26.30L89.28-26.30Q89.28-15.04 69.82-15.04L69.82-15.04L69.82-15.04Q69.57-13.38 69.57-11.97L69.57-11.97L69.57-11.97Q69.57-9.02 70.88-7.90L70.88-7.90L70.88-7.90Q72.19-6.78 74.62-6.78L74.62-6.78L74.62-6.78Q77.06-6.78 79.65-7.90L79.65-7.90L79.65-7.90Q82.24-9.02 83.33-10.82ZM70.27-17.79L70.27-17.79L70.27-17.79Q74.82-17.79 77.44-20.61L77.44-20.61L77.44-20.61Q80.06-23.30 80.06-27.58L80.06-27.58L80.06-27.58Q80.06-29.06 79.52-29.86L79.52-29.86L79.52-29.86Q78.98-30.66 77.89-30.66L77.89-30.66L77.89-30.66Q76.80-30.66 75.87-30.24L75.87-30.24L75.87-30.24Q74.94-29.82 73.98-28.42L73.98-28.42L73.98-28.42Q71.62-25.22 70.27-17.79ZM137.54 1.28L137.54 1.28L137.54 1.28Q129.79 1.28 129.79-4.74L129.79-4.74L129.79-4.74Q129.79-7.36 130.91-12.45L130.91-12.45L130.91-12.45Q132.03-17.54 132.42-19.58L132.42-19.58L132.42-19.58Q133.31-24.26 133.31-25.73L133.31-25.73L133.31-25.73Q133.31-28.99 130.88-28.99L130.88-28.99L130.88-28.99Q129.28-28.99 127.74-26.78L127.74-26.78L127.74-26.78Q126.21-24.58 125.50-20.16L125.50-20.16L121.54 0L109.06 1.28L112.51-16.13L112.51-16.13Q113.09-19.01 113.60-22.27L113.60-22.27L113.60-22.27Q114.11-25.54 114.11-26.05L114.11-26.05L114.11-26.05Q114.11-28.99 111.94-28.99L111.94-28.99L111.94-28.99Q110.46-28.99 108.86-26.82L108.86-26.82L108.86-26.82Q107.26-24.64 106.37-20.16L106.37-20.16L102.46 0L89.86 1.28L96.58-32.64L107.01-33.92L105.92-27.46L105.92-27.46Q107.58-30.91 110.66-32.42L110.66-32.42L110.66-32.42Q113.73-33.92 118.53-33.92L118.53-33.92L118.53-33.92Q121.28-33.92 123.07-32.58L123.07-32.58L123.07-32.58Q124.86-31.23 125.44-29.06L125.44-29.06L125.44-29.06Q126.53-31.30 129.31-32.61L129.31-32.61L129.31-32.61Q132.10-33.92 135.52-33.92L135.52-33.92L135.52-33.92Q138.94-33.92 140.64-33.18L140.64-33.18L140.64-33.18Q142.34-32.45 143.36-31.23L143.36-31.23L143.36-31.23Q145.09-28.99 145.09-24.90L145.09-24.90L145.09-24.90Q145.09-20.86 143.36-12.48L143.36-12.48L143.36-12.48Q142.46-8.38 142.46-6.88L142.46-6.88L142.46-6.88Q142.46-5.38 143.33-4.48L143.33-4.48L143.33-4.48Q144.19-3.58 145.47-3.46L145.47-3.46L145.47-3.46Q144.83-1.28 142.62 0L142.62 0L142.62 0Q140.42 1.28 137.54 1.28ZM164.35 1.28L164.35 1.28L164.35 1.28Q150.27 1.28 150.27-11.97L150.27-11.97L150.27-11.97Q150.27-21.38 155.46-27.46L155.46-27.46L155.46-27.46Q160.96-33.92 170.50-33.92L170.50-33.92L170.50-33.92Q177.41-33.92 180.93-30.72L180.93-30.72L180.93-30.72Q184.45-27.52 184.45-20.80L184.45-20.80L184.45-20.80Q184.45-10.56 178.94-4.61L178.94-4.61L178.94-4.61Q173.57 1.28 164.35 1.28ZM166.02-26.56L166.02-26.56L166.02-26.56Q165.25-24.83 164.64-22.24L164.64-22.24L164.64-22.24Q164.03-19.65 163.26-15.55L163.26-15.55L163.26-15.55Q162.50-11.46 162.50-6.40L162.50-6.40L162.50-6.40Q162.50-4.74 163.04-3.65L163.04-3.65L163.04-3.65Q163.58-2.56 165.06-2.56L165.06-2.56L165.06-2.56Q166.53-2.56 167.46-3.26L167.46-3.26L167.46-3.26Q168.38-3.97 169.09-5.63L169.09-5.63L169.09-5.63Q170.37-8.58 171.39-14.05L171.39-14.05L171.39-14.05Q172.42-19.52 172.51-21.89L172.51-21.89L172.51-21.89Q172.61-24.26 172.61-26.02L172.61-26.02L172.61-26.02Q172.61-27.78 172.10-28.93L172.10-28.93L172.10-28.93Q171.58-30.08 170.14-30.08L170.14-30.08L170.14-30.08Q168.70-30.08 167.74-29.18L167.74-29.18L167.74-29.18Q166.78-28.29 166.02-26.56ZM208.26-17.98L208.26-17.98L208.26-17.98Q210.56-22.08 210.56-26.24L210.56-26.24L210.56-26.24Q210.56-28.99 208.58-28.99L208.58-28.99L208.58-28.99Q207.04-28.99 205.44-26.37L205.44-26.37L205.44-26.37Q203.78-23.74 203.26-20.35L203.26-20.35L199.94 0L186.69 1.28L193.22-32.64L203.78-33.92L202.62-27.46L202.62-27.46Q205.76-33.92 212.80-33.92L212.80-33.92L212.80-33.92Q216.51-33.92 218.53-32L218.53-32L218.53-32Q220.54-30.08 220.54-26.14L220.54-26.14L220.54-26.14Q220.54-22.21 217.95-19.71L217.95-19.71L217.95-19.71Q215.36-17.22 210.94-17.22L210.94-17.22L210.94-17.22Q209.02-17.22 208.26-17.98ZM241.92-7.23L241.92-7.23L241.92-7.23Q238.59-3.78 232.51-3.78L232.51-3.78L232.51-3.78Q224.90-3.78 223.30-9.34L223.30-9.34L223.30-9.34Q222.78-11.01 222.78-12.86L222.78-12.86L222.78-12.86Q222.78-14.72 223.17-16.64L223.17-16.64L226.18-32.64L239.17-33.92L235.65-15.30L235.65-15.30Q235.52-14.46 235.33-13.57L235.33-13.57L235.33-13.57Q235.14-12.67 235.14-11.74L235.14-11.74L235.14-11.74Q235.14-10.82 235.46-10.21L235.46-10.21L235.46-10.21Q235.78-9.60 236.22-9.22L236.22-9.22L236.22-9.22Q236.99-8.70 238.37-8.70L238.37-8.70L238.37-8.70Q239.74-8.70 240.93-10.37L240.93-10.37L240.93-10.37Q242.11-12.03 242.69-14.91L242.69-14.91L246.21-32.64L258.82-33.92L254.02-8.77L254.02-8.77Q251.65 3.52 246.78 8.38L246.78 8.38L246.78 8.38Q244.29 10.88 241.06 11.87L241.06 11.87L241.06 11.87Q237.82 12.86 233.66 12.86L233.66 12.86L233.66 12.86Q226.94 12.86 223.10 10.75L223.10 10.75L223.10 10.75Q219.26 8.64 219.26 5.12L219.26 5.12L219.26 5.12Q219.26 2.50 221.25 0.99L221.25 0.99L221.25 0.99Q223.23-0.51 226.30-0.51L226.30-0.51L226.30-0.51Q228.99-0.51 231.04 0.64L231.04 0.64L231.04 0.64Q232.26 1.34 232.83 2.24L232.83 2.24L232.83 2.24Q231.36 3.52 231.36 5.63L231.36 5.63L231.36 5.63Q231.36 8.45 233.92 8.45L233.92 8.45L233.92 8.45Q238.14 8.45 240.58-1.28L240.58-1.28L240.58-1.28Q241.28-4.16 241.92-7.23Z" fill="#444"/>
            </svg></a>
        </div>
    </div>
    <h1 class="page-title">Match Card</h1>
    <div id="main_overlay" class="overlay-text visible">
    <div id="startGameInfo">
            <div id="howToPlay">
                <h2>How to play</h2>
                <span class="playInfo">On Screen You will see a deck of card, every card have icon on obverse but 
                    You can see only revers. You need to find pairs by clicking them to peek the icon. If u find pair
                    the cards will stay on obverse side.</span>
                <h2>Control</h2>
                <span class='playInfo'>Control is very Simply just click with your left mouse button on cards to peek the icons </span>
            </div>
            <div id="choseDif">
                <form name="Play" action="../Script/startGame.inc.php" method="POST">
                    <input name="game" type="text" value="<?php echo $_GET['game']; ?>" style="display:none;" />
                    <h2>START GAME</h2>
                    <div class="btn btn-one" id="easy"><span>EASY</span></div>
                    <div class="btn btn-one" id="normal"><span>MEDIUM</span></div>
                    <div class="btn btn-one" id="hard"><span>HARD</span></div>
                </form> 
            </div>
        </div>
    </div>
    
    <div id="over-txt" class="overlay-text ">
        Game Over</br>
        <span class="overlay-text-small">Click to restart</span>
    </div>
    
    <div id="victory-txt" class="overlay-text">
        
        <form action="../Script/games.inc.php" method="post">
        WINNER
        <input type="text" id="gameTime" name="gameTime" value="0" style="display:none;" />
        <input type="text" id="gameDif" name="gameDif" value="NONE" style="display:none;" />
        <input type="text" id="gameInput" name="gameInput" value="FlipACard" style="display:none;" />
        <input type="number" id="scoreInput" name="scoreInput" style="display:none;" />
        <span class="overlay-text-small">Your score: </span><span id="endScore">0</span><br>
        <div id="gridBtn">
            <button class="newGame" type="submit" name="submit">New Game</button>
            <button id="lb" class="newGame" type="submit" name="leaderBoard">View LeaderBoard</button>
        </div>
        </form>
    </div>
    <div class="game-container">
        <div class="game-info-container">
            <div class="game-info">
                Time <span id="time">100</span>
            </div>
            <div class="game-info">
                Flips <span id="flips">0</span>
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon1.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon1.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon2.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon2.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon3.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon3.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon4.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon4.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon5.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon5.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon6.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon6.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon7.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon7.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon8.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon8.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon9.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon9.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon10.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon10.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon11.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon11.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon12.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-normal">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon12.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon13.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon13.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon14.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon14.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon15.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon15.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon16.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon16.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon17.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon17.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon18.png" alt="" class="value-card">
            </div>
        </div>
        <div class="card-hard">
            <div class="card-back card-face">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/mainCard.png" alt="" class="middle">
            </div>
            <div class="card-front card-face">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-top-right">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-left">
                <img src="../Img/Card/cornerCard2.png" alt="" class="corner corner-bottom-right">
                <img src="../Img/Card/icon18.png" alt="" class="value-card">
            </div>
        </div>
    </div>

    <div class="side-menu">
        <div class="sticky-menu">
            <?php
            if (isset($_SESSION["useruid"])){
                echo '<a href = ".." ><div class="side-menu-item menu-home">Home</div></a>';
                echo '<a href="User.php?game=FlipACard"><div class="side-menu-item menu-profile" >Profile</div></a>';
                echo '<a href="games.php"><div class="side-menu-item menu-memory-games">Games</div></a>';
            }else {
                echo '<div class="side-menu-item menu-login" >Login</div>';
                echo '<div class="side-menu-item menu-register" >Register</div>';
                echo '<a href="games.php"><div class="side-menu-item menu-memory-games">Games</div></a>';
            }
            ?>
            <a href="AboutSite.php"><div class="side-menu-item menu-about">About Site</div></a>     
        </div>
    </div>
        
    </div>
    
    <footer id="Footer">
        <div class="fot-box">
            <div class="inner">
                <div class="box-left">
                    <ul class="menu-footer">
                        <li>
                            <a class="text-black" rel="nofollow" href="AboutSite.php">About Site</a>
                        </li>
                        <li>
                            <a class="text-black" rel="nofollow" href="/faqs/"></a>
                        </li>
                        <li>
                            <a class="text-black" rel="nofollow" href="">Cookies Policy</a>
                        </li>
                    </ul>
                </div>
                <div class="box-right">
                    <p class="text-black">Made by Patryk Arendt</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>	