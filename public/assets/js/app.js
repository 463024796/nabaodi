(function ($) {
    'use strict';

    $(function () {
        var $fullText = $('.admin-fullText');
        $('#admin-fullscreen').on('click', function () {
            $.AMUI.fullscreen.toggle();
        });

        $("button[name='btn_edit']").click(function () {
            //打开模态框的时候。先把所有的值清空！
            var modal = $(".am-modal");
            $(".am-modal").find("input").val('');
            var order_id = $(this).parents('tr').find("input[type='checkbox']").val();
            console.log(order_id);
            //获取点击的这个的id
            var user_id = $(this).parents("tr").find("input[type='checkbox']").val();
            modal.find(".am-modal-hd").text("修改订单信息");
            $.get("/admin/user", { id: user_id }, function (data) {
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
                },
                onCancel: function (e) {

                }
            });
        });
    });
    //点击新增的时候
    $('#doc-prompt-toggleAll').on('click', function () {
        $(".am-modal").find(".am-modal-hd").text("新增订单-信息填写");
        $(".am-modal").find("input").val('');
        $(".am-modal").find("input[name='email']").prop("disabled", false);
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
            },
            onCancel: function (e) {

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
    //点击删除
    $("#del-all").on("click", function () {
        var all = '';
        $("input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                all += ',' + $(this).val();
            }
        });
        $.post("/admin/orders/delete", { all }, function (data) {
            return location.reload();
        })
    });
    //删除id
    $("button[name='del-id']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[type='checkbox']").val();
        $.get("/admin/orders/delete", { id: id }, function (data) {
            return location.reload();
        })
    })
    //拉黑
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
    //移除黑名单
    $("button[name='del-reback']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='user_id']").val();
        // console.log(id)
        $.get("/admin/blacklist/del-reback", { id: id }, function (data) {
            return location.reload();
        })
    })
    //批量移除黑名单
    $("button[name='del-reback-all']").click(function () {
        var all = '';
        $("input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                all += ',' + $(this).val();
            }
        });
        $.post("/admin/blacklist/del-reback", { all }, function (data) {
            return location.reload();
        })
    })
    //批量完成订单
    $("button[name='del-all-order']").click(function () {
        var all = '';
        $("input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                all += ',' + $(this).val();
            }
        });
        $.post("/admin/orders/del-order", { all }, function (data) {
            return location.reload();
        })
    })
    //单个删除的时候
    $("button[name='del-one']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='order_id']").val();
        // console.log(id);
        $.get("/admin/orders/delete", { id: id }, function (data) {
            return location.reload();
        })
    })
    //还原
    $("button[name='del-order-reback']").click(function () {
        var all = '';
        $("input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                all += ',' + $(this).val();
            }
        });
        $.post("/admin/orders/del-order-reback", { all }, function (data) {
            return location.reload();
        })
    })
    //单个还原的时候
    $("button[name='del-order-reback-one']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='order_id']").val();
        // console.log(id);
        $.get("/admin/orders/del-order-reback", { id: id }, function (data) {
            return location.reload();
        })
    })
    //单个完成订单的时候
    $("button[name='del-complete']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='order_id']").val();
        // console.log(id);
        $.get("/admin/orders/del-order", { id: id }, function (data) {
            return location.reload();
        })
    })
    //彻底删除的时候
    $("button[name='del-real-delete']").click(function () {
        //获取id
        var id = $(this).parents("tr").find("input[name='order_id']").val();
        // console.log(id);
        $.get("/admin/orders/delete-orders", { id: id }, function (data) {
            return location.reload();
        })
    })
    //点击彻底删除
    $("button[name='del-real-delete-all']").on("click", function () {
        var all = '';
        $("input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                all += ',' + $(this).val();
            }
        });
        $.post("/admin/orders/delete-orders", { all }, function (data) {
            return location.reload();
        })
    });

    $("button[name='add-order']").click(function () {
        var order_number = $("input[name='order']").val();
        var product_name = $("input[name='product_name']").val();
        var arr = [];
        arr.push(order_number,product_name);
        $.post("/index/add", {arr}, function (data) {
            if (data !== true) {
                return alert(data);
            }
            return location.reload();
        })
    });
})(jQuery);
