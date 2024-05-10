@extends('admin.layout.layouts')
@section('style')
@endsection
@section('text')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Отправить сообщение
            </h1>
        </section>
        <section class="content">
            <div class="box">
                <form action="{{url('/user/sendMessageClient')}}" method="post">
                    <div class="box-header with-border">
                        @include('admin.errors')
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Кому</label>
                                <input type="text" class="form-control" id="email" value="{{$user['email']}}" disabled="disabled">
                                <input type="hidden" class="form-control" value="{{$user['email']}}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="title">Тема</label>
                                <input type="text" class="form-control" id="title" placeholder="Тема" name="title">
                            </div>
                            <div class="form-group">
                                @csrf
                                <label for="content">Текст сообщения</label>
                                <textarea id="content" cols="30" rows="10" class="form-control"
                                          name="content">{{old('content')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <a href="{{url('/user/client')}}" class="btn btn-danger">Назад</a>
                        </div>
                        <input type="submit" class="btn btn-success pull-right" name="submit" value="Отправить">
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
