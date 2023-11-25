<div>
    <form id="formAddRole" class="p-0">
        @csrf
        <div class="form-group">
            <label for="name">Nama Role</label>
            <input type="text" class="form-control" name="name" id="name">
            <small class="text-danger err-msg" id="name_error"></small>
        </div>
        <div class="mt-5">
            <button type="button" class="btn btn-sm btn-outline-danger px-4 cta" data-dismiss="modal">batalkan</button>
            <button type="submit" class="btn btn-sm btn-primary px-4 cta float-right" id="saveBtn">Tambahkan
                role</button>
        </div>
    </form>
</div>

<script>
    $('#formAddRole').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{ route('role.store') }}",
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
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: "somthing wnet wrong",
                        position: 'topCenter'
                    });
                }

                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Tambahkan role');
            },
            error: function(res) {
                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Tambahkan role');

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
