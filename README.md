Routes APIS

http://localhost:8000/api/user/store

{
    "name": "João",
    "email": "joao@hotmail.com",
    "document": "1234567892222",
    "type": "CPF"
}

http://localhost:8000/api/transaction

{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}

Obs: pode rodar o test se não quiser criar usuario que ele já cria 3, antes de rodar test de refresh no banco para não dar nenhuma falha

