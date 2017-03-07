(function () {

    packager('app.components.sidebar');

    app.components.sidebar = {
        init: function () {
            this.initSidebar();
        },
        initSidebar: initSidebar
    };

    function initSidebar() {
        // mark the current tab
        $list = $('.page-sidebar-menu');

        // click event
        $list.on('click', 'li:not(.heading)', function () {
            $list.find('li').removeClass('active');
            $(this).addClass('active');
        });
    }

})();