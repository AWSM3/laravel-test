<?php
declare(strict_types=1);

/** @namespace */
namespace App\Http\Requests;

/** @uses */
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * Class ProcessMailingRequest
 * @package App\Http\Requests
 */
class ProcessMailingRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'images'   => 'required|array',
            'images.*' => 'url',
            'file'     => 'required|file'
        ];
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->get('images');
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file('file');
    }
}
