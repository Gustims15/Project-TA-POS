const categoryTabs = document.querySelector('#categoryTabs');
const productGrid = document.querySelector('#productGrid');
const menuTitle = document.querySelector('#menuTitle');
const searchInput = document.querySelector('#searchInput');

const openCart = document.querySelector('#openCart');
const closeCart = document.querySelector('#closeCart');
const cartDrawer = document.querySelector('#cartDrawer');
const cartBackdrop = document.querySelector('#cartBackdrop');

const cartList = document.querySelector('#cartList');
const cartCount = document.querySelector('#cartCount');
const itemsTotal = document.querySelector('#itemsTotal');
const grandTotal = document.querySelector('#grandTotal');
const placeOrder = document.querySelector('#placeOrder');
const toast = document.querySelector('#toast');

let products = [];
let categories = [];
let activeCategory = '';
let cart = [];

const formatRupiah = value => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  }).format(Number(value || 0));
};

const showToast = message => {
  if (!toast) {
    return;
  }

  toast.textContent = message;
  toast.classList.add('show');

  setTimeout(() => {
    toast.classList.remove('show');
  }, 2200);
};

const openCartDrawer = () => {
  cartDrawer.classList.add('show');
  cartBackdrop.classList.add('show');
};

const closeCartDrawer = () => {
  cartDrawer.classList.remove('show');
  cartBackdrop.classList.remove('show');
};

openCart?.addEventListener('click', openCartDrawer);
closeCart?.addEventListener('click', closeCartDrawer);
cartBackdrop?.addEventListener('click', closeCartDrawer);

const getProductImage = product => {
  const fallbackImage =
    'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=500&q=80';

  if (!product.image) {
    return fallbackImage;
  }

  if (product.image.startsWith('http://') || product.image.startsWith('https://')) {
    return product.image;
  }

  const imagePath = product.image
    .replace(/^\/storage\//, '')
    .replace(/^storage\//, '')
    .replace(/^\/+/, '');

  return `${window.NGUNJUK_ROUTES.storage}/${imagePath}`;
};

const normalizeProduct = product => {
  const sizes = Array.isArray(product.sizes) ? product.sizes : [];

  return {
    id: Number(product.id),
    category_id: Number(product.category_id),
    category: product.category?.name || 'Menu',
    name: product.name,
    description: product.description || '-',
    stock: Number(product.stock || 0),
    image: getProductImage(product),
    sizes: sizes.map(size => ({
      id: Number(size.id),
      name: size.name,
      price: Number(size.price || 0),
      is_default: Boolean(size.is_default),
      is_active: Boolean(size.is_active ?? true)
    }))
  };
};

const getDefaultSize = product => {
  if (!product.sizes || product.sizes.length === 0) {
    return null;
  }

  return product.sizes.find(size => size.is_default) || product.sizes[0];
};

const getSelectedSize = productId => {
  const selected = document.querySelector(
    `button.size-btn.active[data-product-id="${productId}"]`
  );

  if (!selected) {
    const product = products.find(item => item.id === Number(productId));
    return product ? getDefaultSize(product) : null;
  }

  return {
    id: Number(selected.dataset.sizeId),
    name: selected.dataset.sizeName,
    price: Number(selected.dataset.price)
  };
};

const loadProducts = async () => {
  try {
    const response = await fetch(window.NGUNJUK_ROUTES.products, {
      method: 'GET',
      headers: {
        Accept: 'application/json'
      }
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Gagal mengambil produk.');
    }

    products = result.data.map(normalizeProduct);
    categories = [...new Set(products.map(product => product.category))];
    activeCategory = categories[0] || '';

    renderCategories();
    renderProducts();
  } catch (error) {
    console.error(error);
    showToast('Gagal mengambil data produk.');
  }
};

const renderCategories = () => {
  categoryTabs.innerHTML = '';

  categories.forEach(category => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = category === activeCategory ? 'active' : '';
    button.textContent = category;

    button.addEventListener('click', () => {
      activeCategory = category;
      renderCategories();
      renderProducts();
    });

    categoryTabs.appendChild(button);
  });
};

const renderProducts = () => {
  const keyword = searchInput?.value.toLowerCase().trim() || '';

  const filteredProducts = products.filter(product => {
    const matchCategory = product.category === activeCategory;
    const matchSearch =
      product.name.toLowerCase().includes(keyword) ||
      product.description.toLowerCase().includes(keyword);

    return matchCategory && matchSearch;
  });

  menuTitle.textContent = `${activeCategory || 'Menu'} menu`;
  productGrid.innerHTML = '';

  if (!filteredProducts.length) {
    productGrid.innerHTML = `
      <div class="cart-empty product-empty">
        Produk tidak ditemukan.
      </div>
    `;
    return;
  }

  filteredProducts.forEach(product => {
    const isOutOfStock = product.stock <= 0;
    const defaultSize = getDefaultSize(product);
    const displayPrice = defaultSize ? defaultSize.price : 0;

    const card = document.createElement('article');
    card.className = `product-card ${isOutOfStock ? 'out-of-stock' : ''}`;

    const sizeHtml = product.sizes.length > 1
      ? `
        <div class="size-row">
          <span class="size-label">Size</span>

          ${product.sizes.map(size => `
            <button
              type="button"
              class="size-btn ${defaultSize && size.id === defaultSize.id ? 'active' : ''}"
              data-product-id="${product.id}"
              data-size-id="${size.id}"
              data-size-name="${size.name}"
              data-price="${size.price}"
            >
              ${size.name}
            </button>
          `).join('')}
        </div>
      `
      : `
        <div class="size-row">
          <span class="size-label">Size</span>
          <span class="regular-size">
            ${defaultSize ? defaultSize.name : 'Regular'} / satu ukuran
          </span>
        </div>
      `;

    card.innerHTML = `
      <div class="drink-img">
        <img src="${product.image}" alt="${product.name}">
      </div>

      <div class="product-info">
        <div class="product-head">
          <div>
            <h3>${product.name}</h3>

            <span class="stock-badge ${isOutOfStock ? 'empty' : ''}">
              ${isOutOfStock ? 'Stok habis' : `Stok ${product.stock}`}
            </span>
          </div>

          <strong class="price">${formatRupiah(displayPrice)}</strong>
        </div>

        <p class="description">${product.description}</p>

        ${sizeHtml}

        <div class="card-footer">
          <div class="qty-row">
            <button
              type="button"
              class="qty-btn qty-minus"
              data-id="${product.id}"
              ${isOutOfStock ? 'disabled' : ''}
            >
              −
            </button>

            <span id="qty-${product.id}">1</span>

            <button
              type="button"
              class="qty-btn qty-plus"
              data-id="${product.id}"
              ${isOutOfStock ? 'disabled' : ''}
            >
              +
            </button>
          </div>

          <button
            type="button"
            class="add-btn add-cart-btn"
            data-id="${product.id}"
            ${isOutOfStock || !defaultSize ? 'disabled' : ''}
          >
            ${isOutOfStock ? 'Stok Habis' : 'Add to Cart'}
          </button>
        </div>
      </div>
    `;

    productGrid.appendChild(card);
  });
};

const getQuantity = productId => {
  const quantityElement = document.querySelector(`#qty-${productId}`);

  return Number(quantityElement?.textContent || 1);
};

const setQuantity = (productId, quantity) => {
  const quantityElement = document.querySelector(`#qty-${productId}`);

  if (!quantityElement) {
    return;
  }

  quantityElement.textContent = Math.max(1, quantity);
};

productGrid?.addEventListener('click', event => {
  const sizeButton = event.target.closest('.size-btn');
  const minusButton = event.target.closest('.qty-minus');
  const plusButton = event.target.closest('.qty-plus');
  const addButton = event.target.closest('.add-cart-btn');

  if (sizeButton) {
    const productId = Number(sizeButton.dataset.productId);

    document
      .querySelectorAll(`.size-btn[data-product-id="${productId}"]`)
      .forEach(button => button.classList.remove('active'));

    sizeButton.classList.add('active');

    const productCard = sizeButton.closest('.product-card');
    const priceElement = productCard?.querySelector('.price');

    if (priceElement) {
      priceElement.textContent = formatRupiah(Number(sizeButton.dataset.price || 0));
    }

    return;
  }

  if (minusButton) {
    const productId = Number(minusButton.dataset.id);
    const currentQuantity = getQuantity(productId);

    setQuantity(productId, currentQuantity - 1);
    return;
  }

  if (plusButton) {
    const productId = Number(plusButton.dataset.id);
    const product = products.find(item => item.id === productId);
    const currentQuantity = getQuantity(productId);

    if (product && currentQuantity >= product.stock) {
      showToast('Jumlah melebihi stok tersedia.');
      return;
    }

    setQuantity(productId, currentQuantity + 1);
    return;
  }

  if (addButton) {
    const productId = Number(addButton.dataset.id);
    const product = products.find(item => item.id === productId);

    if (!product || product.stock <= 0) {
      showToast('Stok produk habis.');
      return;
    }

    const selectedSize = product.sizes.length > 1
      ? getSelectedSize(product.id)
      : getDefaultSize(product);

    if (!selectedSize) {
      showToast('Size produk belum tersedia.');
      return;
    }

    const quantity = getQuantity(product.id);

    if (quantity > product.stock) {
      showToast('Jumlah melebihi stok tersedia.');
      return;
    }

    addToCart({
      product_id: product.id,
      product_size_id: selectedSize.id,
      name: product.name,
      image: product.image,
      size: selectedSize.name,
      price: selectedSize.price,
      quantity,
      stock: product.stock
    });

    addButton.textContent = 'Added to cart';
    addButton.classList.add('added');

    showToast('Produk berhasil ditambahkan ke cart.');
    renderCart();
  }
});

const addToCart = item => {
  const existingItem = cart.find(cartItem => {
    return cartItem.product_id === item.product_id &&
      cartItem.product_size_id === item.product_size_id;
  });

  if (existingItem) {
    const newQuantity = existingItem.quantity + item.quantity;

    if (newQuantity > item.stock) {
      showToast('Jumlah cart melebihi stok tersedia.');
      return;
    }

    existingItem.quantity = newQuantity;
    return;
  }

  cart.push(item);
};

const cartTotalQuantity = () => {
  return cart.reduce((total, item) => total + item.quantity, 0);
};

const cartTotalPrice = () => {
  return cart.reduce((total, item) => total + item.price * item.quantity, 0);
};

const renderCart = () => {
  cartList.innerHTML = '';

  if (!cart.length) {
    cartList.innerHTML = `
      <div class="cart-empty">
        Keranjang masih kosong.
      </div>
    `;
  }

  cart.forEach(item => {
    const cartItem = document.createElement('div');
    cartItem.className = 'cart-item';

    cartItem.innerHTML = `
      <div class="cart-img">
        <img src="${item.image}" alt="${item.name}">
      </div>

      <div class="cart-item-info">
        <h3>${item.name}</h3>
        <p class="cart-item-meta">${item.size}</p>

        <div class="cart-price-row">
          <strong>${formatRupiah(item.price)}</strong>

          <div class="qty-row">
            <button
              type="button"
              class="qty-btn cart-minus"
              data-id="${item.product_id}"
              data-size-id="${item.product_size_id}"
            >
              −
            </button>

            <span>${item.quantity}</span>

            <button
              type="button"
              class="qty-btn cart-plus"
              data-id="${item.product_id}"
              data-size-id="${item.product_size_id}"
            >
              +
            </button>
          </div>
        </div>
      </div>
    `;

    cartList.appendChild(cartItem);
  });

  cartCount.textContent = cartTotalQuantity();
  itemsTotal.textContent = formatRupiah(cartTotalPrice());
  grandTotal.textContent = formatRupiah(cartTotalPrice());
};

cartList?.addEventListener('click', event => {
  const minusButton = event.target.closest('.cart-minus');
  const plusButton = event.target.closest('.cart-plus');

  if (!minusButton && !plusButton) {
    return;
  }

  const button = minusButton || plusButton;
  const productId = Number(button.dataset.id);
  const productSizeId = Number(button.dataset.sizeId);

  const item = cart.find(cartItem => {
    return cartItem.product_id === productId &&
      cartItem.product_size_id === productSizeId;
  });

  if (!item) {
    return;
  }

  if (minusButton) {
    item.quantity -= 1;

    if (item.quantity <= 0) {
      cart = cart.filter(cartItem => {
        return !(cartItem.product_id === productId &&
          cartItem.product_size_id === productSizeId);
      });
    }
  }

  if (plusButton) {
    if (item.quantity >= item.stock) {
      showToast('Jumlah melebihi stok tersedia.');
      return;
    }

    item.quantity += 1;
  }

  renderCart();
});

const submitOrder = async () => {
  if (!cart.length) {
    showToast('Cart masih kosong.');
    return;
  }

  const payload = {
    items: cart.map(item => ({
      product_id: item.product_id,
      product_size_id: item.product_size_id,
      quantity: item.quantity
    }))
  };

  placeOrder.disabled = true;
  placeOrder.textContent = 'Memproses...';

  try {
    const response = await fetch(window.NGUNJUK_ROUTES.orders, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': window.NGUNJUK_CSRF_TOKEN
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Gagal menyimpan transaksi.');
    }

    cart = [];
    renderCart();
    closeCartDrawer();

    showToast('Transaksi berhasil masuk ke database.');

    await loadProducts();

    setTimeout(() => {
      window.location.href = window.NGUNJUK_ROUTES.history;
    }, 900);
  } catch (error) {
    console.error(error);
    showToast(error.message || 'Gagal menyimpan transaksi.');
  } finally {
    placeOrder.disabled = false;
    placeOrder.textContent = 'Place an order';
  }
};

placeOrder?.addEventListener('click', submitOrder);
searchInput?.addEventListener('input', renderProducts);

renderCart();
loadProducts();