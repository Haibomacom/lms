var app = getApp()
Page({
    data: {
        user_id: 0,
        book_id: 0,
        book_detail: [],
        book_intro: null,
        author_intro: null,
        favorite: 0
    },

    tapImg: function () {
        wx.previewImage({
            urls: [this.data.book_detail.img]
        })
    },

    tapLocation: function (event) {
        app.checkToken('/pages/book/detail?id=' + this.data.book_detail.id, () => {
            var location_id = event.currentTarget.dataset.location
            app.request('/book/location/' + location_id, 'get', '', (code, data) => {
                if (code == 200) {
                    if (data.data.status == 1) {
                        wx.showModal({
                            content: '确认付款借阅',
                            complete: result => {
                                if (result.confirm) {
                                    app.request('/borrow/add', 'post', {
                                        token: wx.getStorageSync('user_token'),
                                        location: location_id
                                    }, (code, data) => {
                                        if (code == 200) {
                                            wx.requestPayment({
                                                timeStamp: data.data.timeStamp,
                                                nonceStr: data.data.nonceStr,
                                                package: data.data.package,
                                                signType: data.data.signType,
                                                paySign: data.data.paySign,
                                                complete: result => {
                                                    if (result.errMsg == 'requestPayment:ok') {
                                                        app.showAlert('支付成功')
                                                    } else {
                                                        app.showAlert(result.errMsg)
                                                    }
                                                }
                                            })
                                        } else {
                                            app.showAlert(data.message)
                                        }
                                    })
                                }
                            }
                        })
                    } else {
                        app.showAlert('当前图书已被借阅')
                    }
                } else {
                    app.showAlert('服务器错误')
                }
            }, false)
        })
    },

    tapFavorite: function () {
        app.showLoadings()
        app.request('/favorite/control', 'post', {
            token: wx.getStorageSync('user_token'),
            id: this.data.book_detail.id
        }, (code, data) => {
            app.hideLoadings()
            this.setData({
                favorite: 1 - this.data.favorite
            })
        })
    },

    format: function (content) {
        if (content) {
            var data = ''
            var temp = content.split('\\n')
            for (var item in temp) {
                data = data + temp[item] + '\n'
            }
            return data
        } else {
            return '无'
        }
    },

    onLoad: function (options) {
        app.showLoadings()
        var url = null
        if (options.id) {
            url = '/book/id/' + options.id + '?include=author,category,location,author_book'
        } else if (options.isbn) {
            url = '/book/isbn/' + options.isbn + '?include=author,category,location,author_book'
        }
        app.request(url, 'get', '', (code, data) => {
            if (code == 200) {
                this.setData({
                    book_id: data.data.id,
                    book_detail: data.data,
                    book_intro: this.format(data.data.intro),
                    author_intro: this.format(data.data.author.data.intro)
                })
                app.setTitle(this.data.book_detail.title)
                var token = wx.getStorageSync('user_token')
                if (token) {
                    app.request('/favorite/check', 'post', {
                        token: token,
                        id: this.data.book_detail.id
                    }, (code, data) => {
                        this.setData({
                            favorite: parseInt(data.message)
                        })
                    })
                }
            } else {
                app.showAlert('服务器错误')
            }
            app.hideLoadings()
        })
    },

    onPullDownRefresh: function () {
        this.onLoad({
            id: this.data.book_detail.id
        })
        wx.stopPullDownRefresh()
    },
})