@extends('master.layouts.dashboard')

@section('title', 'Membership | syariahrooms')

@section('content')
    <div class="row">
        <h3 class="my-16">Paket / Membership</h3>
        <div class="col">
            <div class="card card-body">
                <div class="col">
                    <div class="row justify-content-between my-10 gap-10 px-0">
                        <div class="row mx-md-0 col-auto mx-auto gap-10">
                            @can('membership-store')
                            <button class="btn btn-primary col col-sm-auto add-membership"><i
                                    class="ri-add-line remix-icon"></i><span>Tambah Membership</span></button>
                            @endcan
                        </div>
                        <div class="mx-md-0 col-auto mx-auto">
                            <div class="input-group align-items-center">
                                <span class="input-group-text hp-bg-dark-100 border-end-0 pe-0 bg-white">
                                    <i class="iconly-Light-Search text-black-80" style="font-size: 16px;"></i>
                                </span>
                                <input class="form-control border-start-0 ps-8" id="search_membership"
                                    name="search_membership" type="text" value="" placeholder="Search Membership">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Fitur</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_membership">
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <nav class="col-12 col-sm-auto text-center pagination_membership"
                                aria-label="Page navigation example">
                            </nav>
                            <br>
                            <p class="membership_entry"></p>
                        </div>
                    </div>
                </div>
            </div>
        @section('modal')
            <div class="modal fade" id="modalMembership" aria-labelledby="modalMembership" aria-hidden="true"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="formMembership">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalMembershipLabel">Tambah Membership</h5>
                                <button class="btn-close hp-bg-none d-flex align-items-center justify-content-center"
                                    data-bs-dismiss="modal" type="button" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1" style="font-size: 24px;"></i>
                                </button>
                            </div>
                            <div class="modal-body body-membership">
                                <input class="membership_id" id="membership_id" name="id" type="text" hidden>
                                <div class="form-group mb-12">
                                    <label for="name">Nama</label>
                                    <input class="form-control name" id="name" name="name" type="text"
                                        placeholder="Nama" required>
                                </div>
                                <div class="form-group mb-12">
                                    <label for="price">Harga</label>
                                    <input class="form-control price" id="price" name="price" type="number"
                                        placeholder="Harga" required>
                                </div>
                                <div class="form-group mb-12">
                                    <label for="fitur">Fitur</label>
                                    <input class="form-control fitur" id="fitur" name="fitur" type="text"
                                        placeholder="Fitur" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @can('membership-store')
                                <button class="btn btn-primary btn-save-membership" type="submit"><i
                                        class="icofont icofont-plus"></i> Tambah</button>
                                @endcan
                                @can('membership-update')
                                <button class="btn btn-primary btn-edit-membership" type="submit"><i
                                        class="icofont icofont-pencil"></i> Edit</button>
                                @endcan
                                @can('membership-destroy')
                                <button class="btn btn-danger btn-delete-membership" type="button"><i
                                        class="icofont icofont-trash"></i> Hapus</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection

    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('app-assets/js/pagination/pagination.js') }}"></script>
<script type="text/javascript">
    @canany(['membership-store', 'membership-update'])
        $('#formMembership').unbind('submit');
    @endcanany
    $(function() {
        $('.role').select2({
            theme: 'bootstrap4',
            dropdownParent: '#modalMembership'
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        loadMembership(1)
    })

    function pageMembership(totalPages, visiblePages) {
        $(".pagination_membership").twbsPagination({
            totalPages: totalPages,
            visiblePages: visiblePages,
            paginationClass: 'pagination justify-content-center mr-6',
            pageClass: 'membershipPageLink',
            onPageClick: function(event, p) {
                loadMembership(p)
            }
        })
    }

    function loadMembership(page, search) {
        search = $('#search_membership').val()
        $.ajax({
            type: "get",
            url: "{{ route('dashboard.membership.data') }}",
            data: {
                'search': search,
                'page': page
            },
            success: function(res) {
                var entry =
                    `Menampilkan ${res.from ?? 0} sampai ${res.to ?? 0} dari ${res.total ?? 0} entri`;
                $('.membership_entry').text(entry);

                if (res.data.total > 50) {
                    pageMembership(res.data.last_page, 5);
                } else {
                    pageMembership(res.data.last_page, res.data.last_page);
                }

                let data = '';
                if (res.data.length > 0) {
                    $.each(res.data, function(k, v) {
                        action =
                            `<button class="btn btn-sm btn-primary detail-membership" title="Detail" data-id="${v.id}"><i class="icofont icofont-gear"></i></button>`;
                        data += `<tr>
                        <td scope="row">${k+1}</td>
                        <td>${v.name}</td>
                        <td>${v.price}</td>
                        <td>${v.fitur}</td>
                        <td class="text-center">${action}</td>
                    </tr>`;
                    });
                    $('#tbody_membership').html(data);
                } else {
                    data = `<tr>
                    <td class="text-center" colspan="5">Data Kosong</td>
                </tr>`;
                    $('#tbody_membership').html(data);
                    $('.membership_entry').empty();
                }
            },
            error: function(request, status, error) {
                let errorData = JSON.parse(request.responseText);
            }
        });
    }


    $('#search_membership').keyup(delay(function(e) {
        let search_membership = $(this).val()
        $(".pagination_membership").twbsPagination('destroy')
        loadMembership(1, search_membership)
    }, 250))

    $('.add-membership').on('click', function() {
        $('#modalMembershipLabel').html('Tambah Membership')
        $('.btn-save-membership').show()
        $('.btn-edit-membership').hide()
        $('.btn-delete-membership').attr('data-id', 0)
        $('.btn-delete-membership').hide()
        $('#formMembership').trigger('reset')
        $('.select2').val('').trigger('change')
        $('.password').attr('required', true)
        $('#modalMembershipLabel').html('Tambah Membership')
        $('#modalMembership').modal('show')
    })

    var deleteMembershipId;

    $('body').on('click', '.detail-membership', function() {
        var id = $(this).data('id')
        $.get("{{ route('dashboard.membership.show', ':id') }}".replace(':id', id), function(data) {
            $('#modalMembershipLabel').html('Atur Membership')
            $('.membership_id').val(data.data.id)
            $('.name').val(data.data.name)
            $('.price').val(data.data.price)
            $('.fitur').val(data.data.fitur)
            $('.password').attr('required', false)
            $('.btn-save-membership').hide()
            deleteMembershipId = data.data.id;
            $('.btn-edit-membership').show()
            $('.btn-delete-membership').show()
            $('#modalMembershipLabel').html('Edit Membership')
            $('#modalMembership').modal('show')
        })
    })

    $('#formMembership').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            data: $(this).serialize(),
            url: "{{ route('dashboard.membership.store') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $(this).trigger("reset")
                $('#modalMembership').modal('hide')
                swal("Success...", data.message, "success")
                loadMembership(1)
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON.message;
                swal("Error...", errorMessage, "error");
            }
        })
    })

    $('.btn-delete-membership').on('click', function() {
    var id = deleteMembershipId;
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
                        url: "{{ route('dashboard.membership.destroy', ':id') }}".replace(':id',
                            id),
                        success: function(data) {
                            $('#modalMembership').modal('hide');
                            swal("Success...", data.message, "success");
                            loadMembership(1);
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
@endsection
