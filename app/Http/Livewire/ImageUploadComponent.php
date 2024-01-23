<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use App\Models\Image;

class ImageUploadComponent extends Component
{
    use WithFileUploads;


    public $image;


    public function mount()
    {
        // $image
    }


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'image' => 'required',
        ]);
    }

    public function uploadImage()
    {
        
        // $this->validate([
        //     'image' => 'required',
        // ]);


        // $image = new Image();


        // $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
        // $this->image->storeAs('image_uploads', $imageName);
        // $image->image = $imageName;


        // $image->save();


        // session()->flash('message', 'Image has been uploaded successfully');


        // $this->image = '';


    }



    public function render()
    {
        //Get Uploaded Images


        $images = Image::orderBy('id', 'DESC')->get();
        return view('livewire.image-upload-component', ['images' => $images])->layout('livewire.layouts.base');
    }
    // public function render()
    // {
    //     return view('livewire.image-upload-component');
    // }
}
