(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/ButtonBehavior',
            [
                'mcc',
                'Meritt/QEdu/UI/Follow/Assets/js/ButtonView'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.ButtonView);
    }
}(this, function (mcc, ButtonView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Follow/Assets/js/ButtonBehavior',
        function (config) {
            _buttonView = new ButtonView(config);
        }
    );
}));
