<?php

namespace App\Http\V1\Requests\Reseller;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public const NAME = 'name';

    public const AVATAR_UPLOAD_ID = 'avatarUploadId';

    public const WEBSITE = 'website';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::NAME => 'string|required',
            self::AVATAR_UPLOAD_ID => 'string|nullable',
            self::WEBSITE => 'string|nullable',
        ];
    }
}
