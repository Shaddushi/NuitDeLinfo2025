<template>
  <div class="scoreboard-container">
    <div class="scoreboard">
      <h1 class="scoreboard-title">Tableau des Scores</h1>
      <table class="score-table">
        <thead>
        <tr>
          <th>Rang</th>
          <th>Nom</th>
          <th>Score</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(score, index) in scores" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ score.user }}</td>
          <td>{{ score.score }}</td>
        </tr>
        </tbody>
      </table>
      <button class="btn btn-primary mt-4" @click="goToGame">
        Retour au jeu
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'Scoreboard',
  data() {
    return {
      scores: [],
    };
  },
  created() {
    this.getAllScores();
  },
  methods: {
    goToGame() {
      this.$router.push('/game');
    },

    getAllScores() {
      axios
          .get('http://api.devsfecations.fr/user/score/tab')
          .then((response) => {
            this.scores = response.data.map((user) => ({
              score: user.score,
              user: user.pseudo,
            }));
            this.sortedScores();
          })
          .catch((error) => {
            alert(
                "Erreur lors de la connexion : " +
                (error.response?.data?.message || 'Erreur inconnue')
            );
          });
    },

    sortedScores() {
      this.scores = this.scores.sort((a, b) => b.score - a.score);
    },
  },
};
</script>

<style scoped>
.scoreboard-container {
  width: 100%;
  height: 100%;
  background-color: #e2e2e2;
  color: #040F29
}

.scoreboard {
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
}
.scoreboard-title {
  margin-bottom: 20px;
}
.score-table {
  width: 100%;
  border-collapse: collapse;
}
.score-table th,
.score-table td {
  border: 1px solid #ddd;
  padding: 8px;
}
.score-table th {
  background-color: #f2f2f2;
}
</style>
