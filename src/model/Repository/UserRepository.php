<?php

namespace Demo\Repositories;

/**
 * Classe UserRepository
 * 
 * @version 1.0.0
 * 
 */
class UserRepository
{

    public function findById(int $iId) : array {
        return [
            'id' => $iId,
            'name' => 'user',
        ];
    }

}

