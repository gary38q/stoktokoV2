<x-base-layout>

    <div class="container card p-5" style="overflow-x:auto;">
        <h1>Pengiriman</h1>
        <hr>
        
            <!--begin::Accordion-->
            <div class="accordion" id="kt_accordion_1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_1">
                        <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                            Menunggu Pengiriman
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div style="overflow-x:auto;">
                                    <table id="mytabletunggu" class="table table-row-bordered gy-5">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800">
                                                <th class="text-center">Transaction ID</th>
                                                <th class="text-center">Tanggal Transaksi</th>
                                                <th class="text-center">Nama Penerima</th>
                                                <th class="text-center">Alamat Penerima</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengiriman as $waitPengiriman)
                                                <tr>
                                                    @if($waitPengiriman->status_pengiriman == 1)
                                                    <td class="text-center">{{ $waitPengiriman->id_history_transaksi }}</td>
                                                    <td class="text-center">{{ $waitPengiriman->created_date }}</td>
                                                    <td class="text-center">{{ $waitPengiriman->nama_penerima }}</td>
                                                    <td class="text-center">{{ $waitPengiriman->alamat_penerima }}</td>
                                                    <td align="center"><button class="btn btn-primary" onclick="detail_pengiriman('{{ $waitPengiriman->id }}')">Kirim</button><button class="btn btn-danger" onclick="delete_pengiriman('{{ $waitPengiriman->id_history_transaksi }}','{{ $waitPengiriman->nama_penerima }}')">Batal</button></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_2">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                        Dalam Pengiriman
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div style="overflow-x:auto;">
                                <table id="mytablepengiriman" class="table table-row-bordered gy-5">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="text-center">Transaction ID</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Nama Penerima</th>
                                            <th class="text-center">Alamat Penerima</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengiriman as $inPengiriman)
                                        <tr>
                                            @if($inPengiriman->status_pengiriman == 2)
                                            <td class="text-center">{{ $inPengiriman->id_history_transaksi }}</td>
                                            <td class="text-center">{{ $waitPengiriman->created_date }}</td>
                                            <td class="text-center">{{ $inPengiriman->nama_penerima }}</td>
                                            <td class="text-center">{{ $inPengiriman->alamat_penerima }}</td>
                                            <td align="center"><button class="btn btn-primary" onclick="detail_pengiriman('{{ $inPengiriman->id }}')">Detail</button></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_3">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_3" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                        Pengiriman Selesai
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_3" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_3" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div style="overflow-x:auto;">
                                <table id="mytableselesai" class="table table-row-bordered gy-5">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="text-center">Transaction ID</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Nama Penerima</th>
                                            <th class="text-center">Alamat Penerima</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengiriman as $donePengiriman)
                                        <tr>
                                            @if($donePengiriman->status_pengiriman == 3)
                                            <td class="text-center">{{ $donePengiriman->id_history_transaksi }}</td>
                                            <td class="text-center">{{ $waitPengiriman->created_date }}</td>
                                            <td class="text-center">{{ $donePengiriman->nama_penerima }}</td>
                                            <td class="text-center">{{ $donePengiriman->alamat_penerima }}</td>
                                            <td align="center"><button class="btn btn-primary" onclick="detail_pengiriman('{{ $donePengiriman->id }}')">Detail</button></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Accordion-->
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
    $('#mytabletunggu').DataTable({
        dom: '<"top"f>rt<"bottom"ip><"clear">',
    });

    $('#mytablepengiriman').DataTable({
        dom: '<"top"f>rt<"bottom"ip><"clear">',
    });

    $('#mytableselesai').DataTable({
        dom: '<"top"f>rt<"bottom"ip><"clear">',
    });
});
    
    function detail_pengiriman(id){
        $('#nama_barang').text(nama);
        $('#harga_barang').text(harga);
        $('#stock_barang').text(stock);
        $('#cart_SKU').val(id);
        $('#exampleModalCenter').modal('show');
    }

    $('#exampleModalCenter').on('shown.bs.modal', function() {
        $('#Jumlah').focus();
    })

    
    function delete_pengiriman(id, name) {
        
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