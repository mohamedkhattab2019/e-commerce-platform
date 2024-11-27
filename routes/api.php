<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stripe\PaymentIntent;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/categories', [CategoryController::class, 'index']);               // Get all categories
Route::get('/categories/products', [CategoryController::class, 'showWithProducts']); // Get products by category
Route::post('/categories', [CategoryController::class, 'store']);             // Create a category

Route::get('/categories/{id}/products', [ProductController::class, 'getByCategory']); // Get products by category
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']); 
Route::post('/products/{id}', [ProductController::class, 'update']);
Route::get('/products/{id}', [ProductController::class, 'getProductById']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::middleware('guestOrAuth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity']);
    Route::delete('/cart/{productId}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clearCart']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
Route::get('/orders/{orderId}/invoice', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');

Route::post('/create-payment-intent', function (Request $request) {

    Stripe::setApiKey(env('STRIPE_SECRET'));

    $amount = $request->input('amount'); // Amount in cents
    $currency = 'usd'; // Example currency

    try {
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_method_types' => ['card'],
        ]);

        return response()->json(['client_secret' => $paymentIntent->client_secret,'data'=>$paymentIntent]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
});