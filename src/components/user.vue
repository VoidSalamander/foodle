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
    <v-container>
      <v-row>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title class="text-h5">User Profile</v-card-title>
            <v-card-text>
              <v-form @submit.prevent="updateUser">
                <v-text-field v-model="user.username" label="Username"></v-text-field>
                <v-text-field v-model="user.email" label="Email"></v-text-field>
                <v-text-field v-model="user.currentPassword" label="Current Password" type="password" required></v-text-field>
                <v-text-field v-model="user.newPassword" label="New Password" type="password"></v-text-field>
                <v-btn type="submit" color="primary" block>Update</v-btn>
                <v-btn text @click="logout" class="my-4">Logout</v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title class="text-h5">Leaderboard</v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item-group>
                  <v-list-item v-for="(player, index) in leaderboard" :key="index">
                    <v-list-item-content>
                      <v-list-item-title>{{ player.username }}</v-list-item-title>
                      <v-list-item-subtitle>Wins: {{ player.win_count }} | Plays: {{ player.play_count }}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import axiosInstance from '@/api/axiosInstance';
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'App',
  computed: {
    ...mapGetters(['getUser']),
    username() {
      return this.getUser ? this.getUser.username : 'User';
    }
  },
  data() {
    return {
      user: {
        username: '',
        email: '',
        currentPassword: '',
        newPassword: ''
      },
      leaderboard: []
    };
  },
  created() {
    this.fetchLeaderboard();
    if (this.getUser) {
      this.user.username = this.getUser.username;
      this.user.email = this.getUser.email;
    }
  },
  methods: {
    ...mapActions(['logoutuser']), // 映射 Vuex 的登出操作
    navigateTo(page) {
      this.$router.push(page);
    },
    async updateUser() {
      try {
        const response = await axiosInstance.post('/updateUserData.php', {
          id: this.getUser.id,
          currentPassword: this.user.currentPassword,
          newPassword: this.user.newPassword,
          username: this.user.username,
          email: this.user.email
        }, {
          headers: { 'Content-Type': 'application/json' }
        });
        if (response.data.message === "Update successful") {
          alert("Update successful!");
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        console.error('Error updating user data:', error);
        alert('Error updating user data');
      }
    },
    async fetchLeaderboard() {
      try {
        const response = await axiosInstance.get('/getLeaderboard.php');
        this.leaderboard = response.data;
      } catch (error) {
        console.error('Error fetching leaderboard:', error);
      }
    },
    logout() {
      this.logoutuser(); // 調用 Vuex 的登出操作
      this.$router.push('/login'); // 導航到登錄頁面
    }
  }
};
</script>

<style scoped>
.fill-height {
  min-height: 100vh;
}
.my-4 {
  margin: 16px 0;
}
</style>
