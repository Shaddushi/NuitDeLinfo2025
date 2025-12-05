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
        class="btn btn-dark text-white center-placement rounded-end-circle d-flex align-items-center justify-content-end fs-3"
        style="width: 60px; height: 60px"
        data-bs-toggle="offcanvas"
        data-bs-target="#sideMenu">
        <i class="bi bi-chevron-right" />
    </button>

    <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="sideMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primary">Navigation</h5>
            <button type="button" class="btn-close bg-white rounded-circle" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body container-onglet">

            <div>
            <ul class="list-unstyled">
                <li class="py-2" v-if="!isLogged">
                    <a href="/login" class="text-decoration-none text-white fs-4 nav-link-custom rounded-pill px-3 py-2">
                        <i class="bi bi-chevron-right me-2"/> Se connecter
                    </a>
                </li>
                <li class="py-2">
                    <a href="/" class="text-decoration-none text-white fs-4 nav-link-custom rounded-pill px-3 py-2">
                        <i class="bi bi-chevron-right me-2"/> Accueil
                    </a>
                </li>
                <li class="py-2" v-if="isLogged">
                    <a href="/game" class="text-decoration-none text-white fs-4 nav-link-custom rounded-pill px-3 py-2">
                        <i class="bi bi-chevron-right me-2"/> Jeu
                    </a>
                </li>
                <li class="py-2">
                  <a href="/credits" class="text-decoration-none text-white fs-4 nav-link-custom rounded-pill px-3 py-2">
                    <i class="bi bi-chevron-right me-2"/> Crédits
                  </a>
                </li>
            </ul>
            </div>
            <ul class="list-unstyled mt-auto bg-primary rounded-4 p-2" v-if="isLogged" @click="logout" role="button">
                <li class="py-2">
                  <button class="text-decoration-none text-white fs-4" style="background: none;border: none;">
                    <i class="bi bi-chevron-right me-2"/> Logout
                  </button>
                </li>
            </ul>
        </div>
    </div>
</template>


<style lang="scss">
    .container-onglet {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .nav-link-custom{
        &:hover{
            background-color: var(--bs-primary);
        }
    }

    .center-placement{
        position: absolute;
        top: 50%;
        left: -10px;
        transform: translateY(-50%);
    }
</style>