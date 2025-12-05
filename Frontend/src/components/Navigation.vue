<script setup>
    import { ref, onMounted , watch} from "vue";
    
    const isLogged = ref(false);
    
    onMounted(() => {
        setInterval(() => {
            const token = localStorage.getItem("token");
            isLogged.value = !!token;
        }, 200); 
    });



    function logout() {
        localStorage.removeItem("token");
    }
</script>


<template>
    <button
        class="btn btn-dark text-white center-placement rounded-circle d-flex align-items-center justify-content-end fs-5"
        style="width: 60px; height: 60px"
        data-bs-toggle="offcanvas"
        data-bs-target="#sideMenu">
        <i class="bi bi-chevron-right" />
    </button>

    <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="sideMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white">Navigation</h5>
            <button type="button" class="btn-close bg-white rounded-circle" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body container-onglet">

            <div>
            <ul class="list-unstyled">
                <li class="py-2" v-if="!isLogged">
                    <a href="/login" class="text-decoration-none text-white fs-5">
                        <i class="bi bi-chevron-right me-2"/> Se connecter
                    </a>
                </li>
                <li class="py-2">
                    <a href="/" class="text-decoration-none text-white fs-5">
                        <i class="bi bi-chevron-right me-2"/> Accueil
                    </a>
                </li>
                <li class="py-2" v-if="isLogged">
                    <a href="/game" class="text-decoration-none text-white fs-5">
                        <i class="bi bi-chevron-right me-2"/> Jeu
                    </a>
                </li>
                <li class="py-2">
                  <a href="/credits" class="text-decoration-none text-white fs-5">
                    <i class="bi bi-chevron-right me-2"/> Crédits
                  </a>
                </li>
            </ul>
            </div>
            <ul class="list-unstyled mt-auto" v-if="isLogged">
                <li class="py-2">
                  <button @click="logout" class="text-decoration-none text-white fs-5" style="background: none;border: none;">
                    <i class="bi bi-chevron-right me-2"/> Logout
                  </button>
                </li>
            </ul>
        </div>
    </div>
</template>


<style scoped>
    .container-onglet {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
</style>