<?php

namespace Demo\Repositories;

/**
 * Classe LeadRepository
 * 
 * @version 1.0.0
 * 
 */
class LeadRepository
{

    public function findById(int $iId) : array {
        return [
            'id' => $iId,
            'name' => 'lead',
        ];
    }

}

