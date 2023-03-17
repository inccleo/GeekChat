# GeekChat
# 基于ChatGPT的微信小程序

这是一个基于OpenAI的ChatGPT模型的微信小程序项目，前端采用uni-app框架，后端使用PHP Webman。通过这个小程序，用户可以与ChatGPT模型进行实时聊天。

## 功能特点

1. 代码采用Stream流模式通信，一边生成一边输出，响应速度超过官网，前端采用JS的EventSource，小程序采用JS的websocket
2. 支持Markdown格式，代码高亮，代码复制

## 安装教程

### 前端

1. 克隆此项目到本地：
2. 使用HBuilderX或者微信开发者工具打开项目文件夹 siteinfo.js 配置接口地址 socket地址。
3. 在HBuilderX或微信开发者工具中运行项目。

### 后端

1. 克隆此项目到本地，安装依赖，根据需要配置.env文件（ChatGPT密钥，mysql配置，redis配置，微信登录配置）。


## 演示二维码

请使用微信扫描下方二维码体验小程序：

![演示二维码](./qrcode.jpg)

![演示截图](./demo1.jpg)

![演示截图](./demo2.jpg)

![演示截图](./demo3.jpg)


## 打赏支持

如果您觉得这个项目对您有帮助，可以扫描下方二维码进行打赏支持，非常感谢您的支持！

![打赏二维码](./donate_qrcode.jpg)

## 贡献与支持

如果您在使用过程中遇到问题，欢迎提交Issue。我们非常感谢您的反馈和贡献！