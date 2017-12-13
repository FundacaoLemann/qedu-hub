(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLearningIndicator/Assets/js/IdebLearningIndicator',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebLearningIndicator/Assets/js/view/IdebLearningIndicator'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebLearningIndicatorView);
    }
}(this, function (mcc, IdebLearningIndicatorView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebLearningIndicator/Assets/js/IdebLearningIndicator',

        function() {
            idebLearningIndicator = new IdebLearningIndicatorView();
        }
    );
}));
