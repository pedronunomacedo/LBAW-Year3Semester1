<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS only -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&display=swap" rel="stylesheet"> 
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
    <link href="/css/profile.css" rel="stylesheet">
    <link href="/css/checkout.css" rel="stylesheet">
    <link href="/css/loginAndregister.css" rel="stylesheet">
    <link href="/css/categoryPage.css" rel="stylesheet">
    <link href="/css/userOrders.css" rel="stylesheet">
    <link href="/css/productPage.css" rel="stylesheet">
    <link href="/css/wishlist.css" rel="stylesheet">
    <link href="/css/order.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>

  </head>
  <body style="background-color: #f6f6f6;">
    <header>
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar" style="z-index: 10">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ url('/') }}"><h1 class="display-6" style="color: white"><strong>Tech<span style="color:red">4</span>You</strong></h1></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse text-bg-dark" id="navbarColor02">
            <form class="navbar-form form-inline w-50 mx-auto my-0" id="search_bar" action="{{ url('mainPageSearch/products') }}" method="GET" role="search"> <!-- increase the search bar size: .col-lg-4 -->
              <div class="form-group position-relative">
                <i class="fa fa-search" style="position: absolute; right:1rem; top: 0.6rem; color: black;"></i>
                <input style="width: 100%;" type="search" name="search" value="" class="form-control form-control-dark text-bg-white" placeholder="Search for products" aria-label="Search">
              </div>
            </form>
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0">
              @if (Auth::check())
                @if (Auth::user()->isAdmin())
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><strong style="color:white">{{Auth::user()->name}}</strong></a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}">Profile</a>
                      <a class="dropdown-item" href="/adminManageUsers">Manage Users</a>
                      <a class="dropdown-item" href="/adminManageProducts">Manage Products</a>
                      <a class="dropdown-item" href="/adminManageOrders">Manage Orders</a>
                      <a class="dropdown-item" href="/adminManageFAQs">Manage FAQs</a>
                      <div><hr class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                  </li>
                @else
                  <li class="nav-item" style="display: block" id="user_wishlist_icon">
                    <a class="nav-link position-relative" href="/wishlist">
                      <i class="far fa-heart fa-2x" style="color: white"></i> <!-- style="color: #54B4D3" -->
                      @if (Auth::user()->wishlist()->count() > 0)
                        <i class="fas fa-circle position-absolute" style="color: orangered; top: 0.2rem; right: 0.2rem;"></i>
                      @endif
                    </a>
                  </li>
                  <li class="nav-item" style="display: block" id="user_shopcart_icon">
                    <a class="nav-link position-relative" href="/shopcart">
                      <i class="fas fa-shopping-cart fa-2x" style="color: white"></i> <!-- style="color: #54B4D3" -->
                      @if (Auth::user()->shopcart()->count() > 0)
                        <i class="fas fa-circle position-absolute" style="color: orangered; top: 0.2rem; right: 0.2rem;"></i>                     
                      @endif
                    </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><strong style="color:white">{{Auth::user()->name}}</strong></a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="{{route('profile', [Auth::id()])}}">Profile</a>
                      <a class="dropdown-item" href="/orders">Orders</a>
                      <a class="dropdown-item" href="/wishlist" style="display: none" id="user_wishlist_dropdown">Wishlist</a>
                      <a class="dropdown-item" href="/orders" style="display: none" id="user_wishlist_shopcart">ShopCart</a>
                      <div><hr class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                    </div>
                  </li>
                @endif
              @else
                <li class="nav-item">
                  <a class="nav-link btn btn-info mx-3" style="color: black; width: 5rem;" href="{{route('login')}}">Login</a>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <section id="content" class="min-vh-100" style="margin-top: 8rem;">
      <div class="alert alert-success show fade align-items-center" id="wishlist-success" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-check-circle"></i><div></div></div>
      <div class="alert alert-warning show fade align-items-center" id="wishlist-error" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-exclamation-circle"></i><div></div></div>
      <div class="alert alert-success show fade align-items-center" id="shopcart-success" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-check-circle"></i><div></div></div>
      <div class="alert alert-warning show fade align-items-center" id="shopcart-error" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-exclamation-circle"></i><div></div></div>
      <div class="alert alert-success show fade align-items-center" id="order-success" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-check-circle"></i><div></div></div>
      <div class="alert alert-warning show fade align-items-center" id="order-error" style="display: none; position: fixed; z-index: 5; left: 50%; transform: translateX(-50%);"><i class="fas fa-exclamation-circle"></i><div></div></div>
      @yield('content')
    </section>
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mx-5">
      <p class="col-md-4 mb-0 text-muted">&copy; 2022 Tech4You</p>
      <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Home</a></li>
        <li class="nav-item"><a href="/faqs" class="nav-link px-2 text-muted">FAQs</a></li>
        <li class="nav-item"><a href="/about" class="nav-link px-2 text-muted">About</a></li>
        <li class="nav-item"><a href="/contactUs" class="nav-link px-2 text-muted">Contacts</a></li>
      </ul>
    </footer>
  </body>
</html>
