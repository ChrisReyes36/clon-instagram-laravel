<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     $images = Image::all();

//     foreach ($images as $image) {
//         echo $image->image_path . '<br>';
//         echo $image->description . '<br>';
//         echo $image->user->name . ' ' . $image->user->surname . '<br>';

//         echo '<strong>Likes:</strong> ' . count($image->likes) . '<br>';

//         if (count($image->comments) > 0) {
//             echo "<strong>Comments:</strong><br>";
//             foreach ($image->comments as $comment) {
//                 echo $comment->user->name . ' ' . $comment->user->surname . ': ';
//                 echo $comment->content . '<br>';
//             }
//         }

//         echo "<hr>";
//     }

//     die();

//     return view('welcome');
// });

Auth::routes();

// GENERALES
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/image/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('image.detail');

// USUARIOS
Route::get('/config', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
Route::get('/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::get('/users/{search?}', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

// IMAGENES
Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.file');
Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/edit/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');

// COMENTARIOS
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');

// LIKES
Route::get('/like/{image_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');
Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');
