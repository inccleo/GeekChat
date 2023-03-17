<template>
	<u-popup :show="show" mode="bottom" borderRadius="44rpx" :closeable="true" @close="onClose">
		<view class="popupBox">
			<view class="h2 bold">获取您的昵称、头像</view>
			<view class="h3">获取用户头像、昵称，主要用于向用户提供具有辨识度的用户中心界面</view>
			<view class="form">
				<view class="input u-flex">
					<view class="h2">头像</view>
					<view class="info">
						<button class="avatar-wrapper" open-type="chooseAvatar" @chooseavatar="onChooseAvatar">
							<image class="avatar" :src="avatarUrl||'/static/avatar.png'"></image>
							<u-icon name="arrow-right" size="32rpx" color="#999"></u-icon>
						</button> 
					</view>
				</view>
				<view class="input u-flex">
					<view class="h2">昵称</view>
					<view class="info">
						<input type="nickname" v-model="nickName" placeholder="请输入昵称" @blur="onBlur"/>
					</view>
				</view>
			</view>
			<view class="submit" :style="{background:PrimaryColor}" @click="submit">确定</view>
		</view>
		
	</u-popup>

	
</template>

<script>
export default {
	data() {
        return {
			PrimaryColor: '#7966ff', //主题色
			avatarUrl:'',
			nickName:'',
			show:false,
		}
	},
	watch:{
		showWxLogin(val){
			this.show = val
			if(val){
				this.avatarUrl = this.vuex_user.avatar
				this.nickName = this.vuex_user.name
			}
		}
	},
	methods:{
		onClose(){
			this.$u.vuex('showWxLogin',false)
		},
		onChooseAvatar(e){
			console.log(e)
			//该图片需要上传到自己服务器--此处没做处理
			this.avatarUrl = e.detail.avatarUrl
		},
		onBlur(e){
			console.log(e)
			this.nickName = e.detail.value
		},
		checkURL(URL){
			var str=URL;
			//判断URL地址的正则表达式为:http(s)?://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?
			//下面的代码中应用了转义字符"\"输出一个字符"/"
			var Expression=/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
			var objExp=new RegExp(Expression);
			if(objExp.test(str)==true){
				return true;
			}else{
				return false;
			}
		},
		async submit(){
			var that = this
			if(!that.avatarUrl){
				uni.showToast({
					title: '请上传头像~',
					icon: 'none'
				});
				return
			}
			if(!that.nickName){
				uni.showToast({
					title: '请输入昵称~',
					icon: 'none'
				});
				return
			}
			if(that.checkURL(that.avatarUrl)){
				that.onClose()
				that.$emit('submit',{name:this.nickName,avatar:this.avatarUrl});
				return;
			}
			var extension = that.avatarUrl.substring(that.avatarUrl.lastIndexOf('.') + 1)
			var random = String(Math.random()*100000).split('.')[0]
			var now = new Date()
			var year = now.getFullYear()
			var month = (now.getMonth() + 1) < 10?'0'+(now.getMonth() + 1):(now.getMonth() + 1)
			var day = now.getDate() < 10?'0'+now.getDate():now.getDate()
			var hours = now.getHours() < 10?'0'+now.getHours():now.getHours()
			var minutes = now.getMinutes() < 10?'0'+now.getMinutes():now.getMinutes()
			var seconds = now.getSeconds() < 10?'0'+now.getSeconds():now.getSeconds()
			
			var cloudPath = 'user_'+year+month+day+hours+minutes+seconds+'_'+random+'.'+extension
			uni.showLoading({
				mask: true,
				title: '加载中...'
			})
			await uniCloud.uploadFile({
				filePath: that.avatarUrl,
				cloudPath: cloudPath
			}).then(async res => {
				await uniCloud.getTempFileURL({
					fileList: [res.fileID]
				}).then(res => {
					if(res.fileList.length > 0){
						that.avatarUrl = res.fileList[0].tempFileURL
					}else{
						uni.showLoading({
							mask: true,
							title: '更新失败...'
						});
						return;
					}
				});
			})
			that.onClose()
			uni.hideLoading()
			that.$emit('submit',{name:this.nickName,avatar:this.avatarUrl});
		},
	},
}
</script>

<style lang="scss">
.popupBox{
	width: 100%;
	padding: 50rpx 40rpx 30rpx;
	.h2{
		color: #333;
		font-size: 32rpx;
	}
	.h3{
		font-size: 26rpx;
		color: #999;
		line-height: 1.4;
		padding-top: 14rpx;
	}
	.bold{
		font-weight: bold;
	}
	.form{
		margin-top: 30rpx;
		border-top: 1px solid #EFEFEF;
		.input{
			padding: 24rpx 0;
			border-bottom: 1px solid #EFEFEF;
			.info{
				flex:1;
				margin-left: 30rpx;
				.avatar-wrapper{
					width: 100%;
					height: 70rpx;
					display: flex;
					justify-content: space-between;
					.avatar{
						width: 70rpx;
						height: 70rpx;
						border-radius: 10rpx;
					}
				}
				button{
					padding: 0;
					background-color: #fff;
					border: 0;
					tap-highlight-color: rgba(0,0,0,0);
					tap-highlight-color: transparent;
					-webkit-tap-highlight-color: rgba(0,0,0,0);
					-webkit-tap-highlight-color: transparent;
					border-radius: 0;
				}
				button::after{
					border: 0;
					border-radius: 0;
				}
				input{
					background: transparent;
					width: 100%;
					height: 70rpx;
					color: #333;
					font-size: 30rpx;
					border: none;
					border-radius: 0;
				}
			}
		}
	}
}
.submit{
	margin-top: 30rpx;
	width: 100%;
	height: 92rpx;
	border-radius: 10rpx;
	text-align: center;
	line-height: 92rpx;
	color: #fff;
	font-size: 32rpx;
	background: #E83F3C;
}
</style>