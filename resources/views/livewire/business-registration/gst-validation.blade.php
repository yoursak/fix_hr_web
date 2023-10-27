<div class="col-sm-6 col-md-12">
    <div class="form-group">
        <label class="form-label">GST Number</label>
        <input wire:model="gstNumber" class="form-control" name="gst" type="text" placeholder="eg. 29GGGGG1314R9Z6">
        {{-- @if(!$isValid)
        <p class="text-red-500" style="color: red">GST is not valid.</p>
        @endif --}}
        @if ($isValid)
        <p style="color: green">GST Number is Valid</p>
        {{-- <p>Trade Name: {{ $tradeName }}</p>
        <ul>
            @php

            dd($data);
            @endphp
            @foreach ($data as $item)
            <li>{{ $item['Label'] }}: {{ $item['Value'] }}</li>
            @endforeach
        </ul> --}}
        @endif
        @if ($gstNumber && !$isValid)
        <p style="color: red">GST Number is Not Valid</p>
        @endif
    </div>
    <button class="btn btn-sm btn-success" wire:click="validateGst">Validate GST</button>
</div>