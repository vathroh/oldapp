require('./bootstrap');

window.Vue = require('vue');

import Formupload from './components/Inputfile/FormUpload'

const app = new Vue({
    // el: '#app',
    // components: {
    //     Dashboardmenu
    // },
    // router
    el: '#app',
    components: {
        Formupload
    },

});
