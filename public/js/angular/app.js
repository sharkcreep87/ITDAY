var app = angular.module('DefaultTemplate',['LocalStorageModule']).constant('API_URL', 'https://developers-162.apitoolz.com/api');
app.config(function (localStorageServiceProvider) {
  localStorageServiceProvider
    	.setPrefix('DefaultTemplate');
});
app.factory('AuthService', ['$rootScope','localStorageService', function ($rootScope,localStorageService) {
    var service = {
        authenticated : function(){
              if(localStorageService.get('auth')) {
                    return true;
              }
              return false;
       },
       setAuthenticate : function($authUser){
         	  localStorageService.set('auth', $authUser);
       },
       getUser : function(){
              if(service.authenticated){
                    return localStorageService.get('auth');
              }
              return null;
        },
        logout : function(){
              localStorageService.remove('auth');
              window.location.href = "/";
        }
    }
    return service;
}]);
app.filter('unsafe', function($sce) {
    return function(val) {
    	if (!val) return val;
        return $sce.trustAsHtml(val.replace(/\n\r?/g, '<br />'));
    };
});

app.filter("trust", ['$sce', function($sce) {
  return function(htmlCode){
    htmlCode = htmlCode.replace(/ /gi, '');
    return $sce.trustAsHtml(htmlCode);
  }
}]);
app.filter('unique', function() {
   return function(collection, keyname) {
      var output = [], 
          keys = [];

      angular.forEach(collection, function(item) {
          var key = item[keyname];
          if(keys.indexOf(key) === -1) {
              keys.push(key);
              output.push(item);
          }
      });

      return output;
   };
});

var config = {
				headers:  {
			        'Authorization': 'Basic eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRjNjVlYjYzYzY1Y2MxMWE5Zjc3OWExNjk3NDViMjkwMmNhOWZlNjk0OGI3Y2RhZDRiYTNkYWQxZjA2MDI1OWVhNGM2Mzc2NTgwNWVjN2IyIn0.eyJhdWQiOiIzIiwianRpIjoiNGM2NWViNjNjNjVjYzExYTlmNzc5YTE2OTc0NWIyOTAyY2E5ZmU2OTQ4YjdjZGFkNGJhM2RhZDFmMDYwMjU5ZWE0YzYzNzY1ODA1ZWM3YjIiLCJpYXQiOjE0OTQyMjIyMzUsIm5iZiI6MTQ5NDIyMjIzNSwiZXhwIjoxNDk1NTE4MjM1LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.BKgaU7pbKgWrYJq6W4NLq3zY355qO6wffxwxu41uI0RIdFW-tFuyoqr1wkmRpqPeyXpV5L_-lgfvlU6z8KLrplnSnCasSSPraLjXmSJ2wnX8GU6hOPF1wWaQb_47TFM-TDvLesJHpVK3gGWiHkpChskPOT1vPgkBP-OIDuhastvJ0_7gViA51JjN0eaE4iFfWnvgBaQMgxuWA-4z6m_sq7RV60nkZUDj2i4w62Fw5R4pBKhtyYw7F7EfQTosghtUWI3PBIGTj8LmWdFY7vmxJeeTYim3S1P3e09MuJWrX9x75QEA28CumHS7t2kEy2eaV38bRzc-4K2hxBIxnaBOzKs0XTIylIgtA0RreNSqP12jMXjuNggYmSDlGn6E3w24Ql96DRbNIaSy8J6jpl3APQN_fYs6kwGMwkenI2a5NSdkUXzZwvHsvgVSucYQCjwWoaGCMmOxwsmdHaMa2GM5frBwe0VryW70kyD1ZhIvZHqLJjBJSDM4JarfzMvYLRCXttvblBMAyrkzxEJKInj4IJtvGFqiP6EK6NdsPBY3-kL2m3ioFoheRbdnUB-dOUo3yYz3HHw0CKpN8zokWCrZxqaiEE_d4Hx2rIr_Yvps1A6ReXcB8jat20XjXzuuuzsTFDrXvjsRCc4jgZVU0b4EyjPe73XjDf_3-c281ykKRgY',
			        'Accept': 'application/json'
			    }
			};

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}