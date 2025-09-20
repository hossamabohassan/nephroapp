<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|in:home,book,info,user,settings,mail',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'opens_in_new_tab' => 'boolean',
            'permission' => 'required|string|in:public,editor,admin',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The menu item title is required.',
            'url.required' => 'The URL is required.',
            'icon.in' => 'Please select a valid icon.',
            'order.required' => 'The order is required.',
            'order.min' => 'The order must be 0 or greater.',
            'permission.required' => 'The permission level is required.',
            'permission.in' => 'Please select a valid permission level.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
            'opens_in_new_tab' => $this->has('opens_in_new_tab'),
        ]);
    }
}