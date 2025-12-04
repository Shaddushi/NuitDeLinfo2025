import { createRouter, createWebHistory } from 'vue-router';
import Credit from '@/components/Credit.vue';
import Accueil from "@/components/Accueil.vue";
import GameContainer from "@/components/GameContainer.vue";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
