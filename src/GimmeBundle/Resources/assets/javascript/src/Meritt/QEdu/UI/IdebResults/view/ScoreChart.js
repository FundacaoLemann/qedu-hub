(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebResults/Assets/js/view/ScoreChart',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.ScoreChartView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '#graph',

        initialize: function(config) {
            this.title      = config.title;
            this.categories = config.categories;
            this.series     = config.series;

            this.selectedCategory = 0;
            for (var i = 0; i < this.categories.length; ++i) {
                if (config.edition == this.categories[i]) {
                    this.selectedCategory = i;
                    break;
                }
            }
        },

        render: function (Highcharts) {
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    downloadJPEG: 'Fazer download em uma imagem JPEG',
                    downloadPDF:  'Fazer download em um documento PDF',
                    downloadPNG:  'Fazer download em uma imagem PNG',
                    downloadSVG:  'Fazer download em uma imagem SVG',
                    printChart:   'Imprimir gráfico'
                }
            });

            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: this.el,
                    type: 'line',
                    exporting: {
                        enabled: true
                    }
                },
                title: {
                    text: this.title,
                    align: 'left',
                    x: 0,
                    style: {
                        fontSize      : '14px',
                        color         : '#000',
                        fontWeight    : 'bold',
                        textTransform : 'uppercase'
                    }
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    buttons: {
                        printButton: {
                            enabled: false
                        }
                    }
                },
                xAxis: {
                    categories: this.categories,
                    min: 0,
                    plotLines: [{
                        color: '#ddd',
                        width: 2,
                        value: this.selectedCategory
                    }]
                },
                yAxis: {
                    title: {
                        enabled: false
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                                this.x + ': ' + Highcharts.numberFormat(this.y, 1)
                    }
                },
                legend: {
                    width: 600,
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'top',
                    y: 35,
                    x: 15,
                    itemMarginBottom: 25,
                    itemWidth: 120,
                    borderColor: 'transparent',
                    itemStyle: {
                        fontSize: '10px',
                        width: '170px'
                    }
                },
                series: this.series
            });
        }
    });
}));
