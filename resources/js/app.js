/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import store from './store';
import router from './router';
import BootstrapVue from 'bootstrap-vue'

require('./bootstrap');

Vue.use(BootstrapVue);
//Swal

window.Swal = require('sweetalert2');

const Toast = window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000
});

axios.interceptors.request.use(function (config) {

    if(!config.noloading) {
        store.commit('loading');
    }

    return config;
}, (error) => {

    store.commit('endLoading');
    return Promise.reject(error);
});

axios.interceptors.response.use((response) => {
    store.commit('endLoading');
    return response;
}, function (error) {
    let json = error.response.data;
    let message = json.message;

    store.commit('endLoading');

    //If error 401 redirect to login
    if(error.response.status === 401) {
        router.push('/login');
    } else if(error.response.status === 404) {
        message = 'El recurso no existe';
    }

    if(json.errors !== undefined) {
        let errors = [];
        console.log(json.errors);
        _.forEach(json.errors, (err, index) => {
            errors.push(err[0]);
        });

        Toast.fire('Error', errors.join('<br>'), 'error');
    } else {
        Toast.fire('Error', message, 'error');
    }

    return Promise.reject(error.response);
});

require('./helpers');

const app = new Vue({
    router,
    store
}).$mount('#app');
