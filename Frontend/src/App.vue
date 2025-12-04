<script setup>
  import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <div class="h-100 w-100">

        <Navigation />
        <router-view />
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
