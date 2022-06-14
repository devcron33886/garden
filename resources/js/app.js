/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'

// });


$(function () {

    const scrollToElement = function (el, ms) {
        const speed = (ms) ? ms : 600;
        $('html,body').animate({
            scrollTop: $(el).offset().top
        }, speed);
    };


    $('[data-toggle="tooltip"]').tooltip();

    const observer = lozad(); // lazy loads elements with default selector as '.lozad'
    observer.observe();

    $('.scroll').click(function (e) {
        e.preventDefault();
        scrollToElement($(this).attr('href'), 2000);
    });


});


setTimeout(() => {
    $('.flash-removable').remove();
}, 3000);

