<template>
	<view class="container">
		<view class="notice">
			<!-- <u-notice-bar bgColor="#fff" color="#82848a" :text=""></u-notice-bar> -->
		</view>

		<view class="form">

			<view class="logo">
				<u--image src="/static/logo.png" shape="circle" width="200rpx" height="200rpx">
				</u--image>
			</view>
			<u-transition :show="true" mode="slide-left">
				<view class="title">GeekChat</view>
			</u-transition>
			<u-transition :show="true" mode="slide-right">
				<view class="desc">抢先体验GPT-4</view>
			</u-transition>

		</view>


		<u-transition :show="true" mode="slide-right">
			<view class="tool_list">
				<view class="group_tool_wrap" v-for="item in list" :key="item._id" @click="handleJump(item)">
					<view class="label_wrap" style="background-color: #6c6ceb" v-if="item.tags">{{ item.tags }}</view>
					<view class="label_wrap" v-else></view>
					<view class="tool_wrap">
						<view class="tool_info">
							<view class="tool_name">{{ item.title }}</view>
							<view class="tool_hint">{{ item.desc }}</view>
						</view>
						<u--image :showLoading="true" :src="item.img" width="80rpx" height="80rpx"></u--image>
					</view>
				</view>
			</view>
		</u-transition>
		
		
		<ad unit-id="adunit-3130ab1a2beb1815" style="margin-top:60rpx;"></ad>
	</view>
</template>


<script>
export default {
	data() {
		return {
			list: [{
				"_id": '6404632309e2988160df195a',
				"title": "AI对话",
				"tags": "热门",
				"desc": "解你困惑，知你烦恼。",
				"img": "/static/index/chat.png",
				"path": "/pages/chat/index",
				"type": "URL",
				"state": true
			}, {
				"_id": "6405386328064aa7a8793a13",
				"appid": "",
				"desc": "一句话生成一张图片",
				"img": "/static/index/picture.png",
				"path": "/pages/huihua/huihua",
				"tags": "",
				"title": "AI绘画",
				"type": "CLOSE",
				"state": true
			}]
		}
	},
	methods: {
		handleJump(item) {
				switch (item.type) {
					case 'URL':
						uni.navigateTo({
							url: item.path
						})
						break
					case 'WEAPP':
						uni.navigateToMiniProgram({
							appId: item.appid,
							path: item.path,
						})
						break
					case 'CLOSE':
						this.$u.toast('暂未开放,敬请期待');
						break
				}
			},
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
}
</script>

<style lang="scss">

.notice {
	margin-top: 15rpx;
}

.form {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	background-color: #fff;
	// 下面两边圆角
	border-radius: 0 0 30rpx 30rpx;

	.logo {
		margin-top: 10%;
	}

	.title {
		font-size: 38rpx;
		font-weight: bolder;
		margin-top: 15rpx;
	}

	.desc {
		margin-top: 15rpx;
		font-size: 28rpx;
		color: #666;
		// 离下面高点
		margin-bottom: 30rpx;
	}

}

.tool_list {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-wrap: wrap;
	padding: 0 20rpx;
	align-items: stretch;

	.group_tool_wrap {
		min-height: 168rpx;
		width: 347rpx;
		border-radius: 10rpx;
		background-color: #fff;
		box-shadow: 2px 2px 5px rgba(93, 105, 143, 0.4);
		margin-top: 20rpx;

		.label_wrap {
			display: flex;
			width: 60rpx;
			height: 32rpx;
			border-radius: 3px;
			color: #fff;
			font-size: 20rpx;
			font-weight: 500;
			justify-content: center;
			align-items: center;
			position: relative;
			left: 287rpx;
			z-index: 1;
		}

		.tool_wrap {
			box-sizing: border-box;
			width: 100%;
			display: flex;
			padding: 0 30rpx 30rpx 30rpx;

			.tool_info {
				flex: 1;

				.tool_name {
					font-size: 28rpx;
					font-weight: 600;
					color: #333;
				}

				.tool_hint {
					margin-top: 15rpx;
					font-size: 18rpx;
					font-weight: 500;
					color: #999;
				}
			}

			image {
				margin-left: 10rpx;
			}
		}
	}
}
</style>
