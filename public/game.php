<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link href="./css/style.css" rel="stylesheet"/>
<link href="./favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<script src="../src/game.js"></script>
<title>Flappy bird</title>
<style>
body {
    background-color: #4EC0CA;
    overflow: hidden;
    touch-action: none;
}
canvas {
    width: 100vw;
    height: 100vh;
    z-index: 2;
}
dialog {
    font-size: 2em;

    >div {
        display: flex;
        flex-direction: column;
        align-items: center;

        h1 {
            margin: 0.1em;
        }

        span {
            margin-bottom: 1em;
        }
    }
}
img {
    image-rendering: pixelated;
}
</style>
</head>
<body>
<dialog id="gameOverDialog">
    <div>
        <h1>GAME OVER!</h1>
        <span id="score"></span>
        <div>
            <a href="./index.php"><button>Go to menu</button></a>
            <button autofocus onclick="window.location.reload()">Play again</button> 
        </div>
    </div>
</dialog>
<canvas id="mainCanvas"></canvas>
<img id="background" style="position: fixed; left: 0;" src="./assets/background-day.png" />
<script>
const background = document.getElementById("background");
let bgWidth = 0;
let bgHeight = 0;
let scale = 0;

background.onload = () => {
    bgWidth = background.width;
    bgHeight = background.height;
    scale = Math.max(window.innerWidth/bgWidth, 1);
    background.width = bgWidth * scale;
    background.height = bgHeight * scale;
    background.style.bottom = `-${background.width * 0.3}px`;
};

const canvas = document.getElementById("mainCanvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;


addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    scale = Math.max(window.innerWidth/bgWidth, 1);
    background.width = bgWidth * scale;
    background.height = bgHeight * scale;
});

document.getElementById("gameOverDialog").addEventListener("keydown", event => {
   if (event.key === "Escape") {
       event.preventDefault();
   }
});

const ctx = canvas.getContext("2d");
startGame(ctx);
</script>
</body>
</html>
