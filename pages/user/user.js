var app = getApp()
Page({
    data: {
        userRole: 0,
        userMobile: null,
        userInfo: null,
        sendCode: 0,
        sendCodeText: '获取验证码',
        sendCodeTime: 0,
        inputMobile: null
    },

    bindMobileInput: function (event) {
        this.setData({
            inputMobile: event.detail.value
        })
    },

    sendCode: function () {
        app.showLoadings('正在发送中')
        app.request('/auth/initialize/code', 'post', {
            mobile: this.data.inputMobile
        }, (code, data) => {
            if (code == 201) {
                if (!this.data.sendCode) {
                    this.setData({
                        sendCode: 120
                    })
                    var interval = setInterval(() => {
                        if (!this.data.sendCode) {
                            this.setData({
                                sendCode: 0,
                                sendCodeText: '获取验证码'
                            })
                            clearInterval(interval)
                        } else {
                            this.setData({
                                sendCode: this.data.sendCode - 1,
                                sendCodeText: '剩余' + this.data.sendCode + '秒'
                            })
                        }
                    }, 1000)
                }
                app.hideLoadings('发送成功')
            } else {
                app.showAlert(data.message)
            }
        }, false)
    },

    submitInfo: function (event) {
        var data = event.detail.value
        data.token = wx.getStorageSync('user_token')
        app.request('/auth/initialize', 'post', data, (code, data) => {
            if (code == 201) {
                app.showAlert('注册成功')
                this.setData({
                    userMobile: this.data.inputMobile
                })
                this.redirect()
            } else if (code == 404) {
                app.showAlert('请刷新后重试')
            } else {
                app.showAlert(data.message)
            }
        })
    },

    getUserInfo: function () {
        wx.getUserInfo({
            withCredentials: true,
            complete: result => {
                if (result.errMsg == 'getUserInfo:ok') {
                    this.setData({
                        userInfo: JSON.parse(result.rawData)
                    })
                    this.redirect()
                } else {
                    wx.showModal({
                        content: '若不授权，则无法使用应用的部分功能，点击确认重新获取授权。',
                        complete: result => {
                            if (result.confirm) {
                                wx.openSetting({
                                    complete: result => {
                                        this.getUserInfo()
                                    }
                                })
                            }
                        }
                    })
                }
            }
        })
    },

    redirect: function () {
        var url = wx.getStorageSync('redirect_url')
        if (url) {
            wx.removeStorageSync('redirect_url')
            if (url.indexOf('?') != -1) {
                wx.navigateTo({
                    url: url
                })
            } else {
                wx.switchTab({
                    url: url
                })
            }
        }
    },

    scanQrCode: function () {
        wx.scanCode({
            onlyFromCamera: true,
            complete: (result) => {
                if (result.errMsg == 'scanCode:ok') {
                    if (result.scanType == 'QR_CODE') {
                        app.request('/borrow/scan', 'post', {
                            token: wx.getStorageSync('user_token'),
                            str: result.result
                        }, (code, data) => {
                            if (code == 200) {
                                this.controlBorrow(data, result.result)
                            } else if (code == 404) {
                                app.showAlert('当前订单不存在，请刷新后重试')
                            } else {
                                app.showAlert(data.message)
                            }
                        })
                    } else {
                        app.showAlert('无法识别的二维码')
                    }
                }
            }
        })
    },

    controlBorrow: function (data, str) {
        if (data.data.status == '借阅完成') {
            app.showAlert('当前图书已归还')
        } else {
            var content = '图书【' + data.data.book.data.title + '】\n' + '图书位置【' + data.data.location.data.location + '】\n'
            if (data.data.status == '付款成功') content += '付款时间【' + data.data.format.paid_at + '】'
            if (data.data.status == '正在借阅') content += '借出时间【' + data.data.format.borrowed_at + '】'
            wx.showModal({
                content: content,
                complete: (result) => {
                    if (result.confirm) {
                        app.request('/borrow/control', 'post', {
                            token: wx.getStorageSync('user_token'),
                            str: str
                        }, (code, data) => {
                            if (code == 204) {
                                app.showAlert('完成')
                            } else if (code == 404) {
                                app.showAlert('当前订单不存在，请刷新后重试')
                            } else {
                                app.showAlert(data.message)
                            }
                        })
                    }
                }
            })
        }
    },

    onLoad: function (options) {
        wx.login({
            complete: result => {
                if (result.errMsg == 'login:ok') {
                    app.request('/auth/authenticate', 'post', {
                        code: result.code
                    }, (code, data) => {
                        if (code == 200) {
                            wx.setStorageSync('user_token', data.data.token)
                            wx.setStorageSync('user_role', data.data.role)
                            this.setData({
                                userMobile: data.data.mobile,
                                userRole: data.data.role
                            })
                            this.getUserInfo()
                        } else {
                            app.showAlert(data.message)
                        }
                    }, false)
                } else {
                    app.showAlert('微信内部错误，请重启微信后重试')
                }
            }
        })
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    },
})