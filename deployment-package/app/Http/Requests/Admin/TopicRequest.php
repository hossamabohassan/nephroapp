<?php

namespace App\Http\Requests\Admin;

use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicRequest extends FormRequest
{
    private ?string $jsonError = null;
    private ?string $metaError = null;

    public function authorize(): bool
    {
        return $this->user()?->isEditor() ?? false;
    }

    public function rules(): array
    {
        $topicId = $this->route('topic')?->id ?? null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', Rule::unique('topics', 'slug')->ignore($topicId)],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in([Topic::STATUS_DRAFT, Topic::STATUS_REVIEW, Topic::STATUS_PUBLISHED])],
            'summary' => ['nullable', 'string'],
            'template_id' => ['nullable', 'exists:templates,id'],
            'data' => ['required', 'array'],
            'meta' => ['nullable', 'array'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'publish' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('status')) {
            $this->merge(['status' => Topic::STATUS_DRAFT]);
        }

        $this->merge([
            'publish' => $this->boolean('publish'),
        ]);

        $payload = $this->input('data');
        if (is_string($payload)) {
            try {
                $decoded = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
                $this->merge(['data' => $decoded ?? []]);
            } catch (\JsonException $exception) {
                $this->jsonError = $exception->getMessage();
                $this->merge(['data' => null]);
            }
        }

        $meta = $this->input('meta');
        if (is_string($meta) && $meta !== '') {
            try {
                $decodedMeta = json_decode($meta, true, 512, JSON_THROW_ON_ERROR);
                $this->merge(['meta' => $decodedMeta ?? []]);
            } catch (\JsonException $exception) {
                $this->metaError = $exception->getMessage();
                $this->merge(['meta' => null]);
            }
        }
    }

    public function withValidator($validator): void
    {
        if ($this->jsonError) {
            $validator->after(function ($validator) {
                $validator->errors()->add('data', 'JSON parse error: '.$this->jsonError);
            });
        }

        if ($this->metaError) {
            $validator->after(function ($validator) {
                $validator->errors()->add('meta', 'JSON parse error: '.$this->metaError);
            });
        }
    }

    public function payload(): array
    {
        $validated = $this->validated();

        return [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'subtitle' => $validated['subtitle'] ?? null,
            'status' => $validated['status'],
            'summary' => $validated['summary'] ?? null,
            'template_id' => $validated['template_id'] ?? null,
            'data' => $validated['data'],
            'meta' => $validated['meta'] ?? [],
            'category_id' => $validated['category_id'] ?? null,
            'publish' => $validated['publish'] ?? false,
        ];
    }
}




