<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;
use App\Model\Estados;
use App\Model\Cidades;
class FeriadosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function getNacionais()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.feriados.com.br/feriados-vespasiano-mg.php',
        ]); 
        $result = curl_exec($curl);
        //quebrei uma vez, preciso da posição 2
        $teste = explode('<br><div class="rounded_borders" style="background-color:#eee; width: 94%; padding: 8px" align="left"',$result);
        $teste2 = explode('iframe id="calendar_frame"', $teste[1]);
        $teste3 = explode('\n', $teste2[0]);
        $feriados=[];
        $teste4= explode('<span class="style_lista_', $teste3[0]);
       
        // posicoes de 1 a sizeof -1
        for ($i =1; $i < sizeof($teste4)-1;$i++)
        {
            //posicao 0 data
            $teste5 = explode(' - ',$teste4[$i]);
            $data_aux = explode('">',$teste5[0]);
            $tipo = $data_aux[0]; 
            $data = $data_aux[1];
            $teste6= explode('<b>',$teste5[1]);
            //pegar nome
            $teste7 = explode('</b>', $teste6[0]);
            $teste8= explode ('</a></span>',$teste7[0]);
            $teste9 = explode (';">',$teste8[0]);
            //Posição 0 é o nome
            if(sizeof ($teste9)> 1)
            {
                $nome = $teste9[1];
            }
            else
            {
                $nome = "Feriado Municipal";

            }
            $feriados[$i]['nome'] =$nome;
            $feriados[$i]['data'] =$data;
            $feriados[$i]['tipo'] =$tipo;
        }
        return response()->json($feriados);
    }
    public function getEstaduais($sigla)
    {
        $estados = Estados::where('sigla','=',strtoupper($sigla))->first();
        $nomeEstado = $arquivo = str_replace(" ", "_", $estados->nome);
        $url ='http://www.feriados.com.br/feriados-estado-' . strtolower($nomeEstado). '-' . $sigla.'.php';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ]); 
        $result = curl_exec($curl);
        $teste = explode('<br><div class="rounded_borders" style="background-color:#eee; width: 94%; padding: 8px" align="left"',$result);
        $teste2 = explode('iframe id="calendar_frame"', $teste[1]);
        $teste3 = explode('\n', $teste2[0]);
        $feriados=[];
        $teste4= explode('<span class="style_lista_', $teste3[0]);
       
        // posicoes de 1 a sizeof -1
        for ($i =1; $i < sizeof($teste4)-1;$i++)
        {
            //posicao 0 data
            $teste5 = explode(' - ',$teste4[$i]);
            $data_aux = explode('">',$teste5[0]);
            $tipo = $data_aux[0]; 
            $data = $data_aux[1];
            $teste6= explode('<b>',$teste5[1]);
            //pegar nome
            $teste7 = explode('</b>', $teste6[0]);
            $teste8= explode ('</a></span>',$teste7[0]);
            $teste9 = explode (';">',$teste8[0]);
            //Posição 0 é o nome
            if(sizeof ($teste9)> 1)
            {
                $nome = $teste9[1];
            }
            else
            {
                $nome = "Feriado Municipal";

            }
            $feriados[$i]['nome'] =$nome;
            $feriados[$i]['data'] =$data;
            $feriados[$i]['tipo'] =$tipo;
        }
        return response()->json($feriados);
    }
    public function getMunicipais($sigla, $cidade)
    {
        $estados = Estados::where('sigla','=',strtoupper($sigla))->first();
        $nomeEstado = $arquivo = str_replace(" ", "_", $estados->nome);
        $url = 'http://www.feriados.com.br/feriados-' . strtolower(str_replace(" ", "_", $cidade)).  '-' . $sigla.'.php'; 
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ]); 
        $result = curl_exec($curl);
        $teste = explode('<br><div class="rounded_borders" style="background-color:#eee; width: 94%; padding: 8px" align="left"',$result);
        $teste2 = explode('iframe id="calendar_frame"', $teste[1]);
        $teste3 = explode('\n', $teste2[0]);
        $feriados=[];
        $teste4= explode('<span class="style_lista_', $teste3[0]);
       
        // posicoes de 1 a sizeof -1
        for ($i =1; $i < sizeof($teste4)-1;$i++)
        {
            //posicao 0 data
            $teste5 = explode(' - ',$teste4[$i]);
            $data_aux = explode('">',$teste5[0]);
            $tipo = $data_aux[0]; 
            $data = $data_aux[1];
            $teste6= explode('<b>',$teste5[1]);
            //pegar nome
            $teste7 = explode('</b>', $teste6[0]);
            $teste8= explode ('</a></span>',$teste7[0]);
            $teste9 = explode (';">',$teste8[0]);
            //Posição 0 é o nome
            if(sizeof ($teste9)> 1)
            {
                $nome = $teste9[1];
            }
            else
            {
                $nome = "Feriado Municipal";

            }
            $feriados[$i]['nome'] =$nome;
            $feriados[$i]['data'] =$data;
            $feriados[$i]['tipo'] =$tipo;
        }
        return response()->json($feriados);
    }

}
