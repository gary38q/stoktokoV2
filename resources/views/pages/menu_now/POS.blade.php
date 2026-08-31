<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional POS Terminal</title>
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
        .cart-section { height: 100vh; background: #fff; border-left: 1px solid #dee2e6; display: flex; flex-direction: column; }
        .cart-items { flex-grow: 1; overflow-y: auto; }
        .badge-stock { position: absolute; top: 10px; right: 10px; font-size: 0.7rem; }
        .total-section { background: #1a1d23; color: white; border-radius: 15px 15px 0 0; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        {{-- <div class="col-md-1 sidebar-nav d-flex flex-column align-items-center py-4">
            <div class="mb-4 text-primary"><i data-lucide="layout-grid"></i></div>
            <button class="btn btn-light mb-3 p-3 w-75 shadow-sm"><i data-lucide="package"></i></button>
            <button class="btn btn-white mb-3 p-3 w-75"><i data-lucide="utensils"></i></button>
            <button class="btn btn-white mb-3 p-3 w-75"><i data-lucide="settings"></i></button>
            <div class="mt-auto mb-3 text-danger"><i data-lucide="log-out"></i></div>
        </div> --}}

        <div class="col-md-10 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Menu / Products</h4>
                <div class="input-group w-75 shadow-sm">
                    {{-- <span class="input-group-text bg-white border-end-0"><i data-lucide="search" size="18"></i></span> --}}
                    <input type="text" class="form-control border-start-0" id="searchInput" onkeyup="searchTable()"  placeholder="Search product or scan barcode...">
                </div>
            </div>

            <div class="row g-3">
                                 
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

        <div class="col-md-2 cart-section p-4">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Current Order</h5>
                <button class="btn btn-sm btn-outline-danger">Clear</button>
            </div>

            <div class="cart-items p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-bold">Premium Widget A</p>
                        <small class="text-muted">$24.00 x 1</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-light border">-</button>
                        <span class="fw-bold">1</span>
                        <button class="btn btn-sm btn-light border">+</button>
                    </div>
                </div>
            </div>

            <div class="total-section p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Subtotal</span>
                    <span class="fw-bold">$24.00</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <span class="text-secondary">Tax (10%)</span>
                    <span class="fw-bold">$2.40</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="mb-0">Total</h4>
                    <h4 class="mb-0 text-info">$26.40</h4>
                </div>
                <button class="btn btn-info w-100 py-3 fw-bold text-white shadow">
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
                    <div class="modal-body">
                        <div>
                            <div style="font-size: large">Nama Barang : </div>
                            <div id="nama_barang" style="font-size: large"></div>
                            <br>
                        </div>

                        <div class="row">
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
                        <input type="number" class="form-control" id="Jumlah" name="Jumlah">
                        <input type="hidden" name="cart_SKU" id="cart_SKU">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        // $("#paymentModal").modal()
        $('#nama_barang').text(nama);
        $('#harga_barang').text(harga);
        $('#stock_barang').text(stock);
        $('#cart_SKU').val(id);
        $('#exampleModalCenter').modal('show');
    }
    
    function searchTable() {
    // 1. Get the input value and table rows
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    
    const listproduct =  Array.from(document.querySelectorAll('.listproduct'))
                .map(element => element.id);

    for (let j = 0; j < listproduct.length; j++) {
            if (listproduct[j]) {
                const textValue = listproduct[j];
                // Check if the search term exists in this cell
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    console.log(textValue);
                    $('#' + textValue).css('display', 'block'); // Show the row
                    break; // If a match is found in any column, stop checking this row
                }
                else {
                    $('#' + textValue).css('display', 'none'); // Hide the row
                }
            }
        }
    }
</script>
</body>
</html>