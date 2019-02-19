<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Item;
use App\Models\Movie;
use App\Models\Rental;
use App\Models\Rental_item;
use App\Services\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'can:customer_service']);
    }

    public function index()
    {
        $rentals = Rental::with('client.holder','items')->orderBy('id', 'desc')->get();
        return view('rental.index', compact('rentals'));
    }

    public function rental_save(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'data_items' => 'required|json',
        ]);
        $client_id = $request->client_id;
        $items = json_decode($request->data_items);
        try {
            DB::transaction(function () use ($client_id, $items){
                $rental = Rental::create([
                    'client_id' => $client_id,
                    'status' => 'Pendente',
                    'rental_user' => \Auth::user()->id,
                ]);
                foreach ($items as $item) {
                    $i = json_decode($item);
                    /* dd($i->data->price * 1 - $i->data->discount * 1); */
                    Rental_item::create([
                        'rental_id' => $rental->id,
                        'item_id' => $i->data->id,
                        'item_price' => $i->data->price * 1,
                        'discount' => $i->data->discount * 1,
                        'rental_price' => ($i->data->price * 1 - $i->data->discount * 1),
                        'return_deadline' => $i->data->return_deadline * 1,
                        'return_deadline_extension' => $i->data->return_deadline_extension * 1,
                        'expected_return_date' => Carbon::createFromFormat('d/m/Y', Util::return_date($i->data->return_deadline * 1 + $i->data->return_deadline_extension *1))->format('Y-m-d'),
                        'return_date' => null,
                        'return_user' => null,
                    ]);
                    $item = Item::findOrFail($i->data->id);
                    $item->status = 'Locado';
                    $item->save();
                }
            });
        }catch (\Exception $e) {
            return redirect()->route('rental.items', $client_id)->with('erro', 'Erro na tentativa de registrar a locação.');
        }
        return redirect()->route('rental.index');
        /* dd($items, $request->all()); */
    }

    public function rental_client()
    {
        $clients = Client::with('holder')->whereHas('holder', function ($query){
            $query->where('active', true);
        })->get();
        return view('rental.select_client', compact('clients'));
    }

    public function rental_items(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'client_id' => 'required_if:type,id|exists:clients,id',
            'client_qrcode' => 'required_if:type,qrcode|exists:clients,id',
        ]);
        $id = (isset($request->client_qrcode)) ? $request->client_qrcode : $request->client_id;
        $items = Item::with('movie', 'media')->where('status', 'Disponível')->get();
        $client = Client::with('holder')->whereHas('holder', function ($query){
            $query->where('active', true);
        })->where('id', $id)->first();
        if (isset($request->client_qrcode)){
            $client_qrcode = $request->client_qrcode;
            return view('rental.add_items', compact('client_qrcode', 'items', 'client'));
        }
        return view('rental.add_items', compact('items', 'client'));
    }

    public function rental_items2($id)
    {
        /* $client = Client::findOrFail($id); */
        $client = Client::with('holder')->whereHas('holder', function ($query){
            $query->where('active', true);
        /* })->where('id', $id)->first(); */
        })->findOrFail($id);
        $items = Item::with('movie', 'media')->where('status', 'Disponível')->get();
        return view('rental.add_items', compact('items', 'client'));
    }

    public function return_date($days){
        return Util::return_date($days);
    }

    public function rental_add_item_qrcode($id)
    {
        $id_media = substr($id, 0, 2) * 1;
        $id_movie = substr($id, 2, 8) * 1;
        $items = Item::with('movie.type', 'media')
            ->where('media_id', $id_media)
            ->where('movie_id', $id_movie);
        $exists = ($items->count() > 0) ? true : false;
        $item = $items->where('status', 'Disponível')->first();
        $response = array();
        if ( !$exists ){
            $response['status'] = 'Not Found';
        } elseif (is_null($item)){
            $response['status'] = 'Unavailable';
        } else {
            $response['status'] = 'Available';
        }

        $data = array();
        if ($item != null) {
            $data['id'] = $item->id;
            $data['title'] = $item->movie->title;
            $data['type'] = $item->movie->type->description;
            $data['media'] = $item->media->description;
            $data['price'] = $item->media->rental_price * (1 + $item->movie->type->increase);
            $data['discount'] = 0;
            $data['return_deadline'] = $item->movie->type->return_deadline;
            $data['return_deadline_extension'] = 0;
            $data['return_date'] = Util::return_date($item->movie->type->return_deadline);
        }
        $response['data'] = $data;
        return json_encode($response);

    }

    public function edit()
    {

    }

    public function cancel($id)
    {
        $rental = Rental::findOrFail($id);
        try {
            DB::transaction(function () use ($rental){
                $rental->status = 'Cancelada';
                $rental->save();
                $items = $rental->items;
                foreach ($items as $i) {
                    $item = Item::findOrFail($i->item_id);
                    $item->status = 'Disponível';
                    $item->save();
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('rental.index', $client_id)->with('erro', 'Erro na tentativa de cancelar a locação.');
        }
        return redirect()->route('rental.index');
    }

    public function devolution_index($id)
    {
        $this->surcharge_calc($id);
        $rental = Rental::with('client.holder','items.item.movie.type', 'items.item.media')->findOrfail($id);
        return view('rental.devolution', compact('rental'));
    }
    public function devolution($id, Request $request)
    {
        try {
            DB::transaction(function () use ($request){
                foreach ($request->itens as $item) {
                    $i = Rental_item::findOrfail($item);
                    $i->return_date = Carbon::now()->format('Y-m-d');
                    $i->return_user = \Auth::user()->id;
                    $imovie = Item::findOrfail($i->item_id);
                    $imovie->status = "Disponível";
                    $i->save();
                    $imovie->save();
                    /* $rental = Rental::with('items')->whereHas('items', function ($query){
                        $query->whereNull('return_date');
                    })->where('id', $i->rental_id)->first(); */
                }
                $rental = Rental::with('items')->findOrfail($i->rental_id);
                if($rental->items->where('return_date',null)->count() == 0){
                    $rental->status = "Concluída";
                    $rental->save();
                }
            });
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('rental.devolution',  $id)->with('erro', 'Erro na tentativa de devolver a locação.');
        }
        return redirect()->route('rental.devolution', $id);
    }
    public function surcharge_calc($id)
    {
        $rental = Rental::with('items')->findOrfail($id);
        $msg = array();
        foreach ($rental->items as $item) {
            $data = Carbon::parse($item->expected_return_date);
            $now = Carbon::now();
            $diff = $data->diffInDays($now, false);
            array_push($msg,"$item->expected_return_date, diff: $diff");
            if($diff > 0){
                $item->surcharge = $diff * $item->item_price;
                $item->save();
            }
        }
    }

}
