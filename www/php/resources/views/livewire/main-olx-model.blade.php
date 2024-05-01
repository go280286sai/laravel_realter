<div>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Недвижимость
            </h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="olx_apartment" class="form-label">URL</label>
                            <input type="text" name="url" class="form-control"
                                   aria-describedby="emailHelp" wire:model="url">
                        </div>
                        <div class="btn btn-success mt-2" wire:click="setUrl">Обновить</div>
                    </div>
                    <div class="form-group">
                        <table>
                            <tr>
                                <td>
                                    <div class="btn btn-danger">Запустить обновление</div>&nbsp;
                                </td>
                                <td>
                                    <div class="btn btn-danger">Выполнить синхронизацию</div>&nbsp;
                                </td>
                                <td><a href="{{url('/user/olx_apartment_delete_index')}}">
                                        <div class="btn btn-danger">Список удаленных</div>&nbsp;
                                    </a></td>
                                @if(\Illuminate\Support\Facades\Auth::user()->is_admin==1)
                                    <td>
                                            <div class="btn btn-danger">Сохранить как</div>&nbsp;
                                    </td>
                                    <td>
                                        <div class="btn btn-danger">Удалить все данные</div>&nbsp;
                                    </td>
                                @endif
                            </tr>
                        </table>
                        <br>
                        <table>
                            <tr>
                                <td><a href="{{url("/user/create_apartment")}}">
                                        <div
                                            class="btn btn-danger">Создать объявление</div>&nbsp;
                                    </a></td>
                                <td>
                                    <div class="btn btn-danger">Удалить из базы</div>&nbsp;
                                </td>
                                <td>
                                    <div class="btn btn-danger">Добавить в избранное</div>&nbsp;
                                </td>
                                <td>
                                    <div class="btn btn-danger">Удалить из избранного</div>&nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>Среднее отклонение прогноза: <b>{{\App\Models\Setting::getMAE()}}грн.</b> или
                                                <b>{{round(\App\Models\Setting::getMAE()/$rate, 2)}}$</b></div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-orange-400">
                                <th scope="col">
                                </th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Комнаты</th>
                                <th scope="col">Этаж</th>
                                <th scope="col">Этажность</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Прогноз</th>
                                <th scope="col">Тип</th>
                                <th scope="col">Расположение</th>
                                <th scope="col">Время</th>
                                <th scope="col">Комментарий</th>
                                <th scope="col">Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apartments as $apartment)
                                <tr>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">
                                        <div class="form-check">
                                            <input v-model="check_items" name="check_items"
                                                   class="form-check rounded text-danger" type="checkbox"
                                                   value="{{$apartment->id}}" id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}"> {{$apartment->title}}
                                        @if($apartment->favorites==1)
                                            <span class="inline-block fa fa-star" title="В избранном"></span>
                                        @endif
                                    </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}"> {{$apartment->rooms}}</td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">{{$apartment->floor}} </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">{{$apartment->etajnost}} </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">
                                        <a href="{{$apartment->url}}"
                                           title="{{$apartment->description}}"
                                           target="_blank">{{\Illuminate\Support\Str::substr($apartment->description, 0, 150)}}
                                        </a>
                                    </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">
                                        {{$apartment->price.'грн.'}}
                                                                            {{round($apartment->price/$rate, 2).'$'}}
                                    </td>
                                    <td class="{{$apartment->real_price>$apartment->price?"bg-red-200":"bg-green-200"}}">
                                        {{($apartment->real_price-$apartment->price).'грн.'}}
                                          {{round(($apartment->real_price-$apartment->price)/$rate, 2).'$'}}
                                        @if($apartment->location_index==1)
                                            <span class="inline-block fa fa-money" title="Выгодное предложение"></span>
                                        @endif
                                    </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">{{$apartment->type}} </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}"> {{$apartment->location}}</td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">{{\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $apartment->date)->format('d-m-Y')}} </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">{{$apartment->comment}} </td>
                                    <td class="{{$apartment->status==0?"bg-orange-200":''}}">
                                        @if($apartment->status==0)
                                            <input type="hidden" name="" id="apartmentStatus"
                                                   value="{{$apartment->id}}">
                                        @endif
                                        <form action="{{env('APP_URL').'/user/view/'.$apartment->id}}" method="get">
                                            <button class="btn"
                                                    title="Редактировать"><i class="fa fa-edit"></i></button>
                                        </form>
                                        <form action="{{env('APP_URL').'/user/olx_apartment_comment/'.$apartment->id}}"
                                              method="get">
                                            <button class="btn" title="{{__('messages.comment_add')}}"><i
                                                    class="fa fa-bars"></i>
                                            </button>
                                        </form>
                                        <form action="{{env('APP_URL')}}/user/olx_apartment_delete" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$apartment->id}}">
                                            <button onclick="return confirm('Вы уверенны')" class="btn"
                                                    title="Удалить"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </section>
    </div>
</div>