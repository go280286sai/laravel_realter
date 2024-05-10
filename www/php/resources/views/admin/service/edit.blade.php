@extends('admin.layout.layouts')
@section('style')
@endsection
@section('text')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Редактировать услугу
            </h1>
        </section>
        <section class="content">
            <div class="box">
                <form action="{{url('/user/service/'.$service->id)}}" method="post">
                    @method('PUT')
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title"
                                       name="title"
                                       value="{{$service->service}}">
                                @csrf
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <a href="{{url('/user/service')}}" class="btn btn-danger">Назад</a>
                        </div>
                        <input type="submit" class="btn btn-warning pull-right" value="Редактировать">
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $(".select2").select2();
            $('#datepicker').datepicker({
                autoclose: true
            });
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@endsection
