(function ($) {
    'use strict';

    $(function () {
        var $fullText = $('.admin-fullText');
        $('#admin-fullscreen').on('click', function () {
            $.AMUI.fullscreen.toggle();
        });
        //所有订单
        $("button[name='btn_edit']").click(function () {
            //打开模态框的时候。先把所有的值清空！
            var modal = $(".am-modal");
            $(".am-modal").find("input").val('');
            var order_id = $(this).parents('tr').find("input[type='checkbox']").val();
            //获取点击的这个的id
            var user_id = $(this).parents("tr").find("input[type='checkbox']").val();
            modal.find(".am-modal-hd").text("修改订单信息");
            $.get("/admin/orders", { id: user_id }, function (data) {
                modal.find("input[name='order_number']").val(data.order_number);
                modal.find("input[name='email']").val(data.email);
                modal.find("input[name='qq']").val(data.qq);
                modal.find("input[name='alipay_id']").val(data.alipay_id);
                modal.find("input[name='product_name']").val(data.product_name);
                modal.find("input[name='date']").val(data.time);
                modal.find("input[name='email']").prop("disabled", true);
            })
            $('#my-promptAll').modal({
                relatedTarget: this,
                onConfirm: function (e) {
                    e.data.push(order_id);
                    $.post("/admin/orders/edit", { data: e.data }, function (data) {
                        return location.reload();
                    })
                }
            });
        });
    });
    //所有用户
    $("button[name='btn_edit_member']").click(function () {
        //打开模态框的时候。先把所有的值清空！
        var modal = $(".am-modal");
        $(".am-modal").find("input").val('');
        //获取点击的这个的id
        var user_id = $(this).parents("tr").find("input[type='checkbox']").val();
        modal.find(".am-modal-hd").text("修改订单信息");
        $.get("/admin/user", { id: user_id }, function (data) {
            modal.find("input[name='email']").val(data.email);
            modal.find("input[name='qq']").val(data.qq);
            modal.find("input[name='alipay_id']").val(data.alipay_id);
            modal.find("input[name='phone']").val(data.phone);
            modal.find("input[name='date']").val(data.time);
            modal.find("input[name='email']").prop("disabled", true);
            modal.find("input[name='phone']").prop("disabled", true);
        })
        $('#my-promptAll').modal({
            relatedTarget: this,
            onConfirm: function (e) {
                e.data.push(user_id);
                $.post("/admin/orders/edit-user", { data: e.data }, function (data) {
                    return location.reload();
                })
            }
        });
    });

    //点击新增的时候
    $('#doc-prompt-toggleAll').on('click', function () {
        $(".am-modal").find(".am-modal-hd").text("新增订单-信息填写");
        $(".am-modal").find("input[name!='email']").val('');
        $(".am-modal").find("input[name='email']").prop("disabled", true);
        $('#my-promptAll').modal({
            relatedTarget: this,
            onConfirm: function (e) {
                $.post("/admin/orders/add", { data: e.data }, function (data) {
                    if (data == true) {
                        return location.reload();
                    } else {
                        alert(data);
                    }
                });
            }
        });
    });
    //点击checkbox
    $("#checkall").click(function () {
        if ($(this).is(':checked')) {
            $("input[type='checkbox']").prop("checked", true);
        } else {
            $("input[type='checkbox']").prop("checked", false);
        }
    })

    // //拉黑
    $("button[name='del-black']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='user_id']").val();
        // console.log(id)
        $.get("/admin/orders/del-black", { id: id }, function (data) {
            if (data !== true) {
                return alert(data);
            }
            return location.reload();
        })
    })


    $("button[name='add-order']").click(function () {
        var order_number = $("input[name='order']").val();
        var product_name = $("input[name='product_name']").val();
        var arr = [];
        arr.push(order_number, product_name);
        $.post("/index/add", { arr }, function (data) {
            if (data !== true) {
                return alert(data);
            }
            return location.reload();
        })
    });

})(jQuery);
/**
 * 各类批量
 * @param  url 
 */
function batch(url) {
    var all = '';
    $("input[type='checkbox']").each(function () {
        if ($(this).is(":checked")) {
            all += ',' + $(this).val();
        }
    });
    $.post(url, { all }, function (data) {
        return location.reload();
    })
}

function delById(url, obj, type, attr) {
    //获取id
    var id = obj.parents("tr").find("input[" + type + "='" + attr + "']").val();
    $.get(url, { id: id }, function (data) {
        if (data !== true) {
            return alert(data);
        }
        return location.reload();
    })

}