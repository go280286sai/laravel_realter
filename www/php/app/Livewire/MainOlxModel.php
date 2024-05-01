<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Http\Controllers\User\ResearchController;
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

    public function mount()
    {
        $this->getRateDollor();
        $this->resource = Research::find(1);
        $this->url = $this->resource->url;
        $this->OlxApartment = OlxApartment::all()->sortByDesc('date');
        $this->rate = MyFunc::getDollar();
        $this->token = MyFunc::getToken();
    }

    public function getRateDollor():void
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

    public function render()
    {

        return view('livewire.main-olx-model',
            ['apartments' => $this->OlxApartment, 'rate' => $this->rate, 'token' => $this->token,
                'status_sync' => $this->status_sync]);
    }
}
