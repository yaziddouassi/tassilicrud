<?php
namespace App\Http\Controllers\Tassili\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;
use Spatie\RouteAttributes\Attributes\Get;

class DashboardController extends Controller
{

   public   $tassiliPanel = 'admin' ;
   public   $tassiliSettings = [] ;

   public function __construct()
    {
        config(['inertia.ssr.enabled' => false]); // desactivate ssr
        $this->tassiliSettings = [
           'user' => \Illuminate\Support\Facades\Auth::user(),
           'routes' =>  \Tassili\Crud\Models\TassiliCrud::where('active',true)->get(),
           'company' => config('tassili.company'),
        ];
    }

   #[Get('admin',middleware : ['tassili.auth'])]
    public function index(Request $request)
    {
        
        return Inertia::render('TassiliPages/Admin/Dashboard/Dashboard', [
            'tassiliSettings' =>  $this->tassiliSettings,
            'chart1' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Jan','Fev','Mars'] ],
            'chart2' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Avil','Mai','jUIN'] ],
            'chart3' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Juillet','Aout','septembre'] ],
            'widget1' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Sales of month',
                         'icon'  => 'trending_up'], 
            'widget2' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Number of Visiteurs',
                         'icon'  => 'trending_up'],              
            'widget3' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Bests Products',
                         'icon'  => 'trending_up'],
            'widget4' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Sales of month',
                         'icon'  => 'trending_up'], 
            'widget5' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Number of Visiteurs',
                         'icon'  => 'trending_up'],              
            'widget6' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Bests Products',
                         'icon'  => 'trending_up'],                

        ]);
    }
    
}