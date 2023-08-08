<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\ImageColumn;

class S3ImageColumn extends ImageColumn
{
    public function getImagePath(): ?string
    {
        $state = $this->getState();
        if ($state) {
            return env('AWS_S3_URL').$state;
        }

        return null;
    }
}
