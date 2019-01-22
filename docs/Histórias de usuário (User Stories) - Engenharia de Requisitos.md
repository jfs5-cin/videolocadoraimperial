# ![](./logo.png)Locadora Imperial

## Histórias de usuário (**User Stories**) e Critérios de Aceitação

#### US001 - User Stories 001 - Acesso ao sistema como administrador

**Como um** administrador **eu quero** acessar o sistema  **para que seja possível** utilizar as funcionalidades para controlar o acervo da locadora.

##### Criterios de Aceitação US001

. O administrador não pode acessar a área restrita do sistema se não informar suas credenciais (usuário e senha).

. Se for informado usuário e/ou senha incorretos, informar "Estas Credenciais não correspodem aos nossos registros".

#### US018 - User Stories 018 - Incluir um filme como administrador

**Como um** administrador **eu quero** incluir um filme **para que seja possível** consulta-lo ou utiliza-lo posteriormente.

##### Criterios de Aceitação US018

. O administrador deve informar os campos: titulo, titulo original, país, ano, direção, elenco, sinopse, duração, gênero, tipo e distribuidora.

. Informar "Gênero não Cadastrado", caso o campo Gênero digitado não corresponder aos dados cadastrados na tabela Gênero.

. Informar "Tipo não Cadastrado", caso o campo Tipo digitado não corresponder aos dados cadastrados na tabela Tipo.

. Informar "Distribuidora não Cadastrada", caso o campo Distribuidora digitado não corresponder aos dados cadastrados na tabela Distribuidora.

#### US026 - User Stories 026 - Incluir um usuário como administrador

**Como um** administrador **eu quero** incluir um usuário **para que seja possível** acessar o sistema da locadora.

##### Criterios de Aceitação US026

. O administrador deve informar os campos: perfil, user name, senha e email.

#### US0102 - User Stories 102 - Cadastrar um cliente titular como atendente

**Como um** atedente **eu quero** cadastrar um cliente titular se for maior de idade informando o nome, email, endereço, telefone residencial, endereço de trabalho, telefone comercial, telefone celular, sexo, cpf e data de nascimento **para que seja possível** o cliente locar itens.

**Criterios de Aceitação US102**

. O atendente deve informar os campos referentes ao titular: nome , email, endereço, numero do telefone residencial, local de trabalho, numero do telefone comercial, numero do telefone celular, sexo, CPF e data de nascimento.

. Um titular so pode ter no máximo três dependentes.

. O atendente deve informar os campos referentes aos dependentes: nome , email, sexo e data de nascimento.

. Tanto titulares quanto dependentestêm um numero de inscrição, o qual é único por cliente.

#### US114 - User Stories 114 - Cadastro de Reserva de filme para cliente como atendente

**Como um** atendente **eu quero** reservar filmes para cliente  **para que seja possível** atender a necessidade do cliente.

##### Criterios de Aceitação US114

. O atendente deve reservar os filmes para titular e dependente cadastrados no sistema (Id e/ou nome).

. O atendente deve informar a data e hora da reserva no sistema.

. O atendente deve informar os filmes cadastrados no sistema para reserva (Id e/ou nome).

. O atendente deve informar o tipo de mídia no sistema para reserva (Id e/ou nome).

. O atendente so deve reservar itens do mesmo tipo de midia que não estejam disposnível na locadora.

. Se alguns dos dados estiverem incorretos, o sistema informa "Dados Incorretos".

. Se o tipo o filme para aquele tipo de midia estiver na locadora, informar "Mídia Disponível na Locadora".

#### US117 - User Stories 117 -Cancelamento de Reserva de filme para cliente como atendente

**Como um** atendente **eu quero** cancelar  reserva de filmes **para que seja possível** remove-lo do cadastro reserva.

##### Criterios de Aceitação US117

. O atendente deve informar os dados do titular e/ou dependente e/ou do filme cadastrados no sistema.

. Se alguns dos dados estiverem incorretos, o sistema informa "Dados Incorretos".

#### US118 - User Stories 118 - Registro de Locação como atendente

**Como um** atendente **eu quero** registrar locações **para que seja possível** locar itens para clientes.

##### Criterios de Aceitação US118

. O atendente deve registrar as locações para titular e/ou dependente cadastrados no sistema.

. O atendente deve informar os itens cadastrados no sistema.

. O atendente deve informar a data do inicio da locação no sistema.

. O atendente deve informar o valor acordado com o cliente da locação no sistema.

. O atendente deve informar a data de devolução prevista acordada com o cliente para cada item no sistema.

. Se alguns dos dados estiverem incorretos, o sistema informa "Dados Incorretos".

#### US122 - User Stories 122 - Registro de Devolução de Itens como atendente

**Como um** atendente **eu quero** registrar devoluções de itens **para que seja possível** receber os itens que foram locados.

##### Criterios de Aceitação US122

. O atendente deve informar o nome do item e/ou id.

. Caso o cliente já tiver pago o valor total do item locado no ato da locação e o saldo for R$ 0,00 e devolver todas as mídias locadas e a data de devolução prevista acordada for menor ou igual a data da devolução, registrar a data da devolução do item devolvido.

. Se o cliente pagar o saldo do valor dos itens locados e devolver todas as mídias locadas, registrar a data de devolução.

. Se a data de devolução prevista acordada for maior que a data da devolução, informar o valor do saldo mais o valor de cada midia multiplicado pelo o numero de dias em atraso que deve ser pago.

. Se alguns dos dados estiverem incorretos, o sistema informa "Dados Incorretos".

#### US202 - User Stories 202 - Consulta avançada ao acervo como cliente

**Como um** cliente **eu quero** consultar o acervo **para que seja possível** verificar se o filme X existe na locadora e em quais tipos de mídias.

##### Criterios de Aceitação US202

. O cliente pode consultar o acervo pelo site nos principais navegadores disponíveis.

. O cliente deve informar o título  (ou parte dele), original ou em português, e/ou informando gênero, tipo de mídia disponível, ator, diretor, nacionalidade, lançamentos.

. Se alguns dos dados estiverem incorretos, o sistema informa "Dados Incorretos".
