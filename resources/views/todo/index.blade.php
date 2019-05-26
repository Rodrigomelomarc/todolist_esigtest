@extends('layout')

@section('content')
    <div class="w-50 mx-auto">
        <div class="mt-5 text-secondary justify-content-center">
            <h1>To-do List</h1>
        </div>
        <form class="row" action="{{ route('items.store') }}" method="post">
            @csrf
            <div class="col col-10">
                <input type="text"
                       name="nome"
                       class="form-control"
                       placeholder="Adicione aqui um item a lista de tarefas">
            </div>

                <button type="submit" class="btn btn-primary col col-2">Adicionar</button>

        </form>
        <div class="mt-5">
            <ul class="list-group w-100">
                @foreach($items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span id="item-name-{{ $item->id }}">{{ $item->nome }}</span>
                        
                        <div hidden class="input-group w-50" id="input-item-name-{{ $item->id }}">
                            <input type="text" value="{{ $item->nome }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="editaItem({{ $item->id }})"><i class="fas fa-check"></i></button>
                            </div>
                            @csrf
                        </div>

                        <span class="d-flex">
                            <button class="btn btn-outline-info btn-sm" id="btnEdit" onclick="toggle({{ $item->id }})"><i class="fas fa-pencil-alt"></i></button>
                            <form method="post" action="{{ route('items.destroy', ['item'=>$item->id]) }}"
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
    </div>
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

    </script>
@endsection