<script setup>
import { ref } from 'vue';
import ParkingInput from '@/components/ParkingInput.vue';

const username = ref('');
const password = ref('');

// Liste des utilisateurs existants (simulée)
const usersList = ['Thomas', 'Marie', 'Admin', 'Dev', 'GrandMère', 'Lucas'];

const handleLogin = () => {
    if (!username.value) {
        alert("Hé ! Vous devez garer votre voiture d'abord !");
        return;
    }
    console.log(`Tentative de connexion : ${username.value} / ${password.value}`);
};
</script>

<template>
    <div class="login-page">
        <div class="card">
            <h1>Login</h1>

            <form @submit.prevent="handleLogin">
                <label>Utilisateur</label>

                <ParkingInput
                    v-model="username"
                    :users="usersList"
                />

                <label>Mot de passe</label>
                <input type="password" v-model="password" placeholder="•••••••" />

                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
.login-page { display: flex; justify-content: center; align-items: center; height: 100vh; background: #eee; }
.card { background: white; padding: 2rem; border-radius: 8px; width: 350px; }
label { display: block; margin: 10px 0 5px; font-weight: bold; }
input[type="password"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
button { width: 100%; margin-top: 20px; padding: 10px; background: #333; color: white; border: none; cursor: pointer; }
</style>