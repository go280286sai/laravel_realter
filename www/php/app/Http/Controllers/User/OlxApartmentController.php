<?php

namespace App\Http\Controllers\User;

use App\Func\MyFunc;
use App\Http\Controllers\Controller;
use App\Jobs\OlxApartmentJob;
use App\Jobs\RealPriceJob;
use App\Jobs\Send_mail_clientJob;
use App\Models\Client;
use App\Models\Document;
use App\Models\OlxApartment;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OlxApartmentController extends Controller
{
    public function index(): View
    {

        return view('admin.parser.apartment.olx.index');
    }

    public function addOlxApartment(Request $request): void
    {
        $request->validate([
            'title' => 'unique:olx_apartments',
        ]);

        OlxApartmentJob::dispatch($request->all())->onQueue('olx_apartment');
    }

    public function view(string $id): View
    {
        $location = MyFunc::getLocation();
        $apartment = OlxApartment::find($id);
        $client_id = explode('/', $apartment['url']);
        $contacts = Client::all();
        $contact = Client::find($client_id[5]);

        return view('admin.parser.apartment.olx.edit', ['loc' => $location, 'apartment' => $apartment,
            'contacts' => $contacts, 'contact' => $contact]);
    }

    public function edit(Request $request): string
    {
        $fields = MyFunc::stripTags($request->all());
        $fields['url'] = env('APP_URL').'/user/client/'.$fields['url'];
        OlxApartment::edit($fields);

        return to_route('olx_apartment');
    }

    public function cleanDb(): RedirectResponse
    {
        OlxApartment::cleanBase();

        return back();
    }

    public function saveJson(): StreamedResponse
    {
        $data = OlxApartment::all();
        $now = Carbon::now()->format('d_m_Y');
        $name = 'Olx_Apartment_'.$now;
        Storage::put('uploads/'.$name.'.json', json_encode($data->toArray()));

        return Storage::download('uploads/'.$name.'.json');
    }

    public function remove(Request $request): RedirectResponse
    {
        OlxApartment::removeId($request->get('id'));

        return back();
    }

    public function olx_soft_delete_index(): View
    {
        $data = OlxApartment::onlyTrashed()->get();

        return view('admin.parser.apartment.olx.trash', ['trash' => $data]);
    }

    public function olx_soft_delete_all(): RedirectResponse
    {
        OlxApartment::onlyTrashed()->forceDelete();

        return redirect()->route('olx_apartment');
    }

    public function olx_soft_recovery_all(): RedirectResponse
    {
        OlxApartment::onlyTrashed()->restore();

        return redirect()->route('olx_apartment');
    }

    public function olx_soft_delete_item(string $id): RedirectResponse
    {
        OlxApartment::onlyTrashed()->find($id)->forceDelete();

        return redirect()->route('olx_apartment');
    }

    public function olx_soft_recovery_item(string $id): RedirectResponse
    {
        OlxApartment::onlyTrashed()->find($id)->restore();

        return redirect()->route('olx_apartment');
    }

    public function create(): View
    {
        return view('admin.parser.apartment.olx.create');
    }

    public function addCreate(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'unique:olx_apartments|string',
            'rooms' => 'required|numeric',
            'floor' => 'required|numeric',
            'etajnost' => 'required|numeric',
            'area' => 'required|numeric',
            'location' => 'required|not_regex:(Выбрать+)',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);
        $fields = $request->all();
        $fields = MyFunc::stripTags($request->all());
        $fields['type'] = env('APP_NAME');
        $fields['url'] = env('APP_URL').'/user/client/'.$fields['client_id'];
        $fields['date'] = Carbon::now();

        if (isset($fields['service_id'])) {
            Document::add($fields);
        }
        OlxApartment::add($fields);

        return back()->with('success', 'Успешно добавлено');
    }

    public function comment_view(string $id): View
    {
        $data = OlxApartment::find($id);

        return view('admin.parser.apartment.olx.comment', ['data' => $data]);
    }

    public function comment_add(Request $request): RedirectResponse
    {
        $object = MyFunc::stripTags($request->all());
        $id = $object['id'];
        $comment = $object['comment'];
        OlxApartment::addComment($id, $comment);

        return redirect()->route('olx_apartment');
    }

    public function checks_remove(Request $request): void
    {
        $data = $request->get('checks');
        foreach ($data as $item) {
            OlxApartment::removeId($item);
        }
    }

    public function setStatus(Request $request): void
    {
        OlxApartment::setStatus($request->get('id'));
    }

    public function sendPushMessage(Request $request): void
    {
        $text = $request->get('text');
    }

    public function setNewPrice(Request $request): void
    {
        $fields = $request->get('price');
        foreach ($fields['data'] as $item) {
            RealPriceJob::dispatch($item)->onQueue('setPrice');
        }
    }

    public function addFavorite(Request $request): Redirector|RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
        ]);
        OlxApartment::addFavorite($validated['id']);

        return redirect('/user/apartment');
    }

    public function removeFavorite(Request $request): Redirector|RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
        ]);
        OlxApartment::removeFavorite($validated['id']);

        return redirect('/user/apartment');
    }

    public function setting(Request $request): void
    {
        $arr = $request->get('data');
        $name = array_keys($arr);
        $text = array_values($arr);
        Setting::addSetting(['name' => $name[0], 'text' => $text[0]]);
    }

    public function getApartments(Request $request): RedirectResponse|array
    {
        if ($request->get('data') !== null) {
            $mail = $request->get('email');
            $data = $request->get('data');
            $object = MyFunc::getListToArray($data);
            Send_mail_clientJob::dispatch($object[0], $mail)->onQueue('send_client');

            return redirect('/user/documents');
        } else {
            $text = $request->get('text');
            $object = MyFunc::getListToArray($text);

            return [$object[0], $object[1]];
        }
    }
}
