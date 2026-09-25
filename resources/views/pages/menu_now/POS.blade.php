<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eden Jaya POS</title>
    <script src="https://kit.fontawesome.com/19efc8c9d6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; overflow: hidden; }
        .sidebar-nav { height: 100vh; background: #fff; border-right: 1px solid #dee2e6; }
        .product-card { cursor: pointer; transition: transform 0.1s; border: none; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .product-card:active { transform: scale(0.95); }
        .product-container { max-height: 80vh; overflow-y: auto; }
        .cart-section { height: 100vh; background: #fff; border-left: 1px solid #dee2e6; display: flex; flex-direction: column; }
        .cart-items { flex-grow: 1; overflow-y: auto; }
        .badge-stock { position: absolute; top: 10px; right: 10px; font-size: 0.7rem; }
        .total-section { background: #1a1d23; color: white; border-radius: 15px 15px 0 0; }
        input::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-9">
                <div class="container-fluid p-4">
                    <a class="navbar-brand fw-bold" href="/">Eden Jaya</a>
                    <ul class="navbar-nav d-flex flex-row gap-4">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/product">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#delivery">Delivery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#convert">Convert</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#transaction-history">Transaction History</a>
                        </li>
                    </ul>
                </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Products</h4>
                <div class="input-group w-75 shadow-sm">
                    {{-- <span class="input-group-text bg-white border-end-0"><i data-lucide="search" size="18"></i></span> --}}
                    <input type="text" class="form-control border-start-0" id="searchInput" onkeyup="searchTable()"  placeholder="Search product or scan barcode...">
                </div>
            </div>

            <div class="row g-3 product-container">
                                 
                @foreach ($product as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 listproduct" id="{{ str_replace(' ', '', $product->nama_produk ) }}" onclick="openmodal('{{ $product->produk_SKU }}','{{ $product->nama_produk }}','{{ $product->harga }}','{{ $product->jumlah_stock }}')">
                    <div class="card product-card p-2">       
                        <span class="badge rounded-pill bg-success badge-stock">{{ $product->jumlah_stock }} In Stock</span>
                        <div class="card-body px-1 py-2">
                            <h6 class="card-title mb-1 text-truncate">{{ strtoupper($product->nama_produk) }}</h6>
                            <p class="card-text fw-bold text-primary mb-0">Rp. <?php echo number_format( $product->harga, 0,',','.') ?></p>
                        </div>
                    </div>
                </div>
                @endforeach                
            </div>
        </div>

        <div class="col-md-3 cart-section p-4">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Current Order</h5>
                <button onclick="clear_cart()" class="btn btn-danger">Clear</button>
            </div>

            <div class="cart-items p-3">
                
                    @php
                        $total = 0;
                        $index = 0;
                    @endphp
                @foreach ($cart as $index=>$cart)
                @php
                    $total = $total+($cart->harga*$cart->Jumlah);
                @endphp
                <div class="d-flex content-end align-items-center mb-3" data-product-id="{{ $cart->produk_SKU }}">
                    <div class="flex-grow-1 w-50">
                        <p class="mb-0 fw-bold">{{ strtoupper($cart->nama_produk) }}</p>
                        <small class="text-muted">Rp. {{ number_format($cart->harga, 0, '.', '.') }}</small>
                    </div>
                    <div class="d-flex align-items-center w-50">
                        <button class="btn btn-sm btn-warning me-2" onclick="delete_product('{{ $cart->produk_SKU }}','{{ $cart->nama_produk }}')"><i class="fa-regular fa-trash-can"></i></button>
                        <button class="btn btn-sm btn-light border" onclick="decreaseQty(this)">-</button>
                        <input type="number" class="form-control qty-display fw-bold border-0 ms-2 me-2" name="Jumlah" onchange="updateTotalPrice()" value="{{ $cart->Jumlah }}" min="1">
                        <button class="btn btn-sm btn-light border" onclick="increaseQty(this)">+</button>
                    </div>
                </div>

                @endforeach   
            </div>

                <input type="hidden" id="total_harga" value="{{ $total }}">
                <input type="hidden" id="total_qty" value="{{ $index+1 }}">
            <div class="total-section p-4">
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="mb-0">Total</h4>
                    <h4 class="mb-0 text-info" id="totalPrice">Rp. {{ number_format($total, 0, '.', '.') }}</h4>
                </div>
                <button class="btn btn-info w-100 py-3 fw-bold text-white shadow" onclick="checkout()">
                    PLACE ORDER <i data-lucide="chevron-right" class="ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>
    
    <!-- Modal-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="add-to-cart" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Add to Cart</h4>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row p-3">
                            <div style="font-size: large">Nama Barang : </div>
                            <div id="nama_barang" style="font-size: large"></div>
                            <br>
                        </div>

                        <div class="row p-3">
                            <div class="col">
                                <div style="font-size: large">Harga Barang : </div>
                                <div id="harga_barang" style="font-size: large"></div>
                                <br>
                            </div>

                            <div class="col">
                                <div style="font-size: large">Stock Barang : </div>
                                <div id="stock_barang" style="font-size: large"></div>
                                <br>
                            </div>
                        </div>
                        
                            <br>
                        <label style="font-size: large">Jumlah Barang</label>
                        <input type="number" class="form-control" id="Jumlah" name="Jumlah" value=1 min=1 required>
                        <input type="hidden" name="cart_SKU" id="cart_SKU">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    lucide.createIcons();

    // $(document).ready(function () {
        
    // });

    function openmodal(id,nama,harga,stock){
        let hargaBarang = parseInt(harga);
        $('#nama_barang').text(nama);
        document.getElementById('harga_barang').textContent = 'Rp. ' + hargaBarang.toLocaleString('id-ID');
        $('#stock_barang').text(stock);
        $('#cart_SKU').val(id);
        $('#exampleModalCenter').modal('show');
    }
    
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const productCards = document.querySelectorAll('.listproduct');
        
        productCards.forEach(card => {
            const productName = card.querySelector('.card-title').textContent.toLowerCase();
            if (productName.indexOf(filter) > -1) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function decreaseQty(button) {
        const qtyDisplay = button.parentElement.querySelector('.qty-display');
        let currentQty = parseInt(qtyDisplay.value, 10);
        if (currentQty > 1) {
            qtyDisplay.value = currentQty - 1;
            updateTotalPrice();
        }
    }

    function increaseQty(button) {
        const qtyDisplay = button.parentElement.querySelector('.qty-display');
        let currentQty = parseInt(qtyDisplay.value, 10);
        qtyDisplay.value = currentQty + 1;
        updateTotalPrice();
    }

    function updateTotalPrice() {
        const cartItems = document.querySelectorAll('.cart-items > div');
        let total = 0;
        
        cartItems.forEach(item => {
            const priceText = item.querySelector('small').textContent.replace('Rp. ', '').replace(/\./g, '');
            const qty = parseInt(item.querySelector('.qty-display').value, 10);
            const price = parseInt(priceText);
            total += price * qty;
        });
        
        document.getElementById('totalPrice').textContent = 'Rp. ' + total.toLocaleString('id-ID');        
        document.getElementById('total_harga').value = total;
    }

    function getCartData() {
        return Array.from(document.querySelectorAll('.cart-items > div')).map(item => ({
            item_id: item.dataset.productId,
            quantity: parseInt(item.querySelector('.qty-display').value, 10)
        }));
    }

    function delete_product(id, name) {
        
        Swal.fire({
            text: "Apakah Anda yakin akan menghapus "+name+"?",
            icon: "warning",
            width: "500px",
            showCancelButton:!0,
            buttonsStyling:!1,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            didOpen: function(popup) {
                popup.style.fontSize = "16px";
            },
            customClass: {
                confirmButton: "btn btn-active-light",
                cancelButton: "btn btn-primary"
            }
        }).then(function(e) {
            if(e.value) {
                Swal.fire({
                    text: "Menghapus data...",
                    allowOutsideClick: false
                });

                Swal.showLoading();

                $.ajax({
                    method: "POST",
                    url: "{{ route('deleteCart') }}",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    }

    function clear_cart() {
        
        Swal.fire({
            text: "Apakah Anda yakin akan menghapus semua item dari keranjang?",
            icon: "warning",
            width: "500px",
            showCancelButton:!0,
            buttonsStyling:!1,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            didOpen: function(popup) {
                popup.style.fontSize = "16px";
            },
            customClass: {
                confirmButton: "btn btn-active-light",
                cancelButton: "btn btn-primary"
            }
        }).then(function(e) {
            if(e.value) {
                Swal.fire({
                    text: "Menghapus data...",
                    allowOutsideClick: false
                });

                Swal.showLoading();

                $.ajax({
                    url: "{{ route('deleteAllCart') }}",
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    }
    
    function checkout(){
        Swal.fire({
            title: 'Checkout',
            text: "Apakah Perlu Cetak Struk?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cetak',
            cancelButtonText: "Tidak"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('create_transaction') }}",
                    data: {
                        _token: '{{csrf_token()}}',
                        'total_harga': $('#total_harga').val(),
                        'total_qty'  : $('#total_qty').val(),
                        'data'      : JSON.stringify(getCartData()),
                        'print'     : 1
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
            else{
                $.ajax({
                    method: "POST",
                    url: "{{ route('create_transaction') }}",
                    data: {
                        _token: '{{csrf_token()}}',
                        'total_harga': $('#total_harga').val(),
                        'total_qty'  : $('#total_qty').val(),
                        'data'      : JSON.stringify(getCartData()),
                        'print'     : 0
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        })
    }

</script>
</body>
</html>