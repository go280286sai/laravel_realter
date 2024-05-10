@extends('admin.layout.layouts')
@section('style')
@endsection
@section('text')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Добавить комментарий</h1>
        </section>
        <section class="content">
            <div class="box">
                <form action="{{url('/user/client_comment_add')}}" method="post">
                    <div class="box-header with-border">
                        @include('admin.errors')
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                @csrf
                                <input type="hidden" name="id" value="{{$comment->id}}">
                                <label for="comment"></label>
                                <textarea id="comment" cols="30" rows="10" class="form-control"
                                          name="comment">{{$comment->comment}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
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
