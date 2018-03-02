var app_url = 'https://lms.justca.top'
// var app_url = 'http://api.lms.dev'
App({
    setTitle: function (title = null) {
        wx.setNavigationBarTitle({
            title: title ? title + ' - 借阅伴侣' : '借阅伴侣'
        })
    },

    showLoadings: function (title = '正在加载中') {
        wx.showLoading({
            title: title,
            mask: true
        })
        wx.showNavigationBarLoading()
    },

    hideLoadings: function (title = '加载完成') {
        setTimeout(() => {
            wx.hideLoading()
            wx.hideNavigationBarLoading()
            wx.showToast({
                title: title,
                mask: true,
                duration: 300
            })
        }, 200)
    },

    showAlert: function (content) {
        wx.showModal({
            content: content,
            showCancel: false
        })
    },

    request: function (url, method, data, complete, loading = true) {
        if (url.charAt(0) == '/') {
            url = app_url + '/api/v1' + url;
        }
        if (loading) {
            this.showLoadings()
        }
        wx.request({
            url: url,
            method: method,
            data: data,
            complete: result => {
                if (loading) {
                    this.hideLoadings()
                }
                complete(result.statusCode, result.data)
            }
        })
    },

    checkToken: function (url, callable) {
        var token = wx.getStorageSync('user_token')
        wx.request({
            url: app_url + '/api/v1/auth/token',
            method: 'post',
            data: {
                token: token
            },
            complete: result => {
                if (result.statusCode == 204) {
                    callable()
                } else {
                    wx.showModal({
                        content: result.data.message,
                        showCancel: false,
                        complete: result => {
                            if (result.confirm) {
                                wx.setStorageSync('redirect_url', url)
                                wx.switchTab({
                                    url: '/pages/user/user'
                                })
                            }
                        }
                    })
                }
            }
        })
    },

    onLaunch: function () {

    },

    onError: function (msg) {
        console.log(msg)
    }
})