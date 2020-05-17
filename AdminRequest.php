<?php

namespace App\Panel;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    if (isDeleteMethod()) return [];
    $filters = json_decode(request()->get('filters'));
    $roles = [];

    foreach ($filters as $filter) {
      if (($filter->required || $filter->postRequired) && !$filter->nullable) {
        $roles[$filter->fillable] = "required|" . $this->getMaxFilter($filter) . $this->getMinFilter($filter);
      }
    }
    return $roles;
  }

  public function attributes()
  {
    $filters = json_decode(request()->get('filters'));
    $roles = [];

    foreach ($filters as $filter) {
      $roles[$filter->fillable] = $filter->label;
    }

    return $roles;
  }


  private function getMaxFilter($filter)
  {
    $filter = $filter->filterMax;
    if ($filter == null || !is_numeric($filter)) return null;
    return "max:$filter|";
  }

  private function getMinFilter($filter)
  {
    $filter = $filter->filterMin;
    if ($filter == null || !is_numeric($filter) || $filter < 0) return null;
    return "min:$filter|";
  }


}
