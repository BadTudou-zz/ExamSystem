
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// 引入全局变量
import Vue from 'vue';
import global_ from './components/Global'//引用文件
import VueRouter from 'vue-router';
import routes from './routes2';    // 路由配置文件
import global_css from '../../assets/sass/global.css';
import VCharts from 'v-charts';
import axios from 'axios'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

require('./bootstrap');
// window.Vue = require('vue');

Vue.prototype.GLOBAL = global_; //挂载到Vue实例上面

// import VueResource from 'vue-resource';
// Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VCharts);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('app', require('./components/App.vue'));

// 实例化路由
const router = new VueRouter({
  routes
})

axios.interceptors.response.use(function (response) {
  return response;
}, function (err) {
  if (err && err.response) {
    switch (err.response.status) {
      case 400:
        err.message = '请求错误(400)' ;
        alert(err.message);
        break;
      case 401:
        err.message = '未授权，请重新登录(401)';
        // sessionStorage.clear();
        // router.replace({
        //     path: '/Main',
        // })
        alert(err.message);

        break;
      case 403:
        err.message = '拒绝访问(403)';
        alert(err.message);
        break;
      case 404:
        err.message = '请求出错(404)';
        alert(err.message);
        break;
      case 408:
        err.message = '请求超时(408)';
        alert(err.message);
        break;
      case 422:
        alert(err.response.data.message)
        break;
      case 500:
        err.message = '服务器错误(500)';
        alert(err.message);
        break;
      case 501:
        err.message = '服务未实现(501)';
        alert(err.message);
        break;
      case 502:
        err.message = '网络错误(502)';
        alert(err.message);
        break;
      case 503:
        err.message = '服务不可用(503)';
        alert(err.message);
        break;
      case 504:
        err.message = '网络超时(504)';
        alert(err.message);
        break;
      case 505:
        err.message = 'HTTP版本不受支持(505)';
        alert(err.message);
        break;
      default:
        err.message = `连接出错(${err.response.status})!`
        alert(err.message);
    }
  }
  else {
    alert('连接服务器失败!')
    err.message = '连接服务器失败!'
  }
  message.error(err.message);
  return Promise.reject(err);
});

// 判断是否需要登录权限 以及是否登录
// router.beforeEach((to, from, next) => {
//   if (to.meta.requireAuth) {
//     if (localStorage.getItem('token')) {
//       next();
//     }
//     else {
//       next({
//         path: '/login',
//         query: {redirect: to.fullPath}
//       })
//     }
//   }
//   else {
//     next();
//   }
// });



// // 实例化store
// let store = new Vuex.Store({
//   // state 全局使用的数据
//   state: {
//     // permissionIdList: [1,2,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52],
//     permissionIdList: [],
//     userData: null,
//     token: '',
//   },
//   mutations: {
//     setToken: function (state, token) {
//       state.token = token;
//     },
//     setUserData: function (state, userData) {
//       state.userData = userData;
//     },
//     setPermissionIdList: function (state, permissionIdList) {
//       state.permissionIdList = permissionIdList;
//     }
//   },
//   actions: {  // 新增代码
//   }
// })

// 实例化 Vue
var vm = new Vue({
    // store,
    router
}).$mount('#app');
