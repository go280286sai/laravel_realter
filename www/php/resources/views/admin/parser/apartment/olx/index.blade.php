@extends('admin.layout.layouts')

@section('style')
    <link rel="stylesheet" href="{{asset('/assets/plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('text')
   <livewire:main-olx-model />
@endsection

@section('js')
    <script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
            integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
@endsection