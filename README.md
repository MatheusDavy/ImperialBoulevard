## CMS_2023

## Requerimentos

#### PHP a partir do 8.1;

## Instalação

#### Primeiro de tudo é necessário clonar o repositório. Uma maneira de fazer isso é ir até a página onde deseja instalar o projeto e rodar o comando:

```
git clone https://github.com/weecomdev/CMS-Base-Weecom-2023.git
```

#### Isto feito é então necessário fazer uma copia e depois renomear o arquivo .env.example para .env (no projeto então vai ficar um .env.example e um .env) e então abrir o terminal no path do projeto e rodar dois comandos:

Primeiro:

```
composer install
```

Segundo:

```
composer update
```

#### Após a instalação e atualização do projeto é necessário criar e popular a base de dados.

Primeiro, comente uma linha na web.php

```
// Rotas do ADM
colocar /** aqui
Route::redirect('adm/', 'dash');
Route::group(['prefix' => 'adm'], function () {
```

Para isso, crie uma base de dados com qualquer nome, abra o arquivo .env e preencha os dados da database e rode o comando para executar as migrations das tables e os seeders
que irão popular elas:

```
php artisan migrate:fresh --seed
```

Feito isso, tire o comentário /** da página web.php.

#### Com a base de dados criada. É preciso rodar dois comandos para compilar os assets do projeto.

Primeiro:

```
npm install
```

Segundo:

```
npm run dev
```

#### Finalmente, é preciso subir o servidor e ir até o caminho adm/login no browser. Para subir o servidor:

```
php artisan serve
```
