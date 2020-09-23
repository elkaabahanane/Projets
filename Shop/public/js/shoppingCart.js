function refreshCart() {
  let cartItems = localStorage.getItem("items");
  if (cartItems !== null) {
    let products = JSON.parse(cartItems);
    cartItems = products.length;

    for (product of products) {
      $("#product-" + product.id)
        .find(".bottom-area")
        .addClass("inCart")
        .find(".product-action")
        .html(
          '<a href="#" class="d-flex justify-content-center align-items-center mx-1"><span><i class="ion-md-checkmark"></i></span>'
        );
    }
  } else {
    cartItems = 0;
  }

  $("#cart-items").text(cartItems);
}

refreshCart();

$(".addToCart").on("click", function (e) {
  e.preventDefault();

  if (typeof Storage !== "undefined") {
    let product = $(this).parents(".product");
    let productId = product.find(".product-id").text();
    let productTitle = product.find(".product-title").text();
    let productQuantity = product.find(".product-quantity").val();
    let productImage = product.find(".product-image").attr("src");
    let productPrice = product.find(".price").text().replace("$", "").trim();

    let item = {
      id: productId,
      image: productImage,
      name: productTitle,
      price: productPrice,
      quantity: productQuantity,
    };

    let cartItems = localStorage.getItem("items");
    if (cartItems !== null) {
      cartItems = JSON.parse(cartItems);
    } else {
      cartItems = [];
    }

    cartItems.push(item);

    localStorage.setItem("items", JSON.stringify(cartItems));

    refreshCart();

    $(this)
      .parent()
      .html(
        '<a href="#" class="d-flex justify-content-center align-items-center mx-1"><span><i class="ion-md-checkmark"></i></span>'
      );
  } else {
    console.log("storage is not working on your browser");
  }
});
