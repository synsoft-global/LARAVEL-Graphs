<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $url_param = $request->segment(1);
        $url_id = $request->segment(2);
        $restrict_val  = checkPermission(Auth::user()->role->slug, 'url_param');
        if(!empty($restrict_val) && count($restrict_val)>0){
            foreach($restrict_val as $k => $v){
                if($v && $url_param == $v) {
                  return redirect('dashboard');
                }
            }
        }

       /* if($url_param=='categories'){
             if($url_param == 'categories'){
               $modelName = "\App\Model\Category";
            }else{
                $modelName = "\App\Model\\".ucfirst(rtrim($request->module, 's'));
            }
        } 
        $status=false;
       
        if(($url_param=='categories' || $url_param=='products') && is_int(+$url_id)){
             $model = new $modelName();
            $status = $model->checkPermission($url_id);
        }*/

       
        return $next($request);
       
    }
}
