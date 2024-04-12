<?php

namespace App\Http\Requests;

use App\Enums\FruitUnit;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class FruitStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', new Enum(FruitUnit::class)],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
