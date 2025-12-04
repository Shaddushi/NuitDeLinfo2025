<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';

const canvasRef = ref(null);
let ctx = null;

const bruno = new Image();
bruno.src = '/bruno.png';
const fruit = new Image();
const fruitList = ['/foxy.png', '/vlc.png']
const cols = Math.round(parent.innerWidth / 32) -1;
const rows = Math.round(parent.innerHeight  / 32) -1;
const cell = 32;
const speed = 8; 

let snake = [];

const snakeSize = ref(snake.length -1);


let dir = { x: 1, y: 0 };
let apple = { x: 5, y: 5 };
let running = false;
let timer = null;


function placeApple() {
  apple.x = Math.floor(Math.random() * cols);
  apple.y = Math.floor(Math.random() * rows);
  fruit.src = fruitList[Math.floor(Math.random() * fruitList.length)];
  if (snake.some(s => s.x === apple.x && s.y === apple.y)) placeApple();
}

function resetGame() {
  snake = [{ x: Math.floor(cols / 2), y: Math.floor(rows / 2) }];
  dir = { x: 1, y: 0 };
  placeApple();
  running = true;
  draw();
}

function update() {
  const head = { x: snake[0].x + dir.x, y: snake[0].y + dir.y };

  if (head.x < 0) head.x = cols - 1;
  if (head.x >= cols) head.x = 0;
  if (head.y < 0) head.y = rows - 1;
  if (head.y >= rows) head.y = 0;

  if (snake.some(s => s.x === head.x && s.y === head.y)) {
    running = false;
    return;
  }

  snake.unshift(head);

  if (head.x === apple.x && head.y === apple.y) {
    placeApple();
  } else {
    snake.pop();
  }
}

function draw() {
  const canvas = canvasRef.value;
  if (!canvas) return;
  ctx = canvas.getContext('2d');
  canvas.width = cols * cell;
  canvas.height = rows * cell;

  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Draw snake body
  for (let i = 1; i < snake.length; i++) {
    ctx.fillStyle = '#f4ab41';
    if(dir.x == -1) ctx.fillRect(snake[i].x * cell - 5, snake[i].y * cell +2 , cell +5, cell);
    else if(dir.x == 1) ctx.fillRect(snake[i].x * cell + 5, snake[i].y * cell +2 , cell + 5, cell);
    else if(dir.y == -1) ctx.fillRect(snake[i].x * cell +2 , snake[i].y * cell -5, cell, cell +5);
    else if(dir.y == 1) ctx.fillRect(snake[i].x * cell +2, snake[i].y * cell +5, cell, cell +5);
 };
  // Draw fruit
  ctx.drawImage(fruit,apple.x * cell + 2, apple.y * cell + 2, cell + 5, cell +5);
  // Draw snake head
  if(dir.x === 1) drawRotatedImage(bruno,snake[0].x * cell - 2,snake[0].y * cell - 2,cell + 10,cell + 10,270);
  else if(dir.x === -1) drawRotatedImage(bruno,snake[0].x * cell - 2,snake[0].y * cell - 2,cell + 10,cell + 10,90);
  else if(dir.y === 1) drawRotatedImage(bruno,snake[0].x * cell - 2,snake[0].y * cell - 2,cell + 10,cell + 10,360);
  else if(dir.y === -1) drawRotatedImage(bruno,snake[0].x * cell - 2,snake[0].y * cell - 2,cell + 10,cell + 10,180);
}

function drawRotatedImage(img, x, y, w, h, angle) {
    ctx.save(); 
    ctx.translate(x + w / 2, y + h / 2); 
    ctx.rotate(angle * Math.PI / 180); 

    ctx.drawImage(
        img,
        -w / 2,
        -h / 2,
        w,  
        h
    );

    ctx.restore();
}

function loop() {
  if (!running) return;
    snakeSize.value = snake.length -1;
  update();
  draw();
}

function handleKey(e) {
  const k = e.key;
  if ((k === 'ArrowUp' || k === 'w') && dir.y !== 1) dir = { x: 0, y: -1 };
  else if ((k === 'ArrowDown' || k === 's') && dir.y !== -1) dir = { x: 0, y: 1 };
  else if ((k === 'ArrowLeft' || k === 'a') && dir.x !== 1) dir = { x: -1, y: 0 };
  else if ((k === 'ArrowRight' || k === 'd') && dir.x !== -1) dir = { x: 1, y: 0 };
  else if (k === ' ' && !running) resetGame();
}

onMounted(() => {
  ctx = canvasRef.value.getContext('2d');
  resetGame();
  window.addEventListener('keydown', handleKey);
  timer = setInterval(loop, 1000 / speed);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKey);
  clearInterval(timer);
});
</script>

<template>
  <div class="containerPersonalized">
    <div class="hud">
      <div>Score: {{ snakeSize }}</div>
      <div class="hint">Flèches pour diriger — Espace pour (re)lancer</div>
    </div>
    <canvas ref="canvasRef" class="snake-game" tabindex="0"></canvas>
    
  </div>
</template>





<style scoped>

    .containerPersonalized {
        display: flex;
        flex-direction: column;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width:100vw;
        height:100%;
        text-align: center;
        align-items: center;
    }
    .hud {
        display: flex;
        margin-top: 8px;
        gap: 12px;
        justify-content: center;
        background: wheat;
        width: fit-content;
        padding: 4px 12px;    
        border-radius: 50px;
    }
    .hint { color: #666; font-size: 0.9rem; }
</style>