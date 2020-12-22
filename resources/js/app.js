import Vue from 'vue';
import router from './router';
import App from './App.vue';

require('./bootstrap');

const app = new Vue({
    el: '#app',
    router,
    components: { App }
});
