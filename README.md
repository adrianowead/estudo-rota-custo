# Rota Custo - Asa Quebrada Air Lines!

Este projeto é um teste de como seria suportar suas formas de interação com o usuário, via CLI e via Web.

## Instalação

Este projeto não usa nenhum compoente de terceiros, somente pacotes necessários para os testes unitários e demais recursos de debug.

### Utilização via CLI

Para ver a utilização via CLI, execute o __index.php__.

```
$ php index.php
```

Feito isso iniciará a comunicação via CLI.

## Rotas novas

Para carregar novas rotas, basta __editar__ o arquivo __exemplo.csv__, mantendo a mesma estrutura:

| Origem  | Destino  | Valor  |
|:-:|:-:|:-:|
| GRU  | CXJ  | 12  |
| CXJ  | POA  | 33  |
| GRU  | POA  | 22  |

## Alteração de mensagens

Para alterar as mensagens, basta modificar o arquivo __steps.json__.
