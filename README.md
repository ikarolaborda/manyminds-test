# Manyminds API de Teste

## Instalação
1 - Clone o repositório:
```bash
git clone https://github.com/ikarolaborda/manyminds-test.git
```
2- Entre no diretório clonado:
```bash
cd manyminds-test
```
3 - Copie o arquivo .env.example para .env:
```bash
cp .env.example .env
```
Edite o arquivo .env com as informações do seu ambiente.
Deve ficar parecido com isso:
```bash
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_HOST=
```

4 - Execute o comando abaixo para iniciar os containers Docker:

```bash
make up
```

Para parar a execução da aplicação, execute o comando abaixo:

```bash
make down
```

## Aplicação:

Esta é uma aplicação simples que utiliza o framework CodeIgniter 3 com PHP, Docker, Nginx e MariaDB para fornecer um API para registro e autenticação de usuários e CRUD de funcionários e departamentos. A aplicação está estruturada de acordo com os princípios SOLID e utiliza consultas SQL cruas em vez de funções ORM.

A aplicação é executada em um ambiente Dockerizado e pode ser iniciada com um único comando utilizando o Makefile fornecido. A configuração do
ambiente pode ser personalizada no arquivo .env. Após a inicialização, as tabelas do banco de dados são criadas e preenchidas com dados iniciais utilizando o arquivo SQL de migração fornecido.

O API de registro e autenticação de usuários usa o método HTTP POST e retorna um token de autenticação que pode ser usado em solicitações futuras. O CRUD de funcionários e departamentos usa os métodos HTTP GET, POST, PUT e DELETE.

Para executar a aplicação, basta seguir os passos fornecidos acima. Certifique-se de editar o arquivo .env para corresponder às suas configurações de ambiente antes de iniciar a aplicação.

Este aplicativo é apenas um exemplo simples e pode ser usado como ponto de partida para criar aplicativos mais complexos.

### Débitos técnicos
Ainda em fase experimental, a aplicação não possui testes automatizados.
Possui endpoints para registro e autenticação de usuários, mas, por alguma razão, os tokens JWT não autenticam corretamente, mais investigações serão necessárias.
Construir um sistema de logs para registrar erros e atividades.
