<div>
    <section class="content-header">
        <h1>
            Добавить объявление
        </h1>
    </section>
    <section class="content">
        <div class="box" id="create_apartment">
            <form action="{{url('/user/addCreate')}}" method="post">
                <div class="box-header with-border">
                    @include('admin.errors')
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            @csrf
                            <label for="title">Название</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}">
                            <label for="rooms">Количество комнат</label>
                            <input type="number" id="rooms" name="rooms" wire:model="rooms" class="form-control" value="{{old('rooms')}}">
                            <label for="floor">Этаж</label>
                            <input type="number" id="floor" name="floor" class="form-control" wire:model="floor" value="{{old('floor')}}">
                            <label for="etajnost">Этажность</label>
                            <input type="number" id="etajnost" name="etajnost" class="form-control" wire:model="etajnost" value="{{old('etajnost')}}">
                            <label for="area">Площадь</label>
                            <input type="number" id="area" name="area" class="form-control" wire:model="area" value="{{old('area')}}">
                            <label for="location">Расположение</label>
                            <br>
                            <select id="location" wire:model="loc" name="location" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option selected >{{old('location')??'Выбрать расположение'}}</option>
                                @foreach($locations as $item)
                                    {{$item}}
                                    <option value="{{$item}}" >{{$item}}</option>
                                @endforeach
                            </select>
                            @if(isset($service->id))
                                <input type="hidden" name="service_id"  value="{{$service->id}}">
                            @endif

                            <br>
                            @if($client)
                                <input type="hidden" id="client_id" name="client_id"  value="{{$client->id}}">
                            @else
                                <label for="location">Contact</label>
                            <br>
                            <select id="client_id" name="client_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option selected>{{old('client_id')??'Контакт'}}</option>
                                @foreach($contacts as $item)
                                    {{$item->last_name.' '.$item->first_name}}
                                    <option value="{{$item->id}}">{{$item->last_name.' '.$item->first_name.' '.$item->surname}}</option>
                                @endforeach
                            </select>
                            <br>
                            @endif
                            <p id="predict_result">Для предварительной оценки, заполните поля выше и нажмите кнопку </p>

                           <input type="button" wire:click="getPredict" class="form-control btn-danger" value="Предварительная оценка"> <br>
                            <strong>Предварительная оценка: </strong><b style="color: red"><input type="text" disabled wire:model="predict"></b><br>
                            <label for="price">Цена, грн.</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{old('price')}}">
                            <br>
                            <label for="title">Описание</label>
                            <textarea id="description" cols="30" name="description" rows="10" class="form-control">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-success pull-right"
                           value="Добавить">
                    <div class="form-group">
                        <a href="{{url('/user/apartment')}}" class="btn btn-danger">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </section></div>
