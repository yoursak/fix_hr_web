<?php

namespace App\Http\Livewire\BusinessRegistration;

use Livewire\Component;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;

class GstValidation extends Component
{
    public $gstNumber;
    public $isValid = false;
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

                // $crawler = new Crawler($content);
                // // dd($crawler);
                // $divName = 'container';
                // $className = 'form-group';
                // $childClass = 'form-control';
                // $labelName = 'label';
                // $attributeName = 'value';
                // $divCrawler = $crawler->filter(".$divName");
                // $rowData = [];

                // // Loop through each div element
                // $divCrawler->each(function (Crawler $div) use ($className, $labelName, $childClass, $attributeName, &$rowData) {
                //     $rows = $div->filter(".$className");
                //     $rowDataItem = [];

                //     // Loop through rows within each div
                //     $rows->each(function (Crawler $row) use ($labelName, $childClass, $attributeName, &$rowDataItem) {
                //         $labels = $row->filter("label"); // Find label elements within the row

                //         // Extract label names
                //         $labelNames = $labels->each(function (Crawler $label) {
                //             return $label->text(); // Extract text from the label elements
                //         });

                //         $cells = $row->filter(".$childClass");

                //         foreach ($cells as $j => $cell) {
                //             $nodeValue = $cell->attr($attributeName);

                //             if (!empty($nodeValue) && isset($labelNames[$j])) {
                //                 $rowDataItem[$labelNames[$j]] = $nodeValue;
                //             }
                //         }
                //     });

                //     $rowData[] = $rowDataItem;
                // });

                // $this->data = $rowData;

            } else {
                // "Trade Name" not found, consider it as not valid
                $this->isValid = false;
                $this->tradeName = null;
            }
        } else {
            // Handle the case where the HTTP request fails
            $this->isValid = false;
            $this->tradeName = null;
        }

    }
    public function render()
    {
        return view('livewire.business-registration.gst-validation');
    }
}