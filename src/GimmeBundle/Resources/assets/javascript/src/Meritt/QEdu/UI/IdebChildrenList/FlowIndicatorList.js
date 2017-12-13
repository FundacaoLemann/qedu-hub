(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/FlowIndicatorList',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/FlowIndicatorList'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.FlowIndicatorListView);
    }
}(this, function (mcc, FlowIndicatorListView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebChildrenList/Assets/js/FlowIndicatorList',

        function(config) {
            view = new FlowIndicatorListView(config);
        }
    );
}));
