function startGame(ctx) {
  ctx.imageSmoothingEnabled = false;
  ctx.fillStyle = "red";
  const gravity = 0.35;
  const spriteScale = 2;
  const pipeGap = 150;

  const bird = {
    downflap: new Image(),
    midflap: new Image(),
    upflap: new Image(),
    width: 34,
    height: 24
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
      x: window.innerHeight / 4,
      y: 100,
      force: {
        x: 0,
        y: 0
      }
    },
    pipes: [{
      x: 1.5,
      y: Math.random()/3 + 0.2
    }, {
      x: window.innerWidth/window.innerHeight + 0.7,
      y: Math.random()/3 + 0.2
    }],
    pace: 7,
    baseOffset: 0,
    alive: true
  };

  addEventListener("keypress", event => {
    if (event.key === " " && state.alive) {
      state.bird.force.y = -10;
    }
  });

  addEventListener("resize", () => {
    baseLevel = window.innerHeight * 0.9;
  });



  setInterval(mainLoop, 1000/60);

  function mainLoop() {
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    physics();

    for (let pos of state.pipes) {
      ctx.translate(pos.x * window.innerHeight, window.innerHeight - pos.y * window.innerHeight)
      ctx.drawImage(pipe, 0, 0, pipe.width * spriteScale, pipe.height * spriteScale);
      ctx.rotate(Math.PI);
      ctx.drawImage(pipe, -pipe.width * spriteScale, pipeGap * spriteScale, pipe.width * spriteScale, pipe.height * spriteScale);
      ctx.rotate(-Math.PI);
      ctx.translate(-pos.x * window.innerHeight, -window.innerHeight + pos.y * window.innerHeight)
    }

    drawBird();
    for (let x = 0; x < window.innerWidth + state.baseOffset; x += base.width * spriteScale) {
      ctx.drawImage(base, x - state.baseOffset, baseLevel, base.width * spriteScale, base.height * spriteScale);
    }
  }

  function physics() {
    state.bird.force.y += gravity;
    state.bird.y += state.bird.force.y;

    if (state.bird.y < -bird.height * spriteScale) {
      state.bird.y = -bird.height * spriteScale;
      state.bird.force.y = -state.bird.force.y;
    }

    if (state.bird.y >= baseLevel - bird.height * spriteScale / 2) {
      state.bird.y = baseLevel - bird.height * spriteScale / 2;
      state.bird.force.y = - Math.floor(state.bird.force.y * 0.7);
    }

    for (let pos of state.pipes) {
      pos.x -= state.pace / window.innerHeight * state.alive;

      const hitboxRadius = bird.width * spriteScale * 0.4;
      const pipeX = pos.x * window.innerHeight;
      const pipeY = window.innerHeight - pos.y * window.innerHeight;

      const betweenPipes = state.bird.x + hitboxRadius > pipeX && state.bird.x - hitboxRadius < pipeX + pipe.width * spriteScale;
      const inGap = state.bird.y + hitboxRadius < pipeY && state.bird.y - hitboxRadius > pipeY - pipeGap * spriteScale;
      if (betweenPipes && !inGap) {
        if (state.alive) {
          state.bird.force.y = -10;
        }
        state.alive = false;
      }
    }


    state.pipes = state.pipes.filter(pos => pos.x * window.innerHeight >= -pipe.width * spriteScale);
    const pipeCount = state.pipes.length;
    if (pipeCount < 2 && state.pipes[pipeCount - 1].x < 1.5) {
      state.pipes.push({
        x: window.innerWidth / window.innerHeight,
        y: Math.random()/3 + 0.2
      });
    }

    state.pace += 1/1_000 * state.alive;
    state.baseOffset += state.pace * state.alive;
    state.baseOffset %= base.width;
  }

  function drawBird() {
    const upForce = state.bird.force.y;
    const rotation = Math.atan(upForce/10);
    const sprite = upForce < -2 ? bird.downflap :
      upForce < 5 ? bird.midflap : bird.upflap;


    ctx.translate(state.bird.x, state.bird.y);
    ctx.rotate(rotation);

    // Hitbox
    // 
    // const radius = bird.width * spriteScale * 0.4;
    // ctx.beginPath();
    // ctx.ellipse(0, 0, radius, radius, 0, 0, Math.PI * 2);
    // ctx.fill();
    // ctx.closePath();

    ctx.drawImage(sprite, -bird.width * spriteScale / 2, -bird.height * spriteScale / 2, bird.width * spriteScale, bird.height * spriteScale);

    ctx.rotate(-rotation);
    ctx.translate(-state.bird.x, -state.bird.y);
  }
}

