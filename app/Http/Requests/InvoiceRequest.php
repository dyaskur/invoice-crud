<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Subject field is required.',
        ];
    }

    public function data()
    {
        return [
            'subject'        => $this->subject ?? $this->name,
            'invoice_number' => str_pad(Invoice::query()->latest()->first()->invoice_number + 1, 4, '0', STR_PAD_LEFT),
            'issue_date'     => $this->issue_date,
            'due_date'       => $this->due_date,
            'sub_total'      => $this->sub_total ?? 0,
            'tax_percentage' => $this->tax_percentage,
            'total_payment'  => $this->total_payment,
            'issued_by'      => $this->issued_by,
            'issued_for'     => $this->issued_for,
            'status'         => $this->status ?? "draft",
        ];
    }
}
