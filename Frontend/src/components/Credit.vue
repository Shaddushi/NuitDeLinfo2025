<template>
  <div
      :class="[
      'credit-page text-white p-4 d-flex h-100 flex-column align-items-center',
      { 'credit-page-game': timerActive }
    ]"
    @click="showClickEffect"
  >
    <!-- Barre du haut -->
    <div class="top-bar w-100 mb-5">
      <div class="top-left">
        <a href="/scoreboard">
          <button
              class="btn btn-light mb-2">
            Tableau des scores
          </button>
        </a>
      </div>

      <h1 class="credits-title">Crédits</h1>

      <div class="top-right">
        <button
            class="btn btn-light mb-2"
            @click="startApp"
            v-if="!timerActive && timeLeft === 15"
        >
          Lancer le mini-jeu
        </button>

        <div v-if="timerActive || (timeLeft < 15 && timeLeft !== 0)" class="mb-0">
          Temps restant : {{ timeLeft }} s
        </div>
        <div v-if="!timerActive && timeLeft === 0" class="mb-0 text-danger">
          Jeu fini !
        </div>
      </div>
    </div>

    <div class="w-100 d-flex flex-column align-items-center gap-4 mb-5">
      <div
          v-for="(credit, cIndex) in credits"
          :key="cIndex"
          :class="['credit-row', { 'credit-div-1': started }]"
      >
        <span>
          <span
              v-for="(letter, lIndex) in credit.letters_name"
              :key="lIndex"
              @click="hideLetterName(letter, cIndex, lIndex)"
          >
            {{ letter }}
          </span>
        </span>

        <span>
          <span
              v-for="(letter, lIndex) in credit.letters_role"
              :key="lIndex"
              @click="hideLetterRole(letter, cIndex, lIndex)"
          >
            {{ letter }}
          </span>
        </span>
      </div>
    </div>

    <span class="text-warning" v-if="timerActive || timeLeft === 0">Votre score: {{ score }}</span>

    <div class="bottom-0 position-fixed mb-2">
      Merci à VLC, Libre Office, ffmpeg, firefox, debian, audacity et OBS d'exister.
    </div>
    <div
        v-if="clickEffect.visible"
        class="click-effect"
        :style="{ top: clickEffect.y + 'px', left: clickEffect.x + 'px' }"
    ></div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'Credit',
  data() {
    return {
      started: false,
      timerActive: false,
      timeLeft: 15,
      timerId: null,
      credits: [
        { name: 'DECROIX Valentin', role: 'Développeur front-end' },
        { name: 'FOLLET Hugo', role: 'Admin sys & developpeur back-end' },
        { name: 'DARQUES Tom', role: 'Développeur front-end' },
        { name: 'MORVILLE Baptiste', role: 'Graphiste en chef' },
        { name: 'HAUTECOEUR Arthur', role: 'Graphiste Adjoint' },
        { name: 'DUPORTAIL Honoré', role: 'Développeur front-end' },
        { name: 'MAILLARD Paul', role: 'Directeur du pôle histoire' },
      ].map((c) => ({
        ...c,
        letters_name: c.name.split(''),
        letters_role: c.role.split(''),
      })),
      score: 0,
      clickEffect: {
        visible: false,
        x: 0,
        y: 0,
        timeoutId: null,
      },
    };
  },
  methods: {
    startApp() {
      this.started = true;
      this.timerActive = true;
      this.timeLeft = 15;

      if (this.timerId) {
        clearInterval(this.timerId);
      }

      this.timerId = setInterval(() => {
        if (this.timeLeft > 0) {
          this.timeLeft--;
        } else {
          this.timerActive = false;
          clearInterval(this.timerId);
          this.timerId = null;
          this.sendScore();
        }
      }, 1000);
    },
    hideLetterName(letter, creditIndex, letterIndex) {
      if (!this.timerActive) return;

      this.credits[creditIndex].letters_name.splice(letterIndex, 1, '  ');
      if (letter !== '  ') {
        this.score++;
      }
    },
    hideLetterRole(letter, creditIndex, letterIndex) {
      if (!this.timerActive) return;

      this.credits[creditIndex].letters_role.splice(letterIndex, 1, '  ');
      if (letter !== '  ') {
        this.score++;
      }
    },
    sendScore() {
      const token = localStorage.getItem('token');

      axios.post('https://api.devsfecations.fr/user/score', {
        score: this.score,
      }, {
        headers: {
          Authorization: token ? `${token}` : '',
        },
      }).then(() => {
        console.log('Score envoyé avec succès');
      }).catch((error) => {
        console.error('Erreur lors de l\'envoi du score:', error);
      });
    },
    showClickEffect(event) {
      if (!this.timerActive) return;

      const x = event.clientX;
      const y = event.clientY;

      if (this.clickEffect.timeoutId) {
        clearTimeout(this.clickEffect.timeoutId);
      }

      this.clickEffect.x = x;
      this.clickEffect.y = y;
      this.clickEffect.visible = true;

      this.clickEffect.timeoutId = setTimeout(() => {
        this.clickEffect.visible = false;
        this.clickEffect.timeoutId = null;
      }, 300);
    },
  },
  beforeUnmount() {
    if (this.timerId) {
      clearInterval(this.timerId);
    }
  },
};
</script>

<style scoped>
<style scoped>
h1 {
  font-weight: bold;
  font-size: 4rem;
  margin: 0;
}

/* barre du haut */
.top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  width: 100%;
}

.credits-title {
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  font-weight: bold;
  font-size: 4rem;
  margin: 0;
}

.top-right {
  margin-left: auto;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.credit-page {
  user-select: none;
  background-color: #000;
  font-size: 1.2rem;
}

.credit-page-game {
  cursor: url("/images/pointer-01.webp") 16 16, auto;
}

.credit-page-game:active {
  cursor: url("/images/pointer-02.webp") 16 16, auto;
}

/* état initial (hors animation) */
.credit-row {
  width: 50%;
  display: flex;
  justify-content: space-between;
  opacity: 1;
  transform: translateY(0);
}

/* appliquée après clic pour lancer l'animation (8s) */
.credit-div-1 {
  animation-name: slide-up;
  animation-duration: 8s;
  animation-timing-function: ease-out;
  animation-fill-mode: forwards;
}

@keyframes slide-up {
  0% {
    opacity: 0;
    transform: translateY(100vh);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Effet visuel au clic (remplace visuellement la souris) */
.click-effect {
  position: fixed;
  width: 64px;
  height: 64px;
  margin-left: -32px; /* pour centrer sur le clic */
  margin-top: -32px;
  pointer-events: none;
  background: url("/images/debris.gif") no-repeat center;
  background-size: contain;
}
</style>
