
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

// 引入全局变量
import global_ from './components/Global'//引用文件
Vue.prototype.GLOBAL = global_//挂载到Vue实例上面

// import VueResource from 'vue-resource';
// Vue.use(VueResource);
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// import 1 from './store/'; // vuex 数据存储所需对象

import routes from './routes';    // 路由配置文件

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('app', require('./components/App.vue'));
Vue.component('navigation', require('./components/Navigation.vue'));


// const app = new Vue({
//     el: '#app'
// });

// 实例化路由
const router = new VueRouter({
    routes
});

// 实例化 Vue
var vm = new Vue({
    // store,
    router
}).$mount('#app');
