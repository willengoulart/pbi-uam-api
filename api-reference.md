# Especificação de API - Progress: BI

## Lista de Conteúdo

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

## Cursos

Método                                        | URL                           | Descrição curta
--------------------------------------------- | ----------------------------- | -----------------
[Listar cursos](#listar-cursos)               | **GET:** `/courses`           | Retorna a lista de cursos cadastrados no sistema
[Informações do curso](#informações-do-curso) | **GET:** `/courses/:courseId` | Retorna as informações do curso solicitado

### Listar cursos

Retorna a lista de cursos cadastrados no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                | Default   | Descrição
--------- | ------------------- | --------- |-----------
status    | `Number` ou `Array` | 1 (ativo) | Filtra a lista de cursos pelo status

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/courses',
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

Retorna informações detalhadas sobre um curso.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/courses/' + courseId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "data": {
        "id": "Number",
        "name": "String",
        "status": "Number"
    }
}
```

## Turmas

Método                                        | URL                           | Descrição curta
--------------------------------------------- | ----------------------------- | -----------------
[Listar turmas](#listar-turmas)               | **GET:** `/classes`           | Retorna a lista de turmas cadastradas no sistema
[Informações da turma](#informações-da-turma) | **GET:** `/classes/:classId`  | Retorna as informações da turma solicitada

### Listar turmas

Retorna a lista de turmas cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
status    | `Number` ou `Array`         | 1 (ativo) | Filtra a lista de turmas pelo status
courseId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de turmas pelos cursos aos quais pertencem

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/classes',
    method: 'GET',
    dataType: 'json',
    data: {
        status: 1,
        courseId: 14,
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

### Informações da turma

Retorna informações detalhadas sobre uma turma.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/classes/' + classId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "data": {
        "id": "Number",
        "name": "String",
        "code": "String",
        "period": "String",
        "status": "Number",
        "course": {
            "id": "Number",
            "name": "String",
            "status": "Number"
        }
    }
}
```

## Alunos

Método                                        | URL                             | Descrição curta
--------------------------------------------- | ------------------------------- | -----------------
[Listar alunos](#listar-alunos)               | **GET:** `/students`            | Retorna a lista de alunos cadastradas no sistema
[Informações do aluno](#informações-do-aluno) | **GET:** `/students/:studentId` | Retorna as informações do aluno solicitado

### Listar alunos

Retorna a lista de alunos cadastrados no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
status    | `Number` ou `Array`         | 1 (ativo) | Filtra a lista de alunos pelo status
courseId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de alunos pelos cursos aos quais pertencem
classId   | `Number`, `Array` ou `null` | `null`    | Filtra a lista de alunos pelas turmas às quais pertencem

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/students',
    method: 'GET',
    dataType: 'json',
    data: {
        status: 1,
        courseId: 14,
        classId: [25, 26],
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

### Informações do aluno

Retorna informações detalhadas sobre um aluno.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/students/' + studentId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "data": {
        "id": "Number",
        "name": "String",
        "ra": "String",
        "status": "Number",
        "course": {
            "id": "Number",
            "name": "String",
            "status": "Number"
        },
        "classes": [
            {
                "id": "Number",
                "name": "String",
                "status": "Number"
            }
        ]
    }
}
```

## Provas

Método                                        | URL                       | Descrição curta
--------------------------------------------- | ------------------------- | -----------------
[Listar provas](#listar-provas)               | **GET:** `/tests`         | Retorna a lista de provas cadastradas no sistema
[Informações da prova](#informações-da-prova) | **GET:** `/tests/:testId` | Retorna as informações da prova solicitada

### Listar provas

Retorna a lista de provas cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
status    | `Number` ou `Array`         | 1 (ativo) | Filtra a lista de provas pelo status
courseId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de provas pelos cursos aos quais pertencem
studentId | `Number`, `Array` ou `null` | `null`    | Filtra a lista de provas pelos alunos que a fizeram

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/tests',
    method: 'GET',
    dataType: 'json',
    data: {
        status: 1,
        courseId: 14,
        studentId: [107, 109, 104],
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

### Informações da prova

Retorna informações detalhadas sobre uma prova.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/tests/' + testId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "data": {
        "id": "Number",
        "name": "String",
        "code": "String",
        "status": "Number",
        "course": {
            "id": "Number",
            "name": "String",
            "status": "Number"
        }
    }
}
```

## Categorias

Método                                                 | URL                                | Descrição curta
------------------------------------------------------ | ---------------------------------- | -----------------
[Listar categorias](#listar-categorias)                | **GET:** `/categories`             | Retorna a lista de categorias cadastradas no sistema
[Informações da categoria](#informações-da-categorias) | **GET:** `/categories/:categoryId` | Retorna as informações da categoria solicitada

### Listar categorias

Retorna a lista de categorias cadastradas no sistema baseada nos filtros informados.

#### Parâmetros

Parâmetro | Tipo                        | Default   | Descrição
--------- | --------------------------- | --------- |-----------
status    | `Number` ou `Array`         | 1 (ativo) | Filtra a lista de categorias pelo status
courseId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de categorias pelos cursos aos quais pertencem
testId    | `Number`, `Array` ou `null` | `null`    | Filtra a lista de categorias pelas provas em que foram usadas

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/categories',
    method: 'GET',
    dataType: 'json',
    data: {
        status: 1,
        courseId: 10,
        testId: 2,
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

### Informações da categoria

Retorna informações detalhadas sobre uma categoria.

#### Parâmetros

Este método não suporta parâmetros.

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/categories/' + categoryId,
    method: 'GET',
    dataType: 'json',
});
```

#### JSON de retorno

``` json
{
    "data": {
        "id": "Number",
        "name": "String",
        "status": "Number",
        "courses": [
            {
                "id": "Number",
                "name": "String",
                "status": "Number"
            }
        ],
        "tests": [
            {
                "id": "Number",
                "name": "String",
                "status": "Number"
            }
        ]
    }
}
```

## Resultados

Método                                  | URL                 | Descrição curta
--------------------------------------- | ------------------- | -----------------
[Buscar resultados](#buscar-resultados) | **GET:** `/results` | Retorna uma lista de resultados cadastrados no sistema

### Buscar resultados
Retorna uma lista de resultados baseada nos filtros informados.

#### Parâmetros

Parâmetro  | Tipo                        | Default   | Descrição
---------- | --------------------------- | --------- |-----------
testId     | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados pelas provas em que foram usadas
studentId  | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados pelos alunos que realizaram a prova
categoryId | `Number`, `Array` ou `null` | `null`    | Filtra a lista de resultados pelas categorias às quais pertencem

#### Exemplo de requisição (Ajax)

``` javascript
$.ajax({
    url: '/results',
    method: 'GET',
    dataType: 'json',
    data: {
        testId: 2,
        studentId: 11,
        categoryId: [1, 3],
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
            "errors": "Number",
            "hits": "Number",
            "category": {
                "id": "Number",
                "name": "String",
                "status": "Number",
            },
            "test": {
                "id": "Number",
                "name": "String",
                "code": "String",
                "status": "Number",
            },
            "student": {
                "id": "Number",
                "name": "String",
                "ra": "String",
                "status": "Number"
            }
        }
    ]
}
```
