<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReadingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {

        $base64 = null;
        if ($this->cover_base64) {
            $name = Str::slug(Str::random(15) . '-' . $this->month_ref) . time() . '.png';
            $file = base64_decode(preg_replace(
                '#^data:image/\w+;base64,#i',
                '',
                $this->cover_base64
            ));
            $path = Storage::put('readings/' . $name, $file);
            $base64 = $name;
        }

        if ($base64) {
            $this->merge([
                'cover_base64' => $base64,
                'reading' => str_replace(',', '.', str_replace('.', '', $this->reading)),
                'reading_date' => Carbon::createFromFormat('d/m/Y', $this->reading_date)->format('Y-m-d'),
                'reading_date_next' => Carbon::createFromFormat('d/m/Y', $this->reading_date_next)->format('Y-m-d'),
            ]);
        } else {
            $this->merge([
                'reading' => str_replace(',', '.', str_replace('.', '', $this->reading)),
                'reading_date' => Carbon::createFromFormat('d/m/Y', $this->reading_date)->format('Y-m-d'),
                'reading_date_next' => Carbon::createFromFormat('d/m/Y', $this->reading_date_next)->format('Y-m-d'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meter_id' => 'required|min:1',
            'reading' => 'required|numeric|between:0,999999999.9999999999999',
            'month_ref' => 'required|min:1|max:20|in:Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro',
            'year_ref' => 'required|min:4|max:4',
            'reading_date' => 'required|date_format:Y-m-d',
            'reading_date_next' => 'required|date_format:Y-m-d',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1024|dimensions:max_width=1800,max_height=1800',
            'cover_base64' => 'nullable',
            'url_cover' => 'nullable|url|max:1500'
        ];
    }

    public function messages()
    {
        return [
            'reading.between' => 'O campo leitura deve ser entre 0 e 999.999.999,9999999999999.',
            'reading_date.date_format' => 'Formato de data inválido',
            'reading_date_next.date_format' => 'Formato de data inválido',
        ];
    }
}
