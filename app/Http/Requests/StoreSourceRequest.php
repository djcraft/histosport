<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SourceRules;
class StoreSourceRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() { return SourceRules::rules(); }
}
