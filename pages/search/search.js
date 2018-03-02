var app = getApp()
Page({
    data: {
        search: '',
        result_list: [],
        flag: false,
        history: []
    },

    bindSearchInput: function (event) {
        var data = event.detail.value
        this.setData({
            search: data
        })
        if (!data) {
            this.setData({
                flag: false
            })
        }
    },

    clearHistory: function () {
        wx.removeStorageSync('search_history')
        this.setData({
            history: []
        })
    },

    tapHistory: function (event) {
        this.setData({
            search: event.target.dataset.search
        })
    },

    search: function () {
        if (this.data.search) {
            this.data.history.push(this.data.search)
            var arr = this.outRepeat(this.data.history)
            wx.setStorageSync('search_history', arr.join(','))
            app.request('/book/search?include=author,category', 'post', {
                search: this.data.search
            }, (code, data) => {
                this.setData({
                    flag: true,
                    result_list: data.data
                })
            })
        } else {
            app.showAlert('搜索不得为空')
        }
    },

    scan: function () {
        wx.scanCode({
            onlyFromCamera: true,
            complete: (result) => {
                if (result.errMsg == 'scanCode:ok') {
                    if (result.scanType == 'EAN_13') {
                        wx.navigateTo({
                            url: '../book/detail?isbn=' + result.result
                        })
                    } else {
                        app.showAlert('不是有效的ISBN码')
                    }
                }
            }
        })
    },

    outRepeat: function (a) {
        var hash = []
        var arr = []
        for (var i = 0; i < a.length; i++) {
            hash[a[i]] = null
        }
        for (var key in hash) {
            arr.push(key)
        }
        return arr
    },

    onLoad: function (options) {
        if (wx.getStorageSync('search_history')) {
            this.setData({
                history: wx.getStorageSync('search_history').split(',')
            })
        }
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    },

    onReachBottom: function () {

    },
})