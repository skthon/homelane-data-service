<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    /**
     * Boot method for assigning uuid field value when creating a record
     */
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (empty($model->{$uuidFieldName})) {
                $model->{$uuidFieldName} = static::generateUuid();
            }
        });
    }

    /**
     * Get model's UUID field name.
     *
     * @return string
     */
    public function getUuidFieldName(): string
    {
        if (! empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }

        return 'uuid';
    }

    /**
     * Generate uuid
     */
    public static function generateUuid()
    {
        return (string) Str::orderedUuid();
    }
}
