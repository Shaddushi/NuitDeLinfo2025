<script setup>
import { onMounted, ref } from "vue";

const canvasRef = ref(null);
let context = null;

onMounted(() => {
  const canvas = canvasRef.value;
  context = canvas.getContext("2d");

  context.fillStyle = "red";
  context.fillRect(10, 10, 30, 30);
});
</script>

<template>
  <canvas ref="canvasRef" class="snake-game"></canvas>
</template>

<style scoped>
.snake-game {
    display: flex;
    margin: auto;
    width: 100%;
    height: 100%;
    background: #eee;
}
</style>