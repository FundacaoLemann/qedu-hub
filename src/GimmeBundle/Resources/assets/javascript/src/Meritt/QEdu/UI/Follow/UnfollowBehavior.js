(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/UnfollowBehavior',
            [
                'mcc',
                'Meritt/QEdu/UI/Follow/Assets/js/UnfollowView'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.UnfollowView);
    }
}(this, function (mcc, UnfollowView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Follow/Assets/js/UnfollowBehavior',
        function (config) {
            _unfollowView = new UnfollowView(config);
        }
    );
}));
