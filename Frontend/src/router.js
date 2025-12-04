import { createRouter, createWebHistory } from 'vue-router';
import Credit from '@/components/Credit.vue';
import Accueil from "@/components/Accueil.vue";
import Game from "@/components/Game.vue";

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
        component: Game,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
