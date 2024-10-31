<?php

namespace Coreproc\NovaArtisanCards\ArtisanCall\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtisanCallRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'command' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
