document.getElementById('addOrderForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    // Send data to server
    fetch('/E-Commerce-Website-Main/user_management.php/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            phone: phone,
            email: email,
            address: address,
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
