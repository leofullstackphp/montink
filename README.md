# 🛒 Montink - Sistema de Pedidos com Cupons

Este projeto é uma aplicação PHP com integração de cupons, controle de pedidos e suporte a webhook para atualização de status.

---

## 🚀 Como iniciar o projeto

Para iniciar o projeto, basta executar o comando:

```bash
docker-compose up -d
```

Após a inicialização, o sistema estará disponível em:

- 🖥️ Aplicação: [http://localhost:8080](http://localhost:8080)  
- 🗃️ phpMyAdmin: [http://localhost:8081](http://localhost:8081)  
  - **Usuário:** `root`  
  - **Senha:** `root`

---

## 🗄️ Banco de Dados

O banco de dados do projeto é iniciado automaticamente com o Docker.

Ele utiliza o arquivo `tabelas.sql` localizado na raiz do projeto para criar as tabelas iniciais automaticamente.

---

## 📩 Webhook de Atualização de Pedido (POST)

Você pode testar a atualização de um pedido utilizando uma requisição **POST** autenticada com **Basic Auth**.

### Exemplo:

```bash
curl --location 'http://localhost:8080/api/webhook' --header 'Authorization: Basic bW9udGluazptb250aW5r' --form 'id_pedido="8"' --form 'status="pago"'
```

🔐 **Autenticação**:  
- **Usuário:** `montink`  
- **Senha:** `montink`

✅ O status do pedido será atualizado com o valor informado (`pago`, `cancelado`, etc).  
❌ Se o status enviado for `cancelado`, o pedido será **removido automaticamente**, junto com os itens vinculados (`pedidos_itens`) via exclusão em cascata.

---

## 📦 Migração de Cupons

Para rodar a **migração de cupons**, siga os passos abaixo:

1. Abra o arquivo `cupons.csv` localizado na raiz do projeto e insira os cupons no seguinte formato:

   ```
   codigo,tipo,valor,quantidade_uso,usado,validade
   DESCONTO10,percentual,10.00,100,0,2025-12-31
   ```

2. ⚠️ **Atenção**: o campo `codigo` é **único**.  
   Se você tentar inserir um cupom com o mesmo código mais de uma vez, ocorrerá erro.

3. Acesse o container do seu projeto PHP:

   ```bash
   docker exec -it CONTAINER_ID bash
   ```

4. Execute o script de migração:

   ```bash
   php cupons-migrar.php
   ```

Após a execução, os cupons serão inseridos no banco de dados e você verá mensagens de sucesso no terminal.