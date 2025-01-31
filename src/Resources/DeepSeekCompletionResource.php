<?php 

namespace Johadtech\DeepSeekV3\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeepSeekCompletionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'content' => $this->content,
            'usage' => $this->usage,
        ];
    }
}
