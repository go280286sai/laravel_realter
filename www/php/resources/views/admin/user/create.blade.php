@extends('admin.layout.layouts')
@section('style')
@endsection
@section('text')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Добавить пользователя
      </h1>
    </section>
    <section class="content">
        <form action="{{url('/user/users')}}" method="post">
            @csrf
      <div class="box">
        <div class="box-header with-border">
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Пользователь</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Пользователь" value="{{old('name')}}">
            </div>
              <div class="form-group">
                  <label for="birthday">Дата рождения</label>
                  <label for="birthday"></label><input type="date" class="form-control" id="birthday" name="birthday"
                                                       placeholder="Дата рождения" value="{{old('birthday')}}">
              </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{old('email')}}">
            </div>
              <div class="form-group">
                  <label for="phone">Номер телефона</label>
                  <input type="number" class="form-control" id="phone" name="phone"
                         placeholder="Номер телефона" value="{{old('phone')}}">
              </div>
              <div class="form-group">
                  <label for="gender_id">Пол</label>
                  <div class="form-control">
                      <input class="form-check-input" type="radio" name="gender_id" id="gender_id"
                             value="2">
                      <label class="form-check-label" for="gender_id">
                          Мужской
                      </label>
                  </div>
                  <div class="form-control">
                      <input class="form-check-input" type="radio" name="gender_id" id="gender_id"
                             value="3">
                      <label class="form-check-label" for="gender_id">
                          Женский
                      </label>
                  </div>
              </div>
              <div class="form-group">
                  <label for="description">Обо мне</label>
                 <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{old('description')}}</textarea>
              </div>
            <div class="form-group">
              <label for="password">Пароль</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
            </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="form-group">
                <a href="{{url('/user/users')}}" class="btn btn-danger">Назад</a>
            </div>
          <button class="btn btn-success pull-right">Добавить</button>
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
