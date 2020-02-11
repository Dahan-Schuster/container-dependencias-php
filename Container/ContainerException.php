<?php

use CD\Container\ContainerExceptionInterface;

class ContainerException extends Exception implements ContainerExceptionInterface {
 
	public function __construct($sMensagem = "", $iCodigo = 0, Throwable $oAnterior = null) {
		parent::__construct($sMensagem, $iCodigo, $oAnterior);
	}
}