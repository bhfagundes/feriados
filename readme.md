# Criação da API para obter feriados
    Foi construída uma api de forma obter feriados municipais, estaduais, nacionais. 
    Atualmente contamos com 3 endpoints para a API:
## /feriados
    Este endpoint retorna apenas os feriados nacionais para o ano em vigência

## /feriados/{sigla}
    Este endpoint retorna os feriados nacionais e estaduais. O parâmetro sigla, é a sigla do estado que se pretende obter os feriados.

## /feriados/{sigla}/{cidade}   
    Este endpoint retorna os feriados nacionais, estaduais e municipais. O parâmetro sigla, é a sigla do estado desejado. O parâmetro cidade é o nome da cidade pertencente ao estado anterior em que se deseja obter os feriados.
## /feriados/estadosEspecificos
    Este endpoint retorna apenas os feriados estaduais dos estados especificados. O método de requisição deverá ser post e deverá ser enviado um json como párâmetro no modelo:
    {
    "estados": [
        {
            "UF": "MG"
        },
        {
            "UF": "RJ"
        },
        {
            "UF": "SP"
        }]
    }
## feriados/municipiosEspecificos    
    Este endpoint retorna apenas os feriados municipais dos municipios especificados. O método de requisição deverá ser post e deverá ser enviado um json como párâmetro no modelo:

    {
    "cidades": [
        {
            "uf": "RJ",
            "cidade": "sumidouro"
        },
        {
            "uf": "SE",
            "cidade": "aracaju"
        },
        {
            "uf": "MT",
            "cidade": "cuiabá"
        }
     ]
    }