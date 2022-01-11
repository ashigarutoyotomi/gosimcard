<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateSimCardData extends DataTransferObject
{
    intpublic $id;
    stringpublic $name;
    intpublic $quantity;
    ?stringpublic $image_src;

    public static function fromRequest(int $simcardId,
        SimCardRequest $request) : UpdateSimCardData {
        $data = [
            'id' => $simcardId,
            'name' => $request->get('name'),
            'quantity' => (int) $request->get('quantity'),
        ];
        $file = = $request->file('image');
        if ($file){
            $data['image_src']=$file->store('images/simcard');
        } else {
            Storage::delete($data['image_src']);
            $data['image_src']= null;
        }
        return new self($data);
    }
}
