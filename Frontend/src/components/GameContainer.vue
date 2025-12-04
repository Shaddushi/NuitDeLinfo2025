<template>
    <div class="h-100">
        <Snake v-if="false" />
        <Game />
    </div>
</template>

<script>
import Game from "@/components/Game.vue";
import Snake from "@/components/snake.vue";
export default {
    components: {Game, Snake},
    data() {
        return {}
    }
}
</script>