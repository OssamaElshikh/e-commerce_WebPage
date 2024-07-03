<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-commerce website</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
      .card-deck {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
      }
      .card {
        flex: 1 1 18rem;
        margin: 15px;
        min-width: 18rem;
      }
      .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }
      .nav-link.category-link.active {
        color: green;
      }
      .modal-fullscreen {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .modal-content {
        width: 90%;
        max-width: 1200px;
      }
      .modal-body {
        display: flex;
      }
      .modal-body img {
        width: 50%;
        height: auto;
        object-fit: cover;
      }
      .modal-body .details {
        flex: 1;
        padding-left: 20px;
      }
      .details h5, .details p, .details .sizes {
        margin-bottom: 20px;
      }
      .sizes .btn {
        margin-right: 10px;
        margin-bottom: 10px;
      }
      .sizes .btn.active {
        background-color: green;
        color: white;
      }
      .cart-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
      }
      .cart-item img {
        width: 100px;
        height: auto;
        object-fit: cover;
        margin-right: 15px;
      }
      .cart-item-info {
        flex: 1;
      }
      .cart-item-controls {
        display: flex;
        align-items: center;
      }
      .cart-item-controls button {
        margin: 0 5px;
      }
      .place-order-btn {
        width: 100%;
        background-color: green;
        color: white;
      }
      .order-success {
        color: green;
        font-weight: bold;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/connect.php'; ?>

    <!-- The nav bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link category-link active" data-testid="category-link" href="#" data-category="All">All</a>
            </li>
            <li class="nav-item">
              <a class="nav-link category-link" data-testid="category-link" href="#" data-category="Men">Men</a>
            </li>
            <li class="nav-item">
              <a class="nav-link category-link" data-testid="category-link" href="#" data-category="Women">Women</a>
            </li>
            <li class="nav-item">
              <a class="nav-link category-link" data-testid="category-link" href="#" data-category="Kids">Kids</a>
            </li>
          </ul>

          <div class="nav-item">
            <a class="nav-link" data-testid="cart-btn" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">
              <i class="fa-solid fa-cart-shopping"></i>
              <span class="cart-item-count">0</span>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Products -->
    <div class="container mt-4">
      <div class="row" id="products">
        <?php
        $query = "SELECT id, name, price, image, category FROM items";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4 product" data-category="'.htmlspecialchars($row['category']).'">';
                echo '<div class="card h-100">';
                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" class="card-img-top" alt="'.htmlspecialchars($row['name']).'">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.htmlspecialchars($row['name']).'</h5>';
                echo '<p class="card-text">$'.htmlspecialchars($row['price']).'</p>';
                echo '<button class="btn btn-success view-details" data-id="'.htmlspecialchars($row['id']).'"><i class="fa fa-shopping-cart"></i></button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }

        mysqli_close($con);
        ?>
      </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img src="" alt="" id="modalProductImage">
            <div class="details">
              <h5 id="modalProductName"></h5>
              <p id="modalProductPrice"></p>
              <div class="sizes">
                <button class="btn btn-outline-secondary size-option" data-size="S">S</button>
                <button class="btn btn-outline-secondary size-option" data-size="M">M</button>
                <button class="btn btn-outline-secondary size-option" data-size="L">L</button>
                <button class="btn btn-outline-secondary size-option" data-size="XL">XL</button>
              </div>
              <button class="btn btn-success mt-3 add-to-cart">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">My Bag</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="cartItems"></div>
            <div class="total-price mt-3">
              <h5>Total: $<span id="cartTotal">0.00</span></h5>
            </div>
            <div class="order-success" id="orderSuccessMessage" style="display: none;">
              Order placed successfully!
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn place-order-btn">Place Order</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const categoryLinks = document.querySelectorAll('.category-link');
        const products = document.querySelectorAll('.product');
        const viewDetailsButtons = document.querySelectorAll('.view-details');
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        let selectedSize = null;
        const cart = [];

        categoryLinks.forEach(link => {
          link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.getAttribute('data-category');

            // Remove active class from all links
            categoryLinks.forEach(link => link.classList.remove('active'));

            // Add active class to the clicked link
            this.classList.add('active');

            products.forEach(product => {
              if (category === 'All' || product.getAttribute('data-category') === category) {
                product.style.display = 'block';
              } else {
                product.style.display = 'none';
              }
            });
          });
        });

        viewDetailsButtons.forEach(button => {
          button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            // Fetch product details from the database
            fetch(`get_product.php?id=${productId}`)
              .then(response => response.json())
              .then(data => {
                document.getElementById('modalProductImage').src = `data:image/jpeg;base64,${data.image}`;
                document.getElementById('modalProductName').textContent = data.name;
                document.getElementById('modalProductPrice').textContent = `$${data.price}`;
                document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('active'));
                selectedSize = null;
                productModal.show();
              });
          });
        });

        document.querySelectorAll('.size-option').forEach(button => {
          button.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            selectedSize = this.getAttribute('data-size');
          });
        });

        document.querySelector('.add-to-cart').addEventListener('click', function() {
          if (selectedSize) {
            const productName = document.getElementById('modalProductName').textContent;
            const productPrice = document.getElementById('modalProductPrice').textContent;
            const productImage = document.getElementById('modalProductImage').src;
            
            const existingItem = cart.find(item => item.name === productName && item.size === selectedSize);
            if (existingItem) {
              existingItem.quantity++;
            } else {
              cart.push({ name: productName, price: productPrice, size: selectedSize, image: productImage, quantity: 1 });
            }

            updateCartCount();
            productModal.hide();
          } else {
            alert('Please select a size.');
          }
        });

        document.querySelector('[data-testid="cart-btn"]').addEventListener('click', function() {
          displayCartItems();
        });

        document.querySelector('.place-order-btn').addEventListener('click', function() {
          document.getElementById('orderSuccessMessage').style.display = 'block';
          setTimeout(() => {
            document.getElementById('orderSuccessMessage').style.display = 'none';
          }, 3000);
          cart.length = 0;
          updateCartCount();
          displayCartItems();
          updateCartTotal();
        });

        function updateCartCount() {
          const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
          document.querySelector('.cart-item-count').textContent = cartCount;
        }

        function displayCartItems() {
          const cartItemsContainer = document.getElementById('cartItems');
          cartItemsContainer.innerHTML = '';

          if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
          } else {
            cart.forEach(item => {
              const itemDiv = document.createElement('div');
              itemDiv.classList.add('cart-item');
              itemDiv.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-item-info">
                  <p>${item.name}</p>
                  <p>${item.price}</p>
                  <p>Size: ${item.size}</p>
                </div>
                <div class="cart-item-controls">
                  <button class="btn btn-outline-secondary decrease-quantity" data-name="${item.name}" data-size="${item.size}">-</button>
                  <span>${item.quantity}</span>
                  <button class="btn btn-outline-secondary increase-quantity" data-name="${item.name}" data-size="${item.size}">+</button>
                </div>
              `;
              cartItemsContainer.appendChild(itemDiv);
            });
            updateCartTotal();
          }
        }

        function updateCartTotal() {
          const total = cart.reduce((sum, item) => sum + parseFloat(item.price.slice(1)) * item.quantity, 0);
          document.getElementById('cartTotal').textContent = total.toFixed(2);
        }

        document.getElementById('cartItems').addEventListener('click', function(event) {
          if (event.target.classList.contains('increase-quantity')) {
            const name = event.target.getAttribute('data-name');
            const size = event.target.getAttribute('data-size');
            const item = cart.find(item => item.name === name && item.size === size);
            if (item) {
              item.quantity++;
              displayCartItems();
              updateCartCount();
            }
          } else if (event.target.classList.contains('decrease-quantity')) {
            const name = event.target.getAttribute('data-name');
            const size = event.target.getAttribute('data-size');
            const item = cart.find(item => item.name === name && item.size === size);
            if (item && item.quantity > 1) {
              item.quantity--;
              displayCartItems();
              updateCartCount();
            } else if (item && item.quantity === 1) {
              const index = cart.indexOf(item);
              cart.splice(index, 1);
              displayCartItems();
              updateCartCount();
            }
          }
        });
      });
    </script>
  </body>
</html>
