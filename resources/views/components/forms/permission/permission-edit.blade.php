<div>
    <form id="formEditPermission" class="p-0">
        @csrf
        <input type="hidden" class="d-none" name="id" id="id" value="{{ $permission->id }}">
        <div class="form-group">
            <label for="group">Nama Group</label>
            <input type="text" class="form-control" name="group" id="group" value="{{ $permission->group }}">
            <small class="text-danger err-msg" id="group_error"></small>
        </div>
        <div class="form-group">
            <label for="name">Nama Permission</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $permission->name }}">
            <small class="text-danger err-msg" id="name_error"></small>
        </div>
        <div class="mt-5">
            {{-- <button type="button" class="btn btn-sm btn-outline-danger px-4 cta" data-dismiss="modal">batalkan</button> --}}
            <button type="submit" class="btn btn-sm btn-primary px-4 cta float-right" id="saveBtn">Update data
                permission</button>
        </div>
    </form>
</div>

<script>
    $('#formEditPermission').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('_method', 'PATCH');

        $.ajax({
            type: "POST",
            url: "{{ route('permission.update', $permission->id) }}",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".err-msg").html("");
                $(".form-control").removeClass("is-invalid");
                $(".cta").attr("disabled", true);
                $("#saveBtn").html("<span class='spinner-border spinner-border-sm'></span>");
            },
            success: function(res) {
                if (res.code == 200) {
                    iziToast.success({
                        title: "Stored!",
                        message: res.message,
                        position: "topCenter"
                    });

                    reloadDT();
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: "somthing wnet wrong",
                        position: 'topCenter'
                    });
                }

                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Update data permission');
            },
            error: function(res) {
                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Update data permission');

                iziToast.error({
                    title: 'Error!',
                    message: 'Periksa kembali form isian',
                    position: 'topCenter'
                });

                $.each(res.responseJSON.errors, function(i, val) {
                    $("#" + i + "_error").html(val);
                    $("#" + i).addClass("is-invalid");
                });
            }
        });
    });
</script>
