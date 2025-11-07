<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CompetitionRules;
class StoreCompetitionRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() { return CompetitionRules::rules(); }
}
