<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\MessagingResponse; 
use SimpleXMLElement;
use GuzzleHttp\Client;

use App\Models\log_access;
use App\Models\menu;

use Illuminate\Support\Facades\Log;


class webhookController extends Controller
{
    
 public function index(Request $request, log_access $log){

    $response = new MessagingResponse();

    $body = $request->input('Body');
    $from = $request->input('From');
    $from = substr($from, -10);

    $menuTela = null;
    $abreSolicitacao = false;
    $log_number = null;
    $log_id = 0;

    


    // api portuques: http://10.0.38.39/tascom/prd/tascomPanel/public/api/whatsapp
 

$url = "http://10.0.38.39/tascom/prd/tascomPanel/public/api/whatsapp?cd_atendimento=$body&token=ghjr4925ddrnnlpo56c6d5hj6d5b2e9aqz6494adadhjkghudsdf4d54mlo9kyrscnznx";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$api = json_decode(curl_exec($ch));

//dd($api[0]->nm_paciente);


    
$log_gets = $log->where('number', $from)->where('active',true)->get(); // inicio da verificação do numero na base local

foreach ($log_gets as $log_get) {
    $log_number = $log_get->number;
    $log_status = $log_get->status_number_id;
    $log_status_active = $log_get->active;
    $log_id = $log_get->id;
    $log_atendimento = $log_get->cd_atendimento;
}


if ($api[0]->cd_atendimento == $body || $from == $log_number){
    $api = true;
}elseif($from != $log_number){
    $api = false;
}
$mv = $api == true ? true : false;



    if ($mv == true){
    
    if ($from == $log_number && $log_status == 2 && $body == 0){

        self::atualizaLog($log_id, 1, $body, $log, $from, null, null , $log_atendimento);
        $response->message("*Por favor escolha uma das opções abaixo:* \n\n".self::menu('menu',0,null));

        
        }elseif($from == $log_number && $log_status == 2 && $body != 0){

            $validOpcao = self::validaOpcao($body,2000);

            

            if ($validOpcao['status'] == true){


                $menuXMLs = menu::where('active', true)
                ->where('type','submenu')
                ->where('order',$body)
                ->get();

                foreach ($menuXMLs as $menuXML) {
                    $grupo = $menuXML->grupo; 
                    $atividade = $menuXML->atividade;
                    $aceitar = $menuXML->aceitar;
                    $equipe = $menuXML->equipe;
                    $desc = $menuXML->description;
                }

                $url = "http://10.0.38.39/tascom/prd/tascomPanel/public/api/whatsapp?cd_atendimento=$log_atendimento&token=ghjr4925ddrnnlpo56c6d5hj6d5b2e9aqz6494adadhjkghudsdf4d54mlo9kyrscnznx";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $api = json_decode(curl_exec($ch));        
        
                $nm_paciente = $api[0]->nm_paciente;
                $cd_paciente = $api[0]->cd_paciente;
                $setorLeito = $api[0]->cd_setor_leito;
                $cd_convenio = $api[0]->cd_convenio;
                $nm_convenio = $api[0]->nm_convenio;
                $cd_atendimento = $api[0]->cd_atendimento;
                $dt_nascimento = $api[0]->cd_atendimento;
                $vip = $api[0]->paciente_vip;
                $precaucao = $api[0]->precaucao;
                

                $cabecalho = '<?xml version="1.0"?><schedule></schedule>';
                $data = array(
                    'serviceLocal' => [
                        'alternativeIdentifier' => $setorLeito
                    ],
                    'team' => [
                        'alternativeIdentifier' => $equipe 
                    ],
                    'activitiesOrigin' => 4,
                    'teamExecution' => 1,
                    'date' => date('Y-m-d'),
                    'hour' => date('h:i'),
                    'activityRelationship' => [
                        'activity' => [
                            'alternativeIdentifier' => $atividade
                        ],
                        'activity' => 
                            ['alternativeIdentifier' => $aceitar
                        ]
                    ],
                    'observation' => $grupo,
                    'priority' => 1,
                    'customFields' => [
                        'uni.ds_unid_destino' => '',
                        'uni.ds.unid_local_destino' => '',
                        'uni.cd_unid_destino' => '',
                        'uni.cd.unid_local_destino' => '',
                        'pac.cd_paciente' => $cd_paciente,
                        'pac.nm_paciente' => $nm_paciente,
                        'pac.sn_vip' => $vip,
                        'con.cd_convenio' => $cd_convenio,
                        'con.nm_convenio' => $nm_convenio,
                        'usr.cd_login' => 'master',
                        'tarefa.desc' => $desc,
                        'pac.cd_atendimento' => $cd_atendimento,
                        'pac.dt_nascimento' => $dt_nascimento,
                        'tarefa.classif' => $precaucao,
                        'cmp.nm_solic' => 'master',

                    ]
                );

                function array_to_xml( $data, &$xml_data ) {
                    foreach( $data as $key => $value ) {
                        if( is_array($value) ) {
                            if( is_numeric($key) ){
                                $key = 'item'.$key; //dealing with <0/>..<n/> issues
                            }
                            $subnode = $xml_data->addChild($key);
                            array_to_xml($value, $subnode);
                        } else {
                            $xml_data->addChild("$key",htmlspecialchars("$value"));
                        }
                     }
                }
                
                // initializing or creating array
                
                // creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement($cabecalho);
                
                // function call to convert array to xml
                
                array_to_xml($data,$xml_data);
                //saving generated xml file; 
                $xml = $xml_data->asXML();
            
                $content = http_build_query(array(
                    'xml' => $xml,
                    ));
                    
                    $context = stream_context_create(array(
                    'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded",
                    'content' => $content,
                    )
                    ));
                    
                $result = file_get_contents('http://127.0.0.1/integraWhatsapp/src/index.php', null, $context);
                $retorno = $result == true ? true : false;
                
                

                if ($retorno == true){
                    self::atualizaLog($log_id, 3, $body, $log, $from, 200, $result, $log_atendimento);

                    $response->message("*Solicitação aberta com sucesso ! \nPara abrir outra solicitação é só nos chamar novamente !*"); 
                   
                   

                }else{
                    self::atualizaLog($log_id, 1, $body, $log, $from, null, null, $log_atendimento);
                    $response->message("*Ocorreu um erro ao abrir a solicitação* \n\nPor favor escolha uma das opções abaixo: \n\n".self::menu('menu',0)); 

                }
                

                }elseif($validOpcao['status'] == false){

                    $response->message($validOpcao['mensagem']);
                }
            

    }else{ // cria o primeiro log de acesso e dispara mensagem de opções

        if (($from != $log_number) || ($from == $log_number && $log_status == 3 && $log_status_active == 0)){

            $log->create([
                'number'=> $from,
                'status_number_id' => 1,
                'active' => true,
                'cd_atendimento' => $body
            ]);


            $validOpcao = self::validaOpcao(null,1000);
            
            $response->message($validOpcao['mensagem']);

        
            

        }else{
            $validOpcao = self::validaOpcao($body,0);
            
            if ($validOpcao['status'] == true){

                self::atualizaLog($log_id, 2, $body, $log, $from, null, null, $log_atendimento);

                # entrada em submenu
                $response->message($validOpcao['mensagem']);
            

            }elseif($validOpcao['status'] == false){

                $response->message($validOpcao['mensagem']);
            }
            
        }
 
    }

}else{

    $response->message("*Seja bem vindo ao atendimento RHP!* \n\nPor favor nos envie o número do atendimento do paciente!.");

}   

    return $response;
}


 public static function menuFnc($tipo,$refmenu){
    $menu = menu::where('active', true)
    ->where('type',$tipo)
    ->where('refmenu',$refmenu)
    ->get();
    return $menu;   
 }

 public static function icons($dsIcon){
    switch($dsIcon)
    {
        case "cop":
        return '👩‍🍳';
        break;
        
        case "enf":
        return '👩‍⚕';
        break;
        
        case "hig":
        return '🧹';
        break;

        case "lav":
        return '🧺';
        break;

        case "psi":
        return '💭';
        break;
                
        case "sol":
        return '🛏';
        break;
                    
        case "out":
        return '🗒';
        break;

        case "ded":
        return '🦟';
        break;

        default:
        return '';
        break;
    }
 }

 public static function jsonTOxml($data,$cabecalho){
  /*  function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
    
    // initializing or creating array
    
    // creating object of SimpleXMLElement
    $xml_data = new SimpleXMLElement($cabecalho);
    
    // function call to convert array to xml
    
    array_to_xml($data,$xml_data);
    //saving generated xml file; 
    $xml = $xml_data->asXML();

    $content = http_build_query(array(
        'xml' => $xml,
        ));
        
        $context = stream_context_create(array(
        'http' => array(
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded",
        'content' => $content,
        )
        ));
        
    $result = file_get_contents('http://127.0.0.1/integraWhatsapp/src/index.php', null, $context);
    $retorno = $result == true ? true : false;
    return $result;*/
    
    
 }

 public static function atualizaLog( $log_id ,$status, $body, $log , $from ,$tipo, $xml , $cd_atendimento){

    if ($tipo == 200){

        $log->where('id', $log_id)
        ->update(['active' => false]);

        $log->create([
            'number'=> $from,
            'status_number_id' => $status,
            'menu_id' => $body,
            'active'=> false,
            'cd_atendimento' => $cd_atendimento,
            'xml' => $xml
        ]);

    }else{
        $log->where('id', $log_id)
        ->update(['active' => false]);

        $log->create([
            'number'=> $from,
            'status_number_id' => $status,
            'menu_id' => $body,
            'active'=> true,
            'cd_atendimento' => $cd_atendimento,
        ]);
    }
 }

 public static function menu ($tipo, $refmenu){
    $menuTela = null;

    if ($tipo == 'menu'){

        $menus = self::menuFnc('menu',0);

        foreach ($menus as $menu) { 
            $menuTela .= '*'.$menu->order.'* - '.$menu->description.' '.self::icons($menu->icon)."\n";
        }
            
        return $menuTela;

    }elseif($tipo == 'submenu'){

        $menus = self::menuFnc('submenu',$refmenu);

        foreach ($menus as $menu) { 
            $menuTela .= '*'.$menu->order.'* - '.$menu->description.' '.self::icons($menu->icon)."\n";
        }
        $menuTela .= '*0* - Voltar';
        return $menuTela;
        
    }
    
 }

 public static function validaOpcao($opcao,$tipo_menu){

    $posicoesMenu = self::menuFnc('menu',0);

        $opcoesMenu = array();
        $opMenu = 1;

        foreach ($posicoesMenu as $opcaoM) {

            array_push($opcoesMenu,$opMenu);
            $opMenu++;

        }

        // contador de opções de SubMenu
    $posicoesSubMenu = self::menuFnc('submenu',$opcao);

        $opcoesSubMenu = array();
        $opSubMenu = 1;

        foreach ($posicoesSubMenu as $opcaoS) {

            array_push($opcoesSubMenu,$opSubMenu);
            $opSubMenu++;

        }      

    if($tipo_menu == 0 ){
        
        //$opcoes = array(1,2,3,4,5,6,7,8);
        // contador de opções de menu
        

        // menu principal  
        if(in_array($opcao, $opcoesMenu)){
            return [
                    'status' => true ,
                    //'mensagem' => "*Seja bem vindo ao atendimento RHP!* \nPorfavor escolha uma das opções abaixo: \n\n".self::menu('menu',0,null) 
                    'mensagem' => "*Agora escolha o serviço desejado:* \n\n".self::menu('submenu',$opcao)
                   ]
                ;
        }else{
            
            return [
                'status' => false, 
                'mensagem' => "⚠⚠⚠ *Opção Inválida* ⚠⚠⚠ \nPor favor escolha uma das opções abaixo: \n\n".self::menu('menu',0,null) 
                ]
              ;
        }
  
    }elseif($tipo_menu == 1000 ){

        return [
            'status' => true ,
            'mensagem' => "*Por favor escolha uma das opções abaixo:* \n\n".self::menu('menu',0,null) 
           ]
        ;

        // fim do menu principal

    }elseif($tipo_menu == 2000){

        if(in_array($opcao, $opcoesSubMenu)){
            return [
                    'status' => true ,
                    'mensagem' => "*Agora escolha o serviço desejado :* \n\n".self::menu('submenu',$opcao)
                   ]
                ;
        }else{
            
            return [
                'status' => false, 
                'mensagem' => "⚠⚠⚠ *Opção Inválida* ⚠⚠⚠ \n\nPor favor escolha uma das opções abaixo: \n\n".self::menu('submenu',$opcao) 
                ]
              ;
        }


        
    }

    



 }

}
