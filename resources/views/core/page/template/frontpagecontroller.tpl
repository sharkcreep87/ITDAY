<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Pages;

class FrontPageController extends Controller {

  function getPageInfo($alias)
  {
    $page = Pages::where("alias",$alias)->first();
    if($page){
      $this->data['meta_title'] = $page->meta_title;
      $this->data['meta_keywords']= $page->meta_keywords;             
      $this->data['meta_description']= $page->meta_description;
    }else{
      return redirect('/');
    }
    return $this->data;
  }

  {methods}

}