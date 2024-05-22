<div>
    <form id="formPermitGranting" class="p-0">
        @csrf
        <input type="hidden" class="d-none" name="id" id="id" value="{{ $role->id }}">
        <div class="form-group">
            <label for="name">Nama Role</label>
            <input type="text" class="form-control bg-white" name="name" id="name" value="{{ $role->name }}"
                readonly>
        </div>
        @foreach ($groups as $group_name)
            <label>{{ $group_name }}</label>
            <div class="row">
                @foreach ($permissions as $permission)
                    @if ($permission->group == $group_name)
                        <div class="col-sm-6 col-md-3 mb-2">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="permission_name_{{ $permission->id }}"
                                    name="permission_name[]" value="{{ $permission->name }}"
                                    {{ in_array($permission->id, $set_permissions) ? 'checked' : '' }} />
                                <label for="permission_name_{{ $permission->id }}"
                                    style="font-weight: normal !important;">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach

        <div class="mt-5">
            {{-- <button type="button" class="btn btn-sm btn-outline-danger px-4 cta" data-dismiss="modal">batalkan</button> --}}
            <button type="submit" class="btn btn-sm btn-primary px-4 cta float-right" id="saveBtn">Grant
                Permissions</button>
        </div>
    </form>
</div>

<script>
    $('#formPermitGranting').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('_method', 'PATCH');

        $.ajax({
            type: "POST",
            url: "{{ url('controls/role') }}" + "/" + "{{ $role->id }}" + "/grant-permit",
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
                $('#saveBtn').html('Grant Permissions');
            },
            error: function(res) {
                $(".cta").attr("disabled", false);
                $('#saveBtn').html('Grant Permissions');

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
