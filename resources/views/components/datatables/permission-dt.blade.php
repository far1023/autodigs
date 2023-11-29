<div>
    <table class="table table-striped table-hover dttables" id="permissionTable">
        <thead class="text-xs text-gray">
            <tr>
                <th>#</th>
                <th>Group</th>
                <th>Permission</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('js')
    <script>
        $('#permissionTable').DataTable({
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
            ajax: {
                url: "{{ route('permission.index') }}",
                error: function(xhr, error, code) {
                    $('#permissionTable_processing').hide();
                    $('#reloadBtn').removeClass('icn-spinner');
                    iziToast.error({
                        title: 'Error!',
                        message: "somthing wnet wrong, data not reloaded",
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
                    data: 'group',
                    name: 'group',
                },
                {
                    data: 'name',
                    name: 'name',
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
            $("#permissionTable").DataTable().ajax.reload(null, false);
        }

        $('body').on('click', '.delete', function() {
            if (confirm("Hapus data permission?")) {
                let btn = $(this);

                let html = btn.html();

                btn.attr('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('controls/permission') }}" + "/" + $(this).data("id"),
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
