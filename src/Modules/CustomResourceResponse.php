<?php

namespace Modules;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceResponse;

class CustomResourceResponse extends ResourceResponse
{
    /**
     * @param  array|Collection|\Illuminate\Database\Eloquent\Collection  $data
     * @return array
     */
    protected function wrap($data, $with = [], $additionalData = [])
    {
        $isEmpty = $this->resource->resource === null;

        if ($data instanceof Collection) {
            $data = $data->all();
        }

        if ($isEmpty || $this->haveDefaultWrapperAndDataIsUnwrapped($data)) {
            $data = [$this->wrapper() => $isEmpty ? null : $data];
        } elseif ($this->haveAdditionalInformationAndDataIsUnwrapped($data, $with, $additionalData)) {
            $data = [($this->wrapper() ?: 'data') => $data];
        }

        foreach ($additionalData as &$additional) {
            if ($additional instanceof CustomResource && $additional->resource === null) {
                $additional = null;
            }
        }

        return array_merge_recursive($data, $with, $additionalData);
    }
}
