@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-1.0.2/skins/all.css')}} ">
@stop

@section('content_header')
    <h1>Distribuidoras</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
        <li><a href="{{ route('distributor.index') }}">Distribuidoras</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <a href="{{ route('distributor.create') }}" class="btn btn-primary"><i class="fas fa-boxes"></i> Adicionar Distribuidora</a>
        </div>
        <div class="box-body" style="min-height: 70vh">
            @if (session('erro'))
                <div class="alert alert-error alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="fas fa-exclamation-circle"></i> Erro: </h4>
                    <p>{{ session('erro') }}</p>
                </div>
            @endif
            <table class="table table-striped table-remove-modal">
                <thead>
                    <tr>
                        <th style="text-align: center;">CNPJ</th>
                        <th style="text-align: center;">Razão Social</th>
                        <th style="text-align: center;">Pessoa de Contato</th>
                        <th style="text-align: center;">Cidade</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($distributors as $d)
                    <tr>
                        <td>{{ $d->cnpj }}</td>
                        <td>{{ $d->corporate_name }}</td>
                        <td>{{ $d->contact_name }} - {{ $d->contact_phone }} </td>
                        <td>{{ $d->city }}-{{ $d->state }}</td>
                        <td style="text-align: center;">
                            <form action="{{ route('distributor.destroy', $d->id) }}" class="form-inline" method="POST" >
                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}
                                <div class="btn-group">
                                    <abbr title="Modificar gênero"><a href="{{ route('distributor.edit', $d->id) }}" class="btn btn-default btn-sm" style="color: darkgreen"><i class="fas fa-edit"></i></a></abbr>
                                    <abbr title="Remover gênero"><button type="submit" class="btn btn-default btn-sm form-delete"><i class="fas fa-trash-alt" style="color: darkred"></i></button></abbr>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="dialog_del">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remover essa distribuidora?</h4>
                </div>
                <div class="modal-body">
                <p>Tem certeza que deseja remover esta distribuidora?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="delete-btn">Confirmar</button>
                </div>
            </div>
        </div>
</div>
@stop

@section('js')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/icheck-1.0.2/icheck.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('.table').DataTable({
                language: {
                    "decimal":        "",
                    "emptyTable":     "Nenhum gênero cadastrado.",
                    "info":           "Exibindo _START_ até _END_ de _TOTAL_ gêneros.",
                    "infoEmpty":      "Nenhum gênero para exibir.",
                    "infoFiltered":   "(filtrado de _MAX_ total de gêneros.)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Exibindo _MENU_ gêneros.",
                    "loadingRecords": "Carregando...",
                    "processing":     "Processando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "A busca não encontrou resultados",
                    "paginate": {
                        "first":      "Primeiro",
                        "last":       "Último",
                        "next":       "Próximo",
                        "previous":   "Anterior"
                    },
                },
                pageLength: 10,
                "bLengthChange" : true,
                "order": [[ 0, "asc" ]],

            });
        });
        $('.table-remove-modal').on('click', '.form-delete', function(e){
            e.preventDefault();
            var $form = $(this).parents("form");
            $('#dialog_del').modal()
                .on('click', '#delete-btn', function(){
                    $form.submit();
                });
        });
    </script>
@stop
