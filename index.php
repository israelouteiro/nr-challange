<?php
$returned_value = vPost("http://www.portal.scf.sebrae.com.br/licitante/frmPesquisarAvancadoLicitacao.aspx",[]);

$returned_value = explode('<div id="resultadoBusca">', $returned_value);
$clean_array = array();

for( $i=1 ; $i<count($returned_value); $i++ ){
	$clean_information = explode('</div>', $returned_value[$i]);
	$clean_information = $clean_information[0];

	$genOb = new objetoLicitacao();
	$genOb->unidade = vUnidade($clean_information);
	$genOb->nome = vNome($clean_information);
	$genOb->objeto = vObjeto($clean_information);
	$genOb->data_abertura = vDataA($clean_information);
	$genOb->situacao = vSituacao($clean_information);
	$genOb->local = vLocal($clean_information);
	$genOb->telefone = vTelefone($clean_information);
	$genOb->fax = vFax($clean_information);

	$clean_array[count($clean_array)] = $genOb;
}

print_r($clean_array);

function vUnidade($ci){
	$rv = explode('<span class=unidade>', $ci);
	$rv = explode('</span>', $rv[1]);
	return $rv[0];
}

function vNome($ci){
	$rv = explode('<h3>', $ci);
	$rv = explode('</h3>', $rv[1]);
	return $rv[0];
}

function vObjeto($ci){
	$rv = explode('<b>Objeto: </b>', $ci);
	$rv = explode('<br /><b>', $rv[1]);
	return $rv[0];
}

function vDataA($ci){
	$rv = explode('<b>Data de Abertura : </b>', $ci);
	$rv = explode('<br /><b>', $rv[1]);
	return $rv[0];
}

function vSituacao($ci){
	$rv = explode('<b>Situação: </b>', $ci);
	$rv = explode('<br /><b>', $rv[1]);
	return $rv[0];
}

function vLocal($ci){
	$rv = explode('<b>Local da Licitação: </b>', $ci);
	$rv = explode('<br /><b>', $rv[1]);
	return $rv[0];
}

function vTelefone($ci){
	$rv = explode('<b>Telefone: </b>', $ci);
	$rv = explode('<b>', $rv[1]);
	return $rv[0];
}

function vFax($ci){
	$rv = explode('<b>Fax: </b>', $ci);
	$rv = explode('<br /></p>', $rv[1]);
	return $rv[0];
}




function vPost($urlenviar, $array_enviar){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlenviar);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array_enviar) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    return $server_output;
}

class objetoLicitacao{
	var $nome;
	var $unidade;
	var $objeto;
	var $data_abertura;
	var $situacao;
	var $local;
	var $telefone;
	var $fax;
}
