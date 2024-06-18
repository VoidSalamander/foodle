import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state: {
    user: null
  },
  
  mutations: {
    setUser(state, user) {
      state.user = user;
    }
  },
  actions: {
    mylogin({ commit }, user) {
      commit('setUser', user);
    },
    logoutuser({ commit }) {
      commit('setUser', null);
    }
  },
  getters: {
    isAuthenticated: state => !!state.user,
    getUser: state => state.user
  },
  plugins: [createPersistedState()]
});
