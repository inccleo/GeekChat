import App from './App'


import Vue from 'vue'
import uView from "uview-ui";
Vue.use(uView);
import store from '@/store/index.js';
let vuexStore = require('@/store/$u.mixin.js');
Vue.mixin(vuexStore);
// 引入请求封装，将app参数传递到配置中
require('./utils/request.js')(app)
Vue.config.productionTip = false
App.mpType = 'app'
const app = new Vue({
	store,
	...App
})
app.$mount()