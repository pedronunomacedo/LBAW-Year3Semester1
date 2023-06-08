@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<script>
    function encodeForAjax(data) {
        if (data == null) return null;
        return Object.keys(data).map(function(k){
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        }).join('&');
    }

    function sendAjaxRequest(method, url, data, handler) {
        let request = new XMLHttpRequest();

        request.open(method, url, true);
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.addEventListener('load', handler);
        request.send(encodeForAjax(data));
    }

    var deletedProducts = 0; // global variable  
    function deleteProduct(id, numProducts) {
        deletedProducts++;
        sendAjaxRequest("POST", "adminManageProducts/delete", {id : id}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}
        document.querySelector("#productForm" + id).remove();
        document.querySelector("#paragraph_num_products_found").innerHTML = "(" + (numProducts - deletedProducts).toString() + " product(s) found)";
    }
</script>

<script>
    function getProductsFilteredByDate(checkbox) {
        var productsFilteredList = document.getElementsByClassName('product_card');

        var productsListElem = document.getElementById('productsFilteredList');
        
        var yearCheckboxes = document.getElementsByClassName('year_check_box'); // Get all the year yearCheckboxes
        var priceCheckboxes = document.getElementsByClassName('price_check_box'); // Get all the year priceCheckboxes
        var categoryCheckboxes = document.getElementsByClassName('category_check_box'); // Get all the year categoryCheckboxes

        var allYearCheckboxesUnchecked = true;
        for (var i = 0; i < yearCheckboxes.length; i++) {
            if (yearCheckboxes[i].checked) {
                allYearCheckboxesUnchecked = false;
            }
        }

        var allPriceCheckBoxesUnchecked = true;
        for (var i = 0; i < priceCheckboxes.length; i++) {
            if (priceCheckboxes[i].checked) {
                allPriceCheckBoxesUnchecked = false;
            }
        }

        var allCategoryCheckBoxesUnchecked = true;
        for (var i = 0; i < categoryCheckboxes.length; i++) {
            if (categoryCheckboxes[i].checked) {
                allCategoryCheckBoxesUnchecked = false;
            }
        }

        if (allYearCheckboxesUnchecked && allPriceCheckBoxesUnchecked && allCategoryCheckBoxesUnchecked) {
            for (var i = 0; i < productsFilteredList.length; i++) {
                productsFilteredList[i].style.display = 'block';
            }
        }
        else if (!allYearCheckboxesUnchecked && allPriceCheckBoxesUnchecked) {
            for (var i = 0; i < productsFilteredList.length; i++) {
                var allIDs = (productsFilteredList[i].id).split(/\s+/);
                var productID = allIDs[1];
                var productDate = allIDs[2];
                var productPrice = allIDs[3];
                var productCategory = allIDs[4];
                var productDateSplited = productDate.split('-');
                var productYear = parseInt(productDateSplited[0]);

                for (var j = 0; j < yearCheckboxes.length; j++) {
                    var checkBoxYear = parseInt(yearCheckboxes[j].getAttribute('value'));

                    if (checkBoxYear == productYear && yearCheckboxes[j].checked) {
                        productsFilteredList[i].style.display = 'block';
                        break;
                    }
                    else if (checkBoxYear == productYear && !yearCheckboxes[j].checked) {
                        productsFilteredList[i].style.display = 'none';
                        break;
                    }
                }
            }
        }
        else if (allYearCheckboxesUnchecked && !allPriceCheckBoxesUnchecked) {
            for (var i = 0; i < productsFilteredList.length; i++) {
                var allIDs = (productsFilteredList[i].id).split(/\s+/);
                var productID = allIDs[1];
                var productDate = allIDs[2];
                var productPrice = parseFloat(allIDs[3]);
                var productDateSplited = productDate.split('-');
                var productYear = parseInt(productDateSplited[0]);

                var productMeetsPriceChecked = false;
                for (var j = 0; j < 6; j++) {
                    var checkboxPriceRange = (priceCheckboxes[j].value);
                    var checkBoxPriceRange = (priceCheckboxes[j].value).split("_");
                    var minRangePrice = parseFloat(checkBoxPriceRange[0]);
                    var maxRangePrice = parseFloat(checkBoxPriceRange[1]);

                    if (isNaN(maxRangePrice)) {
                        if (minRangePrice <= productPrice && priceCheckboxes[j].checked) {
                            productMeetsPriceChecked = true;
                            break;
                        }
                    }

                    if (minRangePrice <= productPrice && productPrice <= maxRangePrice && priceCheckboxes[j].checked) {
                        productMeetsPriceChecked = true;
                        break;
                    }
                }

                if (productMeetsPriceChecked) {
                    productsFilteredList[i].style.display = 'block';
                }
                else {
                    productsFilteredList[i].style.display = 'none';
                }
            }
        }
        else { // (!allYearCheckboxesUnchecked && !allPriceCheckBoxesUnchecked)
            for (var i = 0; i < productsFilteredList.length; i++) {
                var allIDs = (productsFilteredList[i].id).split(/\s+/);
                var productID = allIDs[1];
                var productDate = allIDs[2];
                var productPrice = parseFloat(allIDs[3]);
                var productDateSplited = productDate.split('-');
                var productYear = parseInt(productDateSplited[0]);

                var productMeetsPriceChecked = false;
                for (var j = 0; j < 6; j++) {
                    var checkboxPriceRange = (priceCheckboxes[j].value);
                    var checkBoxPriceRange = (priceCheckboxes[j].value).split("_");
                    var minRangePrice = parseFloat(checkBoxPriceRange[0]);
                    var maxRangePrice = parseFloat(checkBoxPriceRange[1]);

                    if (isNaN(maxRangePrice)) {
                        if (minRangePrice <= productPrice && priceCheckboxes[j].checked) {
                            productMeetsPriceChecked = true;
                            break;
                        }
                    }
                    
                    if (minRangePrice <= productPrice && productPrice <= maxRangePrice && priceCheckboxes[j].checked) {
                        productMeetsPriceChecked = true;
                        break;
                    }
                }

                var productMeetsYearChecked = false;
                for (var j = 0; j < yearCheckboxes.length; j++) {
                    var checkBoxYear = parseInt(yearCheckboxes[j].getAttribute('value'));

                    if (checkBoxYear == productYear && yearCheckboxes[j].checked) {
                        productMeetsYearChecked = true;
                        break;
                    }
                    else if (checkBoxYear == productYear && !yearCheckboxes[j].checked) {
                        productMeetsYearChecked = false;
                        break;
                    }
                }

                if (productMeetsPriceChecked && productMeetsYearChecked) {
                    productsFilteredList[i].style.display = 'block';
                }
                else {
                    productsFilteredList[i].style.display = 'none';
                }
            }
        }




        var optionSelected = document.getElementById('option_selected').value;

        var allElementsNotListed = [];
        for (var i = 0; i < productsListElem.children.length; i++) {
            if (productsListElem.children[i].style.display == "none") {
                allElementsNotListed.push(productsListElem.children[i]);
            }
        }

        var allElementsListed = [];
        for (var i = 0; i < productsListElem.children.length; i++) {
            if (productsListElem.children[i].style.display == "block") {
                allElementsListed.push(productsListElem.children[i]);
            }
        }

        if (optionSelected == "1") { // Order by product name
            if (allYearCheckboxesUnchecked && allPriceCheckBoxesUnchecked) {
                allElementsListed.sort(function(prod1, prod2) {
                    if (prod1.children[1].children[0].childNodes[0].nodeValue < prod2.children[1].children[0].childNodes[0].nodeValue) {
                        return -1;
                    }
                    else if (prod1.children[1].children[0].childNodes[0].nodeValue > prod2.children[1].children[0].childNodes[0].nodeValue) {
                        return 1;
                    }
                    else {
                        return 0;
                    }
                });
            }
            else {
                allElementsListed.sort(function(prod1, prod2) {
                    if (prod1.children[1].children[0].childNodes[0].nodeValue < prod2.children[1].children[0].childNodes[0].nodeValue) {
                        return -1;
                    }
                    else if (prod1.children[1].children[0].childNodes[0].nodeValue > prod2.children[1].children[0].childNodes[0].nodeValue) {
                        return 1;
                    }
                    else {
                        return 0;
                    }
                });
            }
        }
        else if (optionSelected == "2") { // order by ascendent price
            allElementsListed.sort(function(prod1, prod2) {
                var allIDs1 = (prod1.id).split(/\s+/);
                var productPrice1 = parseFloat(allIDs1[3]);
                var allIDs2 = (prod2.id).split(/\s+/);
                var productPrice2 = parseFloat(allIDs2[3]);

                if (productPrice1 < productPrice2) {
                    return -1;
                }
                else if (productPrice1 > productPrice2) {
                    return 1;
                }
                else {
                    return 0;
                }
            });
            
        }
        else if (optionSelected == "3") { // order by descendent price
            allElementsListed.sort(function(prod1, prod2) {
                var allIDs1 = (prod1.id).split(/\s+/);
                var productPrice1 = parseFloat(allIDs1[3]);
                var allIDs2 = (prod2.id).split(/\s+/);
                var productPrice2 = parseFloat(allIDs2[3]);

                if (productPrice1 < productPrice2) {
                    return 1;
                }
                else if (productPrice1 > productPrice2) {
                    return -1;
                }
                else {
                    return 0;
                }
            });
        }
        else if (optionSelected == "4") { // order by rating
            allElementsListed.sort(function(prod1, prod2) {
                var allIDs1 = (prod1.id).split(/\s+/);
                var productRating1 = parseFloat(allIDs1[4]);
                var allIDs2 = (prod2.id).split(/\s+/);
                var productRating2 = parseFloat(allIDs2[4]);

                if (productRating1 < productRating2) {
                    return 1;
                }
                else if (productRating1 > productRating2) {
                    return -1;
                }
                else {
                    return 0;
                }
            });
        }

        var elementsListDiv = document.getElementById("productsFilteredList");

        elementsListDiv.innerHTML = "";

        for (var i = 0; i < allElementsListed.length; i++) {
            elementsListDiv.appendChild(allElementsListed[i]);
        }
        for (var i = 0; i < allElementsNotListed.length; i++) {
            elementsListDiv.appendChild(allElementsNotListed[i]);
        }

    }
</script>

<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Search</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Search Result: <span style="font-style: italic">{{ $searchStr }}</span></h2></div>
        @if($searchProducts->total() == 0)
            <h3>Sorry, we could not find any product with name <i>{{ $searchStr }}</i></h3>
        @else
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-3" style="margin-bottom: 20px">
                <div class="filter_sidebar">
                    <h4 class="mb-4"><strong>Filters</strong></h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item align-items-center border-0 p-0 mb-2">
                            <h5><strong>Release Year</strong></h5>
                            <hr class="mb-3"/>
                            <div class="form-check">
                                <input class="form-check-input year_check_box" type="checkbox" value="2022" id="2022Check" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="2022Check">
                                    2022
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input year_check_box" type="checkbox" value="2021" id="2021Check" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="2021Check">
                                    2021
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input year_check_box" type="checkbox" value="2020" id="2020Check" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="2020Check">
                                    2020
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input year_check_box" type="checkbox" value="2019" id="lt2020Check" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="lt2020Check">
                                    &lt;2020
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item align-items-center border-0 p-0 mb-2">
                            <h5><strong>Price range</strong></h5>
                            <hr class="mb-3"/>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="0_200" value="0_199.99" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="0_200">
                                    €0 - €200
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="200_400" value="200_399.99" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="200_400">
                                    €200 - €400
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="400_600" value="400_599.99" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="400_600">
                                    €400 - €600
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="600_800" value="600_799.99" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="600_800">
                                    €600 - €800
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="800_1000" value="800_1000" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="800_1000">
                                    €800 - €1000
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price_check_box" type="checkbox" id="gt1000" value="1001" onClick="getProductsFilteredByDate(this)">
                                <label class="form-check-label" for="gt1000">
                                    > €1000
                                </label>
                            </div>
                        </li>
                        <!-- <li class="list-group-item align-items-center border-0 p-0 mb-2">
                            <h5><strong>Price</strong></h5>
                            <hr class="mb-3"/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="slider-range"></div>
                                </div>
                            </div>
                            <div class="row slider-labels">
                                <div class="col-xs-6 caption">
                                    <strong>Min:</strong> <span id="slider-range-value1"></span>
                                </div>
                                <div class="col-xs-6 text-right caption">
                                    <strong>Max:</strong> <span id="slider-range-value2"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form>
                                        <input type="hidden" id="min_price_range" name="min-value" value="">
                                        <input type="hidden" id="max_price_range" name="max-value" value="">
                                    </form>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="filter_orderby_bar mb-3 d-flex align-items-center justify-content-end py-2">
                    <span>Order By: </span>
                    <select class="form-select" id="option_selected" onchange="getProductsFilteredByDate()">
                        <option value="1" selected>Name</option>
                        <option value="2">ASC Price</option>
                        <option value="3">DESC Price</option>
                        <option value="4">Rating</option>
                    </select>
                </div>
                <div class="d-flex flex-wrap" id="productsFilteredList" style="gap: 2rem">
                    <!-- Single item -->
                    @each('partials.product_card', $searchProducts, 'product')
                    <!-- Single item -->
                </div>
                <div class="text-center">
                    {!! $searchProducts->appends(request()->input())->links(); !!}
                </div>
            </div>
        </div>
        @endif
    </div>
</main>


@endsection
