(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Ideb/Assets/js/Filters',
            [
                'mcc',
                'Meritt/QEdu/UI/Ideb/Assets/js/view/Filters'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.FiltersView);
    }
}(this, function (mcc, Filters) {
    mcc.behavior(
        'Meritt/QEdu/UI/Ideb/Assets/js/Filters',

        function(config) {
            filters = new Filters(config);
        }
    );
}));
