(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Enem/Assets/js/Compare',
            [
                'mcc',
                'Meritt/QEdu/UI/Enem/Assets/js/view/Compare'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.CompareView);
    }
}(this, function (mcc, Compare) {
    mcc.behavior(
        'Meritt/QEdu/UI/Enem/Assets/js/Compare',

        function(config) {
            filters = new Compare(config);
        }
    );
}));
