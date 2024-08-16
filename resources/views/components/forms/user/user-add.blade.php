<div>
    <form id="formAddUser" class="p-0">
        @csrf
        <div class="form-group">
            <label class="text-sm" for="name">Nama Pengguna</label>
            <input type="text" class="form-control" name="name" id="name">
            <small class="text-danger err-msg" id="name_error"></small>
        </div>
        <div class="form-group">
            <label class="text-sm" for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username">
            <small class="text-danger err-msg" id="username_error"></small>
        </div>
        <div class="form-group">
            <label class="text-sm" for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email">
            <small class="text-danger err-msg" id="email_error"></small>
        </div>
        <div class="form-group">
            <label class="text-sm" for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
            <small class="text-danger err-msg" id="password_error"></small>
        </div>
        <div class="form-group">
            <label class="text-sm" for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
            <small class="text-danger err-msg" id="password_confirmation_error"></small>
        </div>
        <div class="mt-5 float-right">
            <button type="button" class="btn btn-sm px-3 cta" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-sm btn-success px-4 cta" id="saveBtn">Add User</button>
        </div>
    </form>
</div>

<script>
    $('#formAddUser').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{ route('user.store') }}",
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

                    $("#modalFormUser").modal("hide");
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: "somthing wnet wrong",
                        position: 'topCenter'
                    });
                }

                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Add User');
            },
            error: function(res) {
                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Add User');

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
