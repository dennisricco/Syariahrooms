@extends('master.layouts.dashboard')

@section('title', 'Transaksi | syariahrooms')

@section('content')
    <div class="row">
        <h3 class="my-16">Data Transaksi</h3>
        <div class="col">
            <div class="card card-body">
                <div class="col">
                    <div class="row justify-content-between my-10 gap-10 px-0">
                        <div class="row mx-md-0 col-auto mx-auto gap-10">
                            @can('transaction-store')
                                <button class="btn btn-primary col col-sm-auto add-transaksi"><i
                                        class="ri-add-line remix-icon"></i><span>Tambah Transaksi</span></button>
                            @endcan
                        </div>
                        <div class="mx-md-0 col-auto mx-auto">
                            <div class="input-group align-items-center">
                                <span class="input-group-text hp-bg-dark-100 border-end-0 pe-0 bg-white">
                                    <i class="iconly-Light-Search text-black-80" style="font-size: 16px;"></i>
                                </span>
                                <input class="form-control border-start-0 ps-8" id="search_transaksi"
                                    name="search_transaksi" type="text" value="" placeholder="Search Transaksi">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mitra</th>
                                    <th>Membership</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Bayar Sekarang</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aktif</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_transaksi">
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <nav class="col-12 col-sm-auto text-center pagination_transaksi"
                            aria-label="Page navigation example">
                        </nav>
                        <br>
                        <p class="transaksi_entry"></p>
                    </div>
                </div>
            </div>
        </div>
    @section('modal')
        <div class="modal fade" id="modalTransaksi" aria-labelledby="modalTransaksi" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formTransaksi">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTransaksiLabel">Tambah Transaksi</h5>
                            <button class="btn-close hp-bg-none d-flex align-items-center justify-content-center"
                                data-bs-dismiss="modal" type="button" aria-label="Close">
                                <i class="ri-close-line hp-text-color-dark-0 lh-1" style="font-size: 24px;"></i>
                            </button>
                        </div>
                        <div class="modal-body body-transaksi">
                            <input class="transaksi_id" id="transaksi_id" name="id" type="text" hidden>
                            {{-- <div class="form-group">
                                <label for="nama_mitra">Nama Mitra:</label>
                                <select class="form-select nama_mitra" id="nama_mitra" name="user_id">
                                    <option value="" disabled>Pilih Nama Mitra</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }} </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="membership">Membership:</label>
                                <select class="form-select" id="membership" name="membership_id">
                                    <option value="" disabled>Pilih Nama Membership</option>
                                    @foreach ($memberships as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @can('transaction-store')
                                <button type="submit" class="btn btn-primary btn-save-transaksi"><i
                                        class="icofont icofont-plus"></i>Simpan</button>
                            @endcan
                            @can('transaction-update')
                                <button class="btn btn-primary btn-edit-transaksi" type="submit"><i
                                        class="icofont icofont-pencil"></i> Edit</button>
                            @endcan
                            @can('transaction-destroy')
                                <button class="btn btn-danger btn-delete-transaksi" type="button"><i
                                        class="icofont icofont-trash"></i> Hapus</button>
                                <button class="btn btn-outline-danger btn-lepas-membership" type="button"><i
                                    class="icofont icofont-box"></i>Lepas Membership</button>
                            @endcan
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection
</div>
@endsection

@section('js')
<script src="{{ asset('app-assets/js/pagination/pagination.js') }}"></script>
<script>
    @canany(['transaction-store', 'transaction-update'])
        $('#formTransaksi').unbind('submit');
    @endcanany
    $(function() {
        $('.role').select2({
            theme: 'bootstrap4',
            dropdownParent: '#modalTransaksi'
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        loadTransaksi(1);
    });

    function pageTransaksi(totalPages, visiblePages) {
        $(".pagination_transaksi").twbsPagination({
            totalPages: totalPages,
            visiblePages: visiblePages,
            paginationClass: 'pagination justify-content-center mr-6',
            pageClass: 'transaksiPageLink',
            onPageClick: function(event, p) {
                loadTransaksi(p);
            }
        });
    }

    function loadTransaksi(page, search) {
        search = $('#search_transaksi').val();
        $.ajax({
            type: "get",
            url: "{{ route('dashboard.transaction.data') }}",
            data: {
                'search': search,
                'page': page,
            },
            success: function(res) {
                var entry = `
                Menampilkan ${res.from ?? 0} sampai ${res.to ?? 0} dari ${res.total ?? 0} entri
            `;
                $('.transaksi_entry').text(entry);

                if (res.data.total > 0) {
                    pageTransaksi(res.data.last_page, 5);
                } else {
                    pageTransaksi(res.data.last_page, res.data.last_page);
                }

                let data = '';
                if (res.data.length > 0) {
                    $.each(res.data, (k, v) => {
                        let payButton = '';
                        if (v.status === 'pending') {
                            payButton = `<td>
                                            <button id="pay-button" class="btn btn-sm btn-primary pay-button" title="Bayar-${v.user_name}-${v.membership_name}" data-snap-token="${v.snap_token}">
                                                <i class="icofont icofont-money"></i>
                                            </button>
                                        </td>`;
                        } else if (v.status === 'success') {
                            payButton = '<td>Sudah dibayar</td>'
                        } else {
                            payButton = '<td>Pembayaran gagal</td>'
                        }
                        data += `<tr>
                        <td scope="row">${k+1}</td>
                        <td>${v.user_name}</td>
                        <td>${v.membership_name}</td>
                        <td>${v.start_date == null ? '-' : v.start_date}</td>
                        <td>${v.finish_date == null ? '-' : v.finish_date}</td>                           
                        ${payButton}
                        <td>${v.status}</td>
                        <td>${v.membership_active == 1 ? 'Aktif' : 'Tidak Aktif'}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary detail-transaksi" title="Detail" data-id="${v.id}">
                                <i class="icofont icofont-gear"></i>
                            </button>
                        </td>
                    </tr>`;
                    });
                    $('#tbody_transaksi').html(data);
                } else {
                    data = `
                    <tr>
                        <td class="text-center" colspan="7">Data Kosong</td>
                    </tr>
                `;
                    $('#tbody_transaksi').html(data);
                    $('.transaksi_entry').empty();
                }
            },
            error: function(request, status, error) {
                let errorData = JSON.parse(request.responseText);
            }
        });
    }


    $('#search_transaksi').keyup(delay(function(e) {
        let search_transaksi = $(this).val();
        $(".pagination_transaksi").twbsPagination('destroy');
        loadTransaksi(1, search_transaksi);
    }, 250));

    $('.add-transaksi').on('click', function() {
        $('#modalTransaksiLabel').html('Tambah Transaksi')
        $('.btn-save-transaksi').show();
        $('.btn-edit-transaksi').hide();
        $('.btn-delete-transaksi').attr('data-id', 0);
        $('.btn-delete-transaksi').hide();
        $('.btn-lepas-membership').hide();
        $('#formTransaksi').trigger('reset');
        $('.select2').val('').trigger('change')
        $('.password').attr('required', true)
        $('#modalTransaksiLabel').html('Tambah Transaksi')
        $('#modalTransaksi').modal('show');
    });

    var deleteTransactionId;

    $('body').on('click', '.detail-transaksi', function() {
        var id = $(this).data('id');
        $.get("{{ route('dashboard.transaction.show', ':id') }}".replace(':id', id), function(data) {
            $('.transaksi_id').val(data.data.id)
            $('.user_id').val(data.data.user_id)
            $('.membership_id').val(data.data.membership_id)
            $('.start_date').val(data.data.start_date)
            $('.finish_date').val(data.data.finish_date)
            $('.membership_active').val(data.data.membership_active)
            $('.password').attr('required', false)
            $('.btn-save-transaksi').hide()
            deleteTransactionId = data.data.id;
            $('.btn-lepas-membership').show()
            $('.btn-edit-transaksi').show()
            $('.btn-delete-transaksi').show()
            $('#modalTransaksiLabel').html('Edit Transaksi')
            $('#modalTransaksi').modal('show')
        });
    });


    $('#formTransaksi').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            data: formData,
            url: "{{ route('dashboard.transaction.store') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $(this).trigger("reset");
                $('#modalTransaksi').modal('hide');
                swal("Success...", data.message, "success");
                loadTransaksi(1);
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON.message;
                swal("Error...", errorMessage, "error");
            }
        });
    });

    $('.btn-lepas-membership').on('click', function() {
        var id = deleteTransactionId;
        var url = "{{ route('dashboard.transaction.nonActiveMembership', ['id' => ':id']) }}";
        url = url.replace(':id', id);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle response data if needed
            console.log(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });

    $('.btn-delete-transaksi').on('click', function() {
        var id = deleteTransactionId;
        swal({
                title: "Apakah Anda yakin?",
                text: "Anda tidak akan dapat mengembalikan tindakan ini!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('dashboard.transaction.destroy', ':id') }}".replace(':id',
                            id),
                        success: function(data) {
                            $('#modalTransaksi').modal('hide');
                            swal("Success...", data.message, "success");
                            loadTransaksi(1);
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.message;
                            swal("Error...", errorMessage, "error");
                        }
                    });
                } else {
                    swal("Penghapusan dibatalkan.", {
                        icon: "info",
                    });
                }
            });
    });
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key={{ env('MIDTRANS_CLIENT_KEY') }}></script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.pay-button', function() {
            var snapToken = $(this).data('snap-token');
            snap.pay(snapToken, {
                // Fungsi callback opsional
                onSuccess: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(
                        result, null, 2);
                },
                onPending: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(
                        result, null, 2);
                },
                onError: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(
                        result, null, 2);
                }
            });
        });
    });
</script>

@endsection
