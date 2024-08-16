@extends('adminlte::page')

@section('title', 'User list')

@section('content_header')
    <div>
        <button onclick="reloadDT(this)" id="reloadBtn" class="btn btn-sm"><i class="las la-sync la-lg"></i></button><span
            class="text-lg">User</span>

        @can(['add user'])
            <button class="btn btn-sm px-4 btn-success float-sm-right"
                onclick="renderPage('{{ route('user.add') }}', 'formUserComponent')" data-toggle="modal"
                data-target="#modalFormUser">Add User</button>
        @endcan
    </div>
@stop

@section('content')
    <x-datatables.user-dt />

    <x-adminlte-modal id="modalFormUser">
        <div id="formUserComponent" class="pb-2"></div>
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
            setTimeout($("#formUserComponent").html(""), 500);
        });

        $(document).ready(function() {
            $(".modal-footer").addClass("d-none");
        });
    </script>
@stop
