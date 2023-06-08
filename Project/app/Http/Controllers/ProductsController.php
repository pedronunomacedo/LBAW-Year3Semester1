<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ProductImages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ProductsController extends Controller {
  public function showHighlights() {

    $newProducts = Product::orderBy('launchdate', 'desc')->take(5)
                                                      ->leftJoin(DB::raw('(select distinct on (idproduct) * from productimages order by idproduct asc) as img'), function ($join) {
                                                        $join->on('product.id', '=', 'img.idproduct');
                                                    })->get();
    $bestSmartphones = Product::where('categoryname', 'Smartphones')->orderBy('score', 'desc')->take(5)
                                                      ->leftJoin(DB::raw('(select distinct on (idproduct) * from productimages order by idproduct asc) as img'), function ($join) {
                                                        $join->on('product.id', '=', 'img.idproduct');
                                                    })->get();
    $bestLaptops = Product::where('categoryname', 'Laptops')->orderBy('score', 'desc')->take(5)
                                                      ->leftJoin(DB::raw('(select distinct on (idproduct) * from productimages order by idproduct asc) as img'), function ($join) {
                                                        $join->on('product.id', '=', 'img.idproduct');
                                                    })->get();

    return view('pages.home', ['newProducts' => $newProducts, 'bestSmartphones' => $bestSmartphones, 'bestLaptops' => $bestLaptops]);
  }
  
  public function showAllProducts() {
    $this->authorize('admin', Auth::user());
    $allProducts = Product::orderBy('id', 'ASC')
                          ->leftJoin(DB::raw('(select distinct on (idproduct) * from productimages order by idproduct asc) as img'), function ($join) {
                            $join->on('product.id', '=', 'img.idproduct');
                        })->paginate(20);
    $allCategories = ["Smartphones", "Components", "TVs", "Laptops", "Desktops", "Other"];

    return view('pages.adminManageProducts', ['allProducts' => $allProducts, 'allCategories' => $allCategories]);
  }

  public function destroy(Request $request) { 
    $this->authorize('admin', Auth::user());

    Product::where('id', $request->id)->delete();
    return response(200);
  }

  public function updateProduct(Request $request) {
    $this->authorize('admin', Auth::user());
    $product = Product::findOrFail($request->product_id);
    $product->prodname = $request->product_name;
    $product->price = $request->product_price;
    $product->proddescription = $request->product_description;
    $product->launchdate = $request->product_launchdate;
    $product->stock = $request->product_stock;
    $product->categoryname = $request->product_category;
    $product->save();
    return response(200);
  }

  public static function showProduct($id) {
    $product = Product::findOrFail($id);
    $productImages = ProductsController::getProductImages($id);
    $productReviews = Review::where('review.idproduct', $id)
                      ->join('users', 'review.idusers', 'users.id')
                      ->get();
    
    return view('pages.product', ['product' => $product, 'productImages' => $productImages, 'productReviews' => $productReviews]);
  }

  public static function getProductImages($id) {
    $productImages = ProductImages::where('idproduct', $id)->get('imgpath');

    return $productImages;
  }

  public function searchProducts(Request $search_request) {
    $searchProducts = Product::where('prodname','LIKE','%' . $search_request->search . '%')->orderBy('prodname')->paginate(20);

    return view('pages.searchProducts', ['searchProducts' => $searchProducts, 'searchStr' => $search_request->search] );
  }

  public function searchMainPageProducts(Request $search_request) {
    $searchProducts = Product::where('prodname','LIKE','%' . $search_request->search . '%')
                      ->join('productimages', 'product.id', 'productimages.idproduct')
                      ->distinct('productimages.idproduct')
                      ->paginate(20);

    return view('pages.searchMainPageProducts', ['searchProducts' => $searchProducts, 'searchStr' => $search_request->search] );
  }

  public function addProduct(Request $request) {
    $this->authorize('admin', Auth::user());
    
    $product = New Product;
    $product->prodname = $request->new_product_name;
    $product->price = $request->new_product_price;
    $product->proddescription = $request->new_product_description;
    $product->launchdate = $request->new_product_launchdate;
    $product->stock = $request->new_product_stock;
    $product->categoryname = $request->new_product_category;

    $product->save();

    return response(200);
  }

  public function showCategoryProducts($category) {
    $categoryProducts = Product::where('categoryname', $category)->leftJoin(DB::raw('(select distinct on (idproduct) * from productimages order by idproduct asc) as img'), function ($join) {
                                                            $join->on('product.id', '=', 'img.idproduct');
                                                        })
                                                        ->orderBy('prodname', 'asc')
                                                        ->paginate(20);

    return view('pages.category', ['categoryProducts' => $categoryProducts, 'category' => $category]);
  }
}