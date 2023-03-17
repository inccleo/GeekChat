<template>
	<view>
		<!-- 通知 -->
		<u-notice-bar bgColor='#6c6ceb' color="#fff" text="由于服务人数过多,如果出现异常建议重新尝试" mode="closable">
		</u-notice-bar>
		<!-- 对话列表 -->
		<view class="box-1" id="list-box">
			<view class="talk-list">
				<view v-for="(item, index) in talkList" @click="handleCopy(item.content)" :key="index"
					:id="`msg-${item.id}`">
					<view class="item flex_col" :class="item.type == 1 ? 'push' : 'pull'">
						<image :src="item.pic" mode="aspectFill" class="pic"></image>
						<view class="content">
							<zero-markdown-view :themeColor="themeColor" :markdown="item.content"></zero-markdown-view>
						</view>
						
					</view>
				</view>
			</view>
		</view>
		<!-- 聊天框 -->
		<view class="box-2">
			<view class="flex_col">
				<view @click="handleopen">
					<u-icon name="grid" color="#000" size="28"></u-icon>
				</view>
				<view class="flex_grow">
					<input type="text" class="content" :disabled="isdisable" v-model="content" placeholder="输入问题[有效提问·高效沟通]"
						placeholder-style="color:#DDD;" :cursor-spacing="6">
				</view>
				<button class="send" @tap="login" v-if="!isLogin">登录</button>
				<button class="send" @tap="send" v-else>发送</button>
			</view>
		</view>

		<!-- 我的菜单栏 -->
		<u-popup :show="show" :round="10" mode="bottom" @close="close" closeable>
			<view class="UPOP">
				<view class="title ">我的信息</view>
				<view class="margin">
					<view class="userInfo">
						<view class="info">
							<view class="vip" v-if="isLogin">微信用户</view>
							<view class="name " v-else>登录</view>
						</view>
					</view>
					<view class="stat ">
						<view class="have ">{{ '拥有额度：' + isnum + '次' }}</view>
					</view>
					<view class="invite ">
						<view class="info ">
							<view class="inviteTitle ">邀请新的小伙伴来体验</view>
							<view class="award ">奖励<text class="span">{{ invite }}</text></view>
							<view class="hint ">提示：点击右上角<text class="more ">···</text>可分享朋友圈邀请</view>
						</view>
						<view class="btn ">邀请朋友<button openType="share">邀请</button>
						</view>
					</view>
					<u-line></u-line>
					<view class="videoAd">
						<view class="info">
							<view class="videoAdTitle ">看视频广告攒次数</view>
							<view class="award ">奖励<text class="span ">{{ advertisement }}</text>次/个</view>
						</view>
						<view class="btn" @click="handleAd">观看视频</view>
					</view>
				</view>
				<u-button open-type='contact' color="#6c6ceb" :plain="true" text="咨询客服(意见反馈)"></u-button>
			</view>
		</u-popup>


		<models v-if="loginShow" :ad="true" title="为了更好的体验，快去授权登录吧" btnText="授权登录" @save="getUserInfo"
			@close="loginShow = false"></models>

		<models v-if="signShow" :authorize="false" :ad="true" :title="signTitle" btnText="知道了" closeText=" "
			@save="signShow = false"></models>
		<wxLogin @submit="submitLogin"></wxLogin>

	</view>
</template>

<script>
import wxLogin from '@/components/wxLogin.vue'
import models from '@/components/model.vue'
import siteinfo from "@/siteinfo.js"
import { MPLogin } from '@/api/passport.js';
// 在页面中定义激励视频广告
let videoAd = null

export default {
	components: {
		wxLogin,
		models
	},
	data() {
		return {
			isdisable:false,
			isLogin: false,
			loginShow: false,
			talkList: [],
			content: '',
			show: false,
			isday: 0,
			isnum: 5,
			invite: 10,
			freePerDay: 0,
			advertisement: 10,
			openid: '',
			obj: {},
			id: '',
			socketOpen: false,
			text: ''
		}
	},
	onShow() {
		let _this = this;
		if (uni.getStorageSync('token')) {
			_this.isLogin = true
		}
	},
	async onLoad({
		id
	}) {
		const that = this
		// 连接websocket
		that.connectSocket()

		uni.onSocketClose(function (res) {
		console.log('WebSocket 已关闭！');
		that.connectSocket()
		});

		uni.onSocketOpen(function (res) {
			that.socketOpen = true
			console.log('WebSocket连接已打开！');
		});

		that.id = id
		// 在页面onLoad回调事件中创建激励视频广告实例
		if (wx.createRewardedVideoAd) {
			videoAd = wx.createRewardedVideoAd({
				adUnitId: 'adunit-593140983fbc3c32'
			})
			videoAd.onLoad(() => { })
			videoAd.onError((err) => {

				uni.showToast({
					title: '暂未开放，请邀请好友',
					icon: 'none',
					duration: 2000,
				});
			})
			videoAd.onClose((res) => {
				if (res.isEnded) {
					that.handleAdd(that.openid, that.advertisement)
					return
				} else {
					uni.showToast({
						title: '请不要中途退出!',
						icon: 'none',
						duration: 2000,
					});
				}
			})
		}
	},

	onShareAppMessage: function (options) {
		const that = this;
		// 设置菜单中的转发按钮触发转发事件时的转发内容
		const shareObj = {
			title: '抢先体验GPT-4',
			path: '/pages/chat/index',
		};
		// 返回shareObj
		return shareObj;
	},
	onShareTimeline: function () {
		const that = this;
		// 设置菜单中的转发按钮触发转发事件时的转发内容
		const shareObj = {
			title: '抢先体验GPT-4', //自定义图片路径，可以是本地文件路径、代码包文件路径或者网络图片路径，支持PNG及JPG，不传入 imageUrl 则使用默认截图。显示图片长宽比是 5:4
			path: '/pages/chat/index',
		};
		// 返回shareObj
		return shareObj;
	},

	mounted() {
		this.$nextTick(() => {
			this.getHistoryMsg();
		});
	},
	methods: {
		handleAd() {
			if (videoAd) {
				videoAd.show().catch(() => {
					// 失败重试
					videoAd.load()
						.then(() => videoAd.show())
						.catch(err => {
							console.log('激励视频 广告显示失败')
						})
				})
				return
			}
		},
		async handleAdd(id, count) {
			const that = this
			const res = await AddCount({
				openid: id,
				count: count
			})
			that.isnum = that.isnum + count
			uni.setStorageSync('config', {
				...that.obj,
				num: that.isnum
			});
			uni.showToast({
				title: '恭喜成功获取使用额度',
				icon: 'none',
				duration: 2000,
			});
		},
		async handlefig(code) {
			const res = await handleConfig(code)
			const {
				day,
				freePerDay,
				invite,
				num,
				openid,
				advertisement
			} = res
			this.isday = day
			this.isnum = num
			this.invite = invite
			this.freePerDay = freePerDay
			this.advertisement = advertisement
			this.openid = openid
			uni.hideLoading()
			this.obj = res
			if (!this.id) return
			await this.handleAdd(this.id, invite)
		},
		close() {
			this.show = false
		},
		handleopen() {
			// this.show = true
		},
		handleCopy(message) {
			const that = this
			uni.setClipboardData({
				data: message,
				success: function () { }
			})
		},
		// 获取历史消息
		getHistoryMsg() {
			let get = async () => {
				let data = [{
					"id": '1', // 消息的ID
					"content": `#### GeekChat为您服务：
- 知乎百度答题、做作业
- 写代码、写文案、写论文
- 文案润色、翻译、写诗作词
- 扮演面试官,扮演书籍电影角色
- 例：写一篇工作日报我是行政
- 例：把下文翻译成英文

#### 输出字数不够时，请说继续`, // 消息内容
					"type": 0, // 此为消息类别，设 1 为发出去的消息，0 为收到对方的消息,
					"pic": "/static/logo.png", // 消息头像
				}];
				const selector = `#msg-${data[data.length - 1].id}`;
				// 将获取到的消息数据合并到消息数组中
				this.talkList = [...data, ...this.talkList];
				// 数据挂载后执行，不懂的请自行阅读 Vue.js 文档对 Vue.nextTick 函数说明。

			}
			get();
		},

		// 发送信息
		async send() {
			const taht = this
			if (!taht.content) {
				uni.showToast({
					title: '请输入有效的内容',
					icon: 'none'
				})
				return;
			}

			// 获取vuex token
			taht.token = uni.getStorageSync('token');

			if (!taht.socketOpen) {
				//重连
				taht.connectSocket();
			}

			// 将当前发送信息 添加到消息列表。
			taht.talkList.push({
				"id": new Date().getTime(),
				"content": taht.content,
				"type": 1,
				"pic": "/static/avatar.png",
			});

			// 发送信息
			uni.sendSocketMessage({
				data: JSON.stringify({
					"content": taht.content,
					"event": 'chat',
					"token": taht.token
				})
			});

			let n = 0
			n = this.talkList.length
			taht.isdisable = true
			uni.onSocketMessage(function (res) {
				// console.log('收到服务器内容：' + res.data);
				let data = JSON.parse(res.data);
				if (data.event == 'chat') {
					taht.text += data.content
					let msgboxes = {
						"id": new Date().getTime(),
						"content": taht.text, // 消息内容
						"type": 0, // 此为消息类别，设 1 为发出去的消息，0 为收到对方的消息,
						"pic": "/static/logo.png", // 消息头像
					};
					taht.talkList[n] = msgboxes;
					taht.$nextTick(() => {
						uni.pageScrollTo({
							scrollTop: 2000000, //滚动到页面的目标位置（单位px）
							duration: 0 //滚动动画的时长，默认300ms，单位 ms
						});
					})
					return
				}

				if (data.event == 'close') {
					taht.text = ''
					taht.isdisable = false
					return
				}
			});

			uni.hideLoading()
			taht.$nextTick(() => {
				// 清空内容框中的内容
				taht.content = '';
				uni.pageScrollTo({
					scrollTop: 999999, // 设置一个超大值，以保证滚动条滚动到底部
					duration: 0
				});
			})


		},
		//登录
		async login() {
			this.loginShow = true
		},
		// 微信登录
		async getUserInfo() {
			let that = this;
			uni.showLoading({
				title: '登录中...'
			});
			uni.login({
				provider: 'weixin',
				success: function (loginRes) {
					let code = loginRes.code;
					that.wxloginres(code);
				},
				fail(err) {
					uni.hideLoading()
					uni.showToast({
						icon: 'none',
						title: '登录失败',
						duration: 1500
					})
				}
			});

		},
		// 微信登录获取用户信息
		async wxloginres(wxcode) {
			let that = this;
			MPLogin({
				code: wxcode,
				appid: uni.getAccountInfoSync().miniProgram.appId,
			}).then(res => {
				uni.showToast({
					icon: 'none',
					mask: true,
					title: '登录成功',
					duration: 1500
				})
				that.$u.vuex('token', res.data.token)
				uni.setStorageSync('token', res.data.token);
				that.isLogin = true;
			}).catch(err => {

			})
			uni.hideLoading()
			that.loginShow = false
		},
		//连接socket
		async connectSocket() {
			uni.connectSocket({
			url: siteinfo.ws,
		});
		},
	}
}
</script>

<style lang="scss">
@import "index.scss"
</style>
