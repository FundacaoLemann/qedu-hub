(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowCountBehavior',
            [
                'mcc',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowCountView'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.FollowCountView);
    }
}(this, function (mcc, FollowCountView) {
    mcc.behavior(
        'Meritt/QEdu/UI/Follow/Assets/js/FollowCountBehavior',
        function (config) {
            _showFollowCountView = new FollowCountView(config);
        }
    );
}));
