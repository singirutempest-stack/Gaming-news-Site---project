<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        $news = $this->route('news') ?: $this->route('id');
        $newsId = is_object($news) ? $news->id : $news;

        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('news', 'title')->ignore($newsId),
            ],
            'short_description' => 'required|string|max:300',
            'content' => 'required|string|min:100',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'video_type' => 'required|in:none,local,youtube',
            'video_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'required_if:video_type,local|nullable|mimes:mp4,webm|max:51200',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published',
            'views' => 'nullable|integer|min:0',
            'translations' => 'nullable|array',
            'translations.*.title' => 'nullable|string|max:255',
            'translations.*.short_description' => 'nullable|string|max:300',
            'translations.*.content' => 'nullable|string',
        ];
    }
}
