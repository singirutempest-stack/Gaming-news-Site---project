<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin' || $this->user()?->role === 'journalist';
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255|unique:news,title',
            'short_description' => 'required|string|max:300',
            'content' => 'required|string|min:100',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|in:en,ru,kz',
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'video_type' => 'required|in:none,local,youtube',
            'video_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'required_if:video_type,local|nullable|mimes:mp4,webm|max:51200',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published',
            'views' => 'nullable|integer|min:0',
            'translations' => 'nullable|array',
            'translations.*.title' => 'nullable|string|max:255',
            'translations.*.short_description' => 'nullable|string|max:300',
            'translations.*.content' => 'nullable|string',
        ];
    }
}
