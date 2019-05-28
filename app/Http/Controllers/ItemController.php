<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemFormRequest;
use App\Item;
use App\Services\ItemCreator;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::query()
                ->where('done', '=', 'false')
                ->orderBy('created_at')
                ->get();

        $completedItems = Item::query()
                        ->where('done', '=', 'true')
                        ->orderBy('created_at')
                        ->get();

        return view('todo.index', compact('items', 'completedItems'));
    }
    
    public function store(ItemFormRequest $itemFormRequest)
    {
        $nome = $itemFormRequest->nome;
        Item::create(['nome' => $nome]);

        return redirect()->route('items.index');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index');
    }

    public function update(int $id, Request $request)
    {
        $item = Item::find($id);
        $nome = $request->nome;
        $item->nome = $nome;
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
