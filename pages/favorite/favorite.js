var app = getApp()
Page({
    data: {
        favorites: []
    },

    onLoad: function (options) {
        app.request('/favorite/list', 'post', {
            token: wx.getStorageSync('user_token')
        }, (code, data) => {
            if (code == 200) {
                this.setData({
                    favorites: data.data
                })
            } else {
                app.showAlert('服务器错误')
            }
        })
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    }
})