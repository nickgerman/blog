<?php namespace App;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blog
 *
 * @author alireza
 */
class Blog extends \Eloquent {
    //put your code here
    protected  $table = 'blog';
    
    // return url of blog post 
    function getUrl(){
        return \Config::get('app.url') .'/blog/post/'. $this->slug . '/';
    }
    
    public static  function mostRecommended(){
        return  self::orderBy('socialPoint','desc')->where('public', 1)->take(1)->get()->first();
    }
    public function nextPost(){
        // get next post
        return self::where('id', '>', $this->id)->where('public', 1)->orderBy('id','asc')->take(1)->get()->first();
    }
    public  function previousPost(){
        // get previous  post 
        return self::where('id', '<', $this->id)->where('public', 1)->orderBy('id','desc')->take(1)->get()->first();
    }
    
    public static  function lastPosts($number = null) {       
        if ( $number != null ){
            return self::where('public', 1)->take($number)
                    ->orderBy('created_at','desc')->get();                        
        } else {
            return self::orderBy('created_at','desc')->where('public', 1)
                    ->get();            
        }
    }
	
	public static function seoUrl($string) {
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}
}
