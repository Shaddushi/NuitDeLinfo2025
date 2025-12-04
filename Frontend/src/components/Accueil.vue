<template>
  <div class="credit-page p-4">
    <h1 class="mb-3">Accueil</h1>
    <p>Merci d'utiliser notre application. Cette page est encore en construction.</p>

      <LoginLayout />
  </div>
</template>

<script>

import LoginLayout from "@/components/LoginLayout.vue";

export default {
  name: 'Accueil',
    components: {LoginLayout},
};
</script>
