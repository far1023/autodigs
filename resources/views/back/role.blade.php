@extends('adminlte::page')

@section('title', 'Role list')

@section('content_header')
    <h1>Role</h1>
@stop

@section('content')
    <x-adminlte-card body-class="px-0" theme-mode="outline">
        <div class="px-3 mb-5">
            <button onclick="reloadDT(this)" id="reloadBtn" class="btn btn-sm ml-2 float-sm-right"><i
                    class="las la-sync la-lg"></i></button>

            @can(['add role'])
                <button class="btn btn-sm btn-outline-primary float-sm-right"
                    onclick="renderPage('{{ route('role.add') }}', 'formRoleComponent')" data-toggle="modal"
                    data-target="#modalFormRole">Tambah role</button>
            @endcan
        </div>

        <x-datatables.role-dt />
    </x-adminlte-card>

    <x-adminlte-modal id="modalFormRole">
        <div id="formRoleComponent" class="pb-2"></div>
    </x-adminlte-modal>

    <x-adminlte-modal id="modalFormPermitGranting" size="lg">
        <div id="formPermitGrantingComponent" class="pb-2"></div>
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

        $("#modalFormUser").on('hide.bs.modal', function() {
            $("#formRoleComponent").html("");
        });

        $("#modalFormPermitGranting").on('hide.bs.modal', function() {
            $("#formPermitGrantingComponent").html("");
        });

        $(document).ready(function() {
            $(".modal-footer").addClass("d-none");
        });
    </script>
@stop
