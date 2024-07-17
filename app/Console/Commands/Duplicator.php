<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Duplicator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $projectsId = Project::where('lang', 'id')->get();
            $tr = new GoogleTranslate();
            foreach ($projectsId as $key => $pid) {
                $ping = Project::where([
                    'title' => $pid->title,
                    'lang' => 'en'
                ])->first();
                $pu = ProjectUser::where('project_id', $pid->id)->get();
                $arrPu = $pu->toArray();

                $imgs = Image::where('project_id', $pid->id)->get();
                $arrImgs = $imgs->toArray();
                
    
                if (!empty($ping)) {
                    // dd($ping, $pid);
                } else {
                    $trDesc = $tr->setSource('id')->setTarget('en')->translate($pid->desc);
                    $trTitle = $tr->setSource('id')->setTarget('en')->translate($pid->title);
                    $arr = $pid->toArray();
                    unset($arr['id'], $arr['title'], $arr['desc']);
                    $arr['title'] = $trTitle;
                    $arr['desc'] = $trDesc;
                    $arr['lang'] = 'en';
                    $arr['created_at'] = Carbon::createFromFormat('d/M/Y H:i:s', $arr['created_at'])->toDatetimeString();
                    // $arr['updated_at'] = Carbon::createFromFormat('d/M/Y H:i:s z', $arr['updated_at'])->toDatetimeString();
                    
                    $pingId = Project::insertGetId($arr);

                    $newArrPu = [];
                    foreach ($arrPu as $key => $pu) {
                        unset($pu['id'], $pu['project_id']);
                        $pu['project_id'] = $pingId;
                        $newArrPu[] = $pu;
                    }
                    ProjectUser::insert($newArrPu);

                    $newArrImgs = [];
                    foreach ($arrImgs as $key => $img) {
                        unset($img['id'], $img['project_id']);
                        $img['project_id'] = $pingId;
                        
                        $cdate = Carbon::parse($img['created_at']);
                        $udate = Carbon::parse($img['updated_at']);

                        $img['created_at'] = $cdate->format('Y-m-d H:i:s');
                        $img['updated_at'] = $udate->format('Y-m-d H:i:s');

                        $newArrImgs[] = $img;
                    }

                    Image::insert($newArrImgs);
                    echo $pid->id."-OK\n";
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
        
    }
}
