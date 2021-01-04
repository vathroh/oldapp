require('./bootstrap');

window.Vue = require('vue');

Vue.component('Index', require('./components/bdi/Index').default);

const app = new Vue({
    el: '#app',
});
