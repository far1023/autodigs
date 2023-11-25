<div>
    <table class="table table-striped table-hover dttables" id="userTable">
        <thead class="text-xs text-gray">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('js')
    <script>
        $('#userTable').DataTable({
            bDestroy: true,
            aaSorting: [],
            paging: true,
            lengthChange: false,
            searching: true,
            info: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            drawCallback: function(settings) {
                $('#reloadBtn').removeClass('icn-spinner');
            },
            ajax: "{{ route('user.index') }}",
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
                    data: 'username',
                    name: 'username',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false
                },
            ]
        });

        const reload = (ref = null) => {
            (ref) ? $(ref).addClass('icn-spinner'): '';
            $("#userTable").DataTable().ajax.reload(null, false);
        }

        $('body').on('click', '.delete', function() {
            if (confirm("Hapus data pengguna?")) {
                let btn = $(this);

                let html = btn.html();

                btn.attr('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('pengguna') }}" + "/" + $(this).data("id"),
                    dataType: "json",
                    success: function(res) {
                        if (res.code == 200) {
                            iziToast.success({
                                title: 'Done!',
                                message: res.message,
                                position: 'topCenter'
                            });

                            reload();

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
