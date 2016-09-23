/*==========================================================
    Author      : Megha Shah
    Date Created: 20 Sept 2016
    Description : Controller to handle Home page
    
 ===========================================================*/

dashboard.controller("HomeController", ['$rootScope', '$scope', '$state', '$location', 'dashboardService', 'Flash',
function ($rootScope, $scope, $state, $location, dashboardService, Flash) {
    var vm = this;
    vm.showDetails = true;
    vm.home = {};

    dashboardService.getStats({action:'user_dashboard',user_id:$rootScope.login_user_id}).then(function (response) {
        if(response.status == '1'){
            vm.home.mainData = [
                {
                    title: "Client users",
                    value: response.user_count,
                    theme: "aqua",
                    icon: "user"
                }
            ];
            vm.login_user_name = $rootScope.login_user_name;
            vm.login_user_id = $rootScope.login_user_id;
            vm.login_user_type = $rootScope.login_user_type;
        }else{
            $state.go('login');
            Flash.create('danger', 'Please login again.', 'large-text');
        }
    });

}]);

