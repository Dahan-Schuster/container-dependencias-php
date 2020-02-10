<?php

namespace CD\Container;

use Closure;

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
     * @see ContainerDependenciasInterface::get($sChave)
     * 
     * @param string $sChave
     * 
     * @return bool
     * 
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function has(string $sChave): bool {
       return isset(self::$aDependecias[$sChave]);
    }

    /**
     * Invoca a Closure definida em uma chave do container
	 * e retorna seu resultado
     * 
     * @param string $sChave
     * 
     * @return mixed
     * @throws NotFoundExceptionInterface
     * 
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function get(string $sChave) {
        return (self::$aDependecias[$sChave])($this);
    }

    /**
     * Define uma função anônima dentro do container que pode ser
     * acessado atráves da chave definida no primeiro parâmetro
     * 
     * @param string $sChave
     * @param Closure $fnFuncao
     * 
     * @return void
     * 
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function set(string $sChave, Closure $fnFuncao): void {
        self::$aDependecias[$sChave] = $fnFuncao;
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
     * @param string $sChave
     * @param Closure $fnFuncao
     * 
     * @return void
     * 
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
     * @since 2.0.0 - Contexto alterado para estático
     */
    public static function singleton(string $sChave, Closure $fnFuncao) {
		self::$aDependecias[$sChave] = function() use ($fnFuncao) {
			static $fnFuncaoSingleton;
			
			if (is_null($fnFuncaoSingleton)) {
				$fnFuncaoSingleton = $fnFuncao($this);
			}
			
			return $fnFuncaoSingleton;
		};
    }

}
