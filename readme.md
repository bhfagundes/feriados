# Criação da API para obter feriados
    Foi construída uma api de forma obter feriados municipais, estaduais, nacionais. 
    Atualmente contamos com 3 endpoints para a API:
## /feriados/{ano}
    Este endpoint retorna apenas os feriados nacionais para o ano especificado na url

## /feriados/{ano}/{sigla}
    Este endpoint retorna os feriados estaduais. O parâmetro sigla, é a sigla do estado que se pretende obter os feriados. O parametro {ano} serve para setar o ano que deseja obter o resultado

## /feriados/{ano}/{sigla}/{cidade}   
    Este endpoint retorna os feriados municipais. O parâmetro sigla, é a sigla do estado desejado. O parâmetro cidade é o nome da cidade pertencente ao estado anterior em que se deseja obter os feriados. O parâmetro ano seta o ano em que se deseja obter os resultados
## /feriados/{ano}/estadosEspecificos
    Este endpoint retorna apenas os feriados estaduais dos estados especificados. 
    O parâmetro ano seta o ano em que se deseja obter os resultados. O método de requisição deverá ser post e deverá ser enviado um json como párâmetro no modelo:
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
## feriados/{ano}/municipiosEspecificos    
    Este endpoint retorna apenas os feriados municipais dos municipios especificados. O parâmetro ano seta o ano em que se deseja obter os resultados. O método de requisição deverá ser post e deverá ser enviado um json como párâmetro no modelo:

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