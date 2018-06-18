# Especificação de API - Progress: BI

## Lista de Conteúdo

* [Parâmetros de filtragem](#parametros-filtragem)
* [Cursos](#cursos)
    - [Listar cursos](#listar-cursos)
    - [Informações do curso](#informações-do-curso)
* [Turmas](#turmas)
    - [Listar turmas](#listar-turmas)
    - [Informações da turma](#informações-da-turma)
* [Alunos](#alunos)
    - [Listar alunos](#listar-alunos)
    - [Informações do aluno](#informações-do-aluno)
* [Provas](#provas)
    - [Listar provas](#listar-provas)
    - [Informações da prova](#informações-da-prova)
* [Categorias](#categorias)
    - [Listar categorias](#listar-categorias)
    - [Informações da categoria](#informações-da-categorias)
* [Resultados](#resultados)
    - [Buscar resultados](#buscar-resultados)

## Parâmetros de filtragem
O PBI utiliza filtros altamente customizáveis para todas as endpoints de lista, a fim de tornar a utilização da API simples e fácil de usar ao mesmo tempo que a torna altamente poderosa, oferecendo liberdade para o utilizador extrair as informações como preferir.

Sempre que o utilizador utilizar um endpoint de listagem, ele poderá utilizar query strings para filtrar os dados através de QUALQUER CAMPO. Ou seja, se o endpoint possui os parâmetros foo e bar, o modelo FooBar pode ser assim filtrado:

/foobar?foo=1
Retorna todos os resultados em que foo assume valor 1.

/foobar?bar=[1,2,3]
Retorna todos os resultados em que bar assume os valores 1 OU 2 OU 3.

/foobar?foo=1&bar=2
Retorna todos os resultados em que foo assume o valor 1 E bar assume o valor 2

## Cursos

Método                                        | URL                           | Descrição curta
--------------------------------------------- | ----------------------------- | -----------------
[Listar cursos](#listar-cursos)               | **GET:** `/cursos `           | Retorna a lista de cursos cadastrados no sistema
[Informações do curso](#informações-do-curso) | **GET:** `/cursos/:cursoId`   | Retorna as informações do curso solicitado

### Parâmetros
Parâmetro | Tipo                        | Descrição
--------- | --------------------------- |-----------
status    | `Integer` ou `Array`        | Filtra os cursos pelo status
name      | `String` ou `Array`         | Filtra os cursos pelo nome do curso

### Listar cursos

Retorna a lista de cursos cadastrados no sistema baseada nos filtros informados.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/cursos',
    method: 'GET',
    dataType: 'json',
    data: {
        status: [0, 1], // Retorna todos os cursos do sistema
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
        {
            "id": "Number",
            "name": "String",
            "status": "Number"
        }
    ]
}
```

### Informações do curso

Retorna informações detalhadas sobre um curso acrescidas das turmas e provas.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/cursos/' + courseId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
   {
    "id": 1,
    "name": "A",
    "status": true,
    "turmas": [
        {
            "id": 1,
            "name": "TURMA",
            "code": "1",
            "curso_id": 1,
            "periodo": "M"
        },
        {
            "id": 2,
            "name": "Turma 2",
            "code": "1",
            "curso_id": 1,
            "periodo": "M"
        }
    ],
    "provas": [
        {
            "id": 1,
            "curso_id": 1,
            "name": "Prova 1",
            "code": "P1"
        }
    ]
  }
}
```

## Turmas

Método                                        | URL                           | Descrição curta
--------------------------------------------- | ----------------------------- | -----------------
[Listar turmas](#listar-turmas)               | **GET:** `/turmas`           | Retorna a lista de turmas cadastradas no sistema
[Informações da turma](#informações-da-turma) | **GET:** `/turmas/:turmaId`  | Retorna as informações da turma solicitada

### Listar turmas

Retorna a lista de turmas cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
name      | `String` ou `Array`         | `null` | Filtra a lista de turmas pelo nome
code  | `String` ou `Array` | `null`    | Filtra a lista de turmas pelo código
curso_id | `Integer` ou `Array` | `null` | Filtra a lista de turma pelo curso_id
periodo | `String` ou `Array` | `null`    | Filtra a lista de turmas pelo período

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/turmas',
    method: 'GET',
    dataType: 'json',
    data: {
        "curso_id": 1,
        "periodo": "M"
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
      {
        "id": 1,
        "name": "TURMA",
        "code": "1",
        "curso_id": 1,
        "periodo": "M"
      },
    ]
}
```

### Informações da turma

Retorna informações detalhadas sobre uma turma, incluídos o curso ao qual a turma pertence.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/turmas/' + turmaId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
  {
    "id": 1,
    "name": "TURMA",
    "code": "1",
    "curso_id": 1,
    "periodo": "M",
    "curso": {
        "id": 1,
        "name": "A",
        "status": true
    }
  }
}
```

## Alunos

Método                                        | URL                             | Descrição curta
--------------------------------------------- | ------------------------------- | -----------------
[Listar alunos](#listar-alunos)               | **GET:** `/alunos`            | Retorna a lista de alunos cadastradas no sistema
[Informações do aluno](#informações-do-aluno) | **GET:** `/alunos/:studentId` | Retorna as informações do aluno solicitado

### Listar alunos

Retorna a lista de alunos cadastrados no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
ra    | `Number` ou `Array`         | `null` | Filtra a lista de alunos pelo RA
curso_id  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de alunos pelos cursos aos quais pertencem
turma_id   | `Number`, `Array` ou `null` | `null`    | Filtra a lista de alunos pelas turmas às quais pertencem

Além dos parâmetros específicos também é possível efetuar a busca pelo parâmetros de Cursos, Turmas e Usuários

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/alunos',
    method: 'GET',
    dataType: 'json',
    data: {
        ra: 1,
        curso_id: 2,
        name: "nome_aluno"
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
      {
     "id": 1,
     "usuario_id": 1,
     "ra": 999999999,
     "usuario": {
         "id": 1,
         "email": "email@example.com",
         "senha": "123",
         "nome": "John Doe"
     },
     "cursos": [
         {
             "id": 1,
             "name": "A",
             "status": true,
             "_joinData": {
                 "id": 1,
                 "aluno_id": 1,
                 "curso_id": 1
             }
         },
         {
             "id": 2,
             "name": "B",
             "status": true,
             "_joinData": {
                 "id": 2,
                 "aluno_id": 1,
                 "curso_id": 2
             }
         }
     ],
     "turmas": [],
     "_matchingData": {
         "Cursos": {
             "id": 1,
             "name": "A",
             "status": true
         },
         "AlunosCursos": {
             "id": 1,
             "aluno_id": 1,
             "curso_id": 1
         }
     }
 }
    ]
}
```

### Informações do aluno

Retorna informações detalhadas sobre um aluno.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/alunos/' + studentId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "id": 1,
    "usuario_id": 1,
    "ra": 9999999,
    "turmas": [
        {
            "id": 2,
            "name": "Turma 2",
            "code": "1",
            "curso_id": 1,
            "periodo": "M",
            "_joinData": {
                "id": 2,
                "aluno_id": 1,
                "turma_id": 2
            }
        }
    ],
    "cursos": [
        {
            "id": 1,
            "name": "A",
            "status": true,
            "_joinData": {
                "id": 1,
                "aluno_id": 1,
                "curso_id": 1
            }
        },
        {
            "id": 2,
            "name": "B",
            "status": true,
            "_joinData": {
                "id": 2,
                "aluno_id": 1,
                "curso_id": 2
            }
        }
    ],
    "usuario": {
        "id": 1,
        "email": "email@example.com",
        "senha": "123",
        "nome": "John Doe"
    }
}
```

## Provas

Método                                        | URL                       | Descrição curta
--------------------------------------------- | ------------------------- | -----------------
[Listar provas](#listar-provas)               | **GET:** `/provas`         | Retorna a lista de provas cadastradas no sistema
[Informações da prova](#informações-da-prova) | **GET:** `/provas/:testId` | Retorna as informações da prova solicitada

### Listar provas

Retorna a lista de provas cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
cursoId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de provas pelos cursos aos quais pertencem
turmaId | `Number`, `Array` ou `null` | `null`    | Filtra a lista de provas pelas turmas aos quais pertencem

Além dos parâmetros específicos também é possível efetuar a busca pelo parâmetros de Cursos e Turmas

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/provas',
    method: 'GET',
    dataType: 'json',
    data: {
        cursoId: 14,
        turmaId: 1
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
      {
      "id": 1,
      "curso_id": 1,
      "name": "Prova 1",
      "code": "P1",
      "turma_id": 1,
      "turma": {
          "id": 1,
          "name": "TURMA",
          "code": "1",
          "curso_id": 1,
          "periodo": "M"
      },
      "curso": {
          "id": 1,
          "name": "A",
          "status": true
      }
  }
    ]
}
```

### Informações da prova

Retorna informações detalhadas sobre uma prova.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/provas/' + testId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
  "id": 1,
  "curso_id": 1,
  "name": "Prova 1",
  "code": "P1",
  "turma_id": 1,
  "turma": {
      "id": 1,
      "name": "TURMA",
      "code": "1",
      "curso_id": 1,
      "periodo": "M"
  },
  "curso": {
      "id": 1,
      "name": "A",
      "status": true
  }
}
```

## Categorias

Método                                                 | URL                                | Descrição curta
------------------------------------------------------ | ---------------------------------- | -----------------
[Listar categorias](#listar-categorias)                | **GET:** `/categorias`             | Retorna a lista de categorias cadastradas no sistema
[Informações da categoria](#informações-da-categorias) | **GET:** `/categorias/:categoriaId` | Retorna as informações da categoria solicitada

### Listar categorias

Retorna a lista de categorias cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
name    | `Number` ou `Array`         | `null` | Filtra a lista de categorias pelo status

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/categorias',
    method: 'GET',
    dataType: 'json',
    data: {
        name: 'Conhecimentos Gerais',
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
      {
        "id": 1,
        "name": "Gerais"
      }
    ]
}
```

### Informações da categoria

Retorna informações detalhadas sobre uma categoria.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/categorias/' + categoriaId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "id": 1,
    "name": "Gerais"
}
```

## Resultados

Método                                  | URL                 | Descrição curta
--------------------------------------- | ------------------- | -----------------
[Buscar resultados](#buscar-resultados) | **GET:** `/resultados` | Retorna uma lista de resultados cadastrados no sistema
[Buscar resultados por Turma](#buscar-resultados-turma) | **GET:** `/resultados/getResultadosFromTurma/[TURMA_ID]` | Retorna uma lista de resultados cadastrados no sistema da turma TURMA_ID
[Buscar resultados por Curso](#buscar-resultados-curso) | **GET:** `/resultados/getResultadosFromCurso/[CURSO_ID]` | Retorna uma lista de resultados cadastrados no sistema do curso CURSO_ID

### Buscar resultados
Retorna uma lista de resultados baseada nos filtros informados.

#### Parâmetros

Parâmetro  | Tipo                        | Default   | Descrição
---------- | --------------------------- | --------- |-----------
prova_ud     | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados pela(s) prova(s)
categoria_id  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados pela(s) categoria(s)
aluno_id | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados de um aluno

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/resultados',
    method: 'GET',
    dataType: 'json',
    data: {
        prova_id: 2,
        student_id: 11,
        category_id: [1, 3],
    },
});
```

#### JSON de retorno

``` json
{
    "data": [
      {
      "id": 1,
      "acertos": 20,
      "erros": 30,
      "prova": {
          "id": 1,
          "curso_id": 1,
          "name": "Prova 1",
          "code": "P1",
          "turma_id": 1
      },
      "categoria": {
          "id": 1,
          "name": "Gerais"
      },
      "aluno": {
          "id": 1,
          "usuario_id": 1,
          "ra": 99999999
      }
    }
    ]
}
```

### Buscar resultados por Turma
Retorna uma lista de resultados baseada nos filtros informados.

#### Parâmetros

Parâmetro  | Tipo                        | Default   | Descrição
---------- | --------------------------- | --------- |-----------
TURMA_ID     | `Number` | -    | Filtra a lista de resultados pela turma

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/resultados/getResultadosFromTurma/2',
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

O JSON de retorno é o mesmo da chamada /resultados


### Buscar resultados por Curso
Retorna uma lista de resultados baseada nos filtros informados.

#### Parâmetros

Parâmetro  | Tipo                        | Default   | Descrição
---------- | --------------------------- | --------- |-----------
CURSO_ID     | `Number` | -    | Filtra a lista de resultados pelo CURSO

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/resultados/getResultadosFromCurso/2',
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

O JSON de retorno é o mesmo da chamada /resultados