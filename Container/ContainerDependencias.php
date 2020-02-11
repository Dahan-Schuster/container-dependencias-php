<?php

namespace CD\Container;

use Closure;
use ContainerException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;
use Throwable;

/**
 * Classe ContainerDependencias
 *
 * @package CD\Container
 * @version 1.0.0 - Versionamento inicial da classe
 */
class ContainerDependencias implements ContainerDependenciasInterface {

    /**
     * O array de dependências (o container em si)
     *
     * @var array
     */
    private static $aDependecias = [];
    
    /**
     * Retorna um booleano que representa a presença um
     * valor, dentro do container, associado à chave
     * enviada por parâmetro
     *
     * Se has($sChave) retornar true, então não há nenhum
     * valor no container associado a $sChave e, portanto,
     * get($sChave) irá lançar uma NotFoundExceptionInterface
     * @param string $sClasse
     *
     * @return bool
     *
     * @see ContainerDependenciasInterface::get($sChave)
     *
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function has(string $sClasse): bool {
       return isset(self::$aDependecias[$sClasse]);
    }
	
	/**
	 * Invoca a Closure definida em uma chave do container
	 * e retorna seu resultado
	 *
	 * @param string $sClasse
	 * @throws ContainerException
	 *
	 * @return mixed
	 *
	 * @author Dahan Schuster <dahan@moobitech.com.br>
	 * @since 1.0.0 - Definição do versionamento da classe
	 * @since 2.0.0 - Contexto alterado para estático
	 */
    public static function get(string $sClasse) {
		if (self::has($sClasse)) {
			return (self::$aDependecias[$sClasse])();
		}
		
		try {
			return self::resolverDependenciasDaClasse($sClasse);
		} catch (Throwable $e) {
			throw new ContainerException('Ocorreu um erro ao tentar realizar o autowiring', $e->getCode(), $e);
		}
    }
	
	/**
	 * Descreva o método
	 *
	 * @param string $sClasse
	 * @author Dahan Schuster dahan@moobitech.com.br
	 * @return object
	 * @throws ReflectionException
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private static function resolverDependenciasDaClasse(string $sClasse) {
		$oReflexoDaClasse = new ReflectionClass($sClasse);
		$oConstrutorDaClasse = $oReflexoDaClasse->getConstructor();
		
		if (is_null($oConstrutorDaClasse)) {
			$oObjeto = new $sClasse();
		} else {
			$oObjeto = self::prepararClasseEInstanciar($oReflexoDaClasse, $oConstrutorDaClasse);
		}
		
		self::set($sClasse, function() use ($oObjeto) {
			return $oObjeto;
		});
		
		return $oObjeto;
    }
	
	/**
	 * Descreva o método
	 *
	 * @param ReflectionClass $oReflexoDaClasse
	 * @param ReflectionMethod $oConstrutorDaClasse
	 * @author Dahan Schuster dahan@moobitech.com.br
	 * @return object
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private static function prepararClasseEInstanciar(
		ReflectionClass $oReflexoDaClasse,
		ReflectionMethod $oConstrutorDaClasse) {
		return $oReflexoDaClasse->newInstanceArgs(self::instaciarDependenciasParaOConstrutor($oConstrutorDaClasse));
	}
	
	/**
	 * Descreva o método
	 *
	 * @param ReflectionMethod $oConstrutorDaClasse
	 * @author Dahan Schuster dahan@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private static function instaciarDependenciasParaOConstrutor(ReflectionMethod $oConstrutorDaClasse) {
		return array_map(
			function (ReflectionParameter $rDependencia) {
				return self::get($rDependencia->getClass()->getName());
			},
			$oConstrutorDaClasse->getParameters()
		);
	}

    /**
     * Define uma função anônima dentro do container que pode ser
     * acessado atráves da chave definida no primeiro parâmetro
     *
     * @param string $sClasse
     * @param Closure $fnFuncao
     *
     * @return void
     *
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function set(string $sClasse, Closure $fnFuncao): void {
        self::$aDependecias[$sClasse] = $fnFuncao;
    }
    
    /**
     * Define um valor dentro do container que pode ser
     * acessado atráves da chave definida no primeiro parâmetro
     *
     * Diferentemente do método set(), o singleton irá salvar uma
     * dependência que, ao ser chamada, não é instanciada novamente
     * Ou seja, chamadas ao método get() irão retornar apenas uma
     * instância do mesmo valor, sendo compartilhado por todas as
     * chamadas
     *
     * @param string $sClasse
     * @param Closure $fnFuncao
     *
     * @return void
     *
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function singleton(string $sClasse, Closure $fnFuncao) {
		self::$aDependecias[$sClasse] = function() use ($fnFuncao) {
			static $fnFuncaoSingleton;
			
			if (is_null($fnFuncaoSingleton)) {
				$fnFuncaoSingleton = $fnFuncao($this);
			}
			
			return $fnFuncaoSingleton;
		};
    }
    
}
