<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Редактировать пользователя
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    @if (session('status'))
                        <div class="alert alert-success">
                          <h3> {{ session('status') }}</h3>
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div>
                            <img  class="profile_logo" src="{{\Illuminate\Support\Facades\Storage::disk('public')->url($user->profile_photo_path)}}" alt="">
                        </div>
                        <form action="{{url('/user/updateProfile')}}" method="post" enctype="multipart/form-data">

                            <input type="file"  name="photo" class="form-control mb-2 mt-2">
                            @csrf
                            <button class="btn btn-success" type="submit">Save photo</button>
                        </form>

                        <form wire:submit="save">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   wire:model="name">
                            <div>
                                @error('name') <span class="error red">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthday">День рождения</label>
                            <input type="date" class="form-control" id="birthday" name="birthday"
                                  wire:model="birthday">
                            <div>
                                @error('birthday') <span class="error red">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Номер телефона</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                   wire:model="phone">
                            <div>
                                @error('phone') <span class="error red">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender_id">Пол</label>
                            <div class="form-control">
                                <input class="form-check-input" wire:@if('gender_id'=='1'?'checked':'') @endif   type="radio" name="gender_id" id="gender_id" wire:model="gender_id" value="1">
                                <label class="form-check-label" for="gender_id">
                                    Мужской
                                </label>
                            </div>
                            <div class="form-control">
                                <input class="form-check-input" type="radio" name="gender_id" id="gender_id" wire:@if('gender_id'=='2'?'checked':'') @endif
                                       value="2" wire:model="gender_id">
                                <label class="form-check-label" for="gender_id">
                                    Женский
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Обо мне</label>
                            <textarea name="description" id="description" cols="5" rows="10" class="form-control"
                                      wire:model="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Новый пароль" wire:model="password">
                        </div>
                            <div wire:loading>
                                <svg>...</svg> <!-- SVG loading spinner -->
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.box-body -->

                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
