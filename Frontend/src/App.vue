<script setup>
  import Navigation from "@/components/Navigation.vue";
  import SnakeGame from "@/components/snake.vue";
  import { ref } from "vue";

  const isPlayingSnake = ref(false);

  const konami = ['ArrowUp','ArrowUp','ArrowDown','ArrowDown','ArrowLeft','ArrowRight','ArrowLeft','ArrowRight','b','a'];
  let tryKonami = [];


  function handleKey(e) {
    const k = e.key;
    if(k === "Escape" && isPlayingSnake){
        isPlayingSnake.value = false;
    }
    tryKonami.push(k);
    if(tryKonami[tryKonami.length -1] !== konami[tryKonami.length -1]) {
        tryKonami = []
    }  
    else{
        if(tryKonami.length === konami.length){
            isPlayingSnake.value = true;
            tryKonami = []
        }
    }
  }

  window.addEventListener("keydown", handleKey);
</script>

<template>

  <SnakeGame v-if="isPlayingSnake" /> 

    <div class="h-100 w-100">

        <Navigation />
             <router-view />
    </div>

</template>

<style>


</style>
