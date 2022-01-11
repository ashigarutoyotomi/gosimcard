<?php
namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardData extends DataTransferObject
{
    stringpublic $name;
    intpublic $quantity;
    ?stringpublic $image_src;

    public static function fromRequest(SimCardRequest $request) : CreateSimCardData
    {
        $data = [
            'name' => $request->get('name'),
            'quantity' => (int) $request->get('quantity'),
        ];
        $file = $request->file('image');
        if ($file) {
            $data['image_src'] = $file->store('images/simcard');
        }
        return new self($data);
    }
}
