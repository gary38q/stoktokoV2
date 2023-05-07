<x-base-layout>

    <div class="container card p-5" style="overflow-x:auto;">
        <h1>Pembelian</h1>
        <hr>
        <div class="row justify-content-between">
            <div class="col-6" style="overflow-x:auto; border-right: solid black 1px">
                <h3> Product</h3>
                <table id="mytableproduct" class="table table-row-bordered gy-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th class="text-center">Nama Product</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $product)
                        <tr>
                            <td class="text-center">{{ $product->nama_produk }}</td>
                            <td class="text-center">Rp. <?php echo number_format( $product->harga, 0,',','.') ?></td>
                            <td class="text-center">{{ $product->jumlah_stock }}</td>
                            <td align="center"><button class="btn btn-primary" onclick="openmodal('{{ $product->produk_SKU }}','{{ $product->nama_produk }}','{{ $product->harga }}','{{ $product->jumlah_stock }}')">Add</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-6" style="overflow-x:auto;">
                <h3> Keranjang</h3>
                <table id="mytablekeranjang" class="table table-row-bordered gy-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th class="text-center">Nama Product</th>
                            <th class="text-center">Jumlah Barang</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                        @foreach ($cart as $cart)
                        @php
                            $total = $total+($cart->harga*$cart->Jumlah);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $cart->nama_produk }}</td>
                            <td class="text-center">{{ $cart->Jumlah }}</td>
                            <td class="text-center">Rp. <?php echo number_format( $cart->harga*$cart->Jumlah, 0,',','.') ?></td>
                            <td align="center"><button class="btn btn-danger" onclick="delete_product('{{ $cart->produk_SKU }}','{{ $cart->nama_produk }}')">Delete</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-6">
                            <th colspan="3" class="text-nowrap align-end">Total:</th>
                            <th colspan="1" class="text-dark fs-3">Rp. <?php echo number_format( $total, 0,',','.') ?></th>
                        </tr>
                    </tfoot>
                </table>
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

</x-base-layout>

<script>
$(document).ready(function () {
    $('#mytableproduct').DataTable({
        dom: '<"top"f>rt<"bottom"ip><"clear">',
    });

    $('#mytablekeranjang').DataTable({
        dom: '<"top"f>rt<"bottom"ip><"clear">',
    });
});
    
    function openmodal(id,nama,harga,stock){
        $('#nama_barang').text(nama);
        $('#harga_barang').text(harga);
        $('#stock_barang').text(stock);
        $('#cart_SKU').val(id);
        $('#exampleModalCenter').modal('show');
    }

    $('#exampleModalCenter').on('shown.bs.modal', function() {
        $('#Jumlah').focus();
    })

    
    function delete_product(id, name) {
        
        Swal.fire({
            text: "Apakah Anda yakin akan menghapus "+name+"?",
            icon: "warning",
            showCancelButton:!0,
            buttonsStyling:!1,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
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
</script>