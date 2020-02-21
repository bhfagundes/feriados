<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;
use App\Model\Estados;
use App\Model\Cidades;
use Illuminate\Http\Request;
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
    public $feriadosNac= [];

    public function feriadosNacionais($ano)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.feriados.com.br/'.$ano,
        ]); 
        $result = curl_exec($curl);
        //quebrei uma vez, preciso da posição 2
        $teste = explode('<br><div class="rounded_borders" style="background-color:#eee; width: 94%; padding: 8px" align="left"',$result);
        $teste2 = explode('iframe id="calendar_frame"', $teste[1]);
        $teste3 = explode('\n', $teste2[0]);
        $feriados=[];
        $aux;
        $teste4= explode('<span class="style_lista_', $teste3[0]);
        // posicoes de 1 a sizeof -1
        for ($i =1; $i < sizeof($teste4);$i++)
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
                 $exp = explode ('</span>',$teste9[0]);
                 $nome = $exp[0];
 
             }
            
            if(in_array($nome,$this->feriadosNac))
            {
            
                $aux['nome']=$nome;
                $aux['data']=$data;
                $aux['tipo']=$tipo;
                array_push($feriados,$aux);
            }           
          
        }
        return $feriados;
    }
    public function getNacionais($ano)
    {
        $this->setarNacionais();
        $feriados = $this->feriadosNacionais($ano);
        return response()->json($feriados);
    }
    public function feriadosEstaduais($sigla, $ano)
    {
        $this->setarNacionais();
        $feriadosGerais = $this->feriadosNacionais($ano);
        $url ='http://www.feriados.com.br/feriados-estado-' . $sigla.'.php?ano='.$ano;
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
        for ($i =1; $i < sizeof($teste4);$i++)
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
                $exp = explode ('</span>',$teste9[0]);
                $nome = $exp[0];

            }
            if(!in_array($nome,$this->feriadosNac))
            {
            
                $atributos['nome'] =$nome;
                $atributos['data'] =$data;
                $atributos['tipo'] =$tipo;
                array_push($feriados,$atributos);
            }           
                  
        }
        return $feriados;
    }
    public function getEstaduais($sigla, $ano)
    {
        $feriados = $this->feriadosEstaduais($sigla,$ano);
        return response()->json($feriados);
    }
    public function validaTipoFeriado($data,$feriados,$ano)
    {
        $flag = 1;
        $feriados = $this->feriadosNacionais($ano);
        for($i=1; $i<sizeof($feriados);$i++)
        {
            if($data == $feriados[$i]['data'])
            {
                $flag =0;
                $i=sizeof($feriados);
            }
        }
        return $flag;
    }
    public function feriadosMunicipais($sigla, $cidade, $ano)
    {
        $cid = $cidade;
        $feriadosGerais = $this->feriadosEstaduais($sigla,$ano);
        $feriadosEstaduais = $this->feriadosEstaduais($sigla,$ano);
        $atributos;
        $cidade= preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$cidade);
        $cidade = str_replace(" ", "_", $cidade);
        $cidade = str_replace("ç", "c", $cidade);
        $url = 'http://www.feriados.com.br/feriados-' . strtolower( $cidade).  '-' . $sigla.'.php?ano='.$ano; 
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
        
        for ($i =1; $i < sizeof($teste4);$i++)
        {
            //posicao 0 data
            $teste5 = explode(' - ',$teste4[$i]);
            $exp2 = explode('</span></div></ul><div align="center"><span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; color: #444;">E amanh&atilde;? <a href="http://www.feriadoamanha.com.br">Amanh&atilde; &eacute; Feriado de Qu&ecirc;?</a></span></div></div>',$teste5[1]);
            $data_aux = explode('">',$teste5[0]);
            $tipo = $data_aux[0]; 
            $data = $data_aux[1];
            if(sizeof($exp2) ==2)
            {
                $nome = $exp2[0];
            }
            else
            {
                
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
                    $exp = explode ('</span>',$teste9[0]);
                    $nome = $exp[0];
    
                }
            }
            if(!array_search($nome, array_column($feriadosEstaduais, 'nome')) && !in_array($nome,$this->feriadosNac))
            {
                $atributos['nome'] =$nome;
                $atributos['data'] =$data;
                $atributos['tipo'] =$tipo;
                array_push($feriados,$atributos);
            }
            
        }
        return $feriados;
    }
    public function getMunicipais($sigla, $cidade, $ano)
    {
        $feriados = $this->feriadosMunicipais($sigla,$cidade,$ano);
        return response()->json($feriados);
    }
    public function getMunicipiosEspecificos(Request $request,$ano)
    {
        $cidades = $request->all();
        $cidades =json_encode($cidades);
        $cidades =  json_decode($cidades);
        $data=[];
        for($i=0; $i<sizeof($cidades->cidades);$i++)
        {
            $data[$i]['uf']=$cidades->cidades[$i]->uf;
            $data[$i]['cidade']=$cidades->cidades[$i]->cidade;
            $data[$i]['feriados']= $this->feriadosMunicipais($cidades->cidades[$i]->uf,$cidades->cidades[$i]->cidade,$ano);
        }
        return response()->json($data);
    }
    public function getEstadosEspecificos(Request $request, $ano)
    {
        $estados = $request->all();
        $estados =json_encode($estados);
        $estados =  json_decode($estados);
        $data = [];
        for($i=0; $i<sizeof($estados->estados);$i++)
        {
            $data[$i]['uf']=$estados->estados[$i]->UF;
            $data[$i]['feriados']= $this->feriadosEstaduais($estados->estados[$i]->UF,$ano);
        }
        return response()->json($data);
    }
    public function setarNacionais()
    {
        $nomes[0]='Ano Novo';
        $nomes[1]='Carnaval';
        $nomes[2]='Sexta-Feira Santa';
        $nomes[3]='Dia de Tiradentes';
        $nomes[4]='Dia do Trabalho';
        $nomes[5]='Corpus Christi';
        $nomes[6]='Independência do Brasil';
        $nomes[7]='Nossa Senhora Aparecida';
        $nomes[8]='Dia do Professor';
        $nomes[9]='Dia do Servidor Público';
        $nomes[10]='Dia de Finados';
        $nomes[11]='Proclamação da República';
        $nomes[12]='Natal';
        $this->feriadosNac = $nomes;
        return ;


    }
    ## basta adicionar a flag ?ano=2020
}
