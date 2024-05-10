@extends('admin.layout.layouts')
@section('style')
@endsection
@section('text')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Редактировать пользователя
            </h1>
        </section>
        <section class="content">
            <form action="{{url('/user/users/'.$user->id)}}" method="post">
                @csrf
                @method('PUT')
            <div class="box">
                <div class="box-header with-border">
                    @include('admin.errors')
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label for="birthday">День рождения</label>
                            <input type="date" class="form-control" id="birthday" name="birthday"
                                                                 value="{{$user->birthday}}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Номер телефона</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                      value="{{$user->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="gender_id">Пол</label>
                                <div class="form-control">
                                    <input class="form-check-input" type="radio" name="gender_id" id="gender_id"
                                           value="1" {{($user->gender_id=='1')?'checked':''}}>
                                    <label class="form-check-label" for="gender_id">
                                        Мужской
                                    </label>
                                </div>
                                <div class="form-control">
                                    <input class="form-check-input" type="radio" name="gender_id" id="gender_id"
                                           value="2"
                                        {{($user->gender_id=='2')?'checked':''}}>
                                    <label class="form-check-label" for="gender_id">
                                        Женский
                                    </label>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="description">Обо мне</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$user->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Новый пароль">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <a href="{{url('/user/users')}}" class="btn btn-danger">Назад</a>
                    </div>
                    <button class="btn btn-warning pull-right">Обновить</button>
                </div>
            </div>
            </form>
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
