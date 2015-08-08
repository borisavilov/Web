// Declare app level module which depends on filters, and services
angular.module('dyna-form-ng', [
    'ui.router',
    'ui.select2',
    'controllers',
    'services',
    'directives',
    'form-renderer',
    'ng-highcharts'
]);

angular.module('dyna-form-ng').config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider
        .when('', '/home');

    $stateProvider

        .state('home', {
            url: '/home',
            templateUrl: 'views/home.html',
            controller: 'ReportsDashboardCtrl'
        })

        .state('list', {
            url: '/list',
            templateUrl: 'views/reports-list.html',
            controller: 'ListReportsCtrl'
        })

        .state('list.report', {
            url: '/:report',
            templateUrl: 'views/report-detail.html',
            controller: 'ReportsDetailCtrl'
        })

        .state('list.config', {
            url: '/admin/:reportType',
            templateUrl: 'views/manage-report.html',
            controller: 'ReportsManageCtrl'
        })

        .state('report', {
            url: '/:report/config',
            templateUrl: 'views/report-config.html',
            controller: 'ReportsConfigCtrl'
        })
});


