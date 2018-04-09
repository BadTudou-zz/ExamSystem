
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// 引入全局变量
import global_ from './components/Global'//引用文件
import VueRouter from 'vue-router';
import routes from './routes';    // 路由配置文件
import Vuex from 'vuex';


require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.GLOBAL = global_//挂载到Vue实例上面

// import VueResource from 'vue-resource';
// Vue.use(VueResource);
Vue.use(VueRouter);


// import 1 from './store/'; // vuex 数据存储所需对象


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

// 实例化store
let store = new Vuex.Store({
  // state 全局使用的数据
  state: {
    // permissionIdList: [1,2,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52],
    permissionIdList: [],
    userData: null,
    token: '',
  },
  mutations: {
    setToken: function (state, token) {
      state.token = token;
    },
    setUserData: function (state, userData) {
      state.userData = userData;
    },
    setPermissionIdList: function (state, permissionIdList) {
      state.permissionIdList = permissionIdList;
    }
  },
  actions: {  // 新增代码
  }
})

// 实例化 Vue
var vm = new Vue({
    store,
    router
}).$mount('#app');
