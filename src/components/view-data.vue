<template>
  <v-app>
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
        <v-text-field
          v-model="searchQuery"
          label="Search"
          prepend-icon="mdi-magnify"
          class="mb-4"
        ></v-text-field>
        <v-row>
          <v-col cols="12" md="6" lg="3" v-for="(restaurant, index) in filteredRestaurants" :key="index">
            <v-card class="mb-4">
              <v-card-title>{{ restaurant.name }}</v-card-title>
              <v-card-text>
                <div>{{ restaurant.description }}</div>
                <v-chip
                  v-for="(tag, tagIndex) in restaurant.tags"
                  :key="tagIndex"
                  class="ma-1"
                  color="primary"
                  outlined
                >
                  {{ tag }}
                </v-chip>
              </v-card-text>
              <v-card-actions v-if="isAdmin">
                <v-btn color="red" @click="confirmDelete(restaurant.id)">Delete</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axiosInstance from '@/api/axiosInstance';
import { useRouter } from 'vue-router';
import { mapGetters } from 'vuex';

export default {
  name: 'ViewDataPage',
  computed: {
    ...mapGetters(['getUser']),
    username() {
      return this.getUser ? this.getUser.username : 'UUUUUUU';
    },
    isAdmin() {
      return this.getUser && this.getUser.id < 10;
    }
  },
  setup() {
    const searchQuery = ref('');
    const restaurants = ref([]);
    const router = useRouter();

    const filteredRestaurants = computed(() => {
      const query = searchQuery.value.trim().toLowerCase();
      if (!query) {
        return restaurants.value;
      }
      return restaurants.value.filter(restaurant => {
        const nameMatches = restaurant.name.toLowerCase().includes(query);
        const tagMatches = restaurant.tags.some(tag =>
          tag.toLowerCase().includes(query)
        );
        return nameMatches || tagMatches;
      });
    });

    const fetchRestaurants = () => {
      axiosInstance.get('/getRestaurants.php')
        .then(response => {
          restaurants.value = response.data;
        })
        .catch(error => console.error('Error fetching data:', error));
    };

    const confirmDelete = (id) => {
      if (window.confirm("Are you sure you want to delete this restaurant?")) {
        deleteRestaurant(id);
      }
    };

    const deleteRestaurant = (id) => {
      axiosInstance.post('/deleteRestaurant.php', { id })
        .then(response => {
          fetchRestaurants();
        })
        .catch(error => console.error('Error deleting restaurant:', error));
    };

    const navigateTo = (page) => {
      router.push(page);
    };

    onMounted(fetchRestaurants);

    return {
      searchQuery,
      filteredRestaurants,
      navigateTo,
      confirmDelete
    };
  }
};
</script>

<style scoped>
.mb-4 {
  margin-bottom: 16px;
}
.ma-1 {
  margin: 4px;
}
</style>
