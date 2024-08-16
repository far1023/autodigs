<div class="table-responsive">
    <table class="table table-hover" id="roleTable">
        <thead class="text-xs text-gray">
            <tr>
                <th>#</th>
                <th>Nama Role</th>
                <th>Permissions</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('js')
    <script>
        $('#roleTable').DataTable({
            lengthChange: false,
            searching: false,
            info: true,
            paging: true,
            autoWidth: false,
            bDestroy: true,
            aaSorting: [],
            processing: true,
            serverSide: true,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            drawCallback: function(settings) {
                $('#reloadBtn').removeClass('icn-spinner');
            },
            ajax: {
                url: "{{ route('role.index') }}",
                error: function(xhr, error, code) {
                    $('#roleTable_processing').hide();
                    $('#reloadBtn').removeClass('icn-spinner');
                    iziToast.error({
                        title: 'Error!',
                        message: "somthing wnet wrong, data not loaded",
                        position: 'topCenter'
                    });
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'permissions',
                    name: 'permissions',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false
                },
            ]
        });

        const reloadDT = (ref = null) => {
            (ref) ? $(ref).addClass('icn-spinner'): '';
            $("#roleTable").DataTable().ajax.reload(null, false);
        }

        $('body').on('click', '.edit', function() {
            renderPage($(this).data('url'), 'formRoleComponent');
        });

        $('body').on('click', '.grant-permissions', function() {
            renderPage($(this).data('url'), 'formPermitGrantingComponent');
        });

        $('body').on('click', '.delete', function() {
            if (confirm("Hapus data role?")) {
                let btn = $(this);

                let html = btn.html();

                btn.attr('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('controls/role') }}" + "/" + $(this).data("id"),
                    dataType: "json",
                    success: function(res) {
                        if (res.code == 200) {
                            iziToast.success({
                                title: 'Done!',
                                message: res.message,
                                position: 'topCenter'
                            });

                            reloadDT();

                            btn.attr('disabled', false).html(html);
                        } else {
                            iziToast.error({
                                title: 'Error!',
                                message: "somthing wnet wrong",
                                position: 'topCenter'
                            });
                        }
                    },
                    error: function(res) {
                        btn.attr('disabled', false).html(html);

                        iziToast.error({
                            title: 'Error!',
                            message: res.responseJSON.message,
                            position: 'topCenter'
                        });
                    }
                });
            }
        });
    </script>
@endpush
