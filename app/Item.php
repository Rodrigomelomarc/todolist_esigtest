<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['nome'];

    public function getUndoneItems()
    {
        return $this->query()
            ->where('done', 'false')
            ->orderBy('created_at')
            ->get();
    }

    public function getCompletedItems()
    {
        return $this->query()
            ->where('done', 'true')
            ->orderBy('created_at')
            ->get();
    }

    public function createNewItem(string $nome)
    {
        return $this->create(['nome' => $nome]);
    }

    public function deleteItem(Item $item) {
       return $item->delete();
    }

}
