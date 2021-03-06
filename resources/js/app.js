/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('test', require('./components/Test.vue').default);
Vue.component('dean-excuse', require('./components/DeanExcuse.vue').default);
Vue.component('admin-excuse', require('./components/AdminExcuse.vue').default);
Vue.component('student-excuse-paid', require('./components/StudentExcusePaid.vue').default);
Vue.component('student-excuse-accepted', require('./components/StudentExcuseAccepted.vue').default);
Vue.component('student-open-lecture', require('./components/StudentOpenLecture.vue').default);
Vue.component('studen-chat', require('./components/StudentChat.vue').default);
Vue.component('student-attend-self', require('./components/StudentAttendSelf.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
