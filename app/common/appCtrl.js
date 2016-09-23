/*==========================================================
    Author      : Megha Shah
    Date Created: 20 Sept 2016
    Description : Controller to handle main application
    
 ===========================================================*/

app.controller("appCtrl", ['$rootScope', '$scope', '$state', '$location', 'Flash','appSettings',
function ($rootScope, $scope, $state, $location, Flash,appSettings) {
    
    $rootScope.login_user_name;
    $rootScope.login_user_id;
    $rootScope.login_user_type;
    
    if($rootScope.login_user_name == null){
        if (typeof(Storage) !== "undefined") {
            // Code for localStorage/sessionStorage.
            // Retrive
            if (localStorage.login_user_name) {
                $rootScope.login_user_name = localStorage.getItem("login_user_name");
                $rootScope.login_user_id = localStorage.getItem("login_user_id");
                $rootScope.login_user_id = localStorage.getItem("login_user_id");
            }else{
                $state.go('login');
            }
        }else{
            $state.go('login');
        }
    }
    var vm = this;

    //Main menu items of the dashboard
    vm.menuItems = [
        {
            title: "Dashboard",
            icon: "dashboard",
            state: "dashboard"
        },
        {
            title: "User management",
            icon: "user",
            state: "users"
        }
    ];

    //set the name of user login
    vm.setUserName = function (value) {
        $rootScope.login_user_name = value;
    };


    //set the id of user login
    vm.setUserId = function (value) {
        $rootScope.login_user_id = value;
    };
    
    vm.setUserType = function (value) {
        $rootScope.login_user_type = value;
    };


    //controll sidebar open & close in mobile and normal view
    vm.sideBar = function (value) {
        if($(window).width()<=767){
            if ($("body").hasClass('sidebar-open'))
                $("body").removeClass('sidebar-open');
            else
                $("body").addClass('sidebar-open');
            }
        else {
            if(value==1){
                if ($("body").hasClass('sidebar-collapse'))
                    $("body").removeClass('sidebar-collapse');
            else
                $("body").addClass('sidebar-collapse');
            }
        }
    };
    
    //controll logout 
    vm.logout = function(){
        $rootScope.login_user_name = '';
        $rootScope.login_user_id= '';
        $rootScope.login_user_type= '';
        localStorage.removeItem("login_user_name");
        localStorage.removeItem("login_user_id");
        localStorage.removeItem("login_user_type");
        $state.go('login');
    };

    console.log('getting in to the app controller');

}]);
