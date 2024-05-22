@extends('adminlte::page')

@section('title', 'Permission list')

@section('content_header')
    <h1>Permission</h1>
@stop

@section('content')
    <x-adminlte-card body-class="px-0" theme-mode="outline">
        <div class="px-3 mb-5">
            <button onclick="reloadDT(this)" id="reloadBtn" class="btn btn-sm ml-2 float-sm-right"><i
                    class="las la-sync la-lg"></i></button>

            @can(['add permission'])
                <button class="btn btn-sm btn-outline-primary float-sm-right"
                    onclick="renderPage('{{ route('permission.add') }}', 'formPermissionComponent')" data-toggle="modal"
                    data-target="#modalFormPermission">Tambah permission</button>
            @endcan
        </div>

        <x-datatables.permission-dt />
    </x-adminlte-card>

    <x-adminlte-modal id="modalFormPermission">
        <div id="formPermissionComponent" class="pb-2"></div>
    </x-adminlte-modal>
@stop

@section('css')
    <link rel="stylesheet" href="/css/mystyle.css">
@stop

@section('js')
    <script src="/js/render-page.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        });

        $("#modalFormPermission").on('hide.bs.modal', function() {
            setTimeout($("#formPermissionComponent").html(""), 500);
        });

        $(document).ready(function() {
            $(".modal-footer").addClass("d-none");
        });
    </script>
@stop
