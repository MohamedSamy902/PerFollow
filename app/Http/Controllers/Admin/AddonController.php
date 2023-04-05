<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use App\Models\Addon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    
    public function update()
    {
        return view('admin.update');
    }

    public function updateSystem(Request $request)
    {
        $request->validate([
            'update'=> 'required|mimes:zip'
        ]);
        
          
        if(class_exists('ZipArchive')) {
            if ($request->hasFile('addon')) {
                $path = Storage::disk('local')->put('addons', $request->addon);
              
                $zip = new ZipArchive;
                $result = $zip->open(storage_path('app/' . $path));
                $random_dir = strtolower(Str::random(10));
    
                if ($result === true) {
                   $result = $zip->extractTo(base_path('temp/' . $random_dir . '/addons'));
                   $zip->close();
                } else {
                    return back()->with('error','Can\'t open the zip file.');
                }
    
                $str = file_get_contents(base_path('temp/' . $random_dir . '/addons/update.json'));
                $config = json_decode($str, true);

                if($config['min_version'] != sysVersion()){
                     Storage::delete($path);
                    \File::deleteDirectory(base_path('temp'));
                    return back()->with('error','Minimum required system version is '.$config['min_version'].'. Your system version is '.sysVersion());
                }

                if(!empty($config['directory'])) {
                    foreach ($config['directory'][0]['path'] as $directory) {
                        if (is_dir(base_path($directory)) == false) {
                            mkdir(base_path($directory), 0777, true);
                        } else {
                           echo "error on creating directory";
                          
                        }
                      
                    }

                }

                if(!empty($config['assets'])) {
                    foreach ($config['assets'] as $file) {
                        copy(base_path('temp/' . $random_dir . '/' . $file['root_path']), str_replace('project','assets',base_path($file['update_path'])));
                    }
    
                }

                if(!empty($config['files'])) {
                    foreach ($config['files'] as $file) {
                        copy(base_path('temp/' . $random_dir . '/' . $file['root_path']), base_path($file['update_path']));
                    }
    
                }

            
                try {
                    $sql_path = base_path('temp/' . $random_dir . '/addons/sql/update.sql');
                    if (file_exists($sql_path)) {
                        DB::unprepared(file_get_contents($sql_path));
                    }
                } catch (\Exception $e) {
                    
                }
                
                Artisan::call('optimize:clear');
                Storage::delete($path);
                \File::deleteDirectory(base_path('temp'));

                return back()->with('success','System updated successfully.');

            }
        }
    }

}

