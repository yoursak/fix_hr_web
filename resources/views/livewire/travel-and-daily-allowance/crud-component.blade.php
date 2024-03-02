<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div>
        <form wire:submit.prevent="save">
            @foreach($itemData as $index => $item)
                <div>
                    <input type="text" wire:model="itemData.{{ $index }}.name" placeholder="Name">
                    <input type="number" wire:model="itemData.{{ $index }}.quantity" placeholder="Quantity">
                    <button type="button" wire:click="removeItem({{ $index }})">Remove</button>
                </div>
            @endforeach
            <button type="button" wire:click="addItem">Add Item</button>
            <button type="submit">Save</button>
        </form>

        <ul>
            @foreach($items as $item)
                <li>{{ $item->name }} - {{ $item->quantity }}</li>
            @endforeach
        </ul>
    </div>

</div>
