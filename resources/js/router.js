import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './views/Home.vue';
import Profile from './views/profile/Profile.vue';
import Settings from './views/profile/Settings.vue';

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'Home', component: Home },
        { path: '/:slug', name: 'Profile', component: Profile },
        { path: '/settings/:id', name: 'Settings', component: Settings },
        { path: '*', redirect: '/' }
    ]
});

