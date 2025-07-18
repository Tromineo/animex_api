#  Animex - API Backend para Catálogo de Animes

---

##  Sobre o Projeto
**Animex** é uma API backend desenvolvida em PHP que oferece funcionalidades para gerenciamento, avaliação e recomendação de animes.  
O sistema permite cadastro de animes, criação de listas de favoritos, comentários, avaliações e envio de notificações para usuários.

---

## Tecnologias Utilizadas

### Backend
- **Linguagem:** PHP
- **Framework:** Laravel
- **ORM:** Eloquent (Laravel)

### Banco de Dados
- **Sistema Gerenciador:** MySQL

### API
- **Formato:** RESTful API
- **Autenticação:** JWT (JSON Web Tokens)

### Performance e Cache
- **Ferramenta:** Redis

### Testes
- **Framework de Testes:** PHPUnit

### Documentação
- **Padrão:** Swagger / OpenAPI

---

## Funcionalidades
-  **Pesquisa de Animes**: Busque animes por nome, gênero, ano de lançamento e outros filtros.
-  **CRUD de Animes**: Cadastro, edição, visualização e remoção de animes.
-  **Lista de Favoritos**: Usuários podem favoritar animes e gerenciar suas listas.
-  **Avaliações e Comentários**: Sistema de notas e comentários nos animes.
-  **Recomendações Personalizadas**: Sugestão de animes com base no perfil e atividades do usuário.
-  **Notificações**: Alertas sobre novos episódios ou animes que combinam com o perfil do usuário.

---

### Instalação do projeto

1. Clone o repositório
```
git clone https://github.com/seu-usuario/animex-api.git
cd animex-api
```
2. Instale as dependências
```
composer install
```
3. Copie o arquivo de ambiente e configure as variáveis:
```
cp .env.example .env
```
4. Gere a chave da aplicação
```
php artisan key:generate
```
5. Gere o segredo JWT
```
php artisan jwt:secret
```
6. Inicie o servidor local com o artisan
```
php artisan serve
```

Assim, o projeto estará disponível no endereço http://localhost:8000/api
