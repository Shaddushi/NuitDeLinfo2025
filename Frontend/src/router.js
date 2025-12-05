import { createRouter, createWebHistory } from 'vue-router';
import Credit from '@/components/Credit.vue';
import Accueil from "@/components/Accueil.vue";
import GameContainer from "@/components/GameContainer.vue";
import Login from "@/components/Login.vue";
import Scoreboard from "@/components/Scoreboard.vue";
const routes = [
    // ... autres routes
    {
        path: '/credits',
        name: 'credits',
        component: Credit,
    },
    {
        path: '',
        name: 'accueil',
        component: Accueil,
    },
    {
        path: '/game',
        name: 'game',
        component: GameContainer,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/scoreboard',
        name: 'scoreboard',
        component: Scoreboard,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
