
var app = angular.module('myapp', ['ui.bootstrap']);

app.controller('userCtrl', ['$scope', '$rootScope', '$http', '$dialog', function ($scope, $rootScope, $http, $dialog) {
    
    $rootScope.success = 0;
    $scope.searchBook = function(){
    	console.log("clicked searchBook");
    	console.log("searchQuery",$scope.searchQuery);
    	var searchQuery = $scope.searchQuery;
        $rootScope.message = "";
    	$http({
        method: 'post',
        url: 'getBooks.php',
        data: $.param({'data': searchQuery}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.books = response.data;
            console.log($scope.books);
        });
    };

    var dialogOptions = {
    controller: 'checkOutCtrl',
    templateUrl: 'checkOutBooks.html'
    };

    $scope.checkOut = function(book){
        console.log(book);

        var isbn = book.isbn;
        var countBooks = 0;
        $scope.countBooks = "";
        $http({
        method: 'post',
        url: 'getCountBooks.php',
        data: $.param({'data': isbn}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.countBooks = response.data;
            countBooks = $scope.countBooks[0].countBooks;
            if (countBooks >= 1){
                $rootScope.message = "Book is already checked out!";
            }
            else {
                var bookToCheckout = book;
        
                $dialog.dialog(angular.extend(dialogOptions, {resolve: {book: angular.copy(bookToCheckout)}}))
                .open()
                .then(function(result) {
                    if(result) {
                      angular.copy(result, bookToCheckout);                
                    }
                bookToCheckout = undefined;
                });

                $scope.close = function(){
                    dialog.close(undefined);
                };
            }
        });
    };



    $scope.searchBookCheckIn = function(){
        console.log("clicked searchBook");
        console.log("searchQuery",$scope.searchQueryCheckIn);
        var searchQueryCheckIn = $scope.searchQueryCheckIn;
        $rootScope.checkinmessage = "";
        $http({
        method: 'post',
        url: 'getBooksCheckIn.php',
        data: $.param({'data': searchQueryCheckIn}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.bookscheckin = response.data;
            console.log($scope.bookscheckin);
        });
    };

    $scope.checkIn = function(bookcheckin){
        console.log(bookcheckin);

        var loanid = bookcheckin.loanid;
        $http({
        method: 'post',
        url: 'updateLoans.php',
        data: $.param({'data': loanid}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            console.log(response.data);
            $rootScope.checkinmessage = response.data;
           
        });
    };

    $scope.insertBorrower = function() {
   
        var data = {
            ssn:$scope.ssn,
            firstname:$scope.firstname,
            lastname:$scope.lastname,
            email:$scope.email,
            address:$scope.address,
            city:$scope.city,
            state:$scope.state,
            phone:$scope.phone
            };
        $http({
        method: 'post',
        url: 'insertBorrower.php',
        data: $.param({'data': data}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            console.log(response.data);
            $scope.addborrowermessage = response.data;
        });
    };
    $scope.updateFines = function(){       

        $http({
        method: 'post',
        url: 'updateFines.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            console.log(response.data);
            $scope.updatemessage = response.data;           
        });
    };

    $scope.getFines = function(){
        $http({
        method: 'post',
        url: 'getFines.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.finedetails = response.data;
            console.log($scope.finedetails);
        });
    };

    $scope.payFine = function(finedetail){
        console.log(finedetail);

        var loanid = finedetail.loanid;
        $http({
        method: 'post',
        url: 'payFine.php',
        data: $.param({'data': loanid}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            console.log(response.data);
            $rootScope.payfinemessage = response.data;
           
        });
    };

    $scope.getFinesperBorrower = function(){
        $http({
        method: 'post',
        url: 'getFinesperBorrower.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.finedetailsborrower = response.data;
            console.log($scope.finedetailsborrower);
        });
    };

}])

app.controller('checkOutCtrl', ['$scope', '$rootScope', '$http', 'book', 'dialog', function ($scope, $rootScope, $http, book, dialog) {
    
  
  $scope.book = book;
  $rootScope.message = "";
  $rootScope.messageModal = "";
  
  $scope.checkOutBook = function() {
    console.log("book",book);
    console.log("cardid",$scope.cardid)
    var cardid = $scope.cardid;
    var countLoanBooks = 0;
    $scope.countLoanBooks = "";
    $http({
    method: 'post',
    url: 'getCountLoanBooks.php',
    data: $.param({'data': cardid}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(response) {
        $scope.countLoanBooks = response.data;
        countLoanBooks = $scope.countLoanBooks[0].countLoanBooks;
        if (countLoanBooks >= 3){
            $rootScope.messageModal = "Maximum checkout limit of 3 books reached!";

        }
        else{
            $scope.insertBookLoans();
        }
    });
    };
    $scope.close = function(){
        dialog.close(undefined);
    };
    $scope.insertBookLoans = function() {
    
        var data = {
            isbn:$scope.book.isbn,
            cardid:$scope.cardid
            };
        $http({
        method: 'post',
        url: 'insertBookLoans.php',
        data: $.param({'data': data}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            console.log(response.data);
            $rootScope.message = response.data;
        });
        dialog.close(undefined);

        $scope.close = function(){
        dialog.close(undefined);
        };
    };
}])

