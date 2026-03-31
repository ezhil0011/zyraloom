<?php

use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| ADMIN / COMMON
|--------------------------------------------------------------------------
*/

function messageList()
{
    return Message::whereNull('read_at')
        ->orderBy('created_at', 'desc')
        ->get();
}

function getAllCategory()
{
    return (new Category())->getAllParentWithChild();
}

/*
|--------------------------------------------------------------------------
| PRODUCT / POST
|--------------------------------------------------------------------------
*/

function productCategoryList($option = 'all')
{
    if ($option === 'all') {
        return Category::orderBy('id', 'DESC')->get();
    }

    return Category::has('products')->orderBy('id', 'DESC')->get();
}

function postTagList($option = 'all')
{
    if ($option === 'all') {
        return PostTag::orderBy('id', 'DESC')->get();
    }

    return PostTag::has('posts')->orderBy('id', 'DESC')->get();
}

function postCategoryList($option = 'all')
{
    if ($option === 'all') {
        return PostCategory::orderBy('id', 'DESC')->get();
    }

    return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
}

/*
|--------------------------------------------------------------------------
| CART / WISHLIST
|--------------------------------------------------------------------------
*/

function cartCount($user_id = null)
{
    if (!Auth::check()) return 0;

    $user_id = $user_id ?? auth()->id();

    return Cart::where('user_id', $user_id)
        ->whereNull('order_id')
        ->sum('quantity');
}

function totalCartPrice($user_id = null)
{
    if (!Auth::check()) return 0;

    $user_id = $user_id ?? auth()->id();

    return Cart::where('user_id', $user_id)
        ->whereNull('order_id')
        ->sum('amount');
}

function wishlistCount($user_id = null)
{
    if (!Auth::check()) return 0;

    $user_id = $user_id ?? auth()->id();

    return Wishlist::where('user_id', $user_id)
        ->whereNull('cart_id')
        ->sum('quantity');
}

/*
|--------------------------------------------------------------------------
| SHIPPING / UTIL
|--------------------------------------------------------------------------
*/

function shippingList()
{
    return Shipping::orderBy('id', 'DESC')->get();
}

function generateUniqueSlug($title, $modelClass)
{
    $slug = Str::slug($title);

    if ($modelClass::where('slug', $slug)->exists()) {
        $slug .= '-' . now()->format('ymdis') . '-' . rand(100, 999);
    }

    return $slug;
}
