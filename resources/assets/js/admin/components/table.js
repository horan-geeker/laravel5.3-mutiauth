(function () {

    packager('app.components.table');

    app.components.table = {
        init() {
            this.initRowClick();
            this.initBtnDelete();
            this.initBtnEdit();
        },
        initRowClick: initRowClick,
        initBtnEdit: initBtnEdit,
        initBtnDelete: initBtnDelete
    };

    function initRowClick() {
        $('table.has-show-view').on('click', 'tr', function () {
            var url = $(this).data('url');
            var target = $(this).data('target');
            if (url && target) {
                window.open(url, target);
                return;
            }

            if (url) {
                location.href = url;
            }
        });
    }

    function initBtnEdit() {
        $('#page_content').find('table tr td').on('click', '.btn-edit', function (e) {
            e.stopPropagation();
        });
    }

    function initBtnDelete() {
        var $container = $('#page_content');
        // var $container = $(document).find('table tr td');

        // delegate deletion event
        $container.find('table tr td').on('click', '.btn-delete', function (e) {
        // $container.on('click', '.btn-delete', function (e) {
            e.stopPropagation();
            e.preventDefault();

            // the button
            var $btn = $(this);

            // the row; the record
            var $tr = $(this).closest('tr');

            // prefer the url on the button
            var url = $btn.data('url') ? url = $btn.data('url') : $tr.data('url');

            var onConfirm = function () {

                // disable button
                $btn.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'delete'
                })
                    .done(function (resp) {
                        console.log("delete success");

                        // remove row
                        //$tr.remove();

                        // instead of removing row, refresh the page
                        location.reload();

                        // close modal
                        swal.close();
                    })
                    .fail(function (errors) {
                        console.log("delete error");

                        // it should never emit server error
                        try {
                            if (!_.isArray(errors)) {
                                errors = JSON.parse(errors.responseText);
                            }

                            swal({
                                title: "删除失败",
                                text: errors.general ? errors.general : '服务器出错, 请稍后再试',
                                type: "error"
                            });
                        } catch (e) {
                            swal({
                                title: "删除失败",
                                text: '服务器出错, 请稍后再试',
                                type: "error"
                            });
                        }
                    })
                    .always(function () {
                        console.log("delete complete");

                        // enable button
                        $btn.prop('disabled', false);
                    });
            };

            // default warning message content
            var warningText = $btn.data('warning') ? $btn.data('warning') : '此操作不可逆';

            // init
            swal({
                title: "确认删除?",
                text: warningText,
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, onConfirm);
        });
    }

})();