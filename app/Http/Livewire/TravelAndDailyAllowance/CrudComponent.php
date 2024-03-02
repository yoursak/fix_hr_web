<?php

namespace App\Http\Livewire\TravelAndDailyAllowance;

use App\Models\Item;
use Livewire\Component;

class CrudComponent extends Component
{
    public $items;
    public $itemData = [];

    protected $rules = [
        'itemData.*.name' => 'required',
        'itemData.*.quantity' => 'required|numeric|min:1',
    ];

    public function mount()
    {
        $this->items = Item::all();
        if (empty($this->itemData)) {
            $this->itemData[] = ['name' => '', 'quantity' => ''];
        }
    }

    public function render()
    {
        return view('livewire.travel-and-daily-allowance.crud-component');
    }

    public function addItem()
    {
        $this->itemData[] = ['name' => '', 'quantity' => ''];
    }

    public function removeItem($index)
    {
        unset($this->itemData[$index]);
        $this->itemData = array_values($this->itemData);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->itemData as $item) {
            Item::create([
                'name' => $item['name'],
                'quantity' => $item['quantity'],
            ]);
        }

        $this->reset('itemData');
        $this->items = Item::all();
    }

    public function update($itemId, $index)
    {
        $this->validate();

        $item = $this->itemData[$index];
        Item::find($itemId)->update([
            'name' => $item['name'],
            'quantity' => $item['quantity'],
        ]);

        $this->reset('itemData');
        $this->items = Item::all();
    }
}
// {
//     public function render()
//     {
//         return view('livewire.travel-and-daily-allowance.crud-component');
//     }
// }
