/*网络请求*/
function request(url, data, call, type) {
    var methods = 'post';
    var layerIndex;
    if (type) {
        methods = type;
    }
    datas = $.extend({
    }, data);
    console.log('------ ' + url + ' 请求参数：');
    console.log(datas);
    layerIndex = layer.load(2, {
        shade: [0.1, '#fff'],
        time: 10*1000
    });
    $.ajax({
        type: methods,
        url: url,
        dataType: 'json',
        data: datas
    }).done(function (res) {
        console.log('------ ' + url + ' 返回数据：');
        console.log(res);
        layer.close(layerIndex);
        call(res);
    }).fail(function () {
        layer.alert('服务器异常，请上报管理员<br/>微信：303890562<br/>感谢您的配合');
    });
}
/*添加*/
function add(title, url, w, h) {
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*编辑*/
function edit(title, url, id, w, h) {
    var index = layer.open({
        type: 2,
        title: title,
        content: url + id
    });
    layer.full(index);
}
/*删除*/
function del(obj, url, id) {
    layer.confirm('确认要删除吗？', function (index) {
        request(url,{ id: id },function(res) {
            if (res.ret == 0) {
                $(obj).parents("tr").remove();
                layer.msg('已删除!', { icon: 1, time: 1000 });
            } else {
                layer.msg(res.msg);
            }
        })
    });
}
/*获取表单数据*/
function form2Json(id) {
    var a = $(id).serializeArray();
    var d = {};
    $.each(a, function () {
        if (d[this.name]) {
            if (!d[this.name].push) {
                d[this.name] = [d[this.name]];
            }
            d[this.name].push(this.value || '');
        } else {
            d[this.name] = this.value || '';
        }
    });
    console.log(d);
    return d;
}

function getUrlPara(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
