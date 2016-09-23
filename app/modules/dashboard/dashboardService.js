/*==========================================================
   Author      : Megha Shah
   Date Created: 20 Sept 2016
   Description : To handle the service for Dashboard module
   
===========================================================*/


dashboard.service('dashboardService', ['$http', '$q', 'Flash', 'apiService', function ($http, $q, Flash, apiService) {

    var dashboardService = {};

    //service to communicate with users to include a new user
    var getStats = function (parameters)  {
        var deferred = $q.defer();
        apiService.get("dashboard", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };
    
    //Service to get all users
    var getUsers = function(parameters){
        var deferred = $q.defer();
        apiService.get("users_management", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };
    
    //Service to save user
    var createUser = function(parameters){
        var deferred = $q.defer();
        apiService.create("users_management", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };
    
    //Service to get all users
    var getUser = function(parameters){
        var deferred = $q.defer();
        apiService.get("users_management", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };
    
    //Service to save user
    var updateUser = function(parameters){
        var deferred = $q.defer();
        apiService.update("users_management", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };
    
    //Service to save user
    var deleteUser = function(parameters){
        var deferred = $q.defer();
        apiService.update("users_management", parameters).then(function (response) {
            if (response)
                deferred.resolve(response);
            else
                deferred.reject("Something went wrong while processing your request. Please Contact Administrator.");
        },
            function (response) {
                deferred.reject(response);
            });
        return deferred.promise;
    };

    dashboardService.getStats = getStats;
    dashboardService.getUsers = getUsers;
    dashboardService.createUser = createUser;
    dashboardService.getUser = getUser;
    dashboardService.updateUser = updateUser;
    dashboardService.deleteUser = deleteUser;

    return dashboardService;

}]);
