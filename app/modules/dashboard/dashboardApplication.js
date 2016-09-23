/*==========================================================
    Author      : Megha Shah
    Date Created: 20 Sept 2016
    Description : Base for Dashboard Application module
    
 ===========================================================*/

var dashboard = angular.module('dashboard', ['ui.router', 'ngAnimate','ngMaterial']);


dashboard.config(["$stateProvider", function ($stateProvider) {

    //dashboard home page state
    $stateProvider.state('app.dashboard', {
        url: '/dashboard',
        templateUrl: 'app/modules/dashboard/views/home.html',
        controller: 'HomeController',
        controllerAs: 'vm',
        data: {
            pageTitle: 'Home'
        }
    });
    
    //Achievements page state
    $stateProvider.state('app.users', {
        url: '/users',
        templateUrl: 'app/modules/dashboard/views/users.html',
        controller: 'UsersController',
        controllerAs: 'vm',
        data: {
            pageTitle: 'Users Management'
        }
    });

}]);

