<div>
    <section class="content">
        <div class="box" id="create_apartment">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        @csrf
                        <br>
                        <label class="form-label" for="client_id">Выбрать клиента</label>
                        <br>
                        <select disabled="disabled" id="client_id" name="client_id"
                                class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <option value="{{$doc->client_id}}"
                                    selected>{{$doc->client->last_name.' '.$doc->client->first_name.' '.$doc->client->surname}}</option>
                            @foreach($contacts as $item)
                                {{$item->last_name.' '.$item->first_name.' '.$item->surname}}
                                <option
                                    value="{{$item->id}}">{{$item->last_name.' '.$item->first_name.' '.$item->surname}}</option>
                            @endforeach
                        </select>
                        <br>
                        <label class="form-label" for="service_id">Выбрать услугу</label>
                        <br>
                        <select disabled="disabled" id="service_id" name="service_id"
                                class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <option value="{{$doc->service_id}}" selected>{{$doc->service->service}}</option>
                            @foreach($service as $item)
                                {{$item->service}}
                                <option value="{{$item->id}}">{{$item->service}}</option>
                            @endforeach
                        </select>
                        <br>
                        <label class="form-label" for="rooms">Количество комнат</label>
                        <input type="number" id="rooms" name="rooms" class="form-control" disabled="disabled" wire:model="rooms"
                               value="{{$doc->rooms}}">
                        <label for="etajnost">Этажность</label>
                        <input type="number" id="etajnost" name="etajnost" class="form-control" disabled="disabled"
                               value="{{$doc->etajnost}}" wire:model="etajnost">
                        <label for="location">Расположение</label>
                        <br>
                        <input type="text" name="" id="" wire:model="location" class="form-control" disabled="disabled">
                        <br>
                        <label for="price">Цена, грн.</label>
                        <input type="number" id="price" name="price" class="form-control" disabled="disabled"
                               value="{{$doc->price}}" wire:model="price">
                        <br>
                        <label for="title">Комментарий</label>
                        <textarea disabled="disabled" id="comment" cols="30" name="comment" rows="10"
                                  class="form-control">{{$doc->comment??''}}</textarea>
                    </div>
                </div>
                <input type="hidden" id="getEmail" value="{{$doc->client->email}}" /><br>
                <button class="btn btn-success" wire:click="getApartments">Подобрать варианты</button>
            </div>
            @if($apartments!=null)
                <div class="container">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-orange-400">
                        <th scope="col">Заголовок</th>
                        <th scope="col">Комнаты</th>
                        <th scope="col">Этаж</th>
                        <th scope="col">Этажность</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Расположение</th>
                        <th scope="col">Время</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($apartments as $apartment)
                        <tr>
                            <td> {{$apartment->title}}
                            </td>
                            <td> {{$apartment->rooms}}</td>
                            <td>{{$apartment->floor}} </td>
                            <td>{{$apartment->etajnost}} </td>
                            <td>
                                <a href="{{$apartment->url}}"
                                   title="{{$apartment->description}}"
                                   target="_blank">{{\Illuminate\Support\Str::substr($apartment->description, 0, 150)}}
                                </a>
                            </td>
                            <td>
                                {{$apartment->price.'грн.'}}
                                {{round($apartment->price/$rate, 2).'$'}}
                            </td>
                            <td> {{$apartment->location}}</td>
                            <td>{{\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $apartment->date)->format('d-m-Y')}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            @endif
            <div class="box-footer">
                <div class="form-group">
                    <a href="{{url('/user/documents')}}" class="btn btn-danger">Назад</a>
                </div>
            </div>
        </div>
    </section>
    <br>
</div>
