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
        <v-col cols="12">
          <v-card>
            <v-card-title class="text-h5">Add Data</v-card-title>
            <v-card-text>
              <v-form @submit.prevent="submitForm">
                <v-text-field
                  v-model="form.restaurantName"
                  label="Restaurant Name"
                  prepend-icon="mdi-store"
                  required
                ></v-text-field>
                <v-text-field
                  v-model="form.city"
                  label="City"
                  prepend-icon="mdi-city"
                  required
                ></v-text-field>
                <v-text-field
                  v-model="form.district"
                  label="District"
                  prepend-icon="mdi-home-city"
                  required
                ></v-text-field>
                <v-text-field
                  v-model="form.road"
                  label="Road"
                  prepend-icon="mdi-road-variant"
                  required
                ></v-text-field>
                <v-textarea
                  v-model="form.description"
                  label="Restaurant Description"
                  prepend-icon="mdi-information"
                  rows="3"
                  required
                ></v-textarea>
                <v-switch
                  v-model="form.isChain"
                  label="Is it a chain?"
                  prepend-icon="mdi-storefront"
                ></v-switch>

                <!-- Tag Categories -->
                <v-divider class="my-4"></v-divider>
                <v-autocomplete
                  v-model="form.style"
                  :items="tagSuggestions.style"
                  label="餐廳風格"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>
                <v-autocomplete
                  v-model="form.food"
                  :items="tagSuggestions.food"
                  label="提供食物"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>
                <v-autocomplete
                  v-model="form.price"
                  :items="tagSuggestions.price"
                  label="價格區間"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>
                <v-autocomplete
                  v-model="form.time"
                  :items="tagSuggestions.time"
                  label="營業時段"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>
                <v-autocomplete
                  v-model="form.location"
                  :items="tagSuggestions.location"
                  label="鄰近地點"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>
                <v-autocomplete
                  v-model="form.other"
                  :items="tagSuggestions.other"
                  label="其他標籤"
                  multiple
                  chips
                  prepend-icon="mdi-tag"
                ></v-autocomplete>

                <!-- Custom Tags -->
                <v-text-field
                  v-model="newCustomTag"
                  label="新增標籤"
                  prepend-icon="mdi-tag"
                  append-icon="mdi-plus"
                  @click:append="addCustomTag"
                  @keyup.enter="addCustomTag"
                ></v-text-field>
                <div>
                  <v-chip
                    class="mt-2"
                    v-for="(tag, index) in form.customTags"
                    :key="index"
                    close
                    @click:close="removeCustomTag(tag)"
                  >
                    {{ tag }}
                  </v-chip>
                </div>

                <v-btn type="submit" color="primary" block>Submit</v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
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
      form: {
        restaurantName: '',
        city: '',
        district: '',
        road: '',
        description: '',
        isChain: false,
        style: [],
        food: [],
        price: [],
        time: [],
        location: [],
        other: [],
        customTags: []
      },
      newCustomTag: '',
      tagSuggestions: {
        style: [],
        food: [],
        price: [],
        time: [],
        location: [],
        other: []
      }
    };
  },
  created() {
    this.fetchTags();
  },
  methods: {
    navigateTo(page) {
      this.$router.push(page);
    },
    async fetchTags() {
      try {
        const response = await axiosInstance.get('/getTags.php');
        this.tagSuggestions = response.data;
      } catch (error) {
        console.error('Error fetching tags:', error);
        alert('Failed to fetch tags');
      }
    },
    async submitForm() {
      const formData = {
        restaurantName: this.form.restaurantName,
        city: this.form.city,
        district: this.form.district,
        road: this.form.road,
        description: this.form.description,
        isChain: this.form.isChain,
        style: this.form.style,
        food: this.form.food,
        price: this.form.price,
        time: this.form.time,
        location: this.form.location,
        other: this.form.other,
        customTags: this.form.customTags
      };

      try {
        const response = await axiosInstance.post('/addRestaurant.php', formData, {
          headers: {
            'Content-Type': 'application/json'
          }
        });
        console.log('Response:', response.data);
        this.form = {
          restaurantName: '',
          city: '',
          district: '',
          road: '',
          description: '',
          isChain: false,
          style: [],
          food: [],
          price: [],
          time: [],
          location: [],
          other: [],
          customTags: []
        };
        this.newCustomTag = '';
        alert('Data submitted successfully!');
      } catch (error) {
        console.error('Error submitting data:', error);
        alert('Failed to submit data');
      }
    },
    addCustomTag() {
      const newTag = this.newCustomTag.trim();
      if (newTag && !this.form.customTags.includes(newTag)) {
        this.form.customTags.push(newTag);
        this.newCustomTag = '';
      }
    },
    removeCustomTag(tag) {
      this.form.customTags = this.form.customTags.filter(t => t !== tag);
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

.mt-2 {
  margin: 8px 4px;
}
</style>