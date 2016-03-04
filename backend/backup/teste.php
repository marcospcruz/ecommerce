<?php 

session_start();
foreach ($_SESSION as $key => $value) {
    print(serialize($value).'<br>');
};

?>


<div ng-app="">
 	<p>Name : <input type="text" ng-model="name"></p>
 	<h1>Hello {{name}}</h1>
</div>
