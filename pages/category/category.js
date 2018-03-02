var app = getApp()
Page({
    data: {
        category: []
    },

    onLoad: function (options) {
        app.request('/category/list/all', 'get', '', (code, data) => {
            this.setData({
                category: data.data
            })
        })
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    },
})