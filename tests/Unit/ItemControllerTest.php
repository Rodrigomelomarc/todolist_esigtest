<?php

namespace Tests\Unit;

use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $item = Item::create([
        'id' => 1,
        'nome' => 'Correr'
    ]);

        $found_item = Item::find(1);
        $this->assertEquals($found_item->nome, 'Correr');
    }
}
