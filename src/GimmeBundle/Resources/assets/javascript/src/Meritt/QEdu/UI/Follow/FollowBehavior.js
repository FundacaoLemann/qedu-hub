(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowBehavior',
            [
                'mcc',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowView'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.FollowView);
    }
}(this, function (mcc, FollowView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Follow/Assets/js/FollowBehavior',
        function(config) {
            _FollowView = new FollowView(config);
        }
    );
}));
