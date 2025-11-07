<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PersonneRules;
class StorePersonneRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() { return PersonneRules::rules(); }
}
