function startGame(ctx) {
  ctx.imageSmoothingEnabled = false;
  ctx.textAlign = "center";
  ctx.strokeStyle = "#533545";
  const spriteScale = window.innerHeight / 500;
  const gravity = 0.2 * spriteScale;
  const pipeGap = 150;
  const pipeDistance = Math.min(0.3 * spriteScale, window.innerWidth / window.innerHeight);
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
    pace: spriteScale * 3,
    baseOffset: 0,
    alive: true,
    score: 0
  };

  spawnPipe();
  spawnPipe();

  function flap() {
    if (state.alive) {
      state.bird.force.y = -30 * gravity;
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

  // The framerate is set to 60 exactly because of poor sub-milisecond time
  // measurements in browsers (due to security reasons). Most frames render in
  // <1ms to 3ms, which means that physics with deltaTime is very inconsistent,
  // if not completely broken since a large portion of frames render "in 0ms"
  setInterval(mainLoop, 1000/60);

  function mainLoop() {
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    physics();

    for (let pos of state.pipes) {
      ctx.translate(pos.x * window.innerHeight, window.innerHeight - pos.y * window.innerHeight)
      ctx.drawImage(pipe, 0, 0, pipe.width * spriteScale, pipe.height * spriteScale);
      ctx.rotate(Math.PI);
      ctx.scale(-1, 1);
      ctx.drawImage(pipe, 0, pipeGap * spriteScale, pipe.width * spriteScale, pipe.height * spriteScale);
      ctx.scale(-1, 1);
      ctx.rotate(-Math.PI);
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
  }

  function physics() {
    state.bird.force.y += gravity;
    state.bird.y += state.bird.force.y;

    // Top border collisions
    if (state.bird.y < -bird.height * spriteScale) {
      state.bird.y = -bird.height * spriteScale;
      state.bird.force.y = -state.bird.force.y;
    }

    // Ground collisions
    if (state.bird.y >= baseLevel - bird.height * spriteScale / 2) {
      state.bird.y = baseLevel - bird.height * spriteScale / 2;
      state.bird.force.y = - Math.floor(state.bird.force.y * 0.7);
    }

    for (let pos of state.pipes) {
      pos.x -= state.pace / window.innerHeight * state.alive;

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
      if (betweenPipes && !inGap) {
        if (state.alive) {
          state.bird.force.y = -10;
          gameOver(state.score);
        }
        state.alive = false;
      }
    }


    state.pipes = state.pipes.filter(pos => pos.x * window.innerHeight >= -pipe.width * spriteScale);
    if (state.pipes.length < window.innerWidth / window.innerHeight / pipeDistance + 1) {
      spawnPipe()
    }

    state.pace += 1/1_000 * state.alive;
    state.baseOffset += state.pace * state.alive;
    state.baseOffset %= base.width;
  }

  function drawBird() {
    const upForce = state.bird.force.y;
    const rotation = Math.atan(upForce / (20 * gravity));
    const sprite = upForce < -2 ? bird.downflap :
      upForce < 5 ? bird.midflap : bird.upflap;


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
  fetch("/score.php", {
    method: "POST",
    body: JSON.stringify({score: score})
  })
}
