<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Image;
use App\Models\Lecture;
use App\Models\Major;
use App\Models\OldTechnofest\TbAuth;
use App\Models\OldTechnofest\TbAuthor;
use App\Models\OldTechnofest\TbKarya;
use App\Models\OldTechnofest\TbKategori;
use App\Models\Project;
use App\Models\Role;
use App\Models\Semester;
use App\Models\User;
use DB;
use Illuminate\Console\Command;
use Log;

class Migrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:start {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data technofest CI to Laravel';

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
        $type = $this->option('type');
        
        switch ($type) {
            case 'auth':
                $this->migrateAuth();
                break;
            
            case 'generate-auth':
                $this->generateAuthUnregisteredUser();
                break;

            case 'project-author':
                $this->migrateProjectAuthor();
                break;
        }
        
        return 0;
    }

    public function migrateAuth()
    {
        /* 
            user bermasalah :
            Alfian Noor Sofyan
            Achmad Rifai
            Rosihan Andin Pambudi	
            Dian irma kusukawati
            Frengki Fajar Andila
            Miftahul Rohmah

            =====g punya auth tpi punya karya ??? =====
            Justine Ryan Fabay
            Ben Nicolas
        */
        $oldAuths = TbAuth::whereNotIn('ROLE', [0, 2])->get();

        // User::truncate();
        DB::beginTransaction();
        try {
            foreach ($oldAuths as $key => $auth) {
                if (!in_array($auth->NAMA, ['MARIA APFIAN JESLIN NAIOBE', 'Frengki Fajar Andila', 'Miftahul Rohmah'])) {

                    $collegeOrigin = $auth->ASAL_KAMPUS;
                    if (stripos($auth->ASAL_KAMPUS, "stiki") !== false || stripos($auth->ASAL_KAMPUS, "Sekolah Tinggi Ilmu Komputer Indonesia") !== false) {
                        $collegeOrigin = 'STIKI Malang';
                    }
                    $checkNrp = User::whereNrp($auth->NRP)->count();
                    if ($checkNrp <= 0) {
                        $user = new User;
                        $user->role_id = Role::ROLES['participant'];
                        $user->name = $auth->NAMA;
                        $user->email = $auth->EMAIL;
                        $user->password = $auth->PASSWORD;
                        $user->nrp = $auth->NRP;
                        $user->college_origin =  $collegeOrigin;
                        $user->telephone = $auth->HP;
                        $user->email_verified_at = date('Y-m-d H:i:s');
                        $user->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function generateAuthUnregisteredUser()
    {
        $secondDb = env('DB_DATABASE_SECOND');
        $rows = DB::select("
            select a.ID_AUTHOR, a.NRP, a.NAMA
            from $secondDb.TB_AUTHOR a
            left join $secondDb.TB_AUTH b 
            on a.NRP = b.NRP
            WHERE b.NRP is null
            group by NRP, a.NAMA, a.ID_AUTHOR
        ");

        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row) {
                if (strlen($row->NRP) > 2) {
                    $checkNrp = User::whereNrp($row->NRP)->count();
                    
                    if ($checkNrp <= 0) {
                        $user = new User;
                        $user->role_id = Role::ROLES['participant'];
                        $user->name = $row->NAMA;
                        $user->email = $row->NRP.'@mhs.stiki.ac.id';
                        $user->password = bcrypt('password!@#');
                        $user->nrp = $row->NRP;
                        $user->is_default_password = 1;
                        $user->college_origin = "STIKI Malang";
                        $user->telephone = "";
                        $user->email_verified_at = date('Y-m-d H:i:s');
                        $user->save();
                    }
                } else {
                    Log::info("$row->ID_AUTHOR|$row->NRP|$row->NAMA");
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function migrateProjectAuthor()
    {
        $tk = TbKarya::with([
            'TbProdi',
            'TbSemester',
            'TbAuthor',
            'TbFoto'
        ])
        ->whereHas('TbAuthor', function($q) {
            $q->whereRaw('LENGTH(NRP) > 2');
        })
        ->get();

        DB::beginTransaction();
        try {
            
            foreach ($tk as $key => $karya) {
                $ownerNrp = $karya->TbAuthor->first()->NRP;
                $user = User::whereNrp($ownerNrp)->first();
                $semester = $karya->TbSemester->ID_SEMESTER ?? dd($karya->toArray());
                $major = $karya->TbProdi->PRODI;
                
                $majorModel = Major::where('name', 'LIKE', "%$major%")->first();
                $lecModel = Lecture::name($karya->DOSPEM)->first();

                if (!empty($lecModel)) {
                    $lectureId = $lecModel->id;
                }
                
                if ($karya->DOSPEM == '-') {
                    $lectureId = 20;
                }

                if (empty($user)) {
                    dd('user tidak ketemu '.$user);
                }

                $majorModel = Major::where('name', 'LIKE', "%$major%")->first();
                if (empty($majorModel)) {
                    dd('major tidak ketemu '.$major);
                }
                
                // insert project
                $project = new Project;
                $project->user_id = $user->id;
                $project->category_id = $this->_getCategoryId($karya->ID_KATEGORI);
                $project->semester_id = $semester;
                $project->major_id = $majorModel->id;
                $project->lecture_id = $lectureId;
                $project->status = $karya->IS_VERIF;
                $project->title = $karya->JUDUL;
                $project->desc = $karya->DESKRIPSI;
                $project->github_link = $karya->LINK_GITHUB;
                $project->demo_link = $karya->LINK_DEMO;
                $project->video_link = $karya->LINK_VIDEO;
                $project->approved_at = date('Y-m-d H:i:s');
                $project->is_migrated = 1;
                $project->save();

                //find by nrp all members
                $user = User::whereIn('nrp', $karya->TbAuthor->pluck('NRP')->toArray())
                    ->pluck('id')
                    ->toArray();

                $project->projectUsers()->sync($user);

                // find images of project
                foreach ($karya->TbFoto as $key => $img) {
                    $fimage = "project/$karya->FOLDER/foto/".$img->FOTO;
                    $img = new Image;
                    $img->project_id = $project->id;
                    $img->sid = \Str::random(32);
                    $img->ori_image = $fimage;
                    $img->small_image = $fimage;
                    $img->is_thumbnail = $key == 0 ? "1" : "0";
                    $img->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    private function _getCategoryId($catId)
    {
        $oldTk = TbKategori::where('ID_KATEGORI', $catId)->first();
        if (empty($oldTk)) {
            dd("tidak ditemukan ID $catId di DB Lama");
        }
        $kat = trim($oldTk->KATEGORI);

        $currKat = Category::where('name', 'like', "%$kat%")->first();
        if (empty($currKat->id)) {
            dd("tidak ditemukan kat $kat di DB Lama");
        }

        return $currKat->id;
        
        // $arr = [
        //     // mobile
        //     'PLK_5BX1I' => 4,
        //     'PLK_DQNX8' => 4,
        //     'PLK_E0KME' => 4,
        //     // website
        //     'PLK_4H0YU' => 3,
        //     'PLK_4JMPX' => 3,
        //     'PLK_B5YAC' => 3,
        //     // desktop
        //     'PLK_1IQM1' => 2,
        //     'PLK_LO9C2' => 2,
        //     'PLK_VR1T1' => 2,
        //     // game
        //     'GM_MQTBV' => 5,
        //     'PLK_KSDMA' => 5,
        //     // UI-UX
        //     'DSN_B4PFQ' => 1,
        //     'DSN_TSPI6' => 1,
        //     // poster
        //     'PST_NTC5K' => 7,
        //     // artikel ilmiah
        //     'SCN_YRDPD' => 8,
        //     // bisnis
        //     'BSN_0BS90' => 9,
        //     // desain UI
        //     'SRN_GAETH' => 10,
        //     // project management
        //     'PRJ_S254V' => 6
        // ];

        // return $arr[$catId];
    }

    /* private function _getSemesterId()
    {
        $arr = [
            'Ganjil 2020/2021', => 1
            'Genap 2020/2021',
            'Ganjil 2021/2022'

        ];
        return ;
    } */
}
