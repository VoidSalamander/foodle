<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card>
          <v-card-title class="text-h5">Login</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="login">
              <v-text-field
                v-model="username"
                label="Username"
                prepend-icon="mdi-account"
                type="text"
                required
              ></v-text-field>
              <v-text-field
                v-model="password"
                label="Password"
                prepend-icon="mdi-lock"
                type="password"
                required
              ></v-text-field>
              <v-btn type="submit" color="primary" block>Login</v-btn>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn @click="goToRegister" color="secondary" text>註冊</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axiosInstance from '@/api/axiosInstance';
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    ...mapActions(['mylogin']),
    async login() {
      try {
        const response = await axiosInstance.post('/login.php', {
          username: this.username,
          password: this.password
        }, {
          headers: {
            'Content-Type': 'application/json'
          }
        });
        if (response.data.message === "Login successful.") {
          alert("Login successful!");
          this.mylogin({ id: response.data.userID, username: response.data.username });
          this.$router.push('/Main');
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        console.error("There was an error!", error);
        alert("An error occurred during login. Please try again.");
      }
    },
    goToRegister() {
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
.fill-height {
  min-height: 100vh;
}
</style>
