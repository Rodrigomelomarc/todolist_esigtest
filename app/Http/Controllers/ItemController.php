<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemFormRequest;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $item = null;
    public function __construct()
    {
        $this->item = new Item();
    }

    public function index()
    {
        $itens              = $this->item->getUndoneItems();
        $completedItens     = $this->item->getCompletedItems();

        return view('todo.index', compact('itens', 'completedItens'));
    }
    
    public function store(ItemFormRequest $itemFormRequest)
    {
        $nome = $itemFormRequest->nome;
        $this->item->createNewItem($nome);

        return redirect()->route('itens.index');
    }

    public function destroy(Item $item)
    {
        $this->item->deleteItem($item);
        return redirect()->route('itens.index');
    }

    public function update(int $id, Request $request)
    {
        $item           = Item::find($id);
        $nome           = $request->nome;
        $item->nome     = $nome;
        $item->save();
    }

    public function updateItemToDone(int $id)
    {
        $item = Item::find($id);
        $item->done = true;
        $item->save();
    }

    public function updateItemToUnDone(int $id)
    {
        $item = Item::find($id);
        $item->done = false;
        $item->save();
    }
}
