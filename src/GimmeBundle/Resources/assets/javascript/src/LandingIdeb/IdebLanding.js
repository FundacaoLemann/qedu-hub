(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/IdebLanding',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebLanding'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebLandingView);
    }
}(this, function (mcc, IdebLandingView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebLanding/Assets/js/IdebLanding',

        function() {
            idebLanding = new IdebLandingView();
        }
    );
}));
