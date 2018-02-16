var gulp   = require('gulp'),
    concat = require('gulp-concat'),
    exec   = require('gulp-exec');

var uglifyjsBinary  = './node_modules/.bin/uglifyjs',
    uglifycssBinary = './node_modules/.bin/uglifycss',
    lessBinary      = './node_modules/.bin/lessc',
    coffeeBinary    = './node_modules/.bin/coffee';

var jsCmdVersionOne  = uglifyjsBinary + ' <%= file.path %> --define __DEV__=1 --beautify quote_keys=true',
    jsCmdVersionTwo  = uglifyjsBinary + ' <%= file.path %>',
    jsCompileCoffee  = coffeeBinary   + ' --print --stdio < <%= file.path %>',
    jsUglifyQuotes   = uglifyjsBinary + ' <%= file.path %> --beautify beautify=false,quote_keys=true --no-copyright',
    cssCmdVersionOne = lessBinary     + ' <%= file.path %> --compress',
    cssCmdVersionTwo = lessBinary     + ' <%= file.path %> --compress' + ' | ' + uglifycssBinary;

var execOptions       = {pipeStdout: true},
    noBreakLineOption = {newLine:''};


gulp.task('header.js', function() {
  return gulp.src([
      './javascript/src/Header/SentryBehavior.js',
      './javascript/src/Header/GlobalSearchModel.js',
      './javascript/src/Header/GlobalSearchView.js',
      './javascript/src/Header/GlobalSearchBehavior.js',
      './javascript/src/Header/IdebModal_view.js',
      './javascript/src/Header/IdebModal.js'
    ])
    .pipe(concat('Header.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('landingideb.js', function() {
  return gulp.src([
      './javascript/src/LandingIdeb/jquery.fullPage.js',
      './javascript/src/LandingIdeb/jquery.easings.min.js',
      './javascript/src/LandingIdeb/jquery.slimscroll.min.js',
      './javascript/src/LandingIdeb/IdebInStates_view.js',
      './javascript/src/LandingIdeb/IdebInStates.js',
      './javascript/src/LandingIdeb/Search_view.js',
      './javascript/src/LandingIdeb/Search.js',
      './javascript/src/LandingIdeb/IdebLanding_view.js',
      './javascript/src/LandingIdeb/IdebLanding.js'
    ])
    .pipe(exec(jsCmdVersionTwo, execOptions))
    .pipe(concat('landingideb.js', noBreakLineOption))
    .pipe(gulp.dest('./javascript/dist/'));
});


gulp.task('banner.css', function() {
  return gulp.src([
      './stylesheet/src/Banner/MeuMunicipioBanner.less',
      './stylesheet/src/Banner/ExcelenciaEquidadeBanner.less'
    ])
    .pipe(exec(cssCmdVersionOne, execOptions))
    .pipe(concat('banner.css', noBreakLineOption))
    .pipe(gulp.dest('./stylesheet/dist/'));
});

gulp.task('landingideb.css', function() {
  return gulp.src([
      './stylesheet/src/IdebLanding/jquery.fullPage.css',
      './stylesheet/src/IdebLanding/LandingPage.less',
      './stylesheet/src/IdebLanding/WhatIs.less',
      './stylesheet/src/IdebLanding/IdebInBrazil.less',
      './stylesheet/src/IdebLanding/IdebInStates.less',
      './stylesheet/src/IdebLanding/Search.less',
      './stylesheet/src/IdebLanding/ExcellenceWithEquity.less',
      './stylesheet/src/IdebLanding/BestPractices.less'
    ])
    .pipe(exec(cssCmdVersionTwo, execOptions))
    .pipe(concat('landingideb.css'))
    .pipe(gulp.dest('./stylesheet/dist/'));
});

gulp.task('dropdown-select2.css', function() {
    return gulp.src([
        './stylesheet/src/select2/select2.css',
        './stylesheet/src/select2/select2-bootstrap.css',
        './stylesheet/src/provabrasil/dropdowns-select2.less'
    ])
    .pipe(exec(cssCmdVersionOne, execOptions))
    .pipe(concat('dropdown-select2.css', noBreakLineOption))
    .pipe(gulp.dest('./stylesheet/dist/'))
});

gulp.task('provabrasil.js', function() {
    return gulp.src([
        './javascript/src/ProvaBrasil/Util/statemenu.coffee',
        './javascript/src/ProvaBrasil/Util/fixedLayout.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-fixed-layout.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-i18n.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-dropdown.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-tooltip.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-popover.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-smoothscroll.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-append-hash-to-url.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-highlight-by-hash.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-label_behind.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-chart.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-full-height.coffee',
        './javascript/src/ProvaBrasil/Header/behavior-header.coffee',
        './javascript/src/ProvaBrasil/Footer/behavior-footer.coffee',
        './javascript/src/ProvaBrasil/Util/RotateBanner/behavior.coffee',
        './javascript/src/ProvaBrasil/Search/Global/model-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Search/Global/view-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Search/Global/behavior-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Easteregg/harlemshake.coffee',
    ])
    .pipe(concat('provabrasil.js'))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('provabrasil.css', function() {
    return gulp.src([
        './generic/css/bootstrap/reset.less',
        './generic/css/bootstrap/variables.less',
        './stylesheet/src/ProvaBrasil/variables.less',
        './generic/css/bootstrap/mixins.less',
        './stylesheet/src/ProvaBrasil/mixins.less',
        './generic/css/bootstrap/scaffolding.less',
        './generic/css/bootstrap/grid.less',
        './generic/css/bootstrap/layouts.less',
        './generic/css/bootstrap/type.less',
        './stylesheet/src/ProvaBrasil/type.less',
        './generic/css/bootstrap/code.less',
        './generic/css/bootstrap/forms.less',
        './stylesheet/src/ProvaBrasil/forms.less',
        './generic/css/bootstrap/tables.less',
        './stylesheet/src/ProvaBrasil/tables.less',
        './generic/css/bootstrap/sprites.less',
        './stylesheet/src/ProvaBrasil/sprites.less',
        './generic/css/bootstrap/dropdowns.less',
        './stylesheet/src/ProvaBrasil/dropdowns.less',
        './generic/css/bootstrap/wells.less',
        './stylesheet/src/ProvaBrasil/wells.less',
        './generic/css/bootstrap/component-animations.less',
        './generic/css/bootstrap/close.less',
        './generic/css/bootstrap/buttons.less',
        './stylesheet/src/ProvaBrasil/buttons.less',
        './generic/css/bootstrap/button-groups.less',
        './stylesheet/src/ProvaBrasil/button-groups.less',
        './generic/css/bootstrap/alerts.less',
        './stylesheet/src/ProvaBrasil/alerts.less',
        './generic/css/bootstrap/navs.less',
        './stylesheet/src/ProvaBrasil/navs.less',
        './generic/css/bootstrap/navbar.less',
        './stylesheet/src/ProvaBrasil/navbar.less',
        './stylesheet/src/ProvaBrasil/subnav.less',
        './stylesheet/src/ProvaBrasil/subnav-detail.less',
        './stylesheet/src/ProvaBrasil/navtabs-compact.less',
        './generic/css/bootstrap/breadcrumbs.less',
        './stylesheet/src/ProvaBrasil/subnav-breadcrumbs.less',
        './generic/css/bootstrap/pagination.less',
        './generic/css/bootstrap/pager.less',
        './generic/css/bootstrap/modals.less',
        './generic/css/bootstrap/tooltip.less',
        './stylesheet/src/ProvaBrasil/tooltip.less',
        './generic/css/bootstrap/popovers.less',
        './generic/css/bootstrap/thumbnails.less',
        './stylesheet/src/ProvaBrasil/thumbnails.less',
        './generic/css/bootstrap/labels-badges.less',
        './stylesheet/src/ProvaBrasil/labels-badges.less',
        './generic/css/bootstrap/progress-bars.less',
        './generic/css/bootstrap/accordion.less',
        './generic/css/bootstrap/carousel.less',
        './generic/css/bootstrap/hero-unit.less',
        './generic/css/bootstrap/utilities.less',
        './stylesheet/src/ProvaBrasil/utilities.less',
        './stylesheet/src/ProvaBrasil/dropdownlinks.less',
        './stylesheet/src/ProvaBrasil/responsive.less',
        './stylesheet/src/ProvaBrasil/responsive-1200px-min.less',
        './stylesheet/src/ProvaBrasil/provabrasil.less',
        './stylesheet/src/ProvaBrasil/print.less',
        './stylesheet/src/ProvaBrasil/special_resources.less',
        './stylesheet/src/ProvaBrasil/lines.less',
        './stylesheet/src/ProvaBrasil/feedback.less',
        './stylesheet/src/ProvaBrasil/footer.less',
        './stylesheet/src/ProvaBrasil/scrollbar.less',
        './stylesheet/src/ProvaBrasil/more-slider.less',
        './stylesheet/src/ProvaBrasil/browser-frame.less',
        './stylesheet/src/ProvaBrasil/proficiency/colors.less', // Proficiency Base Colors and Backgrounds
        './stylesheet/src/ProvaBrasil/global-search.less',
        './stylesheet/src/ProvaBrasil/side-toolbar.less',
        './stylesheet/src/ProvaBrasil/avatar.less',
        './stylesheet/src/ProvaBrasil/home/home.less',
        './stylesheet/src/ProvaBrasil/home/features.less',
        './stylesheet/src/ProvaBrasil/home/register.less',
        './stylesheet/src/ProvaBrasil/home/news.less',
        './stylesheet/src/ProvaBrasil/buttonknow.less',
        './stylesheet/src/ProvaBrasil/didactic/didactic.less',
        './stylesheet/src/ProvaBrasil/didactic/title.less',
        './stylesheet/src/ProvaBrasil/didactic/contextinfo.less',
        './stylesheet/src/ProvaBrasil/didactic/filter.less',
        './stylesheet/src/ProvaBrasil/didactic/agitation.less',
        './stylesheet/src/ProvaBrasil/didactic/learningblock.less',
        './stylesheet/src/ProvaBrasil/didactic/compareblock.less',
        './stylesheet/src/ProvaBrasil/didactic/evolutionblock.less',
        './stylesheet/src/ProvaBrasil/context/block/ideb.less',
        './stylesheet/src/ProvaBrasil/survey/home.less',
        './stylesheet/src/ProvaBrasil/survey/question.less',
        './stylesheet/src/ProvaBrasil/survey/filter.less',
        './stylesheet/src/ProvaBrasil/survey/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/censo/filter.less',
        './stylesheet/src/ProvaBrasil/censo/item.less',
        './stylesheet/src/ProvaBrasil/educacenso/grouptable.less',
        './stylesheet/src/ProvaBrasil/educacenso/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/dashboard/index.less',
        './stylesheet/src/ProvaBrasil/dashboard/school/block.less',
        './stylesheet/src/ProvaBrasil/proficiency/building-chart.less',
        './stylesheet/src/ProvaBrasil/proficiency/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/proficiency/page.less',
        './stylesheet/src/ProvaBrasil/proficiency/stamp.less',
        './stylesheet/src/ProvaBrasil/proficiency/buttons-filter.less',
        './stylesheet/src/ProvaBrasil/survey/contextinfo.less',
        './stylesheet/src/ProvaBrasil/survey/context.less',
        './stylesheet/src/ProvaBrasil/school/nse.less',
        './stylesheet/src/ProvaBrasil/censo/aggregated.less',
        './stylesheet/src/ProvaBrasil/censo/school.less',
        './stylesheet/src/ProvaBrasil/search/guided.less',
        './generic/css/jquery.loadmask/jquery.loadmask.css',
        './stylesheet/src/ProvaBrasil/nouislider.less',
        './stylesheet/src/ProvaBrasil/income_rate/base.less',
        './stylesheet/src/ProvaBrasil/income_rate/data_by_grade.less',
        './stylesheet/src/ProvaBrasil/income_rate/aggregated.less',
        './stylesheet/src/ProvaBrasil/income_rate/filter.less',
        './stylesheet/src/ProvaBrasil/income_rate/lateral_bar.less',
        './stylesheet/src/ProvaBrasil/income_rate/download.less',
        './stylesheet/src/ProvaBrasil/income_rate/tech_notes.less',
        './stylesheet/src/ProvaBrasil/distortion/filter.less',
        './stylesheet/src/ProvaBrasil/distortion/grade-data.less',
        './stylesheet/src/ProvaBrasil/distortion/evolution.less',
        './stylesheet/src/ProvaBrasil/distortion/map.less',
        './stylesheet/src/ProvaBrasil/distortion/credits.less',
        './stylesheet/src/ProvaBrasil/distortion/general.less',
        './stylesheet/src/ProvaBrasil/distortion/table-schools.less',
        './stylesheet/src/ProvaBrasil/distortion/color-scale.less',
        './stylesheet/src/ProvaBrasil/distortion/progress-color-scale.less',
        './stylesheet/src/ProvaBrasil/distortion/panes.less',
        './stylesheet/src/ProvaBrasil/controls/dropdown-remote.less',
        './stylesheet/src/ProvaBrasil/util/facebook/share-button.less',
        './stylesheet/src/ProvaBrasil/util/qedu-line.less',
        './stylesheet/src/ProvaBrasil/util/legend.less',
        './stylesheet/src/ProvaBrasil/util/facebook/block.less',
        './stylesheet/src/ProvaBrasil/estudo/excelencia-com-equidade/block.less',
        './stylesheet/src/ProvaBrasil/util/rotateBanner.less',
        './stylesheet/src/ProvaBrasil/util/testimony.less',
        './stylesheet/src/ProvaBrasil/util/tour.less',
        './stylesheet/src/ProvaBrasil/error/404.less',
        './generic/css/graphs/graph.less',
        './generic/css/graphs/bars.less',
        './generic/css/intro.js/introjs.css',
        './generic/css/intro.js/introjs-ie.css',
        './generic/css/jquery.elastislide/jquery.elastislide.css',
        './stylesheet/src/Meritt/QEdu/UI/Fonts/LucidaGrande.css',
        './stylesheet/src/Meritt/QEdu/UI/Mixins.less',
        './stylesheet/src/Meritt/QEdu/UI/UIComponents.less',
        './stylesheet/src/Meritt/QEdu/UI/Variables.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/InnerHeader.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/SearchForm.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/FollowMenu.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/ProfileMenu.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/SignUp.less',
        './stylesheet/src/Meritt/QEdu/UI/Footer/InnerFooter.less',
        './stylesheet/src/Meritt/QEdu/UI/Footer/InnerIdebModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/Button.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/Count.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/FillMoreInfoIfSecretaryModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/FillProfileModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/InnerModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/InnerFollowCampaignModal.less'
    ])
    .pipe(concat('pb-concat.css'))
    .pipe(gulp.dest('./stylesheet/dist/'))
    .pipe(exec(lessBinary + ' -x --include-path=generic/:stylesheet/src/ <%= file.path %> > ./stylesheet/dist/provabrasil.css', {maxBuffer: 1024 * 5000000}))
});

gulp.task('mcc-basic-libs.js', function () {
    return gulp.src([
        'generic/js/mcc/lib/uri.js',
        'generic/js/mcc/lib/number.js',
        'generic/js/bootstrap/bootstrap-alert.js',
        'generic/js/bootstrap/bootstrap-button.js',
        'generic/js/bootstrap/bootstrap-carousel.js',
        'generic/js/bootstrap/bootstrap-collapse.js',
        'generic/js/bootstrap/bootstrap-dropdown.js',
        'generic/js/bootstrap/bootstrap-modal.js',
        'generic/js/bootstrap/bootstrap-tooltip.js',
        'generic/js/bootstrap/bootstrap-popover.js',
        'generic/js/bootstrap/bootstrap-scrollspy.js',
        'generic/js/bootstrap/bootstrap-tab.js',
        'generic/js/bootstrap/bootstrap-transition.js',
        'generic/js/bootstrap/bootstrap-typeahead.js'
    ])
    .pipe(concat('mcc-basic-libs.js', noBreakLineOption))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(concat('mcc-basic-libs.js'), noBreakLineOption)
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('mcc-boot.js', function() {
    return gulp.src([
        './javascript/src/RavenJs/raven.js',
        './javascript/src/underscore.js',
        './javascript/src/underscore.string.js',
        './javascript/src/Mcc/Core/boot.js',
        './javascript/src/Mcc/Core/functions.js',
        './javascript/src/Mcc/Core/install.js',
        './javascript/src/Mcc/Core/behavior.js',
        './javascript/src/Mcc/BigPipe/bigpipe.js',
        './javascript/src/jquery.js',
        './javascript/src/jquery-browser.js',
        './javascript/src/RavenJs/Plugins/jquery.js',
        './javascript/src/RavenJs/Plugins/native.js',
        './javascript/src/jquery.color.js',
        './javascript/src/backbone.js',
        './javascript/src/modernizr.js',
        './javascript/src/Mcc/Extra/Dev/behavior-reload.js',
        './javascript/src/Mcc/Extra/UserVoice/behavior-uservoice-widget.js'
    ])
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(concat('mcc-boot.js', noBreakLineOption))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('distortion.js', function() {
    return gulp.src([
        './javascript/src/ProvaBrasil/Distortion/Service/ColorScale.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionFilter.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionStatus.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEvolution.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEvolutionBrazil.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEvolutionState.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEvolutionCity.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEvolutionSchool.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionEntity.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionBrazil.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionState.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionCity.coffee',
        './javascript/src/ProvaBrasil/Distortion/Models/DistortionSchool.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionEntities.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionStates.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionCities.coffee',
        './javascript/src/ProvaBrasil/Distortion/Collections/DistortionSchools.coffee',
        './javascript/src/ProvaBrasil/Distortion/Routes/DistortionRouter.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionPlayerView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/Filters/DistortionDependenceFilterView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/Filters/DistortionLocalizationFilterView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/Filters/DistortionYearFilterView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionFilterView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionStageView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionEvolutionView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionTableSchoolView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionMapView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionView.coffee',
        './javascript/src/ProvaBrasil/Distortion/Views/DistortionPaneToggleView.coffee',
        './javascript/src/ProvaBrasil/Distortion/behaviorDistortion.coffee',
    ])
    .pipe(concat('distortion.js'))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('Ideb.js', function() {
    return gulp.src([
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/model/ChildrenList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/collection/ChildrenList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/view/ChildrenList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/ChildrenList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/model/FlowIndicatorList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/collection/FlowIndicatorList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/view/FlowIndicatorList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/FlowIndicatorList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/view/LearningRatesList.js',
        'javascript/src/Meritt/QEdu/UI/IdebChildrenList/LearningRatesList.js',
        'javascript/src/Meritt/QEdu/UI/Ideb/view/Filters.js',
        'javascript/src/Meritt/QEdu/UI/Ideb/Filters.js',
        'javascript/src/Meritt/QEdu/UI/IdebResults/view/ScoreChart.js',
        'javascript/src/Meritt/QEdu/UI/IdebResults/view/IdebStatusLocation.js',
        'javascript/src/Meritt/QEdu/UI/IdebResults/ScoreChart.js',
        'javascript/src/Meritt/QEdu/UI/IdebResults/IdebStatusLocation.js',
        'javascript/src/Meritt/QEdu/UI/IdebFlowIndicator/view/IdebFlowIndicator.js',
        'javascript/src/Meritt/QEdu/UI/IdebFlowIndicator/IdebFlowIndicator.js',
        'javascript/src/Meritt/QEdu/UI/IdebLearningIndicator/view/IdebLearningIndicator.js',
        'javascript/src/Meritt/QEdu/UI/IdebLearningIndicator/IdebLearningIndicator.js'
    ])
    .pipe(concat('Ideb.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('print_libs.js', function() {
    return gulp.src([
        'javascript/src/canvas-toBlob.js',
        'javascript/src/rgbcolor.js',
        'javascript/src/canvg.js',
        'javascript/src/FileSaver.js',
        'javascript/src/BlobBuilder.js',
        'javascript/src/html2canvas.js',
        'javascript/src/jspdf.js',
        'javascript/src/jspdf.plugin.addimage.js',
    ])
    .pipe(concat('print_libs.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('jquery.libs.js', function() {
    return gulp.src([
        'javascript/src/jquery.smooth-scroll-1.4.13.js',
        'javascript/src/jquery.shortcuts.js',
        'javascript/src/waypoints.js',
        'javascript/src/jquery.loadmask.js',
        'javascript/src/jquery.nouislider.js',
        'javascript/src/jquery.swatchbook.js',
    ])
    .pipe(concat('jquery.libs.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('print.js', function() {
    return gulp.src([
        'javascript/src/ProvaBrasil/Util/Print/behavior.coffee',
        'javascript/src/ProvaBrasil/Util/Print/view.coffee',
        'javascript/src/ProvaBrasil/Util/Print/data.coffee',
        'javascript/src/ProvaBrasil/Util/Print/canvas.coffee'
    ])
    .pipe(concat('print.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist'))
});

gulp.task('guide.js', function() {
    return gulp.src([
        './javascript/src/ProvaBrasil/Guide/behavior-guide.coffee',
        './javascript/src/ProvaBrasil/Guide/view-guide-abstract.coffee',
        './javascript/src/ProvaBrasil/Guide/view-guide-step-abstract.coffee',
        './javascript/src/ProvaBrasil/Guide/Evolution/view-guide-evolution.coffee',
        './javascript/src/ProvaBrasil/Guide/Evolution/view-guide-evolution-step1.coffee',
        './javascript/src/ProvaBrasil/Guide/Evolution/view-guide-evolution-step2.coffee',
        './javascript/src/ProvaBrasil/Guide/Explore/view-guide-explore.coffee',
        './javascript/src/ProvaBrasil/Guide/Explore/view-guide-explore-step1.coffee',
        './javascript/src/ProvaBrasil/Guide/Explore/view-guide-explore-step2.coffee',
        './javascript/src/ProvaBrasil/Guide/Context/view-guide-context.coffee',
        './javascript/src/ProvaBrasil/Guide/Context/view-guide-context-step1.coffee',
        './javascript/src/ProvaBrasil/Guide/Context/view-guide-context-step2.coffee',
        './javascript/src/ProvaBrasil/Guide/Context/view-guide-context-step3.coffee',
        './javascript/src/ProvaBrasil/Guide/Context/view-guide-context-step4.coffee',
    ])
    .pipe(concat('guide.js'))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('ideb.css', function() {
    return gulp.src([
        './stylesheet/src/Meritt/QEdu/UI/Ideb/Ideb.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/Filters.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/Sidebar.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/Footer.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/ClassificationLabel.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/PerformanceIndicators.less',
        './stylesheet/src/Meritt/QEdu/UI/Ideb/NoDataNotification.less',
        './stylesheet/src/Meritt/QEdu/UI/IdebResults/Results.less',
        './stylesheet/src/Meritt/QEdu/UI/IdebFlowIndicator/IdebFlowIndicator.less',
        './stylesheet/src/Meritt/QEdu/UI/IdebLearningIndicator/IdebLearningIndicator.less',
        './stylesheet/src/Meritt/QEdu/UI/IdebChildrenList/ChildrenList.less',
        './stylesheet/src/Meritt/QEdu/UI/IdebChildrenList/DataFileDownload.less',
    ])
    .pipe(concat('ideb.css'))
    .pipe(gulp.dest('./stylesheet/dist/'))
    .pipe(exec(cssCmdVersionOne, execOptions))
    .pipe(gulp.dest('./stylesheet/dist/'));
});

gulp.task('FollowButton.js', function() {
    return gulp.src([
        './javascript/src/Meritt/QEdu/UI/Follow/ButtonView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/SetFollowProfileView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/SetFollowProfileBehavior.js',
        './javascript/src/Meritt/QEdu/UI/Follow/ButtonBehavior.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowCountView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowCountBehavior.js',
        './javascript/src/Meritt/QEdu/UI/Follow/UnfollowView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/UnfollowBehavior.js',
    ])
    .pipe(concat('FollowButton.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('FollowMenu.js', function() {
    return gulp.src([
        './javascript/src/Meritt/QEdu/UI/Follow/FollowModel.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowCollection.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowListView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowDetailView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowView.js',
        './javascript/src/Meritt/QEdu/UI/Follow/FollowBehavior.js',
    ])
    .pipe(concat('FollowMenu.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('Enem.js', function() {
    return gulp.src([
        'javascript/src/Meritt/QEdu/UI/EnemBase/view/Filters.js',
        'javascript/src/Meritt/QEdu/UI/EnemBase/Filters.js',
        'javascript/src/Meritt/QEdu/UI/Enem/view/Compare.js',
        'javascript/src/Meritt/QEdu/UI/Enem/Compare.js',
        'javascript/src/Meritt/QEdu/UI/EnemBase/view/Base.js',
        'javascript/src/Meritt/QEdu/UI/EnemBase/Base.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/model/School.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/model/SchoolParticipation.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/model/SchoolResults.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/collection/SchoolResults.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/view/SchoolsList.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/SchoolsList.js',
        'javascript/src/Meritt/QEdu/UI/EnemSchoolsList/DataFileDownload.js'
    ])
    .pipe(concat('Enem.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('didactic.js', function() {
   return gulp.src([
       'javascript/src/ProvaBrasil/Didactic/fixed-main-block.coffee',
       'javascript/src/ProvaBrasil/Didactic/fixed-buttons-filter.coffee',
       'javascript/src/ProvaBrasil/Didactic/Proficiency/behavior.coffee',
       'javascript/src/ProvaBrasil/Didactic/Proficiency/view-filters-proficiency.coffee',
       'javascript/src/ProvaBrasil/Didactic/Proficiency/proficiency-collection.coffee',
       'javascript/src/ProvaBrasil/Didactic/Compare/behavior.coffee',
       'javascript/src/ProvaBrasil/Didactic/Compare/view-filters-compare.coffee',
       'javascript/src/ProvaBrasil/Didactic/Compare/compare-collection.coffee',
       'javascript/src/ProvaBrasil/Didactic/Evolution/view-filters-evolution.coffee',
       'javascript/src/ProvaBrasil/Didactic/Evolution/evolution-collection.coffee',
       'javascript/src/ProvaBrasil/Didactic/Evolution/behavior.coffee'
   ])
   .pipe(concat('didactic.js'))
   .pipe(gulp.dest('./javascript/dist'))
   .pipe(exec(jsCompileCoffee, execOptions))
   .pipe(gulp.dest('./javascript/dist'))
   .pipe(exec(jsUglifyQuotes, execOptions))
   .pipe(gulp.dest('./javascript/dist'))
});

gulp.task('explore.js', function() {
    return gulp.src([
        'javascript/src/ProvaBrasil/Explore/model-explore-state.coffee',
        'javascript/src/ProvaBrasil/Explore/view-subnav.coffee',
        'javascript/src/ProvaBrasil/Explore/view-map.coffee',
        'javascript/src/ProvaBrasil/Explore/view-explore.coffee',
        'javascript/src/ProvaBrasil/Explore/view-isotope.coffee',
        'javascript/src/ProvaBrasil/Explore/view-filters.coffee',
        'javascript/src/ProvaBrasil/Explore/model-explore.coffee',
        'javascript/src/ProvaBrasil/Explore/router-explore.coffee',
        'javascript/src/ProvaBrasil/Explore/tour-explore.coffee',
        'javascript/src/ProvaBrasil/Explore/behavior-explore.coffee',
    ])
    .pipe(concat('explore.js'))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('select2-lib.js', function() {
    return gulp.src([
        'generic/js/select2-base.js',
        'generic/js/select2.js',
        'select2_locale_pt-BR'
    ])
    .pipe(concat('select2-lib.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('dropdown-select2.js', function() {
    return gulp.src([
        'javascript/src/ProvaBrasil/Controls/dropdown-select2.coffee',
    ])
    .pipe(concat('dropdown-select2.js'))
    .pipe(gulp.dest('./javascript/dist'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('default', [
    'banner.css',
    'dropdown-select2.css',
    'landingideb.css',
    'provabrasil.css',
    'ideb.css',

    'print_libs.js',
    'distortion.js',
    'header.js',
    'landingideb.js',
    'Ideb.js',
    'mcc-boot.js',
    'mcc-basic-libs.js',
    'provabrasil.js',
    'jquery.libs.js',
    'print.js',
    'guide.js',
    'FollowButton.js',
    'FollowMenu.js',
    'Enem.js',
    'didactic.js',
    'explore.js',
    'select2-lib.js',
    'dropdown-select2.js',
]);
