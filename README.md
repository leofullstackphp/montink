# 🛒 Montink - Sistema de Pedidos com Cupons

Este projeto é uma aplicação PHP com integração de cupons, controle de pedidos e suporte a webhook para atualização de status. Ele é configurado automaticamente via Docker e pronto para uso.

---

## 🗄️ Banco de Dados

O banco de dados do projeto é iniciado automaticamente com o Docker.

Ele utiliza o arquivo `tabelas.sql` localizado na raiz do projeto para criar as tabelas iniciais.

---

## 📩 Webhook de Atualização de Pedido (POST)

Você pode testar a atualização de um pedido utilizando uma requisição **POST** autenticada com **Basic Auth**.

### Exemplo:

```bash
curl --location 'http://localhost:8080/api/webhook' \
--header 'Authorization: Basic bW9udGluazptb250aW5r' \
--form 'id_pedido="8"' \
--form 'status="pago"'
