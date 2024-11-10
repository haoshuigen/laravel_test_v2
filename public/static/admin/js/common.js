var common = {
    config: {
        shade: [0.02, '#000'],
    },
    close: function (index) {
        return layer.close(index);
    },
    // success message
    success: function (msg, callback) {
        if (callback === undefined) {
            callback = function () {
            }
        }
        var index = layer.msg(msg, {
            icon: 1,
            shade: this.config.shade,
            scrollbar: false,
            time: 2000,
            shadeClose: true
        }, callback);
        return index;
    },
    // failure message
    error: function (msg, callback) {
        if (callback === undefined) {
            callback = function () {
            }
        }
        var index = layer.msg(msg, {
            icon: 2,
            shade: this.config.shade,
            scrollbar: false,
            time: 3000,
            shadeClose: true
        }, callback);
        return index;
    },
    // alert message
    alert: function (msg, callback) {
        var index = layer.alert(msg, {end: callback, scrollbar: false});
        return index;
    },
    // confirm frame
    confirm: function (msg, ok, no) {
        var index = layer.confirm(msg, {title: 'Confirm Operation', btn: ['confirm', 'cancel']}, function () {
            typeof ok === 'function' && ok.call(this);
        }, function () {
            typeof no === 'function' && no.call(this);
            self.close(index);
        });
        return index;
    },
    // prompt message
    tips: function (msg, time, callback) {
        var index = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback, shadeClose: true});
        return index;
    },
    // loading message
    loading: function (msg, callback) {
        var index = msg ? layer.msg(msg, {
            icon: 16,
            scrollbar: false,
            shade: this.shade,
            time: 0,
            end: callback
        }) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
        return index;
    }
}
