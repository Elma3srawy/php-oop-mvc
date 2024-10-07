<?php 



use Illuminate\Http\Routing\Route;
use App\Http\Controllers\UserController;


Route::get('/admin/user/{id}' , [UserController::class , 'index']);


Route::get('admin' , function(){
  
});
echo '<pre>';
Route::get('/user' , function(){
});