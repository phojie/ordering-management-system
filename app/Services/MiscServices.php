<?php

declare(strict_types=1);

namespace App\Services;

class MiscServices
{
    public function getRandomColor(): string
    {
        $colors = [
            '#d44000', '#ff7a00',
            '#864000', '#184d47', '#9c3d54', '#c64756',
            '#2b2e4a', '#301b3f', '#e9896a', '#387c6d',
            '#4e3620', '#3a6351', '#387c6d', '#3a6351',
            '#693c72', '#d89216', '#7c9473', '#83a95c',
            '#fc8621', '#810000', '#1f441e', '#cc561e',
            '#2a9d8f', '#fb8500', '#ee9b00', '#e29578',
            '#7f5539', '#2d6a4f', '#0f4c5c', '#2f3e46',
            '#e56b6f', '#ee6c4d', '#2b9348', '#007f5f',
            '#7209b7', '#7b2cbf', '#335c67', '#8f3e00',
            '#fe7f2d', '#197278', '#4f772d', '#dd6e42',
            '#e07a5f',
        ];

        return \Arr::random($colors);
    }
}
