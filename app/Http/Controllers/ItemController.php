<?php

namespace App\Http\Controllers;

use App\Item;
use App\Services\ItemCreator;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::query()
            ->orderBy('created_at')
            ->get();

        return view('todo.index', compact('items'));
    }
    
    public function store(Request $request)
    {
        $nome = $request->nome;
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
}
