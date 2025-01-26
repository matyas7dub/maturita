<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<script src="/src/game.js"></script>
<title>Flappy bird</title>
<style>
body {
    background-color: #4EC0CA;
}
canvas {
    width: 100vw;
    height: 100vh;
    z-index: 2;
}
img {
    image-rendering: -webkit-optimize-contrast; /* webkit */
    image-rendering: -moz-crisp-edges /* Firefox */ 
}
</style>
</head>
<body>
<canvas id="mainCanvas"></canvas>
<img id="background" style="position: fixed; left: 0;" src="/assets/background-day.png" />
<script>
const background = document.getElementById("background");
let bgWidth = 0;
let bgHeight = 0;
let scale = 0;

background.onload = () => {
    console.debug("hello");
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

const ctx = canvas.getContext("2d");
startGame(ctx);
</script>
</body>
</html>
