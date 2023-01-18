import Vue from 'vue';
import Vuex from 'vuex';
import { Snapshot } from './modules/Snapshot';
Vue.use(Vuex);

const store = new Vuex.Store({
    /* ... */
    modules: {
        Snapshot: Snapshot.module
    },
  	/* ... */
});

export default store;
