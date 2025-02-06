async function startGame(ctx) {
  ctx.imageSmoothingEnabled = false;
  ctx.textAlign = "center";
  ctx.strokeStyle = "#533545";
  const spriteScale = window.innerHeight / 500;
  const gravity = spriteScale / 1_400;
  const pipeGap = 150;
  const pipeDistance = Math.min(0.5 * spriteScale, window.innerWidth / window.innerHeight);
  ctx.lineWidth = 2 * spriteScale;
  ctx.font = `${48 * spriteScale}px Pixeloid`;

  const bird = {
    downflap: new Image(),
    midflap: new Image(),
    upflap: new Image(),
    width: 34,
    height: 24,
    radius: 34 * spriteScale * 0.4
  };
  bird.downflap.src = "/assets/yellowbird-downflap.png";
  bird.midflap.src = "/assets/yellowbird-midflap.png";
  bird.upflap.src = "/assets/yellowbird-upflap.png";

  const pipe = new Image();
  pipe.src = "/assets/pipe-green.png";

  const pipeReverse = new Image();
  pipeReverse.src = "/assets/pipe-green-reverse.png";

  const base = new Image();
  base.src = "/assets/base.png";
  let baseLevel = window.innerHeight * 0.9;

  // x is unused, but I might want to add something later
  const state = {
    bird: {
      x: window.innerHeight / 6,
      y: window.innerHeight / 2,
      force: {
        x: 0,
        y: 0
      }
    },
    pipes: [],
    pace: spriteScale / 5,
    baseOffset: 0,
    alive: true,
    score: 0,
    deltaTime: performance.now()
  };

  spawnPipe();
  spawnPipe();

  function flap() {
    if (state.alive) {
      state.bird.force.y = -500 * gravity;
    }
  }

  addEventListener("mousedown", () => flap());
  addEventListener("keypress", event => {
    if(event.key === " ") {
      flap(event);
    }
  });

  addEventListener("resize", () => {
    baseLevel = window.innerHeight * 0.9;
    state.bird.x = window.innerHeight / 4;
  });

  // wait for images
  await bird.downflap.decode();
  await bird.midflap.decode();
  await bird.upflap.decode();
  await pipe.decode();
  await pipeReverse.decode();
  await base.decode();

  requestAnimationFrame(mainLoop);

  function mainLoop(timestamp) {
    state.deltaTime = Math.min(timestamp - state.deltaTime, 100);
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    physics();

    for (let pos of state.pipes) {
      ctx.translate(pos.x * window.innerHeight, window.innerHeight - pos.y * window.innerHeight)
      ctx.drawImage(pipe, 0, 0, pipe.width * spriteScale, pipe.height * spriteScale);
      ctx.drawImage(pipeReverse, 0, -(pipe.height + pipeGap) * spriteScale, pipeReverse.width * spriteScale, pipeReverse.height * spriteScale);
      ctx.translate(-pos.x * window.innerHeight, -window.innerHeight + pos.y * window.innerHeight)
    }

    drawBird();

    for (let x = 0; x < window.innerWidth + state.baseOffset; x += base.width * spriteScale) {
      ctx.drawImage(base, x - state.baseOffset, baseLevel, base.width * spriteScale, base.height * spriteScale);
    }

    ctx.fillStyle = "#E9FCD9";
    ctx.fillText(state.score, window.innerWidth/2, window.innerHeight/8);
    ctx.fillStyle = "#000000";
    ctx.strokeText(state.score, window.innerWidth/2, window.innerHeight/8);
    state.deltaTime = timestamp;
    requestAnimationFrame(mainLoop);
  }

  function physics() {
    state.bird.force.y += gravity * state.deltaTime;
    state.bird.y += state.bird.force.y * state.deltaTime;

    // Top border collisions
    if (state.bird.y < -bird.height * spriteScale) {
      state.bird.y = -bird.height * spriteScale;
      state.bird.force.y = -state.bird.force.y;
    }

    // Ground collisions
    if (state.bird.y >= baseLevel - bird.height * spriteScale / 2) {
      state.bird.y = baseLevel - bird.height * spriteScale / 2;
      state.bird.force.y = - Math.floor(state.bird.force.y * 0.7 * 10) / 10;
    }

    for (let pos of state.pipes) {
      pos.x -= state.pace * state.deltaTime / window.innerHeight * state.alive;

      if (state.bird.x - bird.radius > pos.x * window.innerHeight + pipe.width * spriteScale / 2 && !pos.passed){
        // The "pos(ition)" variable doesn't really work here, but whatever
        pos.passed = true;
        state.score++;
      }

      // Pipe collisions
      const pipeX = pos.x * window.innerHeight;
      const pipeY = window.innerHeight - pos.y * window.innerHeight;

      const betweenPipes = state.bird.x + bird.radius > pipeX && state.bird.x - bird.radius < pipeX + pipe.width * spriteScale;
      const inGap = state.bird.y + bird.radius < pipeY && state.bird.y - bird.radius > pipeY - pipeGap * spriteScale;
      if (betweenPipes && !inGap && state.alive) {
          state.alive = false;
          state.bird.force.y = -0.5;
          gameOver(state.score);
      }
    }


    state.pipes = state.pipes.filter(pos => pos.x * window.innerHeight >= -pipe.width * spriteScale);
    if (state.pipes.length < window.innerWidth / window.innerHeight / pipeDistance + 1) {
      spawnPipe()
    }

    state.pace += 1/280_000 * state.deltaTime * state.alive;
    state.baseOffset += state.pace * state.deltaTime * state.alive;
    state.baseOffset %= base.width * spriteScale;
  }

  function drawBird() {
    const upForce = state.bird.force.y;
    const rotation = Math.atan(upForce * 4 / spriteScale);
    const sprite = upForce < -0.12 ? bird.downflap :
      upForce < 0.3 ? bird.midflap : bird.upflap;


    ctx.translate(state.bird.x, state.bird.y);
    ctx.rotate(rotation);

    // Hitbox
    // 
    // ctx.fillStyle = "red";
    // ctx.beginPath();
    // ctx.ellipse(0, 0, bird.radius, bird.radius, 0, 0, Math.PI * 2);
    // ctx.fill();
    // ctx.closePath();

    ctx.drawImage(sprite, -bird.width * spriteScale / 2, -bird.height * spriteScale / 2, bird.width * spriteScale, bird.height * spriteScale);

    ctx.rotate(-rotation);
    ctx.translate(-state.bird.x, -state.bird.y);
  }

  function spawnPipe() {
    state.pipes.push({
      x: state.pipes.length === 0 ?
        window.innerWidth/window.innerHeight * spriteScale / 2 :
        state.pipes[state.pipes.length - 1].x + pipeDistance,
      y: Math.random()/3 + 0.2,
      passed: false
    });
  }
}

function gameOver(score) {
  document.getElementById("score").innerText = `Score: ${score}`;
  document.getElementById("gameOverDialog").showModal();

  fetch("/score.php", {
    method: "POST",
    body: JSON.stringify({score: score})
  })
}
