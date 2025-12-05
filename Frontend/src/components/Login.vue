<script setup>

    import axios from 'axios';
    import { ref } from 'vue';
    import ParkingInput from "@/components/ParkingInput.vue";
    const isConnecting = ref(true);
    const password = ref('');
    const username = ref('');
    function Connect(){
        axios.post('https://api.devsfecations.fr/user/login', {
            pseudo: username.value,
            password: password.value
            }).then(function (response) {
                localStorage.setItem('token', response.data.token);
                window.location.replace("/");
        }).catch(function (response){
            alert("Erreur lors de la connexion : " + response.response.data.message);
            return;
        })
    }


    function createAccount(){
        axios.post('https://api.devsfecations.fr/user/signin',  {
            pseudo: username.value,
            password: password.value
            }).then(function (response) {
                localStorage.setItem('token', response.data.token);
                window.location.replace("/");
            }).catch(function (response){
            alert("Erreur lors de la connexion : " + response.response.data.message);
            return;
        })
    }

</script>



<template>
    <div class="loginMain bg-light">
    <div class="h4 text-center bg-primary text-white py-3 W-100">
        Linus University
    </div>
    <div class="loginWindow" v-if="isConnecting">
        <h2 class="loginTitle">Connexion</h2>
        <form class="loginInfo" @submit.prevent="Connect()">
            <div class="d-flex w-100">
                <input class="form-control rounded-start-4 rounded-end-0 flex-grow-1" v-model="username" type="text" placeholder="Nom d'utilisateur"/>
                <ParkingInput @register="isConnecting=false" v-model="username" title="Choisir son pseudo en voiture" />
            </div>

            <input class="form-control rounded-4 my-3" v-model="password" type="password" placeholder="Mot de passe" style="height: 45px;"/>

            <button class="btn btn-primary my-3 rounded-4 p-3 w-100 fw-bold" type="submit">Se connecter</button>

            <div class="d-flex w-100 mt-3">
                <div class="divider h-100 flex-grow-1"></div>
                <button class="loginNoProfile" @click="isConnecting=false">Pas de profil ?</button>
                <div class="divider h-100 flex-grow-1"></div>
            </div>

        </form>

    </div>
    <div class="loginWindow" v-else>
        <h2 class="loginTitle">Création de compte</h2>
        <form class="loginInfo" @submit.prevent="createAccount()">
            <input class="form-control my-3" v-model="username" type="text" placeholder="Nom d'utilisateur"/>
            <input class="form-control my-3" v-model="password" type="password" placeholder="Mot de passe"/>
            
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary mt-3" type="submit">Créer un compte</button> 
            </div>  
            <button class="loginNoProfile" @click="isConnecting=true">déjà un profil ?</button>
        </form>
    </div>
    </div>
</template>







<style scoped>

    .divider {
        border-top: #818991 solid 1px;
        transform: translateY(50%);
        opacity: 0.6;
        margin: 0 12px;
    }

    .loginMain{
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .loginWindow {    
        display: flex;
        flex-direction: column;
        align-items: center;     
        justify-content: center;  
        margin: auto;
        background-color: white;
        width: 30vw;
        height: 30vw;
        border: 2px solid #ffffff;
        border-radius: 15px;
        padding: 10px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .loginInfo {
        width: 80%;
        height: 60%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; 
    }
    
    .loginNoProfile {
        color: #b9b4b4;
        background: none;
        border: none;
    }

    .loginNoProfile:hover {
        text-decoration: underline;
        cursor: pointer;
    }
    

    .btn:hover {
        background-color: #2b2b30;
        border-color: #2b2b30;
        color: white;
    }

    @media (max-width: 1200px) {
        .loginWindow {
            width: 50vw;
            height: 50vw;
        }
    }
    
    @media (max-width: 768px) {
        .loginWindow {
            width: 70vw;
            height: 70vw;
        }
    }

    @media (max-width: 480px) {
        .loginWindow {
            width: 90vw;
            height: 60vh;
        }
    }
    
    
</style>

