<script setup>

    import axios from 'axios';
    import { ref } from 'vue';
    import ParkingInput from "@/components/ParkingInput.vue";
    const isConnecting = ref(true);
    const password = ref('');
    const username = ref('');

    function Connect(){
        axios.post('http://api.devsfecations.fr/user/login', {
            pseudo: username.value,
            password: password.value
            }).then(function (response) {
                console.log(response)
                if(response.data.error){
                    alert("Erreur lors de la connexion : " + response.data.error);
                    return;
                }
                localStorage.setItem('token', response.data.token);
                window.location.replace("/");
        })
    }


    function createAccount(){
        axios.post('http://api.devsfecations.fr/user/signin',  {
            pseudo: username.value,
            password: password.value
            }).then(function (response) {
                console.log(response)
                if(response.data.error){
                    alert("Erreur lors de la création du compte : " + response.data.error);
                    return;
                }
                localStorage.setItem('token', response.data.token);
                // window.location.replace("/");
            })
    }

</script>



<template>
    <div class="loginMain">
    <div class="h4 flex py-3 W-100">
        Waifree
    </div>
    <div class="loginWindow" v-if="isConnecting">
        <h2 class="loginTitle">Connexion</h2>
        <form class="loginInfo" @submit.prevent="Connect()">
            <ParkingInput v-model="username" />
            <input class="form-control my-3" v-model="username" type="text" placeholder="Nom d'utilisateur"/>
            <input class="form-control my-3" v-model="password" type="password" placeholder="Mot de passe"/>
            
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary mt-3" type="submit">Se connecter</button> 
            </div>  
            <button class="loginNoProfile" @click="isConnecting=false">Pas de profil ?</button>
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

    .loginMain{
        height: 100vh;
        display: flex;
        flex-direction: column;
    }


    .flex {
        background-color: #121212;
        color: white;
        text-align: center;
    }

    .loginWindow {    
        display: flex;
        flex-direction: column;
        align-items: center;     
        justify-content: center;  
        margin: auto;
        background-color: #121212;
        width: 30vw;
        height: 30vw;
        border: 2px solid #ffffff;
        border-radius: 15px;
        padding: 10px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }
    .loginTitle {
        color: white;
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
        margin-top: 10px;
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

