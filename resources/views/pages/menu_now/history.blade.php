<x-base-layout>

    <div class="container" style="overflow-x:auto;">
        <div class="card p-5">
            <div class="row">
                <div class="col-9" align="left">
                    <h1>History</h1>
                </div>
            </div>

            <hr>

            <!--begin::Accordion-->
            <div class="accordion" id="kt_accordion_1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_1">
                        <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                            History Transaksi
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div style="overflow-x:auto;">
                                <table id="kt_datatable_zero_configuration1" class="table table-row-bordered gy-5 p-5">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="text-center">Transaction ID</th>
                                            <th class="text-center">Total Barang</th>
                                            <th class="text-center">Total Harga</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_history as $history_trans)
                                        <tr>
                                            <td class="text-center">{{ $history_trans->id }}</td>
                                            <td class="text-center">{{ $history_trans->total_qty }}</td>
                                            <td class="text-center">{{ $history_trans->total_harga }}</td>
                                            <td class="text-center"><button class="btn btn-primary">Detail</button></td>
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
                        History Barang
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div style="overflow-x:auto;">
                                <table id="kt_datatable_zero_configuration2" class="table table-row-bordered gy-5 p-5">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Nama Product</th>
                                            <th class="text-center">Pengirim</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_history_barang as $history_bar)
                                        <tr>
                                            <td class="text-center">{{ $history_bar->created_at }}</td>
                                            <td class="text-center">{{ $history_bar->nama_produk }}</td>
                                            <td class="text-center">{{ $history_bar->Pengirim }}</td>
                                            <td class="text-center">{{ $history_bar->Jumlah }}</td>
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
    </div>
    

</x-base-layout>

<script>
    $("#kt_datatable_zero_configuration1").DataTable({
        "ordering": false,
    });
    $("#kt_datatable_zero_configuration2").DataTable({
        "ordering": false,
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
</script>
