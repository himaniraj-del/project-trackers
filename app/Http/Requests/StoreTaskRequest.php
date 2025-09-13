<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ];
    }
}
