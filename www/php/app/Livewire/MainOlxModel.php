<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Http\Controllers\User\ResearchController;
use App\Jobs\OlxApartmentJob;
use App\Models\OlxApartment;
use App\Models\Rate;
use App\Models\Research;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Js;
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


    public function mount(): void
    {
        $this->getRateDollor();
        $this->resource = Research::find(1);
        $this->url = $this->resource->url;
        $this->OlxApartment = OlxApartment::all()->sortByDesc('date');
        $this->rate = MyFunc::getDollar();
        $this->token = MyFunc::getToken();
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
            $this->js("window.location.reload();");
        } catch (Exception $e) {
            Log::info("Error: " . $e->getMessage() . ' Line: ' . $e->getLine() . ' Data: ' . date());
        }
    }

    public function getOlxData(): void
    {
        $data = time();
        if ($this->time == 0 || $data - $this->time > 1800) {
            $host = env('URL_NODE') . '/api/target';
            $req = Http::post($host, ["target" => "realter",
                "url" => $this->url]);
            $status = $req->status();
            $this->js("alert('" . $status . "')");
            $this->time = $data;
        } else {
            $this->js("alert('request is too fast')");
        }
    }

    public function loadOlxData(): void
    {
        $data = time();
        if ($this->time != 0 && $data - $this->time > 1800) {
            for ($i = 0; $i < 25; $i++) {
                $research = Http::get('http:/192.168.50.70:3000/api/realter/' . $i)->body();
                $items = json_decode($research);
                foreach ($items as $item) {
                    try {
                        $data = [
                            'title' => html_entity_decode($item->title, ENT_QUOTES, "UTF-8"),
                            'url' => $item->url,
                            'rooms' => $item->room,
                            'floor' => $item->floor,
                            'etajnost' => $item->etajnost,
                            'area' => $item->area,
                            'price' => $item->price,
                            'type' => $item->type,
                            'description' => html_entity_decode($item->description, ENT_QUOTES, "UTF-8"),
                            'date' => OlxApartment::getDateNew($item->time_),
                            'location' => OlxApartment::location($item->location)
                        ];

                        OlxApartment::add($data);
                    } catch (Exception $exception) {
                        Log::info($exception->getMessage() . ' Line: ' . $exception->getLine() . ' Data: ' . date('Y-m-d H:i:s'));
                    }

                }
            }
        } else {
            $this->js("alert('Система занята. Попробуйте позже.')");
        }
        $this->js("window.location.reload();");
    }

    public function cleanAll(): void
    {
        OlxApartment::cleanBase();
    }

    public function render()
    {

        return view('livewire.main-olx-model',
            ['apartments' => $this->OlxApartment, 'rate' => $this->rate, 'token' => $this->token,
                'status_sync' => $this->status_sync]);
    }
}
