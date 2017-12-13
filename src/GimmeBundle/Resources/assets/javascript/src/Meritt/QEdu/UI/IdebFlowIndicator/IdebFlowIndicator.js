(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebFlowIndicator/Assets/js/IdebFlowIndicator',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebFlowIndicator/Assets/js/view/IdebFlowIndicator'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebFlowIndicatorView);
    }
}(this, function (mcc, IdebFlowIndicatorView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebFlowIndicator/Assets/js/IdebFlowIndicator',

        function() {
            idebFlowIndicator = new IdebFlowIndicatorView();
        }
    );
}));
