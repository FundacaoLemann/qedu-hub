(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchBehavior',
            ['mcc', 'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchView'],
            factory
        );
    } else {
        factory(root.mcc, root.GlobalSearchView);
    }
}(this, function (mcc, GlobalSearchView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchBehavior',
        function (config) {
            var _search;
            _search = new GlobalSearchView(config);

            if (config.focus) {
                _search.focus();
            }
        }
    );
}));