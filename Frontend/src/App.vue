<script setup>
  import SnakeGame from './components/snake.vue';
  import Game from './components/Game.vue';
  import Navigation from "@/components/Navigation.vue";
  import { createIcons, icons } from 'lucide';

  // Caution, this will import all the icons and bundle them.
  createIcons({ icons });
</script>

<template>
    <div class="h-100 w-100">

        <Navigation />
        <SnakeGame v-if="false" />

        <Game />

    </div>

</template>

<style>
.center-placement{
    position: absolute;
    top: 50%;
    left: -30px;
    transform: translateY(-50%);
}

</style>
