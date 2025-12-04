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

        <div class="offcanvas-body ">
            <span class="text-white">

            </span>
            <ul class="list-unstyled">
                <li class="py-2">
                    <a href="#" class="text-decoration-none text-white fs-5">
                        <i class="bi bi-chevron-right me-2"/> Accueil
                    </a>
                </li>
                <li class="py-2">
                    <a href="#" class="text-decoration-none text-white fs-5">
                        <i class="bi bi-chevron-right me-2"/> Jeu
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    }
}
</script>