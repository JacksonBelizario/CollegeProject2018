function tabenter(event,campo)
{
	var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (tecla==13)
	{
		campo.focus();
	}
}
function ExtraiScript(texto)
{
	//desenvolvido por Skywalker.to, Micox e Pita.
	//N�o retire para n�o violar os direitos autorais.
	var ini, pos_src, fim, codigo;
	var objScript = null;
	ini = texto.indexOf('<script', 0)
	while (ini!=-1)
	{
		var objScript = document.createElement("script");
		//Busca se tem algum src a partir do inicio do script
		pos_src = texto.indexOf(' src', ini)
		ini = texto.indexOf('>', ini) + 1;

		//Verifica se este e um bloco de script ou include para um arquivo de scripts
		if (pos_src < ini && pos_src >=0)
		{//Se encontrou um "src" dentro da tag script, esta e um include de um arquivo script
		//Marca como sendo o inicio do nome do arquivo para depois do src
		ini = pos_src + 4;
		//Procura pelo ponto do nome da extencao do arquivo e marca para depois dele
		fim = texto.indexOf('.', ini)+4;
		//Pega o nome do arquivo
		codigo = texto.substring(ini,fim);
		//Elimina do nome do arquivo os caracteres que possam ter sido pegos por engano
		codigo = codigo.replace("=","").replace(" ","").replace("\"","").replace("\"","").replace("\'","").replace("\'","").replace(">","");
		// Adiciona o arquivo de script ao objeto que sera adicionado ao documento
		objScript.src = codigo;
	}
	else
	{//Se nao encontrou um "src" dentro da tag script, esta e um bloco de codigo script
	// Procura o final do script
	fim = texto.indexOf('</script>', ini);
	// Extrai apenas o script
	codigo = texto.substring(ini,fim);
	// Adiciona o bloco de script ao objeto que sera adicionado ao documento
	objScript.text = codigo;
}

//Adiciona o script ao documento
document.body.appendChild(objScript);
// Procura a proxima tag de <script
ini = texto.indexOf('<script', fim);

//Limpa o objeto de script
objScript = null;
}
}
function CreateAjax()
{
	var Ajax = null;
	if (window.XMLHttpRequest)
	{
		Ajax = new XMLHttpRequest();
		if (Ajax.overrideMimeType)
		{
			Ajax.overrideMimeType('text/html');
		}
	}
	else if (window.ActiveXObject)
	{
		try
		{
			Ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				Ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				Ajax = false;
			}
		}
	}
	if (!Ajax)
	{
		alert('Cannot create XMLHTTP instance');
	}
	return (Ajax);
}

function pegar(url, doFunc, id, msg)
{
	var xmlhttp=CreateAjax();

	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange= function()
	{
		if (xmlhttp.readyState == 1)
		{
			MensagemCarregando(msg);
		}
		if(xmlhttp.readyState==4)
		{
			if(xmlhttp.status==200)
			{
				doFunc(xmlhttp, id);
				MensagemCarregando_Limpar(msg);
			}
			else
			{
				MensagemErro(msg, xmlhttp);
			}
		}
	}
	xmlhttp.send(null);
}

function pegarForm_GET(id,id_form,msg)
{
	var url = document.getElementById(id_form).action;
	var elementos_form = BuscaElementosForm(id_form);
	var url_pegar = url+'?'+elementos_form;
	pegar(url_pegar,escrever,id,msg);
}

function pegarForm_POST(id,id_form,msg)
{
	var url = document.getElementById(id_form).action;
	var elementos_form = BuscaElementosForm(id_form);
	var url_pegar = url+'?'+elementos_form;
	pegar_POST(url,escrever,id,msg,elementos_form);
}

function pegar_POST(url, doFunc, id, msg, elementos)
{
	var xmlhttp=CreateAjax();

	xmlhttp.open("POST",url,true);
	xmlhttp.onreadystatechange= function()
	{
		if (xmlhttp.readyState == 1)
		{
			MensagemCarregando(msg);
		}
		if(xmlhttp.readyState==4)
		{
			if(xmlhttp.status==200)
			{
				doFunc(xmlhttp, id);
				MensagemCarregando_Limpar(msg);
			}
			else
			{
				MensagemErro(msg, xmlhttp);
			}
		}
	}
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(elementos);
}

function BuscaElementosForm(idForm)
{
	var elementosFormulario = document.getElementById(idForm).elements;
	var qtdElementos = elementosFormulario.length;
	var queryString = "";
	var elemento;

	this.ConcatenaElemento = function(nome,valor)
	{
		if (queryString.length>0)
		{
			queryString += "&";
		}
		queryString += encodeURIComponent(nome) + "=" + encodeURIComponent(valor);
	};
	for (var i=0; i<qtdElementos; i++)
	{
		elemento = elementosFormulario[i];
		if (!elemento.disabled)
		{
			switch(elemento.type)
			{
				case 'text': case 'password': case 'hidden': case 'textarea':
				{
					this.ConcatenaElemento(elemento.name,elemento.value);
					break;
				}
				case 'select-one':
				{
					if (elemento.selectedIndex>=0)
					{
						this.ConcatenaElemento(elemento.name,elemento.options[elemento.selectedIndex].value);
					}
					break;
				}
				case 'select-multiple':
				{
					for (var j=0; j<elemento.options.length; j++)
					{
						if (elemento.options[j].selected)
						{
							this.ConcatenaElemento(elemento.name,elemento.options[j].value);
						}
					}
					break;
				}
				case 'checkbox': case 'radio':
				{
					if (elemento.checked)
					{
						this.ConcatenaElemento(elemento.name,elemento.value);
					}
					break;
				}
			}
		}
	}
	return queryString;
}

function Erro(Ajax)
{
	switch (Ajax.status)
	{
		case 404:
		{
			return "P�gina n�o encontrada!!!";
			break;
		}
		case 500:
		{
			return "Erro interno do servidor!!!";
			break;
		}
		default:
		{
			return "Erro desconhecido!!!<br>" + Ajax.status;
			break;
		}
	}
	return true;
}

function escrever(req,id)
{
	document.getElementById(id).innerHTML = req.responseText;
	ExtraiScript(req.responseText);
}

function MensagemCarregando(id)
{
	document.getElementById(id).innerHTML = "<img src=\"../img/loading_barra_03.gif\" width=\"94\" height=\"17\" alt=\"loading_barra_03 (1K)\" />";
}

function MensagemCarregando_Limpar(id)
{
	document.getElementById(id).innerHTML = "";
}

function MensagemErro(id, req)
{
	document.getElementById(id).innerHTML = Erro(req);
}
function Mensagem(id,texto)
{
	document.getElementById(id).innerHTML = texto;
}

function listar(metodo)
{
	for(x in metodo)
	{
		metodo.write(x);
	}
}
function executar()
{
	pegar('inicio.php',escrever,'conteudo','msg');
	atualizar_dados();
}
function noticias()
{
	if (document.getElementById('noticias'))
	{
		pegar('noticias/index.php?ultimas=1',escrever,'noticias','msg');
		t=setTimeout('noticias()',120000);
	}
}
function atualizar_dados()
{
	pegar('pensamentos/mostrar.php',escrever,'pensamento','msg');
	pegar('indices_financeiros.php',escrever,'indice_financeiro','msg');
	t=setTimeout('atualizar_dados()',60000);
}
function horas()
{
	var today=new Date()
	var h=today.getHours()
	var m=today.getMinutes()
	var s=today.getSeconds()
	// add a zero in front of numbers<10
	m=checar(m)
	s=checar(s)

	document.getElementById('horas').innerHTML=h+":"+m+":"+s
	//document.getElementById('horas').innerHTML="<?php echo(date('H:i:s')); ?>"
	t=setTimeout('horas()',500)
}
function checar(i)
{
	if (i < 10)
	{
		i="0" + i
	}
	return i;
}

function mascara(o,f)
{
	v_obj=o
	v_fun=f
	setTimeout("execmascara()",1)
}

function execmascara()
{
	v_obj.value=v_fun(v_obj.value)
}

function data_masc(v)
{
	v=v.replace(/\D/g,"");
	v=v.replace(/(\d{2})(\d)/,"$1/$2");
	v=v.replace(/(\d{2})(\d)/,"$1/$2");
	return v;
}

function placa_masc(v)
{
	v=v.replace(/\W/g,"");
	v=v.replace(/(\w{3})(\w)/,"$1-$2");
	return v;
}
function digito(v)
{
	return v.replace(/\D/g,"");
}
function real(v)
{
	return v.replace(/[^0-9","]/g,"");
}
function letracsp(v)
{
	return v.replace(/[^a-z" ""\/""-"A-Z]/g,"");
}
function letrassp(v)
{
	return v.replace(/[^a-zA-Z]/g,"");
}
function letrasUpper(v)
{
	v = v.replace(/[^a-zA-Z]/g,"");
	return v.toUpperCase();
}
function Maiusculos(v)
{
	return v.toUpperCase();
}
function telefone_masc(v)
{
	v=v.replace(/\D/g,""); //Remove tudo o que n�o � d�gito
	v=v.replace(/^(\d\d)(\d)/g,"($1)$2"); //Coloca par�nteses em volta dos dois primeiros d�gitos
	v=v.replace(/(\d{4})(\d)/,"$1-$2"); //Coloca h�fen entre o quarto e o quinto d�gitos
	return v;
}
function cep_masc(v)
{
	v=v.replace(/\D/g,"");
	v=v.replace(/(\d{2})(\d{3})(\d)/g,"$1.$2-$3");
	return v;
}
function cnpj_masc(v)
{
	v=v.replace(/\D/g,"");
	v=v.replace(/^(\d{2})(\d)/,"$1.$2");
	v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
	v=v.replace(/\.(\d{3})(\d)/,".$1/$2");
	v=v.replace(/(\d{4})(\d)/,"$1-$2");
	return v;
}
function cpf_masc(v)
{
	v=v.replace(/\D/g,"");
	v=v.replace(/^(\d{3})(\d)/,"$1.$2");
	v=v.replace(/^(\d{3})\.(\d{3})(\d)/,"$1.$2.$3");
	v=v.replace(/\.(\d{3})(\d)/,".$1-$2");
	return v;
}
function cl_masc(v)
{
	v=v.replace(/\D/g,"");
	v=v.replace(/^(\d{2})(\d)/,"$1.$2");
	return v;
}
function masc_hex(v)
{
	v = v.replace(/\D/g,"");
	v = v.replace(/^(\d{2})(\d)/,"$1:$2");
}

//Valida��o de CPF
function remove(str, sub)
{
	i = str.indexOf(sub);
	r = "";
	if (i == -1) return str;
	r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
	return r;
}

function VerificaCPF (cpf,id)
{
	vcpf = remove(cpf.value,".")
	vcpf = remove(vcpf,"-")
	if (!vercpf(vcpf))
	{
		alert('CPF INVALIDO!');
		document.getElementById(id).focus();
	}
}
function vercpf (cpf)
{
	if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
	{
		return false;
	}
	add = 0;
	for (i=0; i < 9; i ++)
	{
		add += parseInt(cpf.charAt(i)) * (10 - i);
	}
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
	{
		rev = 0;
	}
	if (rev != parseInt(cpf.charAt(9)))
	{
		return false;
	}
	add = 0;
	for (i = 0; i < 10; i ++)
	{
		add += parseInt(cpf.charAt(i)) * (11 - i);
	}
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
	{
		rev = 0;
	}
	if (rev != parseInt(cpf.charAt(10)))
	{
		return false;
	}
	//alert('O CPF INFORMADO � V�LIDO.');
	return true;
}

function validaCNPJ(cnpj,id)
{
	CNPJ = cnpj.value;
	erro = new String;
	if (CNPJ.length < 18) erro += "� necessario preencher corretamente o n�mero do CNPJ! \n\n";
	if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")){
		if (erro.length == 0) erro += "� necess�rio preencher corretamente o n�mero do CNPJ! \n\n";
	}
	//substituir os caracteres que n�o s�o n�meros
	if(document.layers && parseInt(navigator.appVersion) == 4){
		x = CNPJ.substring(0,2);
		x += CNPJ. substring (3,6);
		x += CNPJ. substring (7,10);
		x += CNPJ. substring (11,15);
		x += CNPJ. substring (16,18);
		CNPJ = x;
	} else {
		CNPJ = CNPJ. replace (".","");
		CNPJ = CNPJ. replace (".","");
		CNPJ = CNPJ. replace ("-","");
		CNPJ = CNPJ. replace ("/","");
	}
	var nonNumbers = /\D/;
	if (nonNumbers.test(CNPJ)) erro += "A verifica��o de CNPJ suporta apenas n�meros! \n\n";
	var a = [];
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++){
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
	b = 0;
	for (y=0; y<13; y++) {
		b += (a[y] * c[y]);
	}
	if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		erro +="Digito verificador com problema!";
	}
	if (erro.length > 0){
		alert(erro);
		document.getElementById(id).focus();
		return false;
	}
	return true;
}

/*
* A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
* Digest Algorithm, as defined in RFC 1321.
* Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
* Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
* Distributed under the BSD License
* See http://pajhome.org.uk/crypt/md5 for more info.
*/

/*
* Configurable variables. You may need to tweak these to be compatible with
* the server-side, but the defaults work in most cases.
*/
var hexcase = 0;  /* hex output format. 0 - lowercase; 1 - uppercase        */
var b64pad  = "="; /* base-64 pad character. "=" for strict RFC compliance   */
var chrsz   = 8;  /* bits per input character. 8 - ASCII; 16 - Unicode      */

/*
* These are the functions you'll usually want to call
* They take string arguments and return either hex or base-64 encoded strings
*/
function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
function str_md5(s){ return binl2str(core_md5(str2binl(s), s.length * chrsz));}
function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
function str_hmac_md5(key, data) { return binl2str(core_hmac_md5(key, data)); }

/*
* Perform a simple self-test to see if the VM is working
*/
function md5_vm_test()
{
	return hex_md5("abc") == "900150983cd24fb0d6963f7d28e17f72";
}

/*
* Calculate the MD5 of an array of little-endian words, and a bit length
*/
function core_md5(x, len)
{
	/* append padding */
	x[len >> 5] |= 0x80 << ((len) % 32);
	x[(((len + 64) >>> 9) << 4) + 14] = len;

	var a =  1732584193;
	var b = -271733879;
	var c = -1732584194;
	var d =  271733878;

	for(var i = 0; i < x.length; i += 16)
	{
		var olda = a;
		var oldb = b;
		var oldc = c;
		var oldd = d;

		a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
		d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
		c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
		b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
		a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
		d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
		c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
		b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
		a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
		d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
		c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
		b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
		a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
		d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
		c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
		b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);

		a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
		d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
		c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
		b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
		a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
		d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
		c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
		b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
		a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
		d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
		c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
		b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
		a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
		d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
		c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
		b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);

		a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
		d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
		c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
		b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
		a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
		d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
		c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
		b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
		a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
		d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
		c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
		b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
		a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
		d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
		c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
		b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);

		a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
		d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
		c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
		b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
		a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
		d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
		c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
		b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
		a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
		d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
		c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
		b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
		a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
		d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
		c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
		b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);

		a = safe_add(a, olda);
		b = safe_add(b, oldb);
		c = safe_add(c, oldc);
		d = safe_add(d, oldd);
	}
	return Array(a, b, c, d);

}

/*
* These functions implement the four basic operations the algorithm uses.
*/
function md5_cmn(q, a, b, x, s, t)
{
	return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
}
function md5_ff(a, b, c, d, x, s, t)
{
	return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function md5_gg(a, b, c, d, x, s, t)
{
	return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function md5_hh(a, b, c, d, x, s, t)
{
	return md5_cmn(b ^ c ^ d, a, b, x, s, t);
}
function md5_ii(a, b, c, d, x, s, t)
{
	return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
* Calculate the HMAC-MD5, of a key and some data
*/
function core_hmac_md5(key, data)
{
	var bkey = str2binl(key);
	if(bkey.length > 16) bkey = core_md5(bkey, key.length * chrsz);

	var ipad = Array(16), opad = Array(16);
	for(var i = 0; i < 16; i++)
	{
		ipad[i] = bkey[i] ^ 0x36363636;
		opad[i] = bkey[i] ^ 0x5C5C5C5C;
	}

	var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
	return core_md5(opad.concat(hash), 512 + 128);
}

/*
* Add integers, wrapping at 2^32. This uses 16-bit operations internally
* to work around bugs in some JS interpreters.
*/
function safe_add(x, y)
{
	var lsw = (x & 0xFFFF) + (y & 0xFFFF);
	var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
	return (msw << 16) | (lsw & 0xFFFF);
}

/*
* Bitwise rotate a 32-bit number to the left.
*/
function bit_rol(num, cnt)
{
	return (num << cnt) | (num >>> (32 - cnt));
}

/*
* Convert a string to an array of little-endian words
* If chrsz is ASCII, characters >255 have their hi-byte silently ignored.
*/
function str2binl(str)
{
	var bin = Array();
	var mask = (1 << chrsz) - 1;
	for(var i = 0; i < str.length * chrsz; i += chrsz)
	bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
	return bin;
}

/*
* Convert an array of little-endian words to a string
*/
function binl2str(bin)
{
	var str = "";
	var mask = (1 << chrsz) - 1;
	for(var i = 0; i < bin.length * 32; i += chrsz)
	str += String.fromCharCode((bin[i>>5] >>> (i % 32)) & mask);
	return str;
}

/*
* Convert an array of little-endian words to a hex string.
*/
function binl2hex(binarray)
{
	var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
	var str = "";
	for(var i = 0; i < binarray.length * 4; i++)
	{
		str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) +
		hex_tab.charAt((binarray[i>>2] >> ((i%4)*8  )) & 0xF);
	}
	return str;
}

/*
* Convert an array of little-endian words to a base-64 string
*/
function binl2b64(binarray)
{
	var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwx  yz0123456789+/";
	var str = "";

	for(var i = 0; i < binarray.length * 4; i += 3)
	{
		var triplet = (((binarray[i   >> 2] >> 8 * ( i   %4)) & 0xFF) << 16)
		| (((binarray[i+1 >> 2] >> 8 * ((i+1)%4)) & 0xFF) << 8 )
		|  ((binarray[i+2 >> 2] >> 8 * ((i+2)%4)) & 0xFF);
		for(var j = 0; j < 4; j++)
		{
			if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
			else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
		}
	}
	return str;
}

function editar_form()
{
	document.getElementById('razao').focus();
	document.getElementById('razao').disabled = false;
	document.getElementById('endereco').disabled = false;
	document.getElementById('saltar').disabled = false;
	document.getElementById('editar').disabled = true;
	document.getElementById('salvar').disabled = false;
}
