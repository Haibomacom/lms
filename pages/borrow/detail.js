var app = getApp()
var qr = require('../../utils/qrcode.js')
Page({
    data: {
        detail: [],
        hasQr: false
    },

    pay: function () {
        app.request('/borrow/change', 'post', {
            id: this.data.detail.id
        }, (code, data) => {
            this.onLoad({
                id: this.data.detail.id
            })
        })
    },

    getScreenSize: function () {
        var size = {}
        var info = wx.getSystemInfoSync();
        if (info.windowWidth) {
            size.width = size.height = info.windowWidth * 0.6
        }
        return size
    },

    onLoad: function (options) {
        app.request('/borrow/id/' + options.id, 'get', '', (code, data) => {
            if (code == 200) {
                this.setData({
                    detail: data.data
                })
                if (this.data.detail.status == '付款成功' || this.data.detail.status == '正在借阅') {
                    this.setData({
                        hasQr: true
                    })
                    var size = this.getScreenSize()
                    var str = wx.getStorageSync('user_token') + '|' + this.data.detail.id
                    qr.qrApi.draw(str, 'qr', size.width, size.height)
                } else {
                    this.setData({
                        hasQr: false
                    })
                }
            } else {
                app.showAlert('服务器错误')
            }
        })
    },

    onPullDownRefresh: function () {
        this.onLoad({
            id: this.data.detail.id
        })
        wx.stopPullDownRefresh()
    }
})