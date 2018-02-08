(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/SetFollowProfileBehavior',
            [
                'mcc',
                'Meritt/QEdu/UI/Follow/Assets/js/SetFollowProfileView'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.SetFollowProfileView);
    }
}(this, function (mcc, SetFollowProfileView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Follow/Assets/js/SetFollowProfileBehavior',
        function (config) {
            _setFollowProfileView = new SetFollowProfileView(config);
        }
    );
}));
