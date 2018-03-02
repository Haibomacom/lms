var app = getApp()
Page({
    data: {
        borrows: [],
        pagination: []
    },

    onLoad: function (options) {
        app.checkToken('/pages/borrow/list?', () => {
            app.setTitle('借阅记录')
            app.request('/borrow/list', 'post', {
                token: wx.getStorageSync('user_token')
            }, (code, data) => {
                if (code == 200) {
                    this.setData({
                        borrows: data.data,
                        pagination: data.meta.pagination
                    })
                } else {
                    app.showAlert('服务器错误')
                }
            })
        })
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    },

    onReachBottom: function () {

    }
})