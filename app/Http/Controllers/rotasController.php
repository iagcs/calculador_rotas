<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class rotasController extends Controller
{
    public function index()
    {
        $rotas = DB::table('rotas')->get();
        return view('enderecos',compact('rotas'));
    }

    public function store(Request $request){
        $enderecos = DB::table('rotas')->insert([
            'numero' => $request->numero,
            'logradouro' => $request->logradouro,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
        ]);
        return redirect('/enderecos');
    }

    public function mapa(){
        $rotas = DB::table('rotas')->get();
        $enderecos = array();
        foreach($rotas as $item){
            $enderecos[] = array($item->numero,$item->logradouro,$item->bairro,$item->cidade,$item->estado);
        }
        for($i=0;$i<=count($enderecos)-1;$i++){
            $rota[] = $enderecos[$i];
        }
        $tam=0;
        $count2=0;
        $indice=0;


        for($j=0;$j<(count($rota));$j++){
            //FAZ A REQUISIÇÃO DE TODAS AS ROTAS POSSIVEIS
            for ($i=0; $i < count($rota); $i++) {
                //VERIFICACAO PARA NAO FAZER A VERIFICACAO DE DOIS ENDEREÇOS IGUAIS
                if($indice !== $tam){
                    //VERIFICA SE A POSICAO E NULA. SE FOR NULA QUER DIZER QUE JA FOI VERIFICADA
                    if($rota[$tam]!==null && $rota[$indice]!=null){
                        $link[] = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $rota[$tam][1] . "," . $rota[$tam][0] . " - " .  $rota[$tam][2] . ","  . $rota[$tam][3] . "&destinations=" . $rota[$indice][1] . "," . $rota[$indice][0] . " - " .  $rota[$indice][2] . ","  . $rota[$indice][3] . "&key=";
                        $response_directions[] = Http::get($link[$count2]);
                        $response2_directions[] = json_decode($response_directions[$count2]);
                        $distancia[] = $response2_directions[$count2]->rows[0]->elements[0]->distance->value;
                        $count2++;
                    }else{
                        $distancia[]=null;
                    }
                }else{
                    $distancia[]=null;
                }
                $indice++;
            }
            
            $menor_rota[] = $rota[$tam];
            //DEPOIS QUE FAZ A REQUISICAO DESSA POSICAO, ELA RECEBE NULL PARA NAO SER VERIFICADA NOVAMENTE  
            $rota[$tam]=null;
            $menor=99999999;
            //VERIFICA QUAL A MENOR DISTANCIA DE TODAS AS ROTAS
            for($i=0;$i<count($distancia);$i++){
                if($distancia[$i] !== null){
                    if($menor>$distancia[$i]){
                        $menor=$distancia[$i];
                        $dist=$distancia[$i];
                        //QUANDO ACHA A MENOR DISTANCIA, $tam RECEBE A POSICAO PARA FAZER A PROXIMA VERIFICACAO NO PROXIMO LOOP 
                        $tam=$i;
                    }
                }
            }
            if($dist!==0){
                $menor_distancia[] = $dist/1000;
            }
            $distancia = null;
            $indice=0;
            $dist=0;
            
        }
        $distancia_total = array_sum($menor_distancia);
        
        return view('enderecos', compact('enderecos','menor_rota','distancia_total','rotas','menor_distancia'));
    }

        
}