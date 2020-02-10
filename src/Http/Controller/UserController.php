<?php

namespace Demo\Controller;

use Demo\Repositories\TagRepository;
use Demo\Repositories\UserRepository;
use Demo\Repositories\LeadRepository;

/**
 * Classe UserController
 * 
 * @version 1.0.0
 */
class UserController {
	
	public $iNumber;

    /** @var TagRepository */
    protected $oTagRepository;

    /** @var UserRepository */
    protected $oUserRepository;

    /** @var LeadRepository */
    protected $oLeadRepository;

    public function __construct(
        TagRepository $oTagRepository,
        UserRepository $oUserRepository,
        LeadRepository $oLeadRepository
    ) {
        $this->oTagRepository = $oTagRepository;
        $this->oUserRepository = $oUserRepository;
        $this->oLeadRepository = $oLeadRepository;
    }

    public function index() : void {
        var_dump(
        	$this->iNumber,
            $this->oTagRepository->findById(1),
            $this->oUserRepository->findById(2),
            $this->oLeadRepository->findById(3)
        );
    }

}
