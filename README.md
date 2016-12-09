# SysCGenerator #

Este sistema é capaz de gerar certificados customizados com autenticação digital. O software é dividido em dois sistemas principais: Autenticação digital dos certificados gerados a partir desta ferramenta; e um ambiente para gerenciar o sistema de cadastro de eventos e participantes.  
  
Veja este exemplo funcional que está sendo utilizado pelo grupo PET Fronteira da UFMS (Universidade Federal de Mato Grosso do Sul) - Campus Ponta Porã. [Clique aqui!](http://nerdsdafronteira.com/scg/list.php)  
    
## Software  
1) Autenticação digital é para certificar que aquele certificado foi gerado pelo sistema, apresentando os dados do evento caso seja autentico. Também disponibiliza uma lista de todos os eventos gerados pelo sistema, a fim de que o participante recupere seu documento, também para uma fácil divulgação|disponibilização.  
  
2) Sistema de cadastro de eventos e participantes é um ambiente para o administrador do sistema, no qual é possível gerenciar todos os documentos produzidos por este. Nele o administrador é capaz de criar eventos e vincular participantes|ministrantes|monitores, com o intuito que possa gerar um certificado específico para cada um.  
  

## Instalação  
* Execute a query do `mysql-database.sql` em seu banco de dados MySQL
* Configure o `config.ini` com as informações de conexão, horário do sistema e url online.
    * conn_mysql: representa as informações do banco de dados: nome do banco, host, usuário, senha.
    * general_settings: configuração do horário do sistema `timezone`.
    * path_define.path_online: defini a url do sistema, por exemplo: leonardomauro.com/sistema/
* Pronto! Acesse o `index.php` e veja a aplicação.
    * usuário `test` e senha `test`, para acessar o sistema.

  
## Edições  
* layout: utiliza-se [boostrap](http://getbootstrap.com/) + [bootswatch](http://bootswatch.com/) (theme)
* certificados: veja o exemplo em _/php/layouts/lm-layout_01/_
* codificação e banco de dados: entre em contato comigo para maiores recomendações


## Also look ~  	
* [License GPL v2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
* Create by Leonardo Mauro (leo.mauro.desenv@gmail.com)
* Git: [leomaurodesenv](https://github.com/leomaurodesenv/)
* Site: [Portfolio](http://leonardomauro.com/portfolio/)
