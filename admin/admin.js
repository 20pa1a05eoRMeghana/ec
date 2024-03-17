function fetchProducts() {
    fetch('/E-Commerce-Website-Main/user_management.php/products')
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('productList');
            productList.innerHTML = ''; // Clear previous content

            if (data.products.length > 0) {
                data.products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.innerHTML = `
                        <p><strong>Product ID:</strong> ${product.product_id}</p>
                        <p><strong>Name:</strong> ${product.name}</p>
                        <p><strong>Price:</strong> ${product.price}</p>
                        <img src=${product.pic} style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                        <button onclick="addToCart(${product.product_id})">Add to Cart</button>
                        <hr>
                    `;
                    productList.appendChild(productItem);
                });
            } else {
                productList.innerHTML = '<p>No products found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            document.getElementById('productList').innerHTML = '<p>Error fetching products. Please try again later.</p>';
        });
}



function addToCart(productId) {
    fetch('/E-Commerce-Website-Main/user_management.php/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId }) // Pass only the product ID
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Display success message
    })
    .catch(error => {
        console.error('Error adding product to cart:', error);
        alert('Error adding product to cart. Please try again later.');
    });
}


// Call fetchProducts when the page loads
window.onload = fetchProducts;
document.getElementById('addProductForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get form values
    const productId = document.getElementById('product_id').value;
    const productName = document.getElementById('productName').value;
    const price = document.getElementById('price').value;

    // Send data to server
    fetch('/E-Commerce-Website-Main/user_management.php/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            name: productName,
            price: price,
        })
    })
    .then(response => response.json())
    .then(data => {
        // Display response message
        alert(data.message);
    })
    .catch(error => {
        console.error('Error adding product:', error);
        alert('Error adding product. Please try again later.');
    });
});
document.getElementById('deleteProductForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get product ID
    const productId = document.getElementById('productid').value;

    // Send data to server for deletion
    fetch(`http://localhost/E-Commerce-Website-Main/user_management.php/products?product_id=${productId}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        // Display response message
        alert(data.message);
    })
    .catch(error => {
        console.error('Error deleting product:', error);
        alert('Error deleting product. Please try again later.');
    });
});
document.getElementById('updateProductForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get product ID, updated name, and updated price
    const productId = document.getElementById('productIdToUpdate').value;
    const updatedName = document.getElementById('updatedName').value;
    const updatedPrice = document.getElementById('updatedPrice').value;

    // Send data to server for update
    fetch(`/E-Commerce-Website-Main/user_management.php/products`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            name: updatedName,
            price: updatedPrice
        })
    })
    .then(response => response.json())
    .then(data => {
        // Display response message
        alert(data.message);
    })
    .catch(error => {
        console.error('Error updating product details:', error);
        alert('Error updating product details. Please try again later.');
    });
});

window.onload = fetchProducts;