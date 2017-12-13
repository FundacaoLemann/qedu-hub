(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/ChildrenList',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/ChildrenList'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.ChildrenListView);
    }
}(this, function (mcc, ChildrenList) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebChildrenList/Assets/js/ChildrenList',

        function(config) {
            view = new ChildrenList(config);
        }
    );
}));
