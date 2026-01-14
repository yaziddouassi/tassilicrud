<?php

namespace Tassili\Crud\Utils;
use Illuminate\Support\Str;

class CrudPart
{
   public $piece1;
   public $piece2;
   public $piece3;
   public $piece4;

public function getPiece1($a,$b,$c) {


    $this->piece1 = "<?php

namespace App\Http\Controllers\Tassili\Admin\Crud\\$a;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Crud\Http\Resources\TassiliForm;
use Tassili\Crud\Fields\TextInput;
use App\Http\Controllers\Controller;


class CreatorController extends Controller
{
   
    private TassiliForm \$tassili;
    private array \$pageSettings = [] ;
    private string \$modelClass = 'App\Models\\$a';

     public function __construct()
    {
        \$this->tassili = new TassiliForm();
        \$this->pageSettings = [
        'modelClass' => \$this->modelClass,
        'modelClassName' => '$a',
        'modelLabel' => '$b',
        'modelTitle' => 'Create $b',
        'routeListe' => '/admin/$c',
        'urlCreate' => '/admin/$c/create',
        'validationUrl' => '/admin/$c/create/validation'] ;
         \$this->initTassili();
    }


     public function initTassili()
    {
        \$this->tassili->addForm([
            'url' => \$this->pageSettings['validationUrl'],
        ])->form([
            TextInput::make('name')
        ])->redirectToList(\$this->pageSettings['modelClassName']);
    }

    #[Post('admin/$c/create/validation', middleware: ['tassili.auth'])]
    public function create(Request \$request)
    {
        \$request->validate(['name' => ['required']]);

        \$this->tassili->record = new \$this->modelClass ;

        \$this->tassili->createRecord(\$request);
        \$this->tassili->record->save();  
    }

    #[Get('admin/$c/create', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        return Inertia::render('TassiliPages/Admin/Crud/$a/Creator',[
            'tassiliSettings' => \$this->tassili->getInertiaData(),
            'pageSettings' => \$this->pageSettings]);
    }
    

}
    ";

    return $this->piece1;
   }



   public function getPiece2($a,$b,$c) {
          $this->piece2 = "<?php

namespace App\Http\Controllers\Tassili\Admin\Crud\\$a;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Crud\Http\Resources\TassiliForm;
use Tassili\Crud\Fields\TextInput;
use App\Http\Controllers\Controller;

class UpdatorController extends Controller
{
    private TassiliForm \$tassili;
    private array \$pageSettings = [] ;
    private string \$modelClass = 'App\Models\\$a';

     public function __construct()
    {
        \$this->tassili = new TassiliForm();
        \$this->pageSettings = [
        'modelClass' => \$this->modelClass,   
        'modelClassName' => '$a',
        'modelLabel' => '$b',
        'modelTitle' => 'Update $b',
        'routeListe' => '/admin/$c',
        'urlCreate' => '/admin/$c/create',
        'validationUrl' => '/admin/$c/updator/validation'] ;
        \$this->initTassili();
    }

     
    public function initTassili()
    {
        \$this->tassili->addForm([
            'url' => \$this->pageSettings['validationUrl'],
        ])->form([
            TextInput::make('name'),
        ])->redirectToList(\$this->pageSettings['modelClassName']);
    }

    #[Post('admin/$c/updator/validation', middleware: ['tassili.auth'])]
    public function update(Request \$request)
    {
        \$request->validate(['name' => ['required']]);

        \$this->tassili->record = \$this->modelClass::find(\$request->id);

        if (\$this->tassili->record !== null) {
                 \$this->tassili->updateRecord(\$request);
                 \$this->tassili->record->save();
            }

    }

    #[Get('admin/$c/update/{id}', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$record = \$this->modelClass::findOrFail(\$request->id);
        
        return Inertia::render('TassiliPages/Admin/Crud/$a/Updator', [
            'tassiliSettings' => \$this->tassili->getInertiaData(),
            'pageSettings' => \$this->pageSettings ,
            'record' => \$record]);
    }
    
}

          ";

          return $this->piece2;
   }


   
   public function getPiece3($a,$b,$c) {

      $this->piece3 = "<?php

namespace App\Http\Controllers\Tassili\Admin\Crud\\$a;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Crud\Http\Resources\ListingUtility;
use Tassili\Crud\Fields\TextInput;
use Tassili\Crud\Fields\Repeater;
use Tassili\Crud\Filters\FilterText;

class ListingController extends Controller
{
    
    private string \$modelClass = 'App\Models\\$a';
    private ListingUtility \$utility;

    public function __construct(Request \$request)
    {
        \$this->utility = new ListingUtility([
            'tassiliDataModelLabel' => '$b',
            'tassiliDataModelTitle' => 'Create $b',
            'tassiliDataRouteListe' => '/admin/$c',
            'tassiliDataUrlCreate' => '/admin/$c/create',
            'tassiliModelClass' => \$this->modelClass,
            'tassiliModelClassName' => '$a',
            'paginationPerPageList' => [10, 20, 30, 40, 50],
            'orderByFieldList' => ['id'],
            'orderDirectionList' => ['asc', 'desc'],
            'urlDelete' => '/admin/$c/delete',
        ]);

        \$this->initFilter();
        \$this->initBulk();
        \$this->initModalForm();
    }


     private function initFilter()
    {
        \$this->utility->filterList([
            FilterText::make('name'),
        ]);
    }

     private function initBulk(): void
    {
        \$this->utility->addBulk([
                    'label' => 'Ajouter',
                    'icon' => 'description',
                    'class' => 'text-white',
                    'url' =>'/admin/$c/bulk1' ,
                    'confirmation' => 'Are you sure to change records',
                    'message' => 'Records changed',
        ]);
    }

     private function initModalForm(): void
    {
       \$this->utility->addModalForm([
            'url' => '/admin/$c/modal1',
            'icon' => 'edit',
            'text' => 'Qte',
            'class' => 'text-white',
            'confirm' => 'Are you sure to change record?',
        ])->form([
            TextInput::make('name')
        ]);
    }
    

    private function initQuery(\$query, Request \$request): void
    {
        if (\$request->filled('name')) {
           // \$query->where('name', \$request->name);
        }
    }

    #[Post('admin/$c/bulk1', middleware: ['tassili.auth'])]
    public function bulk1(Request \$request)
    {
        \$this->modelClass::whereIn('id', \$request->actionIds)->update([
            'name' => 'rob',
        ]);
    }

     #[Post('admin/$c/modal1', middleware: ['tassili.auth'])]
    public function modal1(Request \$request)
    {
       
        \$this->utility->record = \$this->modelClass::find(\$request->id);

        if (\$this->utility->record !== null) {
            \$this->utility->updateRecord(\$request);
            \$this->utility->record->save();
            }

    }


    #[Post('admin/$c/delete', middleware: ['tassili.auth'])]
    public function delete(Request \$request)
    {
        \$this->modelClass::destroy(\$request->id);
    }

  
    #[Get('admin/$c', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$this->utility->initializeQuery(
        \$this->modelClass,\$request,fn(\$query, \$req) => \$this->initQuery(\$query, \$req));
        \$data = \$this->utility->getInertiaData();
        \$data['sessionFilter'] = [/*'search','orderByField','orderDirection','paginationPerPage'*/];

        return Inertia::render('TassiliPages/Admin/Crud/$a/Listing',[
                 'tassiliSettings' => \$data]);
    }
    
}
";

      return $this->piece3;
      }



    public function getPiece4($a,$b,$c) {

         $this->piece4 = "<?php

namespace App\Http\Controllers\Tassili\Admin\Crud\\$a\Customs;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Crud\Http\Resources\TassiliForm;

class Custom1Controller extends Controller
{
    private TassiliForm \$tassili;
    
    public function __construct()
    {
       config(['inertia.ssr.enabled' => false]);
       \$this->tassili = new TassiliForm();
       \$this->initTassili();
    } 
    
    public function initTassili()
    {
     
    }

    #[Get('admin/$c/customs/page1',middleware : ['tassili.auth'])]
    public function index(Request \$request)
    {
        return Inertia::render('TassiliPages/Admin/Crud/$a/Customs/Custom1',[
                'tassiliSettings' =>  \$this->tassili->getInertiaData()]);
    }

}
         
         ";

    return $this->piece4;

    }




}