<?php

namespace CD\Container;

use Closure;

/**
 * Interface ContainerDependenciasInterface
 * Define os métodos necessários para a implementação 
 * de uma classe container de dependências 
 * 
 * @author Dahan Schuster <dahan@moobitech.com.br>
 * @version 2.0.0
 */
interface ContainerDependenciasInterface {

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
    public static function has(string $sClasse): bool;

    /**
     * Retorna o valor, dentro do container, associado à 
     * chave enviada por parâmetro
     * 
     * @param string $sClasse
     * 
     * @return mixed
     * 
     * @author Dahan Schuster <dahan@moobitech.com.br>
     * @since 1.0.0 - Definição do versionamento da classe
	 * @since 2.0.0 - Contexto alterado para estático
     */
    public static function get(string $sClasse);

    /**
     * Define um valor dentro do container que pode ser
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
    public static function set(string $sClasse, Closure $fnFuncao);

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
    public static function singleton(string $sClasse, Closure $fnFuncao);
    
}
