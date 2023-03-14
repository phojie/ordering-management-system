<?php

declare(strict_types=1);

namespace App\Traits;

trait Generate
{
    public function generateFullname($data)
    {
        if ($data->suffix) {
            $suffix = ", $data->suffix";
        } else {
            $suffix = '';
        }

        $fullname = (string) ucwords(mb_strtolower("{$data->first_name} {$data->last_name}")).$suffix;

        return $fullname;
    }
}
