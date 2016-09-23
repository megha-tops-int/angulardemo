/*==========================================================
    Author      : Megha Shah
    Date Created: 13 Jan 2016
    Description : Controller to handle User Management

 ===========================================================*/

dashboard.controller("UsersController", ['$rootScope', '$scope', '$state', '$location', 'dashboardService', 'Flash',
function ($rootScope, $scope, $state, $location, dashboardService, Flash) {
    
    
  
    var vm = this;
    vm.user = {};

    vm.showUserList = function(){
        vm.user.pageno  = 1;
        vm.user.total_count = 0;
        vm.user.itemsPerPage = 2;
        vm.user.maxSize = 5;
        vm.user_form = false;
        vm.getUser = {};
        vm.form_title = 'add';

        dashboardService.getUsers(
        {
            action:'user_management',
            user_id:$rootScope.login_user_id,
            search:vm.user.search,
            orderby:vm.user.orderProp,
            item_per_page:vm.user.itemsPerPage,
            page_no:vm.user.itemsPerPage
        })
        .then(function (response) {
            if(response.status == '1'){
                vm.user.users = response.users;
                vm.user.orderProp = '-id';
                vm.user.total_count = response.total_count;
            }else{
                $state.go('login');
            }
        });
    };

    vm.addFormShow = function(){
      vm.form_title = 'add';
      vm.getUser = {};
      vm.getUser.user_type = '1';
      vm.getUser.status = '1';
      vm.getUser.action = "user_add";
      vm.user_form = true;
    };
    vm.addUser = function(data){
        if(data.action == 'user_add'){
            if(data.password == data.confirmPassword && data.password != '' ){
                data.user_id = $rootScope.login_user_id;
                dashboardService.createUser(data).then(function (response) {
                    if(response.status == '1'){
                        Flash.create('success', 'User added successfully.', 'large-text');
                        vm.showUserList();
                    }else{
                        Flash.create('danger', response.message, 'large-text');
                    }
                });
            }else if(data.password == ''){
                Flash.create('danger', 'Please enter password.', 'large-text');
            }else{
                Flash.create('danger', 'Please enter password and confirm password same.', 'large-text');
            }
        }else{
            data.user_id = $rootScope.login_user_id;
            dashboardService.updateUser(data).then(function (response) {
                if(response.status == '1'){
                    Flash.create('success', 'User updated successfully.', 'large-text');
                    vm.showUserList();
                }else{
                    Flash.create('danger', response.message, 'large-text');
                }
            });
        }
    };

    vm.editFormShow = function(id){
        dashboardService.getUser({
            action:'user_get',
            id:id,
            user_id:$rootScope.login_user_id
        }).then(function (response) {
            if(response.status == '1'){
                vm.form_title = 'edit';
                vm.getUser = response.user;
                vm.getUser.action = 'user_edit';
                vm.user_form = true;
            }else{
                Flash.create('danger', response.message, 'large-text');
            }
        });
    };

    vm.deleteUser = function(id){
        if(confirm("Are you sure you want to delete this user?")){
            if(id == $rootScope.login_user_id){
                Flash.create('danger',"You can not delete login user.", 'large-text');
            }else{
                dashboardService.deleteUser({
                    action:'user_delete',
                    id:id,
                    user_id:$rootScope.login_user_id
                }).then(function (response) {
                    if(response.status == '1'){
                        Flash.create('success', 'User deleted successfully.', 'large-text');
                        vm.showUserList();
                    }else{
                        Flash.create('danger', response.message, 'large-text');
                    }
                });
            }
        }
    };
    vm.showUserList();
    
    $scope.$watch("currentPage + numPerPage", function() {
            var begin = (($scope.currentPage - 1) * $scope.numPerPage), end = begin + $scope.numPerPage;
            vm.user.users = vm.user.users.slice(begin, end);
    });
}]);

