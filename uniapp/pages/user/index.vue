<template>
	<view>
		<view class="">
			<view :style="{ marginTop: menuButtonInfo.top + (menuButtonInfo.bottom - menuButtonInfo.top) / 2 + 'px' }"></view>
			<view class="u-flex u-row-between u-col-center u-p-r-40">
				<view class="user u-p-l-40 u-p-r-40 u-flex u-row-left u-col-center" @click="loginClick">
					<image class="avatar" :src="'/static/avatar.png'"></image>
					<view class="u-p-l-20">
						<view class="name u-font-18">{{ is_login ? '微信用户' : '登录' }}</view>
						<!-- <view class="addr u-light-color u-p-t-10 u-font-12">无限制~</view> -->
					</view>
				</view>
				<!-- <view class="" style="margin-top: 100rpx;"  @click="exitClick">
					<u-icon name="/static/icon/exit.png" size="56"></u-icon>
				</view> -->
			</view>
			<!-- <view class="jifen u-flex u-row-left u-p-l-30 u-p-r-30 u-m-t-50">
				<view class="tab u-flex-col u-row-center u-col-center u-p-t-40 u-p-b-40 border-box" hover-class="hover-class" hover-stay-time="50">
					<view class="icon u-flex u-row-center u-col-center">
						<image src="/static/icon/user1.png"></image>
					</view>
					<view class="title u-main-color u-p-t-10 u-font-12">邀请好友</view>
					<view class="cont u-light-color u-p-t-10 u-font-12">+{{inviteIntegral}}积分/位</view>
					<button open-type="share" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;opacity: 0;"></button>
				</view>
				<view class="tab u-flex-col u-row-center u-col-center u-p-t-40 u-p-b-40 border-box" hover-class="hover-class" hover-stay-time="50" @click="signClick">
					<view class="icon u-flex u-row-center u-col-center" :class="isSign?'icons':''">
						<image src="/static/icon/user2.png"></image>
					</view>
					<view class="title u-main-color u-p-t-10 u-font-12">每日签到</view>
					<view class="cont u-light-color u-p-t-10 u-font-12">+{{signIntegral}}积分/天</view>
				</view>
				<view class="tab u-flex-col u-row-center u-col-center u-p-t-40 u-p-b-40 border-box" hover-class="hover-class" hover-stay-time="50" @click="adClick">
					<view class="icon u-flex u-row-center u-col-center">
						<image src="/static/icon/video.png"></image>
					</view>
					<view class="title u-main-color u-p-t-10 u-font-12">赚取积分</view>
					<view class="cont u-light-color u-p-t-10 u-font-12">+{{adIntegral}}积分/次</view>
				</view>
			</view> -->
			<view class="menu u-m-l-40 u-m-r-40 u-m-t-40 border-box">
				<!-- <view class="u-flex u-row-between u-p-30" hover-class="hover-class1" hover-stay-time="50" @click="recordClick">
					<view class="u-flex u-row-left">
						<image src="/static/icon/jinbi.png"></image>
						<view class="u-p-l-20">我的积分</view>
					</view>
					<view class="u-flex u-row-right">
						<view class="u-light-color u-font-12 u-p-r-10">{{vuex_user?vuex_user.integral:0}}积分</view>
						<view class="arror-right"></view>
					</view>
				</view> -->

			</view>
			<view class="adContainer u-m-40" v-if="wxVideoAdIds.length">
				<!-- #ifdef MP-WEIXIN -->
				<ad :unit-id="wxVideoAdIds[Math.floor(Math.random() * wxVideoAdIds.length + 1) - 1]" ad-type="video"
					ad-theme="white"></ad>
				<!-- #endif -->
			</view>
			<view class="menu u-m-l-40 u-m-r-40 u-m-t-40 border-box">
				
				<view class="u-flex u-row-between u-p-30 border-bottom" style="position: relative;"
					hover-class="hover-class1" hover-stay-time="50">
					<view class="u-flex u-row-left">
						<image src="/static/kefu.png"></image>
						<view class="u-p-l-20">联系客服</view>
					</view>
					<view class="u-flex u-row-right">
						<view class="arror-right"></view>
					</view>
					<button open-type="contact"
						style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;opacity: 0;"></button>
				</view>

				<!-- 赞赏作者 -->
				<view class="u-flex u-row-between u-p-30 border-bottom" style="position: relative;"
					hover-class="hover-class1" hover-stay-time="50" @click="zanshang">
					<view class="u-flex u-row-left">
						<image src="/static/zanshang.png"></image>
						<view class="u-p-l-20">赞赏作者</view>
					</view>
					<view class="u-flex u-row-right">
						<view class="arror-right"></view>
					</view>
				</view>
				

			</view>
			<view class="quit u-text-center u-p-t-40" v-if="is_login" @click="exitClick">退出登录</view>
			<view class="" style="height: 180rpx;"></view>
		</view>

		<models v-if="loginShow" :ad="true" title="为了更好的体验，快去授权登录吧" btnText="授权登录" @save="getUserInfo"
			@close="loginShow = false"></models>

		<models v-if="signShow" :authorize="false" :ad="true" :title="signTitle" btnText="知道了" closeText=" "
			@save="signShow = false"></models>
		<wxLogin @submit="submitLogin"></wxLogin>

		<ad unit-id="adunit-33a012033495f561"></ad>

	</view>
</template>

<script>
let videoAd = null;
// 获取系统状态栏的高度
let menuButtonInfo = {};
// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
menuButtonInfo = uni.getMenuButtonBoundingClientRect();
// #endif

import models from '@/components/model.vue'
import wxLogin from '@/components/wxLogin.vue'
import { MPLogin } from '@/api/passport.js';
export default {
	components: {
		models,
		wxLogin
	},
	data() {
		return {
			is_login: false,
			menuButtonInfo: menuButtonInfo,
			loadShow: true,
			// 签到
			isSign: false,
			signShow: false,
			signTitle: '',
			signIntegral: 0,
			inviteIntegral: 0,
			adIntegral: 0,
			// 登录弹窗
			loginShow: false,
		}
	},
	async onLoad() {
		let that = this
		if (that.vuex_user) {
			// that.getUser()
		}
		that.loadShow = false

	},
	async onShow() {
		let _this = this;
		if (uni.getStorageSync('token')) {
			_this.is_login = true
		}
	},
	methods: {
		loginClick() {
			let that = this
			if(!that.is_login){
				that.loginShow = true
			}
		},
		exitClick() {
			var that = this
			uni.showModal({
				title: '温馨提示',
				content: '确定退出当前登录账户？',
				confirmText: '退出',
				confirmColor: '#7966ff',
				success: async function (res) {
					if (res.confirm) {
						that.$u.vuex('token', '')
						// 清空token
						uni.removeStorageSync('token')
						that.is_login = false
					}
				}
			})
		},
		getUserInfo(e) {
			let that = this
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
				that.is_login = true
				uni.setStorageSync('token', res.data.token);
			}).catch(err => {

			})
			uni.hideLoading()
			that.loginShow = false
		},
		
		zanshang() {
			// 屏幕中间显示一个模态弹窗 显示二维码
			uni.showModal({
				title: '赞赏',
				content: '如果您觉得本小程序不错，可以请作者喝杯咖啡哦~',
				showCancel: false,
				confirmText: '赞赏',
				confirmColor: '#7966ff',
				success: function (res) {
					if (res.confirm) {
						uni.previewImage({
							urls: ['https://chatgpt.pcmxj.com/uploads/qrcode.jpg']
						})
					}
				}
			})
		},

	},
	onShareAppMessage(res) {
		return {
			title: '抢先体验GPT-4',
			imageUrl: '/static/share_bg.jpg',
			path: '/pages/index/index?userId=' + this.vuex_user._id
		}
	},
	onShareTimeline(res) {
		return {
			title: '抢先体验GPT-4',
			imageUrl: '/static/share_bg.jpg',
			path: '/pages/index/index'
		}
	}
}
</script>

<style lang="scss">
.user {
	.avatar {
		width: 116rpx;
		height: 116rpx;
		border-radius: 116rpx;
	}

	.name {
		font-size: 40rpx;
		font-weight: 500;
	}
}

.jifen {
	.tab {
		position: relative;
		background-color: #FFFFFF;
		width: 234rpx;
		margin-right: 10rpx;
		margin-left: 10rpx;

		.title {
			font-weight: 550;
		}

		.icon {
			width: 80rpx;
			height: 80rpx;
			border-radius: 80rpx;

			image {
				width: 46rpx;
				height: 46rpx;
			}
		}
	}

	.tab:nth-child(1) .icon {
		background-image: linear-gradient(to bottom right, #8acfaf, #5FBB92, #8acfaf);
		margin-right: 10rpx;
	}

	.tab:nth-child(2) .icon {
		background-image: linear-gradient(to bottom right, #f0d35c, #F0B347, #f0d35c);
		margin-right: 10rpx;
	}

	.tab:nth-child(2) .icons {
		background-image: linear-gradient(to left top, #dadada, #dadada, #dadada);
	}

	.tab:nth-child(3) .icon {
		background-image: linear-gradient(to bottom right, #8c99de, #836AF0, #8c99de);
	}
}

.border-box {
	box-shadow: 0 0px 24px rgba(231, 231, 231, 0.65);
	border-radius: 16rpx;
}

.menu {
	image {
		width: 38rpx;
		height: 38rpx;
	}
}

.border-bottom {
	border-bottom: 1rpx solid #F6F6F6;
}

.hover-class {
	transform: scale(0.95);
	transition: all 0.2s;
}

.hover-class1 {
	background-color: #F8F8F8;
}

.arror-right {
	width: 15rpx;
	height: 15rpx;
	border-top: 3rpx solid #a9acb3;
	border-right: 3rpx solid #a9acb3;
	transform: rotate(45deg);
}

.quit {
	color: #fa6868;
}</style>
