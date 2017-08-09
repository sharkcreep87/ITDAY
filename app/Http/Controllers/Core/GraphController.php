<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GraphController extends Controller
{

    public function graph($id, $view)
    {
        if(!session('access_token'))
        {
            $guzzle = new \GuzzleHttp\Client;
            $response = $guzzle->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => '3',
                    'client_secret' => 'wKKJzMZ6rRCJjJREWeqpB4yeQn1bKr5meD4PlhKq',
                ],
            ]);

            $json = json_decode((string) $response->getBody(), true);
            session()->put('access_token',$json['access_token']);
        }
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config);
        $columns = [];
        $conn = \DB::getPdo();
        foreach($conn->query("SHOW FULL COLUMNS FROM `$row->module_db`") as $column)
        {
            $columns[] = $column;
        }
        $data['columns'] = $columns;
        $data['grid'] = $config['grid']; 
        $data['forms'] = $config['forms']; 
        $data['request'] = isset($config['request']) ? $config['request'] : null;
        $data['row'] = $row;
        $data['access_token'] = session('access_token');
        return view("core.graph.{$view}", $data);
    }

    function postSettings($id, $view, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config);

        foreach ($config['grid'] as $key => $value) {
            if($request->api_detail) {
                $config['form'][$key]['api'] = isset($request->api[$key]) ? 1 : 0;
            }else{
                $config['grid'][$key]['api'] = isset($request->api[$key]) ? 1 : 0;
            }
            
        }

        $config['request']['page'] = isset($request->page) ? $request->page : @$config['request']['page'];
        $config['request']['rows'] =  isset($request->rows) ? $request->rows : @$config['request']['rows'];
        $config['request']['sort'] =  isset($request->sort) ? $request->sort : @$config['request']['sort'];
        $config['request']['order'] =  isset($request->order) ? $request->order : @$config['request']['order'];
        $config['request']['search'] =  isset($request->search) ? $request->search : @$config['request']['search'];

        \DB::table('tb_module')->where('module_id',$id )->update(array('module_config' => \SiteHelpers::CF_encode_json($config))); 
        return redirect("core/graph/{$id}/{$view}")->with('message','API settings has been successfully changed.')->with('status','success');
    }
    
    public function getSearchBuilder($id, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config);
        $data['pageModule'] = $row->module_name;
        $data['tableForm'] = $config['forms'];
        return view('core.graph.builder',$data);
    }

    public function getToken()
    {
        $data['id'] = 3;
        $data['name'] = 'Graph Token';
        $data['secret'] = 'wKKJzMZ6rRCJjJREWeqpB4yeQn1bKr5meD4PlhKq';
        $data['accesss_token'] = session('access_token');
        return view('core.graph.token',$data);
    }

    public function postToken(Request $request)
    {
        $guzzle = new \GuzzleHttp\Client;
        $response = $guzzle->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '3',
                'client_secret' => 'wKKJzMZ6rRCJjJREWeqpB4yeQn1bKr5meD4PlhKq',
            ],
        ]);

        $json = json_decode((string) $response->getBody(), true);
        session()->put('access_token',$json['access_token']);
        return redirect(url()->previous())->with(['message'=>'Access token has been changed successfully', 'status'=>'success']);
    }

    public function guide()
    {
        $guide = file_get_contents(resource_path('views/core/graph/guide.txt'));
        $modules = \DB::table('tb_module')->where('module_type','!=','core')->get();
        foreach ($modules as $module) {
            $config = \SiteHelpers::CF_decode_json($module->module_config);
            $codes['module_title'] = $module->module_title;
            $codes['module_desc'] = strtolower($module->module_title);
            $codes['module_name'] = strtolower($module->module_name);
            $conn = \DB::getPdo();
            $table = $module->module_db;
            $parameters = [];
            $response = [];
            foreach($conn->query("SHOW FULL COLUMNS FROM `$table`") as $column)
            {
                if($column['Extra'] != 'auto_increment')
                {
                    $parameter  = ($column['Null'] == 'NO' ? 'required' : 'optional').'|'.$column['Type'];
                    $parameters[$column['Field']]  = $parameter;
                }
                
                $response[$column['Field']] = $column['Type'].'|'.($column['Default'] == null &&  $column['Null'] != 'NO' ?  'null' : $column['Default']);
            }
            $codes['parameters']  = "{";
            foreach ($parameters as $key => $value) {
                $codes['parameters'] .= "\n\t\t\"".$key."\": ".$value;
            }
            $codes['parameters'] .= "\n\t}";
            $codes['response_array']  = "[";
            $codes['response_array']  .= "\n\t\t{";
            foreach ($response as $key => $value) {
                $codes['response_array'] .= "\n\t\t\t\"".$key."\": ".$value;
            }
            $codes['response_array'] .= "\n\t\t},";
            $codes['response_array'] .= "\n\t\t...";
            $codes['response_array'] .= "\n\t]";
            $codes['response']  = "{";
            foreach ($response as $key => $value) {
                $codes['response'] .= "\n\t\t\"".$key."\": ".$value;
            }
            $codes['response'] .= "\n\t}";

            $code = file_get_contents(resource_path('views/core/graph/module.tpl'));
            $guide .= \SiteHelpers::blend($code,$codes); 
        }
        $guide = \SiteHelpers::blend($guide,['app_name'=>env('APP_NAME','API Toolz')]); 
        return view('core.graph.guide', ['guide'=>$guide]);
    }
}
