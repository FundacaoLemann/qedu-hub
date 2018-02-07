(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemBase/Assets/js/Base',
            [
                'mcc',
                'Meritt/QEdu/UI/EnemBase/Assets/js/view/Base'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.EnemBaseView);
    }
}(this, function (mcc, EnemBaseView) {
    mcc.behavior(
        'Meritt/QEdu/UI/EnemBase/Assets/js/Base',

        function(config) {
            view = new EnemBaseView(config);
        }
    );
}));
