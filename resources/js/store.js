import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loadingCount: 0
  },
  mutations: {
    loading (state) {
      state.loadingCount++;
      console.log('Loading Add', state.loadingCount);
    },
    endLoading (state) {
      if(state.loadingCount > 0) {
        state.loadingCount--;
      }
      console.log('Loading Remove', state.loadingCount);
    }
  },
});
