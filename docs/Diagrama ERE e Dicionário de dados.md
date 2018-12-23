# Locadora Imperial

## Diagrama Entidade Relacionamento Estendido e Dicionário de Dados

### Diagrama Entidade Relacionamento - ERE



### Dicionário de Dados

**Entidade:** Usuário(**User**)

**Tabela:** usuários(**users**)

| Atributo                                       | Tipo            | Tamanho | Domínio | Formato | Restrições |
| ---------------------------------------------- | --------------- | ------- | ------- | ------- | ---------- |
| **<u>id</u>**                                  | increments      |         |         |         | Único      |
| nome (**name**)                                | string          |         |         |         |            |
| email (**email**)                              | string          | 150     |         |         | Único      |
| email verificado em (**email_verified_at**)    | timestamp       |         |         |         |            |
| senha (**password**)                           | string          |         |         |         |            |
| tokem para redefinir senha (**rememberToken**) | rememberToken() |         |         |         |            |

**Entidade:** Titular(**Holder**)

**Tabela:** titulares (**holders**)

| Atributo                              | Tipo       | Tamanho | Domínio | Formato        | Restrições         |
| ------------------------------------- | ---------- | ------- | ------- | -------------- | ------------------ |
| **<u>id</u>**                         | increments |         |         |                | Único              |
| cpf (**cpf**)                         | string     | 11      |         |                | Único, Validar CPF |
| logradouro (**place**)                | string     |         |         |                |                    |
| número (**number**)                   | integer    |         |         |                |                    |
| complemento (**complement**)          | string     |         |         |                |                    |
| bairro (**district**)                 | string     |         |         |                |                    |
| cidade (**city**)                     | string     |         |         |                |                    |
| estado (**state**)                    | string     |         |         |                |                    |
| país (**country**)                    | string     |         |         |                |                    |
| local de trabalho (**workplace**)     | string     |         |         |                |                    |
| telefone residencial (**home_phone**) | string     | 14      |         | (00)0000-0000  |                    |
| telefone celular (**cell_phone**)     | string     | 14      |         | (00)00000-0000 |                    |
| telefone trabalho (**work_phone**)    | string     | 14      |         | (00)00000-0000 |                    |

**Entidade:** Cliente (**Client**)

**Tabela:** clientes (**clients**)

| Atributo                            | Tipo       | Tamanho | Domínio             | Formato    | Restrições                                |
| ----------------------------------- | ---------- | ------- | ------------------- | ---------- | ----------------------------------------- |
| **<u>id</u>**                       | increments |         |                     |            | Único                                     |
| nome (**name**)                     | string     |         |                     |            |                                           |
| email (**email**)                   | string     | 150     |                     |            | Único                                     |
| sexo (**gender**)                   | enum       |         | Masculino, Feminino |            |                                           |
| data de nascimento (**birth_date**) | date       |         |                     | DD/MM/AAAA |                                           |
| tipo (**type**)                     | enum       |         | Titular, Dependente |            |                                           |
| titular (**holder_id**)             | integer    |         |                     |            | Referencia o **id** da tabela **holders** |

**Entidade:** Gênero(**Genre**)

**Tabela:** gêneros(**genres**)

| Atributo                    | Tipo       | Tamanho | Domínio | Formato | Restrições |
| --------------------------- | ---------- | ------- | ------- | ------- | ---------- |
| **id**                      | increments |         |         |         | Único      |
| descrição (**description**) | string     |         |         |         |            |

**Entidade:** Tipo(**Type**)

**Tabela:** tipos(**types**)

| Atributo                                 | Tipo       | Tamanho | Domínio              | Formato | Restrições |
| ---------------------------------------- | ---------- | ------- | -------------------- | ------- | ---------- |
| **<u>id</u>**                            | increments |         |                      |         | Único      |
| descrição (**description**)              | enum       |         | Catálogo, Lançamento |         |            |
| prazo de devolução (**return_deadline**) | integer    |         | dias                 |         |            |
| acréscimo (**increase**)                 | double     | 5, 2    | percencual           |         |            |

**Entidade:** Mídia(**Media**)

**Tabela:** mídias(**medias**)

| Atributo                            | Tipo       | Tamanho | Domínio                   | Formato | Restrições |
| ----------------------------------- | ---------- | ------- | ------------------------- | ------- | ---------- |
| **<u>id</u>**                       | increments |         |                           |         | Único      |
| descrição (**description**)         | enum       |         | DVD, VHS, Blu-Ray, HD-DVD |         |            |
| valor da locação (**rental_price**) | double     | 8, 2    |                           |         |            |

**Entidade:** Distribuidora(**Distributor**)

**Tabela:** distribuidoras(**distributors**)

| Atributo                                | Tipo       | Tamanho | Domínio | Formato        | Restrições          |
| --------------------------------------- | ---------- | ------- | ------- | -------------- | ------------------- |
| **<u>id</u>**                           | increments |         |         |                | Único               |
| cnpj (**cnpj**)                         | string     | 14      |         |                | Único, Validar CNPJ |
| razão social (**corporate_name**)       | string     |         |         |                |                     |
| pessoa de contato (**contact_name**)    | string     |         |         |                |                     |
| telefone de contato (**contact_phone**) | string     | 14      |         | (00)00000-0000 |                     |
| logradouro (**place**)                  | string     |         |         |                |                     |
| número (**number**)                     | integer    |         |         |                |                     |
| complemento (**complement**)            | string     |         |         |                |                     |
| bairro (**district**)                   | string     |         |         |                |                     |
| cidade (**city**)                       | string     |         |         |                |                     |
| estado (**state**)                      | string     |         |         |                |                     |
| país (**country**)                      | string     |         |         |                |                     |

**Entidade:** Filme(**Movie**)

**Tabela:** filmes(**movies**)

| Atributo                             | Tipo       | Tamanho | Domínio | Formato | Restrições                                     |
| ------------------------------------ | ---------- | ------- | ------- | ------- | ---------------------------------------------- |
| **<u>id</u>**                        | increments |         |         |         | Único                                          |
| título (**title**)                   | string     |         |         |         |                                                |
| título original (**original_title**) | string     |         |         |         |                                                |
| país (**country**)                   | string     |         |         |         |                                                |
| ano (**year**)                       | integer    | 4       |         | AAAA    |                                                |
| direção (**direction**)              | string     |         |         |         |                                                |
| elenco (**cast**)                    | string     |         |         |         |                                                |
| sinopse (**synopsis**)               | text       |         |         |         |                                                |
| duração (**duraction**)              | integer    |         | minutos |         |                                                |
| gênero (**gender_id**)               | integer    |         |         |         | Referencia o **id** da tabela **genders**      |
| tipo (**type_id**)                   | integer    |         |         |         | Referencia o **id** da tabela **type**         |
| distribuidora (**distributor_id**)   | integer    |         |         |         | Referencia o **id** da tabela **distributors** |

**Entidade:** Item(**Item**)

**Tabela:** itens(**items**)

| Atributo                              | Tipo       | Tamanho | Domínio | Formato | Restrições                               |
| ------------------------------------- | ---------- | ------- | ------- | ------- | ---------------------------------------- |
| **<u>id</u>**                         | increments |         |         |         | Único                                    |
| número de série (**serial_number**)   | string     | 50      |         |         | Único                                    |
| data de aquisição (**purchase_date**) | date       |         |         |         |                                          |
| filme (**movie_id**)                  | integer    |         |         |         | Referencia o **id** da tabela **movies** |
| mídia (**media_id**)                  | integer    |         |         |         | Referencia o **id** da tabela **medias** |

**Entidade:** Item de Locação(**Rental_item**)

**Tabela:** itens de locações(**rental_items**)

| Atributo                                              | Tipo       | Tamanho | Domínio | Formato    | Restrições                              |
| ----------------------------------------------------- | ---------- | ------- | ------- | ---------- | --------------------------------------- |
| **<u>id</u>**                                         | increments |         |         |            | Único                                   |
| item (**item_id**)                                    | integer    |         |         |            | Referencia o **id** da tabela **items** |
| valor da locação (**rental_price**)                   | double     | 8, 2    |         |            |                                         |
| data de devolução prevista (**expected_return_date**) | date       |         |         | DD/MM/AAAA |                                         |
| data de devolução (**return_date**)                   | date       |         |         | DD/MM/AAAA |                                         |
| usuário que registrou a devolução (**return_user**)   | integer    |         |         |            | Referencia o **id** da tabela **users** |

**Entidade:** Locação(**Rental**)

**Tabela:** locações(**rentals**)

| Atributo                                          | Tipo       | Tamanho | Domínio | Formato | Restrições                                     |
| ------------------------------------------------- | ---------- | ------- | ------- | ------- | ---------------------------------------------- |
| **<u>id</u>**                                     | increments |         |         |         | Único                                          |
| cliente (**client_id**)                           | integer    |         |         |         | Referencia o **id** da tabela **clients**      |
| item (**rental_item_id**)                         | integer    |         |         |         | Referencia o **id** da tabela **rental_items** |
| usuário que registrou a locação (**rental_user**) | integer    |         |         |         | Referencia o **id** da tabela **users**        |

**Entidade:** Item de Locação(**Rental_item**)

**Tabela:** itens de locações(**rental_items**)

| Atributo                                              | Tipo       | Tamanho | Domínio | Formato    | Restrições                              |
| ----------------------------------------------------- | ---------- | ------- | ------- | ---------- | --------------------------------------- |
| **<u>id</u>**                                         | increments |         |         |            | Único                                   |
| item (**item_id**)                                    | integer    |         |         |            | Referencia o **id** da tabela **items** |
| valor da locação (**rental_price**)                   | double     | 8, 2    |         |            |                                         |
| data de devolução prevista (**expected_return_date**) | date       |         |         | DD/MM/AAAA |                                         |
| data de devolução (**return_date**)                   | date       |         |         | DD/MM/AAAA |                                         |
| usuário que registrou a devolução (**return_user**)   | integer    |         |         |            | Referencia o **id** da tabela **users** |

**Entidade:** Reserva(**Reservation**)

**Tabela:** reservas(**reservations**)

| Atributo                                               | Tipo       | Tamanho | Domínio             | Formato | Restrições                                |
| ------------------------------------------------------ | ---------- | ------- | ------------------- | ------- | ----------------------------------------- |
| **<u>id</u>**                                          | increments |         |                     |         | Único                                     |
| cliente (**client_id**)                                | integer    |         |                     |         | Referencia o **id** da tabela **clients** |
| filme (**movie_id**)                                   | integer    |         |                     |         | Referencia o **id** da tabela **movies**  |
| mídia (**media_id**)                                   | integer    |         |                     |         | Referencia o **id** da tabela **medias**  |
| usuário que registrou a reserva (**reservation_user**) | integer    |         |                     |         | Referencia o **id** da tabela **users**   |
| expirada (**expired**)                                 | boolean    |         | Verdadeiro ou Falso |         |                                           |



