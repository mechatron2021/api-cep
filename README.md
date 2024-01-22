1 - baixar a aplicação
	git@github.com:mechatron2021/api-cep.git
2 - acessar o diretorio da aplicação e executar o comando `composer update` para atualização de dependências
3 - renomear o arquivo .env.original para .env
3 - configurar o .env para conexão com banco de dados m(utilizei o mysql)
4 - executar o comando `php artisan migrate`
5 - subir a aplicação executando o comando `php artisan serve` 

usei o POSTMAN para manuipular os end-points:

endpoints:

busca/inclusão (GET) 
	localhost:8000/api/cep-search/$parametro
	o parametro é o cep
	
atualizar (POST)
	localhost:8000/api/cep-update
	body:
	
	{
		"cep": "digite o cep",
		"logradouro": "digite o logradouro",
		"complemento": "digite o complemento, se houver",
		"bairro": "digite o bairro",
		"localidade": "Digite a cidade",
		"uf": "digite a UF, com dois caracteres",
		"ibge": "digite o codigo ibge, se houver",
		"gia": "digite o gia, se houver",
		"ddd": "digite o ddd, se souber",
		"siafi": "digite o siafi, se houver"
	}
	
excluir (DELETE)
	localhost:8000/api/cep-delete/$parametro
	o parametro é o cep

Busca FuzzySearch (POST)
	localhost:8000/api/cep-fuzzy-search	
	use um ou mais atributos, a exemplo, o json abaixo, com seus respectivos valores parciais ou totais:
		{
		"cep": "",
		"logradouro": "",
		"complemento": "",
		"bairro": "",
		"localidade": "",
		"uf": "",
		"ibge": "",
		"gia": "",
		"ddd": "",
		"siafi": ""
	}

dúvidas: Marcelo - 41 991 293 515