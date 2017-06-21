(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/Search',
            [
                'mcc',
                'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchView',
                'Meritt/QEdu/UI/IdebLanding/Assets/js/view/Search'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.GlobalSearchView, root.IdebSearchView);
    }
}(this, function (mcc, GlobalSearchView, IdebSearchView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebLanding/Assets/js/Search',

        function(config) {
            search = new GlobalSearchView(config);
            idebSearchView = new IdebSearchView(config);

            if (config.focus) {
                search.focus();
            }
        }
    );
}));
