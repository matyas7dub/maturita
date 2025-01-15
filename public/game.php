<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<title>Flappy bird</title>
<style>
canvas {
    width: 100vw;
    height: 100vh;
}
</style>
</head>
<body>
<canvas id="mainCanvas" />
<script>
const canvas = document.getElementById("mainCanvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

const ctx = canvas.getContext("2d");
ctx.font = "48px Pixeloid";
ctx.fillStyle = "black";

ctx.fillText("TODO: rendering", 100, 100);
</script>
</body>
</html>
