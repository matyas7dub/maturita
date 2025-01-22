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
<canvas id="mainCanvas" />
<script>
const background = new Image();
background.src = "/assets/background-day.png";
background.style.position = "fixed";
let scale = Math.max(window.innerWidth/background.width, 1);

background.width *= scale;
background.height *= scale;
background.style.left = "0";
background.style.bottom = `-${background.width * 0.3}px`;
document.getElementsByTagName("body")[0].appendChild(background);

const canvas = document.getElementById("mainCanvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;


addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    scale = Math.max(window.innerWidth/background.width, 1);
    background.width *= scale;
    background.height *= scale;
});

const ctx = canvas.getContext("2d");
startGame(ctx);
</script>
</body>
</html>
