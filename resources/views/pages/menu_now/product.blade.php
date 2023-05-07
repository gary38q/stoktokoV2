<x-base-layout>

    <div class="container" style="overflow-x:auto;">
        <div class="card p-5">
            <div class="row">
                <div class="col-9" align="left">
                    <h1>Product</h1>
                </div>
                <div class="col-3" align="right">
                    <button class="btn btn-primary" onclick="create_product()">Tambah Product</button>
                </div>
            </div>
        <hr>
            <div style="overflow-x:auto;">
                <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5 p-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th class="text-center">Nama Product</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($data_product as $product)
                            <tr>
                                <td class="text-center">{{ $product->nama_produk }}</td>
                                <td class="text-center">Rp. <?php echo number_format( $product->harga, 0,',','.') ?></td>
                                <td class="text-center">{{ $product->jumlah_stock }}</td>
                                <td align="center">
                                    <button class="btn btn-success d-inline-block" onclick="add_product_stock('{{ $product->produk_SKU }}','{{ $product->nama_produk }}','{{ $product->harga }}','{{ $product->jumlah_stock }}')">Tambah Stock</button>
                                    <button class="btn btn-primary d-inline-block" onclick="edit_product('{{ $product->produk_SKU }}','{{ $product->nama_produk }}','{{ $product->harga }}')">Edit</button>
                                    <button class="btn btn-danger d-inline-block" onclick="delete_product('{{ $product->produk_SKU }}')">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="stockmodalcenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" id="myform2">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Tambah Stock</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div style="font-size: large">Nama Barang : </div>
                            <div id="nama_barangl" style="font-size: large"></div>
                            <br>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div style="font-size: large">Harga Barang : </div>
                                <div id="harga_barangl" style="font-size: large"></div>
                                <br>
                            </div>

                            <div class="col">
                                <div style="font-size: large">Stock Barang : </div>
                                <div id="stock_barangl" style="font-size: large"></div>
                                <br>
                            </div>
                        </div>
                        
                            <br>
                        <label style="font-size: large">Jumlah Barang</label>
                        <input type="number" class="form-control" id="Jumlah" name="Jumlah">
                        @error('Jumlah')
                            <span class="text-danger errtext">Jumlah Barang Harus Diisi Setidaknya 1</span>
                        @enderror
                        <br>
                        <label style="font-size: large">Pengirim Barang</label>
                        <input type="text" class="form-control" id="pengirim" name="pengirim">
                        @error('pengirim')
                            <span class="text-danger errtext">Pengirim Barang Harus Diisi</span>
                        @enderror
                        <input type="hidden" name="cart_SKUl" id="cart_SKUl">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Create-->
    <div class="modal fade" id="CreateModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" id="myform1">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Create Product</h4>
                    </div>
                    <div class="modal-body">

                        <br>
                        <div>
                            <div style="font-size: large">Nama Barang : </div>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                            @error('nama_barang')
                                <span class="text-danger errtext">Nama Barang Harus Diisi</span>
                            @enderror
                            <br>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <div style="font-size: large">Harga Barang : </div>
                                <input type="number" class="form-control" id="harga_barang" name="harga_barang">
                                @error('harga_barang')
                                    <span class="text-danger errtext">Harga Barang Harus Diisi</span>
                                @enderror
                                <br>
                            </div>
                        </div>                        
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

    
    @if (count($errors) > 0)
        
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('{{ request()->session()->get('modalid'); }}'));
            myModal.show();
        </script>
    @endif
<script>

        $("#kt_datatable_zero_configuration").DataTable();

        function create_product(){
            $('#myform1').attr('action','{{ route('create_product') }}')
            $('#exampleModalLongTitle').text('Create Product');
            $('#nama_barang').val('');
            $('#harga_barang').val('');
            $('#cart_SKU').val('');
            $('.errtext').css('display','none');
            $('#CreateModalCenter').modal('show');
        }

        function edit_product(id,nama,harga){
            $('#myform1').attr('action','{{ route('edit_product') }}')
            $('#exampleModalLongTitle').text('Edit Product');
            $('#nama_barang').val(nama);
            $('#harga_barang').val(harga);
            $('#cart_SKU').val(id);
            $('.errtext').css('display','none');
            $('#CreateModalCenter').modal('show');
        }
        
        function add_product_stock(id,nama,harga,stock){
            $('#myform2').attr('action','{{ route('tambah_stock_product') }}')
            $('#nama_barangl').text(nama);
            $('#harga_barangl').text(harga);
            $('#stock_barangl').text(stock);
            $('#cart_SKUl').val(id);
            $('.errtext').css('display','none');
            $('#stockmodalcenter').modal('show');
        }

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
                        url: "{{ route('delete_product') }}",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(response) {
                            if(response.status) {
                                window.location.reload();
                            }
                            else {
                                Swal.fire({
                                    text: response.message,
                                    type: "error",
                                    showConfirmButton:!0
                                });
                            }
                        }
                    });
                }
            });
        }

        $('#stockmodalcenter').on('shown.bs.modal', function() {
            $('#Jumlah').focus();
        })
    
    

</script>
