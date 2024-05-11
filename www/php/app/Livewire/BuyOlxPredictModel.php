<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Models\Client;
use App\Models\Document;
use App\Models\OlxApartment;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BuyOlxPredictModel extends Component
{
    public $price = null;

    public $rooms = null;

    public $etajnost = null;

    public $location = null;

    public $locations = null;

    public $apartments = null;

    public $doc = null;

    public $contacts = null;

    public $service = null;

    public $rate = 1;
    public string $flask;

    public function mount($id): void
    {
        $this->doc = Document::find($id);
        $this->contacts = Client::all();
        $this->locations = MyFunc::getLocation();
        $this->service = Service::all();
        $this->price = $this->doc->price;
        $this->rooms = $this->doc->rooms;
        $this->etajnost = $this->doc->etajnost;
        $this->location = $this->doc->location;
        $this->rate = MyFunc::getDollar();
        $this->flask = env('URL_FLASK');

    }

    public function getApartments(): void
    {
        $req = Http::post( $this->flask.'/getPredict', ['price' => $this->price, 'rooms' => $this->rooms, 'etajnost' => $this->etajnost, 'location' => $this->location]);
        $body = $req->body();
        $ids = json_decode($body)->ids;
        $id = explode(',', $ids);
        $this->apartments = OlxApartment::whereIn('id', $id)->get();

    }

    public function render(): View
    {
        return view('livewire.buy-olx-predict-model', ['apartments' => $this->apartments, 'doc' => $this->doc,
            'service' => $this->service, 'contacts' => $this->contacts, 'loc' => $this->locations, 'rate' => $this->rate]);
    }
}
