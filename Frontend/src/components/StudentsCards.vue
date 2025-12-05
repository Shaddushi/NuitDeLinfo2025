<script setup>

import { defineProps } from 'vue';


const props = defineProps({
  CharName: String,
  CharText: String,
  CharImg: String,
});


</script>


<template>
    <div class="card">
        <div id="ImgContainer">
            <img :src="CharImg" id="charImg" alt="Avatar" style="width:100%">
            <div class="text">{{ CharText }}</div>
        </div>
      <div class="container">
        <h4 class="name"><b>{{ CharName }}</b></h4>
      </div>
    </div>
</template>

<style scoped>

    #ImgContainer {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.3s ease;
    }

    .text {
      position: absolute;
      inset: 0;
      display: flex;
      justify-content: center;
      color: black;
      padding: 30px;
      text-align: center;
      font-size: 20px;
      opacity: 0;
      transition: 0.3s ease;
      backdrop-filter: blur(0px);
    }

    #charImg {
      filter: blur(10px) brightness(0.2);
    }

    .card:hover #charImg{
        opacity: 0.6;
    }
    
    .card:hover .text {
      opacity: 1;
    }
 
    .card {
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      border-radius: 30px;
      padding: 8px;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container{
        background: var(--bs-primary);
        border-radius:  50px;
        
    }

    .name{
        height: 40px;
        text-align: center;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }





</style>