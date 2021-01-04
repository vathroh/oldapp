require('./bootstrap');

window.Vue = require('vue');

import Index from './components/bdi/index'

const app = new Vue({
    // el: '#app',
    // components: {
    //     Dashboardmenu
    // },
    // router
    el: '#app',
    components: {
        index
    },

});
