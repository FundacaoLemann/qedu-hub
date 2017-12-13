(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/LearningRatesList',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/LearningRatesList'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.LearningRatesListView);
    }
}(this, function (mcc, LearningRatesListView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebChildrenList/Assets/js/LearningRatesList',

        function(config) {
            view = new LearningRatesListView(config);
        }
    );
}));
