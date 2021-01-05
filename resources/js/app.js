require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import routes from './router';

Vue.component('Index', require('./components/bdi/Index').default);
Vue.component('gis', require('./views/gis/index').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
});
