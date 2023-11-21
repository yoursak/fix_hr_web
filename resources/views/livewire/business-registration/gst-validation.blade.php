<div class="col-sm-6 col-md-12">
    <div class="form-group">
        <label class="form-label">GST Number</label>
        <input wire:model="gstNumber" wire:keyup="validateGst" class="form-control" name="gst" type="text"
            placeholder="eg. 29GGGGG1314R9Z6">
        @if ($isValid)
        <p style="color: green">GST Number is Valid</p>
        @elseif (!$isValid)
        <p style="color: red">GST Number is Not Valid</p>
        @endif
        {{-- @if ($isValid)
        <p style="color: green">GST Number is Valid</p>

        @endif
        @if (!$isValid)
        <p style="color: red">GST Number is Not Valid</p>
        @endif --}}
    </div>
    {{-- <button class="btn btn-sm btn-success" wire:click="validateGst">Validate GST</button> --}}
</div>