# Agendas PRO

Agendas PRO é um sistema de agendamentos desenvolvido para auxiliar empresas e profissionais a gerenciar seus compromissos com facilidade e eficiência. Com Agendas PRO, você pode agendar, cancelar e reagendar compromissos, enviar lembretes para seus clientes e gerenciar seu calendário com simplicidade.

## Recursos

- Agendamento de compromissos
- Cancelamento e reagendamento de compromissos
- Envio de lembretes para os clientes
- Gerenciamento de calendário
- Histórico de agendamentos

## 🚀 Como iniciar o projeto

Após clonar o repositório, siga os passos abaixo para rodar o projeto na sua máquina:

1. Acesse a pasta do projeto:
   ```bash
   cd agendas_pro
   ```

2. Instale as dependências do PHP com o Composer:
   ```bash
   composer install
   ```

3. Copie o arquivo de exemplo `.env` e crie o seu:
   ```bash
   cp .env.example .env
   ```

4. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

5. Configure as variáveis de ambiente no arquivo `.env` conforme seu ambiente (banco de dados, cache, etc.).

6. Execute as migrations para criar as tabelas do banco de dados:
   ```bash
   php artisan migrate
   ```

7. Rode os seeders para popular o banco de dados:
   ```bash
   php artisan db:seed
   ```
   
Agora é só acessar:  
[http://localhost:8000](http://localhost:8000) 🚀

