<?php

namespace Tassili\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Tassili\Crud\Utils\TransformString;
use Tassili\Crud\Utils\WizardPart;

class WizardCommand extends Command
{
    protected $signature = 'make:wizard';

    protected $description = 'Permet de choisir un modèle depuis la config tassili.php';

    public function handle()
    {
         // Récupérer le tableau des modèles depuis la config
        $modelList = config('tassili.modelList', []);

        // Vérifier s’il y a des modèles
        if (empty($modelList)) {
            $this->error("No model in config('tassili.modelList').");
            return 1;
        }

        // Demander à l’utilisateur de choisir
        $choix = $this->choice('Choose a model ?', $modelList, 0);

        $this->info("You Choose this model : $choix");

       
        $transform = new TransformString();
        $crudPart = new WizardPart();

        $modelLink = $transform->transformLink($choix);
        $modelUrl = $transform->transformUrl($choix);

        $piece1 = $crudPart->getPiece1($choix, $modelLink, $modelUrl);
        $piece2 = $crudPart->getPiece2($choix, $modelLink, $modelUrl);
        $piece3 = $crudPart->getPiece3($choix, $modelLink, $modelUrl);
        $piece4 = $crudPart->getPiece4($choix, $modelLink, $modelUrl);

        $dossier = base_path("app/Http/Controllers/Tassili/Admin/Crud/{$choix}");
        $custom = "{$dossier}/Customs";

        if (File::exists($dossier)) {
            $this->error('❌ CRUD already exists.');
            return;
        }

        File::makeDirectory($dossier, 0755, true);
        File::makeDirectory($custom, 0755, true);

        File::put("{$dossier}/CreatorController.php", $piece1);
        File::put("{$dossier}/UpdatorController.php", $piece2);
        File::put("{$dossier}/ListingController.php", $piece3);
        File::put("{$custom}/Custom1Controller.php", $piece4);

        $crud = new \Tassili\Crud\Models\TassiliCrud() ;
        $crud->model = $choix;
        $crud->label = $modelLink;
        $crud->route = '/admin/' . $modelUrl;
        $crud->icon = 'description';
        $crud->active = true;
        $crud->save();


        $vueTarget = base_path("resources/js/Pages/TassiliPages/Admin/Crud/{$choix}");
        File::copyDirectory(base_path('vendor/tassili/crud/Fichiers/WizardFiles'), $vueTarget);

        foreach (File::allFiles($vueTarget) as $file) {
            if ($file->getExtension() === 'txt') {
                File::move($file->getPathname(), $file->getPath() . '/' . str_replace('.txt', '.vue', $file->getFilename()));
            }
        }


        $this->info("✅ Wizard {$choix} created with success !");
       

       
    }
}