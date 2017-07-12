(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/IdebInStates',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebInStates'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebInStatesView);
    }
}(this, function (mcc, IdebInStatesView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebLanding/Assets/js/IdebInStates',

        function() {
            idebInStates = new IdebInStatesView();
        }
    );
}));
