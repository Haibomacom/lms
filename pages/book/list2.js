var app = getApp()
Page({
    data: {
        url: '',
        books: [],
        pagination: []
    },

    onLoad: function (options) {
        this.setData({
            url: '/book/list?type=' + options.type + '&data=' + options.data + '&include=author'
        })
        app.setTitle('分类[' + options.name + ']')
        app.request(this.data.url, 'get', '', (code, data) => {
            if (code == 200) {
                this.setData({
                    books: data.data,
                    pagination: data.meta.pagination
                })
            } else {
                app.showAlert('服务器错误')
            }
        })
    },

    onPullDownRefresh: function () {
        this.onLoad()
        wx.stopPullDownRefresh()
    },

    onReachBottom: function () {
        if (this.data.pagination.current_page < this.data.pagination.total_pages) {
            app.request(this.data.url + '&page=' + parseInt(this.data.pagination.current_page + 1), 'get', '', (code, data) => {
                if (code == 200) {
                    this.setData({
                        books: this.data.books.concat(data.data),
                        pagination: data.meta.pagination
                    })
                } else {
                    app.showAlert('服务器错误')
                }
            })
        } else {
            wx.showToast({
                title: '没有更多了',
            })
        }
    }
})