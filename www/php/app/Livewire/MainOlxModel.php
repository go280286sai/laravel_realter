<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Models\OlxApartment;
use App\Models\Rate;
use App\Models\Research;
use App\Models\Setting;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MainOlxModel extends Component
{
    public object $OlxApartment;

    public ?object $resource = null;

    public float $rate;

    public string $token;

    public string $url = '';

    public bool $status_sync = false;

    public int $time = 0;

    public ?string $mae = '0';

    public function mount(): void
    {
        $this->getRateDollor();
        $this->resource = Research::find(1);
        $this->url = $this->resource->url;
        $this->OlxApartment = OlxApartment::all()->sortByDesc('created_at');
        $this->rate = MyFunc::getDollar();
        $this->token = MyFunc::getToken()['token'];
        $this->mae = Setting::all()->first()?->MAE;
        $this->node = env('URL_NODE');
        $this->flask = env('URL_FLASK');

    }

    public function getRateDollor(): void
    {
        $date = Carbon::now()->format('Y-m-d');
        $api = Http::get('https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5')->body();
        $obj = json_decode($api);
        try {
            Rate::add(['dollar' => $obj[1]->sale, 'date' => $date]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
        }
    }

    public function setUrl(): void
    {
        try {
            Research::edit(['url' => $this->url, 'id' => $this->resource->id]);
            $this->js('window.location.reload();');
        } catch (Exception $e) {
            Log::info('Error: '.$e->getMessage().' Line: '.$e->getLine().' Data: '.date('Y-m-d H:i:s'));
        }
    }

    public function getOlxData(): void
    {
        $data = time();
        if ($this->time == 0 || $data - $this->time > 1800) {
            $host = $this->node.'/api/target';
            $req = Http::post($host, ['target' => 'realtor',
                'url' => $this->url]);
            $status = $req->status();
            if ($status == 200) {
                session()->flash('status', 'Start to parse. Please wait');
            } else {
                session()->flash('status', 'Error to parse');
            }
            $this->time = $data;
        } else {
            $this->js("alert('request is too fast')");
        }
    }

    public function loadOlxData(): void
    {
        $req = Http::get(  $this->node.'/api/realtor/24')->body();
        if ($req == "Not found") {
            $this->js('alert("Идет загрузка, ожидайте!")');
            return;
        }
            for ($i = 0; $i < 25; $i++) {
                $research = Http::get(  $this->node.'/api/realtor/'.$i)->body();
                $items = json_decode($research);
                foreach ($items as $item) {
                    try {
                        $data = [
                            'title' => html_entity_decode($item->title, ENT_QUOTES, 'UTF-8'),
                            'url' => $item->url,
                            'rooms' => $item->room,
                            'floor' => $item->floor,
                            'etajnost' => $item->etajnost,
                            'area' => $item->area,
                            'price' => $item->price,
                            'type' => $item->type,
                            'description' => html_entity_decode($item->description, ENT_QUOTES, 'UTF-8'),
                            'date' => OlxApartment::getDateNew($item->time_),
                            'location' =>$item->location,
                        ];
                        OlxApartment::add($data);
                    } catch (Exception $exception) {
                        Log::info($exception->getMessage().' Line: '.$exception->getLine().' Data: '.date('Y-m-d H:i:s'));
                    }

                }
            }
        $this->js('window.location.reload();');
    }

    public function cleanAll(): void
    {
        Http::post(  $this->node.'/api/clean/');
        OlxApartment::cleanBase();

        $this->js('window.location.reload();');
    }

    public function runSync(): void
    {
        try {
            Http::post( $this->flask.'/apartment', ['token' => $this->token]);
            $this->js('setTimeout(function(){window.location.reload();}, 5000);');
        } catch (Exception $exception) {
            Log::info('Error: '.$exception->getMessage().' Line: '.$exception->getLine().' Data: '.date('Y-m-d H:i:s'));
        }
    }

    public function render(): View
    {
        return view('livewire.main-olx-model',
            ['apartments' => $this->OlxApartment, 'rate' => $this->rate, 'token' => $this->token,
                'status_sync' => $this->status_sync, 'mae' => $this->mae]);
    }
}
