require('./bootstrap');

window.Vue = require('vue');
// import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import BlogDashboard from './components/BlogDashboard'
import Dashboardmenu from './components/Dashboardmenu'
import CreatePost from './components/CreatePost'
import Fileinput from './components/Inputfile/Fileinput'

const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/blog/dashboard',
            name: 'dashboard',
            component: BlogDashboard
        },
        {
            path: '/blog/createpost',
            name: 'createpost',
            component: CreatePost
        }
    ]
})

const app = new Vue({
    // el: '#app',
    // components: {
    //     Dashboardmenu
    // },
    // router
    el: '#image-form-wrapper',
    components: {
        Fileinput
    },
    router
});
