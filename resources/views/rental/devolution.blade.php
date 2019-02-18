@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-1.0.2/skins/all.css')}} ">
    <style>
        .info-row-up{
            min-height: 13em;
        }
    </style>
@stop

@section('content_header')
    <h1>Devoluções</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
        <li><a href="{{ route('rental.index') }}">Locações</a></li>
        <li><a href="{{ route('rental.devolution', $rental->id) }}">Devoluções</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-body" style="min-height: 70vh">
            @if (session('erro'))
                <div class="alert alert-error alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="fas fa-exclamation-circle"></i> Erro: </h4>
                    <p>{{ session('erro') }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-default info-row-up">
                        <div class="box-body">
                            <h5 class="box-title"><i class="fas fa-user"></i> Cliente</h5>
                            <p>Nome: <b>{{ $rental->client->name }}</b></p>
                            <h5><i class="fas fa-user-plus"></i> Titular</h5>
                            <p>CPF: <b>{{ $rental->client->holder->cpf }}</b></p>
                            <p>Nome: <b>{{ $rental->client->holder->name }}</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default info-row-up">
                        <div class="box-body">
                            <h5 class="box-title"><i class="fas fa-hand-holding-usd"></i> Resumo:</h5>
                            <p>Qtd. Itens: <b>{{ $rental->items->count() }}</b></p>
                            <p>Valor Desconto: <b>R$ {{ number_format(($rental->items->sum('discount')), 2, ",", "") }}</b></p>
                            <p>Valor Multa: <b>R$ {{ number_format(($rental->items->sum('surcharge')), 2, ",", "") }}</b></p>
                            <p>Valor total: <b>R$ {{ number_format(($rental->items->sum('item_price') - $rental->items->sum('discount') + $rental->items->sum('surcharge')), 2, ",", "") }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <h4>Itens:</h4>
                        <form action="{{ route('rental.devolution', $rental->id) }}" method="post">
                            @csrf
                            <table id="tb_items" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>DEVOLVER</th>
                                        <th>TÍTULO</th>
                                        <th>TIPO</th>
                                        <th>MÍDIA</th>
                                        <th>VALOR</th>
                                        <th>DESCONTO</th>
                                        <th>MULTA</th>
                                        <th>VALOR FINAL</th>
                                        <th>DATA DE DEVOLUÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rental->items->sortBy('expected_return_date') as $item)
                                    <tr>
                                        <td>
                                            @if (is_null($item->return_user))
                                            <input type="checkbox" name="itens[]" value="{{ $item->id }}">
                                            @else
                                            <span class="label bg-green">Entregue</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->item->movie->title }}</td>
                                        <td>{{ $item->item->movie->type->description }}</td>
                                        <td>{{ $item->item->media->description }}</td>
                                        <td>R$ {{ number_format(( $item->item_price ), 2, ",", "") }}</td>
                                        <td>R$ {{ number_format(( $item->discount ), 2, ",", "") }}</td>
                                        <td>R$ {{ number_format(( $item->surcharge ), 2, ",", "") }}</td>
                                        <td>R$ {{ number_format(($item->item_price - $item->discount + $item->surcharge), 2, ",", "") }}</td>
                                        <td>{{  Carbon\Carbon::createFromFormat('Y-m-d', $item->expected_return_date)->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-2 col-md-offset-10">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-fw fa-save"></i> Registrar devolução</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop

@section('js')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/icheck-1.0.2/icheck.js') }}"></script>

@stop
