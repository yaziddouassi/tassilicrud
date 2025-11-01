<?php

namespace Tassili\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TassiliCreator extends Command
{
    protected $signature = 'tassili:install';
    protected $description = 'Install the package';

    public function handle()
    {
        $path = resource_path('js/Vendor');
        $sourcePath = base_path('vendor/tassili/crud/Fichiers/PhpFiles');
        $destinationPath = base_path('app/Http/Controllers/Tassili/Admin');

        if (File::exists($destinationPath)) {
            $this->error("Package already installed");
            return Command::FAILURE;
        }

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        File::copyDirectory($sourcePath, $destinationPath);

        // ----- SECTION 1 -----
        $sourcePath3 = base_path('vendor/tassili/crud/Fichiers/TassiliPages1');
        $directory3 = base_path('resources/js/Pages/TassiliPages/Admin');

        File::copyDirectory($sourcePath3, $directory3);

        if (!File::exists($directory3)) {
            $this->error("Dossier non trouvé : $directory3");
            return Command::FAILURE;
        }

        foreach (File::allFiles($directory3) as $file3) {
            if ($file3->getExtension() === 'txt') {
                File::move(
                    $file3->getPathname(),
                    $file3->getPath() . '/' . str_replace('.txt', '.vue', $file3->getFilename())
                );
            }
        }

        // ----- ROUTES -----
        $sourcePath1 = base_path('vendor/tassili/crud/Fichiers/RouteFiles/tassili.php');
        $destinationPath1 = base_path('routes/tassili.php');

        if (File::exists($sourcePath1)) {
            File::copy($sourcePath1, $destinationPath1);
        }

        $filePath = base_path('routes/web.php');
        $content = file_get_contents($filePath);

        if (!str_contains($content, "require __DIR__.'/tassili.php';")) {
            file_put_contents($filePath, "\nrequire __DIR__.'/tassili.php';\n", FILE_APPEND);
        }

        // ----- SECTION 2 -----
        $sourcePath4 = base_path('vendor/tassili/crud/Fichiers/TassiliLibs1');
        $directory4 = base_path('resources/js/Vendor/TassiliLibs');

        File::copyDirectory($sourcePath4, $directory4);

        if (!File::exists($directory4)) {
            $this->error("Dossier non trouvé : $directory4");
            return Command::FAILURE;
        }

        foreach (File::allFiles($directory4) as $file4) {
            if ($file4->getExtension() === 'txt') {
                File::move(
                    $file4->getPathname(),
                    $file4->getPath() . '/' . str_replace('.txt', '.vue', $file4->getFilename())
                );
            }
        }

        // ----- SECTION 3 -----
        $sourcePath5 = base_path('vendor/tassili/crud/Fichiers/TassiliDev1');
        $directory5 = base_path('resources/js/Pages/TassiliDev');

        File::copyDirectory($sourcePath5, $directory5);

        if (!File::exists($directory5)) {
            $this->error("Dossier non trouvé : $directory5");
            return Command::FAILURE;
        }

        foreach (File::allFiles($directory5) as $file5) {
            if ($file5->getExtension() === 'txt') {
                File::move(
                    $file5->getPathname(),
                    $file5->getPath() . '/' . str_replace('.txt', '.vue', $file5->getFilename())
                );
            }
        }

        // ----- MIDDLEWARE -----
        $sourcePath6 = base_path('vendor/tassili/crud/Fichiers/MiddlewareFiles/TassiliAuth.php');
        $destinationPath6 = base_path('app/Http/Middleware/TassiliAuth.php');

        File::copy($sourcePath6, $destinationPath6);

        $this->info("✅ Package Tassili Free installed!");

        return Command::SUCCESS;
    }
}
