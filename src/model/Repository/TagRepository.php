<?php

namespace Demo\Repositories;

/**
 * Classe TagRepository
 * 
 * @version 1.0.0
 * 
 */
class TagRepository
{

    public function findById(int $iId) : array {
        return [
            'id' => $iId,
            'name' => 'tag',
        ];
    }

}
