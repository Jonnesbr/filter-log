# Projeto Filter-Log 

# Instalação e Configuração

**Requerimentos:**
* Vagrant*;
* Node.js versão 4.x;
* npm - Node Package Manager.

A preparação do ambiente de desenvolvimento é divídida nas seguintes etapas abaixo:

### Ambiente de Desenvolvimento - Vagrant ou Docker

Utilizamos o [Vagrant](https://www.vagrantup.com/) para o isolamento e criação de um ambiente local de testes.

### Nodejs e npm

Existem [várias opções](https://nodejs.org/en/download/package-manager/) de instalação do Node.js, de acordo com o seu sistema operacional. abaixo segue um exemplo de instalação no Ubuntu e outros sistemas baseados no Debian:
```
curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
sudo apt-get install -y nodejs
```
É importante também instalar o pacote *build-essential* pois alguns pacotes instalados via npm podem possuir alguma dependência:
```
sudo apt-get install -y build-essential
```

### Gulp - Task Manager Front-End

Utilizamos o [Gulp](http://gulpjs.com/) como task manager para o desenvolvimento front-end para a automatização das seguintes tarefas:
* Verificação de erros em arquivos JavaScript;
* Compilação de css utilizando Sass;
* Concatenação e minificação de arquivos CSS e JavaScript;
* Otimização de imagens.

Instalação do Gulp-cli (alguns sistemas precisam do 'sudo'):
```
sudo npm install -g gulp-cli
```
A configuração do Gulp é feita no arquivo *gulpfile.js* localizado em 'appbase/assets'. Neste diretório encontramos também o arquivo *package.json* que ó o arquivo onde se encontram as dependências dos plugins que serão instalados para a utilização do Gulp.

Para a instalação das dependências, deve ser executado em 'appbase/assets/' o seguinte comando:
```
sudo npm install
```  
Após a instalação das dependências, o desenvolvedor pode testar o funcionamento executando o comando abaixo:
```
gulp
```
Para maiores informações sobre configuração e funcionamento do Gulp, por favor consulte a [documentação oficial](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md) e a documentação específica sobre seus plugins.

### Bower - Gerenciador de dependências de front-end

O [Bower](https://bower.io/) é utilizado como gerenciador de dependências do front-end, baixando automaticamente as bibliotecas e frameworks utilizados no front-end, como a jQuery e o Bootstrap.

Para instalar o Bower:
```
sudo npm install -g bower
```
As dependências de front-end do modelo base estão listadas no arquivo *bower.json*. Para a instalação das dependências acesse o diretório 'appbase/assets' e execute:
```
bower install
```
Para informações sobre a adição de outras dependências acesse a [documentação](https://bower.io/) do Bower ou fale com o lider técnico do projeto.

### Configuração do VHost

Primeiramente verifique que a VM está em funcionamento através do comando:
```
vagrant status
```
O caso a retorno deve ser parecido com este:
```
Current machine states:

default                   running (virtualbox)

The VM is running. To stop this VM, you can run `vagrant halt` to
shut it down forcefully, or you can run `vagrant suspend` to simply
suspend the virtual machine. In either case, to restart it again,
simply run `vagrant up`.

```
Caso o retorno seja diferente execute o comando a seguir para subir a VM:
```
vagrant up
```
Feito este passo, é necessário acessar a VM via **ssh** utilizando o comando:

```
vagrant ssh
```
Depois, acesse o diretório de configuração do servidor Apache e crie o arquivo de configuração:

```
$ cd /etc/etc/apache2/sites-available
$ sudo nano appbase.conf
```
Segue o exemplo de configuração para o CodeIgniter

```
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName filter-log.dev
        ServerAlias www.filter-log.dev
        DocumentRoot /var/www/filter-log
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Após a criação do arquivo de configuração, habilitar o novo arquivo e reiniciar o servidor Apache com os seguintes comandos:
```
sudo a2ensite appbase.conf
sudo service apache2 restart
```

### Configuração do framework
No diretório raiz do projeto, renomear o arquivo *config.php.example* para *config.php*. Alterar o conteúdo do arquivo *config.php* conforme o exemplo abaixo:
```
<?php
/*Exemplo de configuração*/

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);


define('AMBIENTE_URL','http://filter-log.dev/');
define('BASE_URL','http://filter-log.dev/');

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'nomedabase');

define('ENABLE_PROFILER', false);
```
Renomear também o arquivo *config.php.example* do diretório *application/config/config.php.example* para *config.php* e verificar com o lider técnico a necessidade de alteração de algum parâmetro de configuração.

### Acessar a url do projeto no ambiente local

Adicionar o ip da VM junto com o domínio da aplicação da seguinte forma:

```
sudo nano /etc/hosts
```
Dentro do arquivo *hosts* adicionar o dominio conforme o exemplo abaixo:
```
127.0.0.1       localhost.localdomain localhost
::1             localhost6.localdomain6 localhost6
192.168.33.10   filter-log.dev
```

