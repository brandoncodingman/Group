const cart = [];
  let total = 0;

  function addToCart(item, price) {
    cart.push({ item, price });
    total += price;
    updateCartDisplay();
  }

  function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const totalDisplay = document.getElementById('total');

    cartItems.innerHTML = '';
    cart.forEach((entry, index) => {
      const li = document.createElement('li');
      li.textContent = `${entry.item} - $${entry.price}`;
      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'Remove';
      removeBtn.onclick = () => removeFromCart(index);
      li.appendChild(removeBtn);
      cartItems.appendChild(li);
    });

    totalDisplay.textContent = total;
  }

  function removeFromCart(index) {
    total -= cart[index].price;
    cart.splice(index, 1);
    updateCartDisplay();
  }

  function checkout() {
    if (cart.length === 0) {
      alert("Your cart is empty!");
      return;
    }
    alert("Thanks for your purchase!");
    cart.length = 0;
    total = 0;
    updateCartDisplay();
  }