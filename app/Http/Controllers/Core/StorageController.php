<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
	public function index()
	{
		return view('core.storage');
	}

	public function uploadFile(Request $request){
		$destinationPath =base_path($request->input('path'));
		$file = $request->file('file');
		$filename = $file->getClientOriginalName();
		$uploadSuccess = $file->move($destinationPath, $filename);
		if( $uploadSuccess ) {
		   return response()->json("The file has been uploaded.");
		}
		return response()->json("Something was wrong.", 400);
	}

	public function getFiles()
	{
		if(isset($_GET['operation'])) {
	        $except[] = base_path().'/.git';
	        $except[] = base_path().'/vendor';
	        $except[] = base_path().'/tests';
	        $except[] = base_path().'/storage/framework';
	        $except[] = base_path().'/.env';
	        $except[] = base_path().'/.env.example';
	        $except[] = base_path().'/apitoolz.ppk';
	        $except[] = base_path().'/dev.apitoolz.sql';
	        $except[] = base_path().'/APItoolz-0d951d055e9b.json';
			$fs = new \FileManager(base_path(), $except);
			try {
				$rslt = null;
				switch($_GET['operation']) {
					case 'get_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
						break;
					case "get_content":
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->data($node);
						break;
					case 'create_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->create($node, isset($_GET['text']) ? $_GET['text'] : '', (!isset($_GET['type']) || $_GET['type'] !== 'file'));
						break;
					case 'rename_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->rename($node, isset($_GET['text']) ? $_GET['text'] : '');
						break;
					case 'delete_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->remove($node);
						break;
					case 'move_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
						$rslt = $fs->move($node, $parn);
						break;
					case 'copy_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
						$rslt = $fs->copy($node, $parn);
						break;
					default:
						throw new Exception('Unsupported operation: ' . $_GET['operation']);
						break;
				}
				return response()->json($rslt);
			}
			catch (Exception $e) {
				return response()->json($e->getMessage(), 500);
			}
			return response()->json(null);
		}
	}


	public function getFileContent(Request $request){
		$data['path'] = $request->_file;
		$data['file'] = basename($request->_file);
		$data['content'] = @file_get_contents(base_path($request->_file));
		if($request->ajax()){
			return response()->json($data);
		}
		return view('core.fileeditor', $data);
	}

	public function postFileContent(Request $request) {
		if($request->_file && count($request->_file) > 0){
			foreach ($request->_file as $i => $file) {
				file_put_contents(base_path($file), $request->content[$i]);
			}
		}
		return response()->json(['message'=>'The file has been changed successfully.', 'status'=>'success']);
	}

	public function getPerms(Request $request)
	{
		$dir = base_path($request->_file);
		$perms = substr(sprintf('%o', fileperms($dir)), -3);
		return view('core.permissions',['path'=>$request->_file,'perms'=>$perms]);
	}

	public function postPerms(Request $request)
	{
		$perms = 0;
		$dir = base_path($request->_file);
		if(count($request->owner) > 0)
		{
			foreach ($request->owner as $owner) {
				$perms +=$owner;
			}
		}
		if(count($request->group) > 0)
		{
			foreach ($request->group as $group) {
				$perms +=$group;
			}
		}
		if(count($request->public) > 0)
		{
			foreach ($request->public as $public) {
				$perms +=$public;
			}
		}
		\SSH::run([
		    'sudo chmod -R '.sprintf("%'04d", $perms).' '. $dir,
		]);
		return redirect('core/storage')->with(['message'=>'The permission has been changed successfully','status'=>'success']);
	}

	public function getTerminal()
	{
		return view('core.terminal');
	}

	public function postCommand(Request $request)
    {
		$ssh = \SSH::define('command', [
		    'cd '. base_path(),
		    $request->command
		]);

		$ssh->task('command', function($line)
		{
		    echo $line.PHP_EOL;
		});
    }
}
