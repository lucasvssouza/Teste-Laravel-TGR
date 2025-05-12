# 🛒 Sistema de Gerenciamento de Produtos - Laravel 12

Este projeto é uma aplicação CRUD completa desenvolvida com **Laravel 12**, utilizando **Blade**, **Vite**, **SQLite** e **jQuery**. O sistema permite criar, editar, listar, visualizar e excluir produtos com uma interface moderna e paginada.

---

## ⚙️ Requisitos

- PHP >= 8.2
- Composer
- Node.js + NPM
- SQLite (ou outro banco configurável)
- Navegador moderno

---

## 🚀 Instalação

### 1. Clone o repositório

```bash
gh repo clone lucasvssouza/Teste-Laravel-TGR
```

### 2. Instale as dependências do PHP e front-end

```bash
composer install
npm install
```

### 3. Crie o arquivo `.env`

```bash
cp .env.example .env
```

Edite o `.env` com os dados do banco de dados de sua preferência.

### 4. Gere a chave da aplicação caso necessário

```bash
php artisan key:generate
```

### 5. Execute as migrations

```bash
php artisan migrate
```

> Caso queira é possivel popular a tabela produtos com 30 itens fictícios.
> 
> ```bash
> php artisan db:seed
> ```

### 6. Compile os assets com Vite (opcional)

```bash
npm run dev
```

> Ou para produção:
> 
> ```bash
> npm run build
> ```

---

## 🖥️ Como rodar o projeto

Execute o servidor integrado do Laravel:

```bash
php artisan serve
```

Abra no navegador: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧪 Funcionalidades

- ✅ Cadastro de produtos
- ✅ Edição de produtos
- ✅ Exclusão com confirmação
- ✅ Visualização de detalhes
- ✅ Busca por nome (com pesquisa parcial)
- ✅ Paginação com navegação
- ✅ Validações e feedbacks com SweetAlert2
- ✅ Máscaras de campos (preço e quantidade)
- ✅ Interface responsiva com Bootstrap 5
- ✅ Componentização de alerts e máscaras

---

## 📁 Estrutura do Projeto

- `resources/views/produtos` — Views principais (`index`, `create`, `edit`, `show`)
- `resources/views/components` — Componentes Blade reutilizáveis
- `routes/web.php` — Rotas da aplicação
- `database/seeders` — Seeders para gerar dados de teste
- `public/` — Arquivos públicos e favicon

---

## 📝 Licença

Este projeto está sob a licença MIT.

---
