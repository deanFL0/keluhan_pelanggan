<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeluhanPelangganDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'nomor_hp' => $this->nomor_hp,
            'keluhan' => $this->keluhan,
            'status_keluhan' => $this->status_keluhan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status_history' => KeluhanStatusHisResource::collection($this->statusHistory),
        ];
    }
}
