<template>
	<view class="userModel u-flex u-row-center u-col-center">
		<view class="cont u-flex-col u-col-center" :style="{width: ad?'300px':'520rpx'}">
			<image src="@/static/logo.png"></image>
			<view class="text u-text-center u-content-color u-p-l-60 u-p-r-60" v-html="title"></view>
			
			<ad unit-id="adunit-529c093bb0c2dda2"></ad>
			
			<view v-if="shareBtn" class="btn btn-box u-text-center adClass" hover-class="hover-class" hover-stay-time="50">
				{{btnText}}
				<button class="share-btn" open-type="share"></button>
			</view>
			<view v-else class="btn btn-box u-text-center adClass" hover-class="hover-class" hover-stay-time="50" @click="save">
				{{btnText}}
			</view>
			<view v-if="closeText!=' '" class="no u-text-center u-p-t-30" @click="close">{{closeText}}</view>
			
		</view>
		
	</view>
</template>

<script>

	export default {
		name: 'model',
		props:{
			title:{	//显示的内容
				type: String,
				default: '为了更好的浏览体验，快去授权登录吧'
			},
			authorize:{	//是否授权登录
				type: Boolean,
				default: true
			},
			ad:{	//广告
				type: Boolean,
				default: false
			},
			btnText:{	//按钮文字
				type: String,
				default: '授权登录'
			},
			closeText:{	//关闭文笔
				type: String,
				default: '暂时不用'
			},
			shareBtn:{ //分享按钮
				type: Boolean,
				default: false
			}
		},
		methods: {
			save(){
				this.$emit('save');
			},
			close(){
				this.$emit('close');
			}
		}
	}
</script>

<style lang="scss">
	.userModel{
		z-index: 9999999;
		position: fixed;
		top: 0;
		left: 0;
		width: 100vw;
		height: 100vh;
		background-color: rgba(0,0,0,0.6);
		// backdrop-filter: blur(4rpx);
		.cont{
			width: 520rpx;
			padding: 0px 0 50rpx 0;
			background-color: #FFFFFF;
			border-radius: 32rpx;
			image{
				width: 128rpx;
				height: 128rpx;
				margin-top: -60rpx;
				margin-bottom: 40rpx;
				border-radius: 50%;
			}
			.text{
				line-height: 46rpx;
			}
			.btn{
				position: relative;
				margin-top: 50rpx;
				color: #FFFFFF;
				width: 60%;
				line-height: 80rpx;
				border-radius: 80rpx;
				background-color: #7966ff;
			}
			.share-btn-box{
				margin-left: 20%;
				margin-top: 30rpx;
			}
			.share-btn{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				opacity: 0;
			}
			.no{
				color: #B8B8B8;
			}
		}
	}
	.num{
		font-size: 16px;
		font-weight: 700;
		color: #7966ff;
		padding: 0 8rpx;
	}
	
	.adClass{
		animation: tiaobig 1.2s ease-in-out alternate infinite;
		// animation-iteration-count:1;
	}
	@keyframes tiaobig {
		25% {
			transform: scale(0.98);
		}
		50% {
			transform: scale(1.08);
		}
		75% {
			transform: scale(0.98);
		}
		100% {
			transform: scale(1.08);
		}
	}
</style>
