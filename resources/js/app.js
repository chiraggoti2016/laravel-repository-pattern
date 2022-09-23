/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import router from "./router";
import "./axios";
import store from "./vuex";
import common from './mixins/common.js';
import * as constants from './mixins/constants';
import Toasted from "vue-toasted";
import Chart from "chart.js";
import DataTable from 'laravel-vue-datatable';
import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue";
import Vuelidate from "vuelidate";
// Import component
import VueLoading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.min.css';


//  import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

window.Vue = require("vue").default;
Vue.use(Toasted);


Vue.use(Vuelidate);
// Mixins
Vue.mixin(common);

//  constants
Vue.mixin(constants);

Vue.use(DataTable);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
// Vue.use(VueLoading);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("app", require("./App.vue").default);
Vue.component("loading", VueLoading);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store,
    el: "#app"
});
