# Container de Dependências em PHP

## Implementação de uma classe ContainerDependecias que implenta uma interface

seguindo a PSR-11

Os métodos assinados pela interface ContainerDependenciasInterface são:

* has($sChave): bool;
* get($sChave);
* set($sChave, Closure $fnCallback);
* singleton($sChave, Closure $fnCallback);

<!-- TODO: colocar print das assinaturas -->

### Observações

* A pasta src/Container contém a implementação do Container de Dependências
* Todo o restante do código serve apenas como um projeto demo para o container, a fim de facilitar o aprendizado e os testes
* As variáveis estão escritas seguindo a [Notação Húngara](https://en.wikipedia.org/wiki/Hungarian_notation#Examples)
