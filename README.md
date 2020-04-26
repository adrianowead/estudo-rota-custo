# Rota Custo - Asa Quebrada Air Lines!

Este projeto é um teste de como seria suportar suas formas de interação com o usuário, via CLI e via Web.

[![Building](https://img.shields.io/circleci/build/github/adrianowead/estudo-rota-custo?token=master)]()
[![Size](https://img.shields.io/github/repo-size/adrianowead/estudo-rota-custo)]()
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/badges/build.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/adrianowead/estudo-rota-custo/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

## Necessário
[![Supported PHP version](https://img.shields.io/badge/PHP->%3D%207.2-blue.svg)]()

## Instalação

Este projeto não usa nenhum compoente de terceiros, somente pacotes necessários para os testes unitários e demais recursos de debug.

Neste caso o composer deve ser executado para gerar o __autoload__, com o comando abaixo:

```bash
$ composer install --no-dev --optimize-autoloader
```

Ou apenas o autoload mesmo:

```bash
$ composer dumpautoload
```

### Utilização via CLI

Para ver a utilização via CLI, execute o [__index.php__](./index.php).

```bash
$ php index.php
```

Feito isso iniciará a comunicação via CLI.

## Rotas novas

Para carregar novas rotas, basta __editar__ o arquivo [__exemplo.csv__](./exemplo.csv), mantendo a mesma estrutura (sem cabeçalho) e separado por vírgula:

```csv
GRU,CXJ,12
CXJ,POA,33
GRU,POA,22
```

| Origem  | Destino  | Valor  |
|:-:|:-:|:-:|
| GRU  | CXJ  | 12  |
| CXJ  | POA  | 33  |
| GRU  | POA  | 22  |

## Alteração de mensagens

Para alterar as mensagens, basta modificar o arquivo [__steps.json__](./steps.json).
