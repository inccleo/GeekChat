<script>
	export default {
		onLaunch: function() {
			console.log('App Launch')
			this.getAD()
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		},
		methods:{
			async getAD() {
			},
		}
	}
</script>

<style lang="scss">
	/* 注意要写在第一行，同时给style标签加入lang="scss"属性 */
	@import "uview-ui/index.scss";

	.u-primary-light {
		color: $u-primary-light;
	}
	
	.u-warning-light {
		color: $u-warning-light;
	}
	
	.u-success-light {
		color: $u-success-light;
	}
	
	.u-error-light {
		color: $u-error-light;
	}
	
	.u-info-light {
		color: $u-info-light;
	}
	
	.u-primary-light-bg {
		background-color: $u-primary-light;
	}
	
	.u-warning-light-bg {
		background-color: $u-warning-light;
	}
	
	.u-success-light-bg {
		background-color: $u-success-light;
	}
	
	.u-error-light-bg {
		background-color: $u-error-light;
	}
	
	.u-info-light-bg {
		background-color: $u-info-light;
	}
	
	.u-primary-dark {
		color: $u-primary-dark;
	}
	
	.u-warning-dark {
		color: $u-warning-dark;
	}
	
	.u-success-dark {
		color: $u-success-dark;
	}
	
	.u-error-dark {
		color: $u-error-dark;
	}
	
	.u-info-dark {
		color: $u-info-dark;
	}
	
	.u-primary-dark-bg {
		background-color: $u-primary-dark;
	}
	
	.u-warning-dark-bg {
		background-color: $u-warning-dark;
	}
	
	.u-success-dark-bg {
		background-color: $u-success-dark;
	}
	
	.u-error-dark-bg {
		background-color: $u-error-dark;
	}
	
	.u-info-dark-bg {
		background-color: $u-info-dark;
	}
	
	.u-primary-disabled {
		color: $u-primary-disabled;
	}
	
	.u-warning-disabled {
		color: $u-warning-disabled;
	}
	
	.u-success-disabled {
		color: $u-success-disabled;
	}
	
	.u-error-disabled {
		color: $u-error-disabled;
	}
	
	.u-info-disabled {
		color: $u-info-disabled;
	}
	
	.u-primary {
		color: $u-primary;
	}
	
	.u-warning {
		color: $u-warning;
	}
	
	.u-success {
		color: $u-success;
	}
	
	.u-error {
		color: $u-error;
	}
	
	.u-info {
		color: $u-info;
	}
	
	.u-primary-bg {
		background-color: $u-primary;
	}
	
	.u-warning-bg {
		background-color: $u-warning;
	}
	
	.u-success-bg {
		background-color: $u-success;
	}
	
	.u-error-bg {
		background-color: $u-error;
	}
	
	.u-info-bg {
		background-color: $u-info;
	}
	
	.u-main-color {
		color: $u-main-color;
	}
	
	.u-content-color {
		color: $u-content-color;
	}
	
	.u-tips-color {
		color: $u-tips-color;
	}
	
	.u-light-color {
		color: $u-light-color;
	}
	
	.u-relative,
	.u-rela {
		position: relative;
	}
	
	.u-absolute,
	.u-abso {
		position: absolute;
	}
	
	// nvue不能用标签命名样式，不能放在微信组件中，否则微信开发工具会报警告，无法使用标签名当做选择器
	/* #ifndef APP-NVUE */
	image {
		display: inline-block;
	}
	
	// 在weex，也即nvue中，所有元素默认为border-box
	view,
	text {
		box-sizing: border-box;
	}
	/* #endif */
	
	.u-font-xs {
		font-size: 22rpx;
	}
	
	.u-font-sm {
		font-size: 26rpx;
	}
	
	.u-font-md {
		font-size: 28rpx;
	}
	
	.u-font-lg {
		font-size: 30rpx;
	}
	
	.u-font-xl {
		font-size: 34rpx;
	}
	
	.u-flex {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		align-items: center;
	}
	
	.u-flex-wrap {
		flex-wrap: wrap;
	}
	
	.u-flex-nowrap {
		flex-wrap: nowrap;
	}
	
	.u-col-center {
		align-items: center;
	}
	
	.u-col-top {
		align-items: flex-start;
	}
	
	.u-col-bottom {
		align-items: flex-end;
	}
	
	.u-row-center {
		justify-content: center;
	}
	
	.u-row-left {
		justify-content: flex-start;
	}
	
	.u-row-right {
		justify-content: flex-end;
	}
	
	.u-row-between {
		justify-content: space-between;
	}
	
	.u-row-around {
		justify-content: space-around;
	}
	
	.u-text-left {
		text-align: left;
	}
	
	.u-text-center {
		text-align: center;
	}
	
	.u-text-right {
		text-align: right;
	}
	
	.u-flex-col {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: column;
	}
	
	// 定义flex等分
	@for $i from 0 through 12 {
		.u-flex-#{$i} {
			flex: $i;
		}
	}
	
	// 定义字体(px)单位，小于20都为px单位字体
	@for $i from 9 to 20 {
		.u-font-#{$i} {
			font-size: $i + px;
		}
	}
	
	// 定义字体(rpx)单位，大于或等于20的都为rpx单位字体
	@for $i from 20 through 40 {
		.u-font-#{$i} {
			font-size: $i + rpx;
		}
	}
	
	// 定义内外边距，历遍1-80
	@for $i from 0 through 80 {
		// 只要双数和能被5除尽的数
		@if $i % 2 == 0 or $i % 5 == 0 {
			// 得出：u-margin-30或者u-m-30
			.u-margin-#{$i}, .u-m-#{$i} {
				margin: $i + rpx!important;
			}
			
			// 得出：u-padding-30或者u-p-30
			.u-padding-#{$i}, .u-p-#{$i} {
				padding: $i + rpx!important;
			}
			
			@each $short, $long in l left, t top, r right, b bottom {
				// 缩写版，结果如： u-m-l-30
				// 定义外边距
				.u-m-#{$short}-#{$i} {
					margin-#{$long}: $i + rpx!important;
				}
				
				// 定义内边距
				.u-p-#{$short}-#{$i} {
					padding-#{$long}: $i + rpx!important;
				}
				
				// 完整版，结果如：u-margin-left-30
				// 定义外边距
				.u-margin-#{$long}-#{$i} {
					margin-#{$long}: $i + rpx!important;
				}
				
				// 定义内边距
				.u-padding-#{$long}-#{$i} {
					padding-#{$long}: $i + rpx!important;
				}
			}
		}
	}
	
	// 重置nvue的默认关于flex的样式
	.u-reset-nvue {
		flex-direction: row;
		align-items: center;
	}
</style>
