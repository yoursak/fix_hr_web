<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;

/**
 * Laravel Custom Helper
 *
 * @package		Laravel
 * @subpackage  Layout Helper
 * @category	Helpers
 * @author		Aman Sahu
 */


class ApiResponse
{
  public static function getFirstWord($sentence)
  {
    $words = explode(' ', $sentence);
    if (!empty($words)) {
      return strtolower($words[0]); // Convert the first word to lowercase

    } else {
      return ""; // Return an empty string if the sentence is empty
    }
  }

  public static function concatenateFirstCharacters($sentence)
  {
    $words = explode(' ', $sentence);
    $concatenated = '';

    foreach ($words as $word) {
      if (!empty($word)) {
        $concatenated .= strtolower($word[0]);
      }
    }

    return $concatenated;
  }

  public static function customDateFormat($date)
  {
    return date('F j, Y', strtotime($date));
  }

  public static function JsonResponse($parameter)
  {
    return response()->json($parameter);
  }
}
