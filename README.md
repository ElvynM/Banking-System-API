# Banking API 


<img width=100% src="https://capsule-render.vercel.app/api?type=waving&color=00FFFF&height=120&section=header"/>

[![Typing SVG](https://readme-typing-svg.herokuapp.com/?color=00FFFF&size=30&center=true&vCenter=true&width=1000&lines=Olá,Objective!+seja+bem+vindo++ao+meu+reposítorio+🧑🏻‍💻.)](https://git.io/typing-svg)

Este projeto é o backend da aplicação **Banking API**, desenvolvido com Laravel e configurado para rodar em um ambiente Docker com Laravel Sail.  

## Pré-requisitos  
Antes de começar, certifique-se de que você tem o seguintes itens instalados:  
- **Docker**  
- **WSL 2** com **Ubuntu** (para usuários Windows)  
- **Git**  

---

## Instalação  

### 1. Clonar o repositório  
Clone o repositório do GitHub para sua máquina local:  

```bash  
git clone git@github.com:ElvynM/Banking-System-API.git  
```  

### 2. Montar o ambiente Laravel com Docker  
Dentro do diretório clonado, execute o comando abaixo para configurar o projeto com o Laravel Sail:  

```bash  
curl -s "https://laravel.build/banking-api?with=mysql,redis" | bash  
```  

### 3. Subir os containers  
Após a montagem, navegue para o diretório do projeto e inicie os containers:  

```bash  
cd banking-api && ./vendor/bin/sail up  
```  

---

## Configuração  

### 4. Copiar o arquivo de exemplo `.env`  
Altere o arquivo `.env` com as credenciais apropriadas:  

```bash  
cp .env.example .env  
```  

Configure os valores necessários, como banco de dados, usuário e senha.  

---

## Banco de Dados  

### 5. Executar as migrations  
Para configurar o banco de dados, rode as migrations:  

```bash  
./vendor/bin/sail artisan migrate  
``` 
```bash 
./vendor/bin/sail artisan make:model accounts -m
``` 
```bash
    ./vendor/bin/sail artisan make:migration create_transactions_table
```
```bash
./vendor/bin/sail artisan migrate:status
```



### 
---

## Comandos úteis  
- **Subir rota da api laravel 11:**
```bash
    php artisan install:api
```    
- **Subir os containers:**  
  ```bash  
  ./vendor/bin/sail up  
  ```  
- **Pausar os container:**
    ```bash   
    ./vendor/bin/sail stop
    ```

- **Acessar os container:**  
  ```bash  
  ./vendor/bin/sail shell  
  ```  
- **Acessar os container mysql:**  
  ```bash  
    mysql -h mysql -u sail -p
    SHOW DATABASES
  ```  
- **executar privileges in user sail:**
    ```bash 
    GRANT CREATE, DROP ON *.* TO 'sail'@'%';
    FLUSH PRIVILEGES;

    GRANT ALL PRIVILEGES ON *.* TO 'sail'@'%' WITH GRANT OPTION;
    FLUSH PRIVILEGES;
    ``` 


- **Remove os container:**  
  ```bash  
  ./vendor/bin/sail stop
  ``` 
- **Criar uma Model:**  
  ```bash  
  ./vendor/bin/sail artisan make:model Conta -m
  ``` 
- **Criar uma Controller:**  
  ```bash  
  ./vendor/bin/sail artisan make:controller AccountsController
  ```

  **Criar Teste Automatizados:**  
   ```bash
   **criar o arquivo via linha de comando**
    touch tests/Feature/TransactionTest.php

   ```
   ```bash  
  ./vendor/bin/sail test --filter AccountTest
  ./vendor/bin/sail test --filter TransactionTest

  
  ```
  **Rodar Teste Automatizados:**  
   ```bash  
    ./vendor/bin/sail artisan test
  ```

  
- **Executar API -  Transaction:**  
    ```
  O projeto estará disponível em [http://localhost:8000/api/transaction](POST).  
  ```
- **Executar API - Accounts POST:**  
  O projeto estará disponível em - criar conta [http://localhost:8000/api/accounts](POST). 

- **Executar API - Accounts:**  
  O projeto estará disponível em - criar conta [http://localhost:8000/api/accounts/139](GET).

---

## Suporte  
Para dúvidas ou problemas, entre em contato com [ElvynM](mailto:elvyn@example.com) ou abra uma issue no repositório.



<div align="center">
<br><p align="centre"><b>Visitors Count</b></p>  
<p align="center"><img align="center" src="https://profile-counter.glitch.me/{ELVYN}/count.svg" /></p> 
<br>
</div>


