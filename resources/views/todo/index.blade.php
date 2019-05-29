@extends('layout')

@section('content')
    <div class="w-md-50 mx-auto">
        <div class="mt-5 text-secondary justify-content-center">
            <h1>To-do List</h1>
        </div>
        <form class="row" action="{{ route('itens.store') }}" method="post">
            @csrf
            <div class="col col-md-10">
                <input type="text"
                       name="nome"
                       class="form-control"
                       placeholder="Adicione aqui um item à lista de tarefas">
            </div>

                <button type="submit" class="btn btn-primary col col-md-2">Adicionar</button>

        </form>


        <div id="itens-iniciais" class="mt-5">
            <button id="btnModal" type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#completedModal">
                Exibir itens concluídos
            </button>

            <ul class="list-group w-100">
                @foreach($itens as $item)
                    <li id="item-{{ $item->id }}" class="list-group-item d-flex justify-content-between align-items-center">

                        <div class="d-flex">
                            <div>
                                <button type="button" class="btn btn-outline-success btn-sm mr-1" onclick="markItemAsDone({{ $item->id }})"><i class="fas fa-check"></i></button>
                                <span id="item-name-{{ $item->id }}">{{ $item->nome }}</span>
                            </div>

                            <div hidden class="input-group w-50" id="input-item-name-{{ $item->id }}">
                                <input class="w-50" type="text" value="{{ $item->nome }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="editaItem({{ $item->id }})"><i class="fas fa-check"></i></button>
                                </div>
                                @csrf
                            </div>
                        </div>

                        <span class="d-flex">
                            <button class="btn btn-outline-info btn-sm" id="btnEdit" onclick="toggle({{ $item->id }})"><i class="fas fa-pencil-alt"></i></button>
                            <form method="post" action="{{ route('itens.destroy', ['item'=>$item->id]) }}"
                            onsubmit="return confirm('Deseja realmente excluir ({{ $item->nome }}) da lista?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>

            <div class="modal fade" id="completedModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Itens concluídos</h5>
                            <button class="close" type="button" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div id="modal-body" class="modal-body">
                            <ul class="list-group w-100">
                                @foreach($completedItens as $item)
                                    <li id="item-{{ $item->id }}" class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <button type="button" class="btn btn-outline-danger btm-sm" onclick="markItemAsUnDone({{ $item->id }})" ><i class="fas fa-times"></i></button>
                                            <span id="item-name-{{ $item->id }}">{{ $item->nome }}</span>
                                        </div>

                                        <div hidden class="input-group w-50" id="input-item-name-{{ $item->id }}">
                                            <input class="w-50" type="text" value="{{ $item->nome }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="editaItem({{ $item->id }})"><i class="fas fa-check"></i></button>
                                            </div>
                                            @csrf
                                        </div>

                                        <span class="d-flex">
                            <button class="btn btn-outline-info btn-sm" id="btnEdit" onclick="toggle({{ $item->id }})"><i class="fas fa-pencil-alt"></i></button>
                            <form method="post" action="{{ route('itens.destroy', ['item'=>$item->id]) }}"
                                  onsubmit="return confirm('Deseja realmente excluir este da lista?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Fechar</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>

        function toggle(id) {
            const inputName = $(`#input-item-name-${id}`);
            const name = $(`#item-name-${id}`);
            if(inputName.is(':hidden')){
                inputName.removeProp('hidden');
                name.prop('hidden', true);
            } else {
                name.removeProp('hidden');
               inputName.prop('hidden', true);
            }
        }

        function editaItem(id) {
            const formData = new FormData();
            const nome = $(`#input-item-name-${id} > input`).val();
            const token = $('input[name=_token]').val();
            const url = `/${id}/edit`;
            formData.append('nome', nome);
            formData.append('_token', token);

            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                processData: false,
                contentType: false
            })
                .done(() => {
                    toggle(id);
                    $(`#item-name-${id}`).text(nome);
                });
        }

        function markItemAsDone(id) {
            const item = $(`#item-${id}`);
            const token = $('input[name=_token]').val();
            const formData = new FormData();
            formData.append('_token', token);
            $.ajax({
                type: 'POST',
                url: `/${id}/markDone`,
                data: formData,
                processData: false,
                contentType: false
            }).done(() => {
                item.remove();
                $(item).appendTo('#modal-body');
                location.reload();
            });
        }

        function markItemAsUnDone(id) {
            const item = $(`#item-${id}`);
            const token = $('input[name=_token]').val();
            const formData = new FormData();
            formData.append('_token', token);
            $.ajax({
                type: 'POST',
                url: `/${id}/markUnDone`,
                data: formData,
                processData: false,
                contentType: false
            }).done(() => {
                item.remove();
                $(item).appendTo('#itens-iniciais');
                location.reload();
            });
        }

    </script>
@endsection