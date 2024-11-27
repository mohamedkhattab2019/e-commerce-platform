<?php
namespace App\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryDTO
{
    public string $name_en;
    public string $name_ar;

    public function __construct(string $name_en, string $name_ar)
    {
        $this->name_en = $name_en;
        $this->name_ar = $name_ar;
    }

    public static function fromArray(array $data): self
    {
        $validator = Validator::make($data, [
            // 'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return new self(
            $data['name_en']??$data['name_ar'],
            $data['name_ar']
        );
    }
}
