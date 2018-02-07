(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemBase/Assets/js/Filters',
            [
                'mcc',
                'Meritt/QEdu/UI/EnemBase/Assets/js/view/Filters'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.FiltersView);
    }
}(this, function (mcc, Filters) {
    mcc.behavior(
        'Meritt/QEdu/UI/EnemBase/Assets/js/Filters',

        function(config) {
            filters = new Filters(config);
        }
    );
}));
