<x-base-layout>

    <div class="container" style="overflow-x:auto;">
        <div class="row justify-content-between">
            <div class="col-6 card" style="overflow-x:auto;">
                <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th class="text-center">Product SKU</th>
                            <th class="text-center">Nama Product</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $product)
                        <tr>
                            <td class="text-center">{{ $product->produk_SKU }}</td>
                            <td class="text-center">{{ $product->nama_produk }}</td>
                            <td class="text-center">Rp. <?php echo number_format( $product->harga, 0,',','.') ?></td>
                            <td class="text-center">{{ $product->jumlah_stock }}</td>
                            <td><button class="btn btn-primary" onclick="openmodal('{{ $product->produk_SKU }}','{{ $product->nama_produk }}','{{ $product->harga }}','{{ $product->jumlah_stock }}')">Add</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-6 card" style="overflow-x:auto;">
                <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th class="text-center">Nama Product</th>
                            <th class="text-center">Jumlah Barang</th>
                            <th class="text-center">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $cart)
                        <tr>
                            <td class="text-center">{{ $cart->nama_produk }}</td>
                            <td class="text-center">{{ $cart->Jumlah }}</td>
                            <td class="text-center">Rp. <?php echo number_format( $cart->harga*$cart->Jumlah, 0,',','.') ?></td>
                        </tr>
                        @endforeach
                    </tbody>
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
</script>
