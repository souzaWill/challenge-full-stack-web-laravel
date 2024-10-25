
# Grupo +A Educação Desafio Técnico - Full Stack Web Developer

## Bibliotecas utilizadas - backend
- **[PestPhp](https://pestphp.com/)** framework para testes automatizados
- **[Laravel Pint](https://laravel.com/docs/11.x/pint)** formatação de código
- **[Scribe](https://scribe.knuckles.wtf/)** documentação de APIs
- **[Laravel Log viewer](https://log-viewer.opcodes.io/)** observabilidade e visualização de erros
- **[Pest type coverage](https://pestphp.com/docs/type-coverage)** cobertura de tipagem
- **[Laravel sail](https://laravel.com/docs/11.x/sail)** contêineres
- **[Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)** autenticação
- **[Laravel-pt-br-localization](https://github.com/lucascudo/laravel-pt-BR-localization)** Módulo de linguagem pt-BR
- **[fakerphp](https://fakerphp.org/)** Geração de dados para teste
- **[Railway](https://railway.app/):** Deploy

## Bibliotecas utilizadas - frontend
- **[Vuetify](https://vuetifyjs.com/)** Framework de UI
- **[Eslint](https://eslint.org/)** Biblioteca de análise estática de código
- **[Prettier](https://prettier.io/)** Formatação de código
- **[Vue-router](https://router.vuejs.org/)** Biblioteca de roteamento
- **[Pinia](https://pinia.vuejs.org/)** Gerenciamento de estado
- **[Vue-i18n](https://vue-i18n.intlify.dev/)** Biblioteca de internacionalização
- **[Axios](https://axios-http.com/)** Cliente HTTP
- **[Vue-the-mask](https://vuejs-tips.github.io/vue-the-mask/)** Máscaras para inputs
- **[Vercel](https://vercel.com/):** Deploy

## Links
- [Frontend](https://challenge-full-stack-web-vuejs.vercel.app/) email: admin@maisaedu.com.br senha: youshouldnotpass
- [Backend](https://challenge-full-stack-web-laravel-production-1f95.up.railway.app/)
- [Documentação API](https://challenge-full-stack-web-laravel-production-1f95.up.railway.app/docs)
- [Repositório backend](https://github.com/souzaWill/challenge-full-stack-web-laravel)
- [Repositório frontend](https://github.com/souzaWill/challenge-full-stack-web-vuejs)

## Rodar o Projeto local

Para buildar o backend, é necessário ter o Docker e o Docker Compose instalados.

- Para iniciar o projeto, utilize o script start.sh. Para facilitar a configuração, o SQLite foi utilizado por padrão. No entanto, há um container do MySQL disponível; basta definir as variáveis de ambiente para usá-lo.
- As variáveis de ambiente padrão do sistema estão no arquivo .env.example.
- acesse o http://localhost/

Para o frontend, é necessário ter o NPM instalado.
- Defina a variável de ambiente VITE_API_URL no arquivo .env.
- Execute npm install e, em seguida, npm run dev. O frontend ficará disponível em http://localhost:3000/


## Decisão da arquitetura utilizada
Antes de pegar no código, decidi tentar fazer um escopo inicial do que eu queria entregar para esse desafio. Utilizei a ferramenta Excalidraw:

![image](https://github.com/user-attachments/assets/de177eb8-ad6e-45fa-aefe-d6ffcf70e4a8)

Tentei desenhar as tabelas e as APIs necessárias para a solução.

![image](https://github.com/user-attachments/assets/da8fbc48-0825-4c5a-9d6d-f6c6b8433123)

Existia a opção de criar somente 1 tabela `users` e nela ter os campos `document` e `registration_number`, porém quis deixar a solução um pouco menos simplista, adicionando um relacionamento. Assim, a tabela `student` é a informação adicional para um usuário ser considerado um usuário do tipo estudante, enquanto usuários que não têm um registro nessa tabela são admins.

Também existia a ideia de criar um login para o estudante, porém não foi implementada por falta de tempo, pois, para fazer sentido o login do estudante, seria necessário que ele pudesse visualizar algo.

Também tive a ideia de deixar isso mais parecido com um sistema de matrículas, adicionando a funcionalidade de controle de período letivo, mas a mesma foi descontinuada por falta de tempo.

## Repository Pattern
Afim de não deixar a solução muito simplista, decidi usar **Repository Pattern**. Na minha opinião, não é uma boa escolha para projetos pequenos com poucas tabelas, mas, afim de mostrar um pouco dos meus conhecimentos e também por acreditar que projetos escaláveis devem ter uma base bem sólida, decidi optar por esse padrão. Foi implementado à mão, sem uso de uma biblioteca de terceiros, e assim foi criada a classe `BaseRepositoryInterface` e sua implementação.

Foram usadas **DTOs** para algumas ações, tentando ajudar no desacoplamento de como os dados vêm e como devem chegar no repositório. Assim, as controllers ficaram sendo usadas somente para roteamento e aplicação das regras de autorização definidas pelas policies.

Também foram utilizados **API Resources** para ser a camada que trata como serão os responses da API. Com o crescimento de uma aplicação podem surgir múltiplos clients da API com necessidades diferentes. Colocar isso em uma camada específica sempre ajuda.

![image](https://github.com/user-attachments/assets/9f624217-b7fd-432b-abae-5046d02446d3)

## Testes Automatizados
Costumo tentar seguir o **TDD** quando estou desenvolvendo uma API; pode ser uma mão na roda, pois fica mais fácil de debugar e ainda garante que o erro não volte a acontecer e você não veja. Utilizei o **PestPHP** porque gosto da sintaxe e dos plugins, como o **type coverage** e o **Architecture Testing** (garante que nenhuma função de debug do Laravel seja esquecida no código). Infelizmente, devido ao tempo, não consegui os 100% de coverage, mas ficou acima dos 90%.

![image](https://github.com/user-attachments/assets/c16f8cf1-2f5d-408d-a963-7c4e78e2a786)
![image](https://github.com/user-attachments/assets/fe08aa6e-54eb-4d9b-9943-b2b9a90e4f46)
![image](https://github.com/user-attachments/assets/486f69b8-d7ff-481e-ae50-18e716f67ec9)

## Observabilidade
Para garantir o mínimo de observabilidade da aplicação no deploy, foi usada a biblioteca **Laravel Log Viewer**, uma solução simples, mas eficaz, que garante a visualização dos logs mesmo após o deploy. Para acessá-la, é só entrar em `/docs` da API. Da maneira que foi implementada, não deu tempo de implementar um login, então ela está disponível para qualquer um acessar (o que não é tão bom).

![image](https://github.com/user-attachments/assets/919b1f42-ed06-4df3-8625-d8ad0bdad532)

## Documentação
A documentação dos endpoints foi gerada a partir do **Scribe**. É bem simples, porém ajuda bastante para gerar documentação de APIs rapidamente, permitindo também exportar uma collection com todas as rotas para ser usado em um API client (Postman, Insomnia).

![image](https://github.com/user-attachments/assets/2a39f244-ccec-4a39-927c-c21fa9bc158f)

## Autorização
Com a estrutura definida, foi necessário ter um controle de 'roles'. Assim, na tabela `users` existia uma coluna chamada `role_id`, e na API existe um **RoleEnum**. Caso o `role_id` seja 1, o usuário é um admin, caso 2, estudante, somente admins têm permissão de interagir com registros de estudantes. Esse controle ficou a cargo da **StudentPolicy**. Caso, amanhã, um estudante possa interagir com seus próprios dados, somente será necessário mexer na policy, assim ficando desacoplado das outras camadas da aplicação.

## Autenticação
Para controlar a autenticação, foi usado o **Laravel Sanctum**, uma solução simples que gera um token Bearer. Não foi definida uma expiração para o token, pois o frontend não teve a implementação de um refresh de token.

## Frontend
Para mim, o frontend foi um desafio, pois já tinha trabalhado em alguns projetos, tanto com VueJS quanto com Angular. Porém, a maioria tinha sido de estudos ou em projetos que estavam 'prontos', solucionando problemas. Com isso, tive que estudar, dentro do tempo possível, boas práticas e até projetos para procurar soluções para os meus problemas. Acredito que há muito a melhorar, mas consegui entregar os requisitos.

* A autenticação foi feita salvando o **token** no **local storage** e tudo sendo controlado pelo **Pinia**.
* As chamadas de API foram feitas na camada de serviço e sendo acionadas pela **store**.
* Usei **DTOs** para evitar ficar fazendo loops em arrays na camada de store para tratar dados. Acredito que não é uma prática muito comum usando JS puro, mas ajudou.
* Utilizei o server-side tables porque não acho uma boa prática puxar todos os itens da API e paginar no frontend, porém isso acabou gerando muitas chamadas na API, o que também não é bom num caso com muitos usuários.
* Para formatar o código, utilizei o **Prettier**.
* O frontend e o backend trabalham tanto em inglês quanto em português; foi adicionado os arquivos de tradução com o **i18n**.

# O que você melhoraria se tivesse mais tempo?
* Acho necessário uma definição melhor do campo RA. No que deu para ser entregue, o RA é um número de 8 caracteres (criei baseado no meu RA de quando estava cursando faculdade), que é definido pelo usuário, porém o mesmo não pode se repetir. Acredito que seria interessante que o backend gerasse esse campo, em vez do usuário. O mesmo poderia ser auto incremental, assim evitando sempre ter que consultar se ele já existe, ou talvez ir para uma abordagem baseada em UUID. Porém, acredito que é interessante que esse campo seja de facil leitura para o usuario da plataforma, pois, pode ser uma informacao util durante seu dia dia. assim acredito que isso e algo que poderia ter sido melhorado e mais pensado caso eu tivesse mais tempo.
* componentes mais bem definidos, para que possam ser reutilizados no frontend e também de mais fácil manutenção.
* melhor tratamento de exceções no backend e no frontend.
* login para acesso à documentação e aos logs da API.