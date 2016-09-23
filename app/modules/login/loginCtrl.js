/*==========================================================
    Author      : Megha Shah
    Date Created: 18 Sept 2016
    Description : Controller to handle Login module
    
 ===========================================================*/

login.controller("loginCtrl", ['$rootScope', '$scope', '$state', '$location', 'loginService', 'Flash','apiService',
function ($rootScope, $scope, $state, $location, loginService, Flash, apiService) {
        var vm = this;

        vm.getUser = {};
        vm.setUser = {};
        vm.signIn = true;

        //access login
        vm.login = function (data) {
            if (data.Email != "" && data.Password != "") {
                loginService.accessLogin(vm.getUser).then(function (response) {
                    if (response.status == "1") {
                        $rootScope.login_user_name = response.user_name;
                        $rootScope.login_user_id = response.user_id;
                        $rootScope.login_user_type = response.user_type;
                        if (typeof(Storage) !== "undefined") {
                            // Code for localStorage/sessionStorage.
                            // Store
                            localStorage.setItem("login_user_name", response.user_name);
                            localStorage.setItem("login_user_id", response.user_id);
                            localStorage.setItem("login_user_type", response.user_type);
                        }
                        $state.go('app.dashboard');
                    }
                    else{
                        Flash.create('danger', response.message, 'large-text');
                    }
                });
            }
            else{
                Flash.create('danger', 'Invalid Username', 'large-text');
            };
        };

        //get registration details
        vm.register = function () {
            if (vm.setUser.confirmPassword == vm.setUser.password){
                var action = 'user_register';  //using Geo in trigger
                vm.setUser.action = action;
                loginService.registerUser(vm.setUser).then(function (response) {
                    if (response.status == "1") {
                        vm.setUser = {};
                        vm.signIn = true;
                        $state.go('login');
                    }else{
                        Flash.create('danger', response.message, 'large-text');
                    }
                });
            }else{
                Flash.create('danger', 'Please enter password and confirm password same.', 'large-text');
            }
        };

    }]);

