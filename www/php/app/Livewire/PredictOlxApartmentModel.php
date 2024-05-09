<?php

namespace App\Livewire;

use App\Func\MyFunc;
use App\Models\Client;
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
    public function mount()
    {
        $this->locations = MyFunc::getLocation();
        $this->contacts = Client::all();
        $this->rate = MyFunc::getDollar();
    }

    public function getPredict()
    {
        if($this->rooms == null || $this->floor == null || $this->etajnost == null || $this->area == null || $this->loc == null){
            return $this->predict = "Заполните все поля!";
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
            Log::info('Error: ' . $e->getMessage().' Date: '.date('Y-m-d H:i:s'));
        }


    }

    public function render()
    {
        return view('livewire.predict-olx-apartment-model', ['locations' => $this->locations,
            'rate' => $this->rate,
            'contacts' => $this->contacts,]);
    }
}
