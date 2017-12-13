(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebResults/Assets/js/ScoreChart',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebResults/Assets/js/view/ScoreChart'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.ScoreChartView);
    }
}(this, function (mcc, ScoreChart) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebResults/Assets/js/ScoreChart',

        function(config) {
            growth = new ScoreChart(config);
            growth.render(window.Highcharts);
        }
    );
}));
