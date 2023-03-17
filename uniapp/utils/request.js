import siteinfo from "../siteinfo.js"
module.exports = (vm) => {
	// 初始化请求配置
	uni.$u.http.setConfig((config) => {
		config.timeout = 600000;
		/* config 为默认全局配置*/
		config.baseURL = siteinfo.siteroot; /* 根域名 */
		config.wxapp_id = siteinfo.uniacid
		return config
	})
	// 请求拦截
	uni.$u.http.interceptors.request.use((config) => { // 可使用async await 做异步操作
		// 初始化请求拦截器时，会执行此方法，此时data为undefined，赋予默认{}
		config.data = config.data || {}
		// 根据custom参数中配置的是否需要token，添加对应的请求头
		// if(config?.custom?.auth) {
		// 	// 可以在此通过vm引用vuex中的变量，具体值在vm.$store.state中
		// 	config.header.token = vm.$store.state.userInfo.token
		// } b5e8a700ac9739a43eae0c83aca7b7b4
		const token = uni.getStorageSync('token');
		// const token = '6a1f1f6c7f43d854ba779de1dd4765f5';
		config.header.token = token;
		return config
	}, config => { // 可使用async await 做异步操作
		return Promise.reject(config)
	})

	// 响应拦截
	uni.$u.http.interceptors.response.use((response) => {
		/* 对响应成功做点什么 可使用async await 做异步操作*/
		const data = response.data
		// 自定义参数
		const custom = response.config?.custom
		let pages = getCurrentPages()

		return data.data === undefined ? {} : data
	}, (response) => {
		// 对响应错误做点什么 （statusCode !== 200）
		return Promise.reject(response)
	})
}
