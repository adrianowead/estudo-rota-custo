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

Neste caso o composer deve ser executado para gerar o [__autoload__](https://getcomposer.org/doc/04-schema.md#psr-4), com o comando abaixo:

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


## Consumo de endpoints

Para Utilização as APIs, basta seguir conforme os exemplos abaixo:

> Os exemplos abaixo consideram que o [ambiente web](#utilização-via-web) esteja sendo executado.

* __Cadastro de nova rota__

```bash
$ curl -d "from=GRU&to=REC&price=32" -X POST http://localhost:8000/route
```

* __Consulta de uma rota__

```bash
$ curl -X GET http://localhost:8000/quote/GRU/SCL
```

## Utilização via Web

Para rodar a versão web do projeto, basta configurar seu servidor web, tendo como raíz a pasta onde está o arquivo [__index.php__](./index.php)

Ou executar o servidor embutido, como no exemplo abaixo:

```bash
$ php -S localhost:8000 -t .
```

Mesmo no ambiente web, não foi utilizada nenhuma biblioteca, o __JS__ e __CSS__ foram escritos do zero, valendo-se apenas da compilação de __TS__ e __SCSS__ respectivamente. Onde os fontes estão [neste diretório](./assets).

### Alteração de mensagens

Para alterar as mensagens, basta modificar o arquivo [__steps.json__](./steps.json).


### Rodar os testes

É necessário ter instalada as dependências de desenvolvimento definidas no [__composer.json](./composer.json), além de ter habilidado no seu sistema o [__xdebug__](https://xdebug.org/docs/install) para gerar o relatório de cobertuda de código.

Uma vez que o ambiente esteja configurado, execute o comando abaixo:

```bash
$ composer run test tests/
```


### Disclaimer

Até o presente momento este código foi testado em ambiente *nix (MacOS). Então é possível que em ambientes Windows ocorram alguns problemas com a interface via CLI.

### Agradecimentos

Obrigado ao [John](https://medium.com/@johnopaul) pelo ótimo [post](https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241) sobre criação de [rotas amigáveis](https://techterms.com/definition/friendly_url), semelhante ao funcionamento do [Laravel](https://laravel.com/docs/7.x/routing).
