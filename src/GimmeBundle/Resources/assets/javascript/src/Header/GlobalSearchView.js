(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchView',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchModel'
            ],
            factory
        );
    } else {
        root.GlobalSearchView = factory(root.jQuery, root.Backbone, root._, root.GlobalSearchModel);
    }
}(this, function($, Backbone, _, GlobalSearchModel) {
    return Backbone.View.extend({
        el: '.qedu-search',
        events: {
            'keyup input[type="text"]'              : 'keyUp',
            'keydown input[type="text"]'            : 'keyDown',
            'focus input[type="text"]'              : 'inputFocus',
            'blur input[type="text"]'               : 'inputBlur',
            'mouseenter a.qedu-search-result'       : 'hover',
            'mouseleave a.qedu-search-result'       : 'hover',
            'submit'                                : 'submit',
            'webkitspeechchange input[type="text"]' : 'speechResult',
            'click .qedu-search-result'             : 'trackSuggestionPicked'
        },
        textToSearch: null,
        urlToAppend: '',
        autosend: false,
        initialize: function(config) {
            this.$imgLoading            = $('.ajax-loading');
            this.model                  = new GlobalSearchModel();
            this.templateResults        = _.template($('#qedu-search-tmpl-results').html());
            this.templateNothingTyped   = _.template($('#qedu-search-tmpl-nothing-typed').html());
            this.templateNothingFounded = _.template($('#qedu-search-tmpl-nothing-founded').html());

            this.model.on('sync', _.bind(function(data) {
                return this.onFetch(data);
            }, this));

            if (config && config.urlToAppend) {
                this.urlToAppend = config.urlToAppend;
            }

            this.debouncedFind = _.debounce(_.bind(this.find, this), 300);
        },
        keyDown: function(e) {
            switch (e.keyCode) {
                case 27:
                    return this.close();
                case 13:
                    return this.goResultSelected();
                case 38:
                    return this.moveCursorUp();
                case 40:
                    return this.moveCursorDown();
            }
        },
        keyUp: function(e) {
            if (this.textToSearch === e.currentTarget.value) {
                return;
            }
            this.textToSearch = e.currentTarget.value;
            this.debouncedFind();
        },
        speechResult: function(e) {
            var m, modes, regOpts, regWithoutOpts, v;
            this.$el.find("input[type='text']").prev().hide();
            regOpts = /^ir para (aprendizado|compare|comparar|evolução|proficiência|explorer?|contexto|pessoas|censo|censo escolar)( d[aoe])? /;
            regWithoutOpts = /^ir para /;
            v = this.$el.find("input[type='text']").val();
            m = v.match(regOpts);
            if (!m) {
                m = v.match(regWithoutOpts);
            }
            if (m) {
                if (m.length > 1) {
                    this.$el.find("input[type='text']").val(v.replace(regOpts, ""));
                    modes = {
                        "evolução"      : "evolucao",
                        "proficiência"  : "proficiencia",
                        "comparar"      : "compare",
                        "explore"       : "explorar",
                        "explorer"      : "explorar",
                        "censo escolar" : "censo-escolar",
                        "censo"         : "censo-escolar"
                    };
                    if (modes[m[1]]) {
                        return this.autosend = modes[m[1]];
                    } else {
                        return this.autosend = m[1];
                    }
                } else {
                    this.$el.find("input[type='text']").val(v.replace(regWithoutOpts, ""));
                    return this.autosend = true;
                }
            }
        },
        /* Controle do Teclado*/

        close: function() {
            if ($('.qedu-search-results').size() === 0) {
                this.$el.find('input').val('');
            }
            return this.removeAll();
        },
        goResultSelected: function() {
            var $el, url;
            $el = this.$el.find('ul li a.qedu-search-result.qedu-search-hover');
            if ($el.size() > 0) {
                url = $el.get(0).href;
                if (!_.isBoolean(this.autosend)) {
                    if (_.last(url) !== "/") {
                        url += "/";
                    }
                    url += this.autosend;
                }
                this.trackSuggestionPicked();
                window.location = url;
                return true;
            }
            return false;
        },
        moveCursorUp: function() {
            /* Pega todos os resultados*/

            var allResults, indexSelected, indexToSelect, lastIndex;
            allResults = this.$el.find('ul li a.qedu-search-result');
            /* Encontra o índice do resultado selecionado*/

            indexSelected = null;
            allResults.each(function(index, item) {
                if ($(item).hasClass('qedu-search-hover')) {
                    indexSelected = index;
                }
            });
            /*Encontra o índice do próximo item a ser selecionado*/

            lastIndex = allResults.length - 1;
            indexToSelect = indexSelected - 1;
            if (indexToSelect < 0) {
                indexToSelect = lastIndex;
            }
            /* muda seleção*/

            $(allResults[indexSelected]).removeClass('qedu-search-hover');
            return $(allResults[indexToSelect]).addClass('qedu-search-hover');
        },
        moveCursorDown: function() {
            var allResults, indexSelected, indexToSelect, lastIndex;
            allResults = this.$el.find('ul li a.qedu-search-result');
            indexSelected = null;
            allResults.each(function(index, item) {
                if ($(item).hasClass('qedu-search-hover')) {
                    return indexSelected = index;
                }
            });
            lastIndex = allResults.length - 1;
            indexToSelect = indexSelected + 1;
            if (indexToSelect > lastIndex) {
                indexToSelect = 0;
            }
            $(allResults[indexSelected]).removeClass('qedu-search-hover');
            return $(allResults[indexToSelect]).addClass('qedu-search-hover');
        },
        selectFirstResult: function() {
            return this.$el.find('a.qedu-search-result').first().addClass('qedu-search-hover');
        },
        /* Métodos de Busca*/

        find: function() {
            if (!this.textToSearch) {
                /* cancela timeout anterior*/

                if (this.timeOut) {
                    clearTimeout(this.timeOut);
                }
                /* exibe que nada foi encontrada*/

                return this.showNothingTyped();
            } else {
                /* We use a timeout to prevent to call to much an ajax request*/

                return this.findText();
            }
        },
        findText: function() {
            /* se não limparmos o modelo, e o resultado da busca retornar a mesma coisa
             que a busca anterior, o evento 'change' não é lancado.
             */

            var _this = this;
            this.model.removeAll();
            var searchString = this.textToSearch;

            var url = "/api/search/?text=" + searchString;
            if (this.urlToAppend) {
                url += '&destination=' + this.urlToAppend;
            }
            if (window.ga) {
                var pageUrl = window.location.pathname + window.location.search;
                var separator = "?";
                if (pageUrl.indexOf("?") !== -1) {
                    separator = "&";
                }
                pageUrl = pageUrl+separator+'s='+encodeURIComponent(searchString);
                window.ga('send', 'pageview', pageUrl);
            }
            this.model.url = url;
            return this.model.fetch({
                beforeSend: function() {
                    return _this.$imgLoading.fadeIn();
                },
                complete: function() {
                    return _this.$imgLoading.fadeOut();
                }
            });
        },
        onFetch: function(model) {
            if (model.get('states').length === 0 && model.get('cities').length === 0 && model.get('citygroups').length === 0 &&
                model.get('schools').length === 0) {
                this.showNothingFounded();
                return;
            }
            this.removeAll();
            this.$el.append(this.templateResults(model.toJSON()));
            this.selectFirstResult();
            if (this.autosend !== false) {
                this.goResultSelected();
            }
        },
        showNothingFounded: function() {
            this.removeAll();
            return this.$el.append(this.templateNothingFounded({}));
        },
        showNothingTyped: function() {
            this.removeAll();
            return this.$el.append(this.templateNothingTyped({}));
        },
        removeAll: function() {
            return this.$el.find('.qedu-search-results').remove();
        },
        submit: function(e) {
            return e.preventDefault();
        },
        /* Quando o foco do campo sair,
         deve remover os resultados da busca para nao atrapalhar a navegação na página.
         O setTimeOut é necessário porque, se o usuário clicasse em um resultado da busca,
         o close seria executado antes do click ser executado.
         */

        inputBlur: function(e) {
            return _.delay(this.removeAll.bind(this), 200);
        },
        inputFocus: function(e) {
            this.textToSearch = e.currentTarget.value;
            return this.find();
        },
        focus: function() {
            return this.$el.find('input[type="text"]').focus();
        },
        hover: function(e) {
            var $this;
            this.$el.find('ul li a.qedu-search-result.qedu-search-hover').removeClass('qedu-search-hover');
            $this = $(e.currentTarget);
            if (e.type === 'mouseenter') {
                return $this.addClass('qedu-search-hover');
            } else {
                return $this.removeClass('qedu-search-hover');
            }
        },
        trackSuggestionPicked: function() {
            $el = this.$el.find('ul li a.qedu-search-result.qedu-search-hover');

            var optionPicked = $el.contents().get(0).nodeValue.trim();
            var categoryPicked = $el.closest('ul.qedu-search-nav').find('.qedu-search-legend').text();

            var eventLabel = categoryPicked + ' - ' + optionPicked;

            ga('send', 'event', 'search', 'suggestion picked', eventLabel);
        }
    });
}));
