<div class="col-sm-6 col-md-12">
    <div class="form-group">
        <label class="form-label"><b>GSTIN Number</b></label>
        <input wire:model="gstNumber" id="gstNumberId" wire:keyup="validateGst" class="form-control" name="gst" type="text" maxlength="15" placeholder="eg. 29GGGGG1314R9Z6" required>
        @if ($isValid == 1)
        <p style="color: green">GSTIN Number is Valid</p>
        @elseif ($isValid == 2)
        <p style="color: red">GSTIN Number is Not Valid</p>
        @endif
        <input type="text" name="isValid" id="isValidId" value="{{$isValid}}" hidden>
        {{-- @if ($isValid)
        <p style="color: green">GST Number is Valid</p>F

        @endif
        @if (!$isValid)
        <p style="color: red">GST Number is Not Valid</p>
        @endif --}}
    </div>
    {{-- <button class="btn btn-sm btn-success" wire:click="validateGst">Validate GST</button> --}}
</div>
