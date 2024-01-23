<?php

namespace App\Http\Livewire\BusinessRegistration;

use Livewire\Component;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;

class GstValidation extends Component
{
    public $gstNumber;
    public $isValid;
    public $tradeName;
    public $data = [];

    // GST Validation BY JAYANT


    public function validateGst()
    {
        $url = "https://irisgst.com/gstin-filing-detail/?gstinno={$this->gstNumber}";
        $response = Http::get($url);

        if ($response->successful()) {
            // Check if "trade name" exists in the response content
            $content = $response->body();
            if ($response->status() != 200) {
                throw new \Exception('Failed to fetch data');
            }

            if (strpos($content, 'Trade Name') !== false && strpos($content, 'Legal Name') !== false && strpos($content, 'Constitution of business') !== false) {
                // "Trade Name" found, consider it as valid
                $this->isValid = true;
                $this->tradeName = true;

            } else {
                // "Trade Name" not found, consider it as not valid
                $this->isValid = false;
                $this->tradeName = null;
            }
        } else {
            // Handle the case where the HTTP request fails
            $this->isValid = false;
            $this->tradeName = false;
        }

    }
    public function render()
    {
        return view('livewire.business-registration.gst-validation');
    }
}
