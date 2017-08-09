app.controller('LoginController', function ($scope, $http, API_URL,localStorageService,AuthService) {
	$scope.user = {};
	$scope.signin = function() {
		// show loader
		$('#loader').show();
		// clear input error
		$('input').each(function(){
			$(this).parent('div').removeClass('has-error');
			$(this).parent('div').find('span').html('');
		});
		// create user object
		$http.post(API_URL+'/login',$scope.user, config)
		.then(function ($response) {
              	AuthService.setAuthenticate($response.data);
              	window.location.href="/";
		}, function ($error) {
			$('#loader').hide();
			if($error.status === 400) {
				// create error block
				if(typeof $error.data === 'object') {

					$.each($error.data, function(key, value){
						$('#'+key).parent('div').addClass('has-error');
						$('#'+key).parent('div').find('span').html(value[0]);
						$('#'+key).addClass('invalid');
					});
                          
				} else {
					$('.alert-danger').show();
					$('.alert-danger').html($error.data);
				}
				
			}
		});
	}
});