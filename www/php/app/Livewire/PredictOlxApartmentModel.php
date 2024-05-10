<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PredictOlxApartmentModel extends Component
{
    public $locations;

    public $rate;

    public $contacts;

    public $rooms;

    public $floor;

    public $etajnost;

    public $area;

    public $loc;

    public $predict;

    public $client_id;

    public $service_id;

    public function mount($client_id = null, $service_id = null): void
    {
        $this->locations = MyFunc::getLocation();
        $this->contacts = Client::all();
        $this->client_id = $client_id;
        $this->rate = MyFunc::getDollar();
        $this->service_id = $service_id;
    }

    /**
     * @return string|void
     */
    public function getPredict()
    {
        if ($this->rooms == null || $this->floor == null || $this->etajnost == null || $this->area == null || $this->loc == null) {
            return $this->predict = 'Заполните все поля!';
        }
        try {
            $req = Http::post('http://192.168.50.70:5000/predictApartment', [
                'rooms' => $this->rooms,
                'floor' => $this->floor,
                'etajnost' => $this->etajnost,
                'area' => $this->area,
                'location' => $this->loc,
            ]);
            $data = $req->json();
            $this->predict = json_decode($data)->result;
        } catch (\Exception $e) {
            Log::info('Error: '.$e->getMessage().' Date: '.date('Y-m-d H:i:s'));
        }
    }

    public function render(): View
    {
        return view('livewire.predict-olx-apartment-model',
            [
                'locations' => $this->locations,
                'rate' => $this->rate,
                'contacts' => $this->contacts,
                'client' => $this->client_id,
                'service' => $this->service_id,
            ]);
    }
}
