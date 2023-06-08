function addEventListeners() {
  let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
  [].forEach.call(itemCheckers, function(checker) {
    checker.addEventListener('change', sendItemUpdateRequest);
  });

  let itemCreators = document.querySelectorAll('article.card form.new_item');
  [].forEach.call(itemCreators, function(creator) {
    creator.addEventListener('submit', sendCreateItemRequest);
  });

  let itemDeleters = document.querySelectorAll('article.card li a.delete');
  [].forEach.call(itemDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteItemRequest);
  });

  let cardDeleters = document.querySelectorAll('article.card header a.delete');
  [].forEach.call(cardDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteCardRequest);
  });

  let cardCreator = document.querySelector('article.card form.new_card');
  if (cardCreator != null)
    cardCreator.addEventListener('submit', sendCreateCardRequest);
}

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

function sendItemUpdateRequest() {
  let item = this.closest('li.item');
  let id = item.getAttribute('data-id');
  let checked = item.querySelector('input[type=checkbox]').checked;

  sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
}

function sendDeleteItemRequest() {
  let id = this.closest('li.item').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
}

function sendCreateItemRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  let description = this.querySelector('input[name=description]').value;

  if (description != '')
    sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);

  event.preventDefault();
}

function sendDeleteCardRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
}

function sendCreateCardRequest(event) {
  let name = this.querySelector('input[name=name]').value;

  if (name != '')
    sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);

  event.preventDefault();
}

function itemUpdatedHandler() {
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  let input = element.querySelector('input[type=checkbox]');
  element.checked = item.done == "true";
}

function itemAddedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);

  // Create the new item
  let new_item = createItem(item);

  // Insert the new item
  let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
  let form = card.querySelector('form.new_item');
  form.previousElementSibling.append(new_item);

  // Reset the new item form
  form.querySelector('[type=text]').value="";
}

function itemDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  element.remove();
}

function cardDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);
  let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
  article.remove();
}

function cardAddedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);

  // Create the new card
  let new_card = createCard(card);

  // Reset the new card input
  let form = document.querySelector('article.card form.new_card');
  form.querySelector('[type=text]').value="";

  // Insert the new card
  let article = form.parentElement;
  let section = article.parentElement;
  section.insertBefore(new_card, article);

  // Focus on adding an item to the new card
  new_card.querySelector('[type=text]').focus();
}

function createCard(card) {
  let new_card = document.createElement('article');
  new_card.classList.add('card');
  new_card.setAttribute('data-id', card.id);
  new_card.innerHTML = `

  <header>
    <h2><a href="cards/${card.id}">${card.name}</a></h2>
    <a href="#" class="delete">&#10761;</a>
  </header>
  <ul></ul>
  <form class="new_item">
    <input name="description" type="text">
  </form>`;

  let creator = new_card.querySelector('form.new_item');
  creator.addEventListener('submit', sendCreateItemRequest);

  let deleter = new_card.querySelector('header a.delete');
  deleter.addEventListener('click', sendDeleteCardRequest);

  return new_card;
}

function createItem(item) {
  let new_item = document.createElement('li');
  new_item.classList.add('item');
  new_item.setAttribute('data-id', item.id);
  new_item.innerHTML = `
  <label>
    <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
  </label>
  `;

  new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
  new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);

  return new_item;
}

addEventListeners();




function addProduct() {

  var newProductName = document.getElementById("prod_name").value;
  var newProductPrice = document.getElementById("prod_price").value;
  var newProdDescription = document.getElementById("prod_descp").value;
  var newProductLaunchdate = document.getElementById("prod_date").value;
  var newProductStock = document.getElementById("prod_stock").value;
  var newProductCategory = document.getElementById("prod_cat").value;

  sendAjaxRequest("POST", "adminManageProducts/addProduct", {new_product_name : newProductName, new_product_price : newProductPrice, new_product_description : newProdDescription, new_product_launchdate : newProductLaunchdate, new_product_stock : newProductStock, new_product_category : newProductCategory}, ()=> {window.location = '/adminManageProducts';});
}

function deleteProduct(id) {
  sendAjaxRequest("POST", "adminManageProducts/delete", {id : id}, ()=> {window.location = '/adminManageProducts';}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}

  //document.querySelector("#productForm" + id).remove();
}

function updateProduct(id) {
  var newName = document.querySelector("#prod_name" + id).value;
  var newPrice = document.querySelector("#prod_price" + id).value;
  var newStock = document.querySelector("#prod_stock" + id).value;
  var newLaunchDate = document.querySelector("#prod_date" + id).value;
  var newCategory = document.querySelector("#prod_cat" + id).value;
  var newDescription = document.querySelector("#prod_descp" + id).value;

  sendAjaxRequest("POST", "adminManageProducts/saveChanges", {product_id : id, product_name : newName, product_price : newPrice, product_description: newDescription, product_launchdate : newLaunchDate, product_stock : newStock, product_category : newCategory}, ()=> {window.location = '/adminManageProducts';}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}
}

function deleteUser(id) {
  sendAjaxRequest("POST", "adminManageUsers/delete", {id : id}, ()=> {window.location = '/adminManageUsers';}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}
  //document.querySelector("#userForm" + id).remove();
}

function updateOrder(id) {
  var newOrderState = document.querySelector("#order_state" + id).value;

  sendAjaxRequest("POST", "adminManageOrders/saveChanges", {id : id, new_order_state : newOrderState}, ()=> {window.location = '/adminManageOrders';});
  
  sendAjaxRequest("GET", "/send-email/" + id, {id : id});
}

function deleteFAQ(id) {
  sendAjaxRequest("POST", "adminManageFAQS/delete", {id : id}, ()=> {window.location = '/adminManageFAQs';}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}
  //document.querySelector("#faqForm" + id).remove();
}

function updateFAQ(id) {
  var newFAQquestion = document.querySelector("#faq_question" + id).value;
  var newFAQanswer = document.querySelector("#faq_answer" + id).value;

  sendAjaxRequest("POST", "adminManageFAQS/saveChanges", {id : id, new_faq_question : newFAQquestion, new_faq_answer : newFAQanswer}, ()=> {window.location = '/adminManageFAQs';});
}

function addFAQ() {
  var newFAQquestion = document.querySelector("#faq_question").value;
  var newFAQanswer = document.querySelector("#faq_answer").value;

  sendAjaxRequest("POST", "adminManageFAQS/addFAQ", {new_faq_question : newFAQquestion, new_faq_answer : newFAQanswer}, ()=> {window.location = '/adminManageFAQs';});
}

function addToWishlist(id) {
  //console.log(id);
  //sendAjaxRequest("POST", "wishlist/addToWishlist", {id : id});

  let product_data = {};
  product_data.id = id;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: '/wishlist/addToWishlist',
    data: product_data,
    dataType: 'text',
    success: function (data) {
        $("#wishlist-error").css('display','none');            
        $("#wishlist-success").css('display','flex');
        $("#wishlist-success div").text(data);
        console.log(data);
        setTimeout(() => {
          $("#wishlist-success").css('display','none');
        }, 1000);
    },
    error: function (data) {
        $("#wishlist-success").css('display','none');            
        $("#wishlist-error").css('display','flex');
        $("#wishlist-error div").text(data.responseText);
        console.log(data.responseText);
        setTimeout(() => {
          $("#wishlist-error").css('display','none');
        }, 1000);
    }
  });

  return false;
}

function removeFromWishlist(id){
  let product_data = {};
  product_data.id = id;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: '/wishlist/removeFromWishlist',
    data: product_data,
    dataType: 'text',
    success: function (data) {
      window.location = '/wishlist';
    }
  });

  return false;
}

function addToShopCart(id) {
  //console.log(id);
  //sendAjaxRequest("POST", "shopcart/addToShopCart", {id : id});

  let product_data = {};
  product_data.id = id;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: '/shopcart/addToShopCart',
    data: product_data,
    dataType: 'text',
    success: function (data) {
        $("#shopcart-error").css('display','none');            
        $("#shopcart-success").css('display','flex');
        $("#shopcart-success div").text(data);
        //console.log(data);
        setTimeout(() => {
          $("#shopcart-success").css('display','none');
        }, 1000);
    },
    error: function (data) {
        $("#shopcart-success").css('display','none');            
        $("#shopcart-error").css('display','flex');
        $("#shopcart-error div").text(data.responseText);
        //console.log(data.responseText);
        setTimeout(() => {
          $("#shopcart-error").css('display','none');
        }, 1000);
    }
  });

  return false;
}

function removeFromShopCart(id) {
  let product_data = {};
  product_data.id = id;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: '/shopcart/removeFromShopCart',
    data: product_data,
    dataType: 'text',
    success: function (data) {
      window.location = '/shopcart';
    }
  });

  return false;
}

function addAllToShopCart(products) {
  for (let i = 0; i < products.length; i++) {
    addToShopCart(products[i].idproduct);
  }
}

function addToOrders() {
  //console.log(products);
  let id;
  let x = document.getElementsByClassName('form-check-input');
  for (let i = 0; i < x.length; i++) {
    if (x[i].checked) id = x[i].value;
  }
  
  let product_data = {};
  product_data.id = id;
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    type: "POST",
    url: '/orders/addToOrders',
    data: product_data,
    dataType: 'text',
    success: function (data) {
        window.location = '/';
        $("#order-error").css('display','none');            
        $("#order-success").css('display','flex');
        $("#order-success div").text(data);
        //console.log(data);
        setTimeout(() => {
          $("#order-success").css('display','none');
        }, 1000);
    },
    error: function (data) {
        window.location = '/checkout';
        $("#order-success").css('display','none');            
        $("#order-error").css('display','flex');
        $("#order-error div").text(data.responseText);
        //console.log(data.responseText);
        setTimeout(() => {
          $("#order-error").css('display','none');
        }, 1000);
    }
  });
  return false;
}

function tabAddress() {
  document.getElementById('billingAddress').classList.add('active'); 
  document.getElementById('billingAddress').classList.remove('completed');
  document.getElementById('paymentMethod').classList.remove('active'); 
  document.getElementById('paymentMethod').classList.remove('completed');
  document.getElementById('confirmCheckout').classList.remove('active'); 
  document.getElementById('confirmCheckout').classList.remove('completed');
}

function tabPayment() {
  document.getElementById('paymentMethod').classList.add('active'); 
  document.getElementById('paymentMethod').classList.remove('completed');
  document.getElementById('billingAddress').classList.remove('active'); 
  document.getElementById('billingAddress').classList.add('completed');
  document.getElementById('confirmCheckout').classList.remove('active'); 
  document.getElementById('confirmCheckout').classList.remove('completed');
}

function tabConfirm() {
  document.getElementById('confirmCheckout').classList.add('active'); 
  document.getElementById('confirmCheckout').classList.remove('completed');
  document.getElementById('billingAddress').classList.remove('active'); 
  document.getElementById('billingAddress').classList.add('completed');
  document.getElementById('paymentMethod').classList.remove('active'); 
  document.getElementById('paymentMethod').classList.add('completed');
}

function tabAll() {
  document.getElementById('confirmCheckout').classList.add('active'); 
  document.getElementById('confirmCheckout').classList.add('completed');
  document.getElementById('billingAddress').classList.remove('active'); 
  document.getElementById('billingAddress').classList.add('completed');
  document.getElementById('paymentMethod').classList.remove('active'); 
  document.getElementById('paymentMethod').classList.add('completed');
}

function addReview(productID) {

  var newReviewContent = document.getElementById("new_review_content").value;
  var newReviewRating = document.getElementById("new_review_rating").value;

  sendAjaxRequest("POST", "/review/addReview", {product_id: productID, new_review_content : newReviewContent, new_rating : newReviewRating}, ()=> {window.location = '/product/' + productID;});
}


function increment(obj, quantity_available, product) {
  let new_quantity = parseInt(document.getElementById("form" + product.id).value) + 1;

  if(new_quantity > quantity_available) return;

  update_quantity(product, new_quantity, "increment");
}

function decrement(obj, quantity_available, product) {
  let new_quantity = $(obj).parent().next().children(':first').val();

  if(new_quantity < 1) return; 


  update_quantity(product, new_quantity, "decrement");
}

function update_quantity(productObj, quantity, typeModification) {

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  let new_product_data = {};
  new_product_data.id = productObj.id;
  new_product_data.quantity = quantity;
  new_product_data.idusers = productObj.idusers;
  new_product_data.typeModification = typeModification;

  $.ajax({
    type: "PUT",
    url: "shopcart",
    data: new_product_data,
    dataType: 'text',
    success: function (data) {
        let final = JSON.parse(data);
        let total_price_span = document.getElementById("shop_cart_total_price");
        let value1 = parseFloat(final.Price).toFixed(2);


        total_price_span.innerHTML = value1 + " €";
        let total_products_span = document.getElementById("total_products");
        total_products_span.innerHTML = final.totalProducts;


        let product_shopcart_quantity_span = document.getElementById("product_shopcart_quantity" + final.productID);
        product_shopcart_quantity_span.innerHTML = final.productQuantity;
    },
    error: function (data) {
        alert("Error: updating product!");
    }
  });

  return false;
}

function saveReview(idUser, idProduct) {
  let reviewContent = document.getElementById("review_content" + idUser + "_" + idProduct); // {{ $review->idusers }}_{{ $review->idproduct }}
  let newReviewContent = reviewContent.childNodes[1].value;

  if (newReviewContent == "") return;

  header_buttons = document.getElementById("review_buttons" + idUser + "_" + idProduct); // {{ $review->idusers }}_{{ $review->idproduct }}
  header_buttons.innerHTML = `
    <button onclick="editReview(` + idUser + `, ` + idProduct + `)" style="all: unset; margin-right: 8px; cursor: pointer;"><i class='fas fa-edit' style='font-size: 24px'></i></button>
    <button onclick="deleteReview(` + idUser + `, ` + idProduct + `)" style="all: unset; cursor: pointer;"><i class="fa fa-trash" aria-hidden="true" style='font-size: 24px'></i></button>
  `;

  reviewContent.innerHTML = "";

  reviewContent.innerHTML = newReviewContent;

  sendAjaxRequest("POST", "/review/updateReview", { userID: idUser , productID: idProduct, newContent: newReviewContent});
}


function deleteReview(idUser, idProduct) {
  let reviewDiv = document.getElementById("review" + idUser + "_" + idProduct); // {{ $review->idusers }}_{{ $review->idproduct }}
  reviewDiv.parentNode.removeChild(reviewDiv);

  sendAjaxRequest("POST", "/review/deleteReview", { userID: idUser, productID: idProduct });
}

function editReview(idUser, idProduct) {
  let reviewContent = document.getElementById("review_content"+ idUser + "_" + idProduct); // {{ $review->idusers }}_{{ $review->idproduct }}

  let content = reviewContent.innerHTML;

  header_buttons = document.getElementById("review_buttons" + idUser + "_" + idProduct); // {{ $review->idusers }}_{{ $review->idproduct }}
  header_buttons.innerHTML = `
    <button onclick="saveReview(` + idUser + `, ` + idProduct + `)" style="all: unset; margin-right: 8px; cursor: pointer;">
      <span>&#10003;</span>
    </button>
  `;

  console.log(content);

  reviewContent.innerHTML = `
    <input type="text" value="` + content + `"></input>
  `;
}

function removeAddress(addressID, userID) {
  sendAjaxRequest("POST", "/address/deleteAddress", { addressID: addressID }, ()=> {window.location = '/profile/' + userID;});
}

function deleteAccount() {
  sendAjaxRequest("POST", "/profile/deleteAccount", {}, ()=> {window.location = '/';});
}

function addAddress(idUser) {
  var newAddressCountry = document.getElementById("address_country").value;
  var newAddressCity = document.getElementById("address_city").value;
  var newAddressStreet = document.getElementById("address_street").value;
  var newPostalCode = document.getElementById("address_postalCode").value;

  sendAjaxRequest("POST", "/address/addAddress", { new_address_country : newAddressCountry, new_address_city : newAddressCity, new_address_street : newAddressStreet, new_address_postacode : newPostalCode }, ()=> {window.location = '/profile/' + idUser;});
}

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-10rem";
  }
  prevScrollpos = currentScrollPos;
} 