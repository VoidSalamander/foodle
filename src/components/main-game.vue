<template>
  <v-app-bar app color="primary" dark>
    <v-toolbar-title>Foodle</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn text @click="navigateTo('/Main')">Home</v-btn>
    <v-btn text @click="navigateTo('/AddingData')">Add Data</v-btn>
    <v-btn text @click="navigateTo('/ViewData')">View Data</v-btn>
    <v-btn text @click="navigateTo('/Userpage')">{{ username }}</v-btn>
  </v-app-bar>
  <v-main>
    <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="6">
          <v-card>
            <v-card-title class="text-h5">Guess the Restaurant</v-card-title>
            <v-card-text>
              <v-row justify="center" class="mb-4">
                <v-chip
                  v-for="(hint, index) in displayedHints"
                  :key="index"
                  class="ma-2"
                  color="primary"
                  outlined
                  @mouseenter="showHint(index)"
                  @mouseleave="hideHint"
                >
                  {{ hint.label }}
                </v-chip>
              </v-row>
              <v-tooltip v-if="showTooltip" top>
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on" class="custom-tooltip">{{ tooltipText }}</span>
                </template>
              </v-tooltip>
              <v-autocomplete
                v-model="userGuess"
                :items="suggestions"
                label="Your Guess"
                prepend-icon="mdi-pencil"
                outlined
                hide-no-data
                hide-details
                class="mb-4"
              ></v-autocomplete>
              <v-btn @click="checkAnswer" color="primary" block class="mb-4">Submit</v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- Dialog for result message -->
    <v-dialog v-model="resultDialog" persistent max-width="450">
      <v-card>
        <v-card-title class="headline">{{ resultMessage }}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="resetGame">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-main>
</template>

<script>
import axiosInstance from '@/api/axiosInstance';
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['getUser']),
    username() {
      return this.getUser ? this.getUser.username : 'UUUUUUU';
    }
  },
  data() {
    return {
      hints: [],
      displayedHints: [],
      showTooltip: false,
      tooltipText: '',
      userGuess: '',
      suggestions: [],
      resultMessage: '',
      resultDialog: false,
      correctAnswer: ''
    };
  },
  methods: {
    showHint(index) {
      this.tooltipText = this.displayedHints[index].description;
      this.showTooltip = true;
    },
    hideHint() {
      this.showTooltip = false;
    },
    async fetchQuestion() {
      try {
        const response = await axiosInstance.post('/getRandRest.php');
        const data = response.data;
        this.correctAnswer = data.restaurant_name;
        this.hints = data.tags.map(tag => ({
          label: tag.tag_name,
          description: tag.tag_info
        }));
        this.displayedHints = [this.hints[0]];
        this.resultMessage = '';
        this.userGuess = '';
      } catch (error) {
        console.error("Error fetching data: ", error);
      }
    },
    async fetchSuggestions() {
      try {
        const response = await axiosInstance.get('/getRestName.php');
        this.suggestions = response.data;
      } catch (error) {
        console.error("Error fetching suggestions: ", error);
      }
    },
    async updateUserStats(win) {
      try {
        await axiosInstance.post('/updateUserStats.php', {
          userId: this.getUser.id,
          win: win
        });
      } catch (error) {
        console.error("Error updating user stats: ", error);
      }
    },
    async checkAnswer() {
      if (this.userGuess.trim().toLowerCase() === this.correctAnswer.toLowerCase()) {
        this.resultMessage = '恭喜你，猜對了！';
        this.resultDialog = true;
        await this.updateUserStats(true);
      } else {
        if (this.displayedHints.length < this.hints.length) {
          this.displayedHints.push(this.hints[this.displayedHints.length]);
          this.resultMessage = '抱歉，猜錯了，再試一次吧。';
        } else {
          this.resultMessage = '所有提示已公布，抱歉，你未能猜中。';
          this.resultDialog = true;
          await this.updateUserStats(false);
        }
      }
    },
    resetGame() {
      this.resultDialog = false;
      this.fetchQuestion();
    },
    navigateTo(page) {
      this.$router.push(page);
    }
  },
  async mounted() {
    await this.fetchQuestion();
    await this.fetchSuggestions();
  }
};
</script>

<style scoped>
.fill-height {
  min-height: 100vh;
}
.ma-2 {
  margin: 8px;
}
.mb-4 {
  margin-bottom: 16px;
}
.custom-tooltip {
  margin-bottom: 40px;
}
</style>
