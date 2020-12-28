import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './views/Home.vue';
import Profile from './views/profile/Profile.vue';
import Settings from './views/profile/Settings.vue';
import AddPost from './views/post/AddPost.vue';
import EditPost from './views/post/EditPost.vue';
import SearchFriends from './views/SearchFriends.vue';
import Chat from './views/chat/Chat.vue';
import ChatWith from './views/chat/ChatWith.vue';

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'Home', component: Home },
        { path: '/searchfriends', name: 'SearchFriends', component: SearchFriends },
        { path: '/chat', name: 'Chat', component: Chat },
        { path: '/chat/:slug', name: 'ChatWith', component: ChatWith },
        { path: '/:slug', name: 'Profile', component: Profile },
        { path: '/settings/:id', name: 'Settings', component: Settings },
        { path: '/addpost/:id', name: 'AddPost', component: AddPost },
        { path: '/:slug/post/:id', name: 'EditPost', component: EditPost },
        { path: '*', redirect: '/' }
    ]
});

