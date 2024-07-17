<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Exports\QuizionerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\QuizionerRequest;
use App\Models\FormCustom;
use App\Models\FormOption;
use App\Models\FormResponse;
use App\Models\Semester;
use App\Traits\AjaxTrait;
use Carbon\Carbon;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Http\Request;
use Log;

class QuizionerController extends Controller
{
    use AjaxTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backsite.quizioner.intro');
    }

    public function listQuizioner($semId)
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        $FormCustom = FormCustom::whereSemesterId($semId)->get();
        $data['fc'] = $FormCustom;
        $data['semester'] = Semester::find($semId);
        $data['semesters'] = Semester::orderBy('id', 'desc')->where('id', '!=', $semId)->get();

        return view('backsite.quizioner.index', $data);
    }

    public function datatable(Request $request)
    {
        $data = FormCustom::where('semester_id', $request->semester_id)->orderBy('seq', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($semId)
    {
        $data['fc'] = FormCustom::whereSemesterId($semId)->get();
        $data['semId'] = $semId; 

        return view('backsite.quizioner.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizionerRequest $request, $semId)
    {
        DB::beginTransaction();
        try {
            $fc = new FormCustom;
            $fc->semester_id = $semId;
            $fc->label = $request->label;
            $fc->type = $request->type;
            $fc->name = str_replace(' ', '_', $request->name);
            $fc->placeholder = $request->placeholder;
            $fc->caption = $request->caption;
            $fc->seq = $request->seq;
            $fc->validator = !empty($request->is_required) ? '["required"]' : null;
            $fc->status = $request->status;
            $fc->save();

            if (in_array($request->type, ['combobox', 'checkbox', 'radio'])) {
                $arr = [];
                $values = $request->option_value;
                foreach ($request->option_label as $key => $label) {
                    $arr[] = [
                        'form_custom_id' => $fc->id,
                        'option_label'=> $label,
                        'option_value'=> $values[$key],
                        'created_at'=> Carbon::now(),
                    ];
                }
                FormOption::insert($arr);
            }

            if ($request->type == "linear_scale") {
                $arr = [];
                foreach (range($request->linear_start, $request->linear_end) as $n) {
                    $arr[] = [
                        'form_custom_id' => $fc->id,
                        'option_label'=> $request->label_start,
                        'option_label_2'=> $request->label_end,
                        'option_value'=> $n,
                        'created_at'=> Carbon::now(),
                    ];
                }
                FormOption::insert($arr);
            }
            DB::commit();
        }  catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.quizioner.list-quizioner', $semId)->with('error_msg', 'Failed add item !');
        }

        return redirect()->route('backsite.quizioner.list-quizioner', $semId)->withSuccess('Success add item !');
    }

    public function copas(Request $request)
    {
        DB::beginTransaction();
        try {
            $fc = FormCustom::where('semester_id', $request->source_semester_id)->get();

            foreach ($fc as $key => $fcv) {

                $fc = new FormCustom;
                $fc->semester_id = $request->semester_id;
                $fc->label = $fcv->label;
                $fc->type = $fcv->type;
                $fc->name = $fcv->name;
                $fc->placeholder = $fcv->placeholder;
                $fc->seq = $fcv->seq;
                $fc->status = $fcv->status;
                $fc->caption = $fcv->caption;
                $fc->validator = $fcv->validator;
                $fc->save();

                $fopt = FormOption::where('form_custom_id', $fcv->id)->get();

                if ($fopt->count() >= 1) {
                    foreach ($fopt as $key => $foptv) {
                        FormOption::insert([
                            'form_custom_id' => $fc->id,
                            'option_label' => $foptv->option_label,
                            'option_label_2' => $foptv->option_label_2,
                            'option_value' => $foptv->option_value,
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
            DB::commit();
            
            $this->success = true;
            $this->data = 'Copy-Paste Successfully !';
            $this->code = \Illuminate\Http\Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            $this->success = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($semId, $id)
    {
        $this->authorize('validate-project', $id);
        $fc = FormCustom::with(['formOptions'])->whereId($id)->firstOrFail();

        $data['item'] = $fc;
        $data['semId'] = $semId;

        return view('backsite.quizioner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizionerRequest $request, $semId, $id)
    {
        DB::beginTransaction();
        try {
            $fc = FormCustom::findOrFail($id);
            $fc->label = $request->label;
            $fc->type = $request->type;
            $fc->name = str_replace(' ', '_', $request->name);
            $fc->placeholder = $request->placeholder;
            $fc->seq = $request->seq;
            $fc->status = $request->status;
            $fc->caption = $request->caption;
            $fc->validator = !empty($request->is_required) ? '["required"]' : null;
            $fc->save();

            if (in_array($request->type, ['combobox', 'checkbox', 'radio'])) {
                $values = $request->option_value;
                $optIds = $request->ids_option_label;

                foreach ($request->option_label as $key => $label) {
                    FormOption::updateOrCreate([
                        'id' => $optIds[$key],
                        'form_custom_id' => $fc->id,
                    ], [
                        'option_label' => $label,
                        'option_value' => $values[$key],
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            if ($request->type == "linear_scale") {
                $reqLinStart = $request->linear_start;
                $reqLinEnd = $request->linear_end;
                $foMut = FormOption::where('form_custom_id', $fc->id);
                $fo = clone $foMut;

                $linStart = $foMut->orderBy('option_value', 'asc')->first();
                $linEnd = $foMut->orderby('option_value', 'desc')->first();

                // update label
                $fo->update([
                    'option_label' => $request->label_start,
                    'option_label_2' => $request->label_end
                ]);

                $arrScale = [];
                if ($reqLinStart != $linStart->option_value || $reqLinEnd  != $linEnd->option_value) {
                    foreach (range($request->linear_start, $request->linear_end) as $l) 
                        $arrScale[] = $l;
                    // FormResponse::where('form_custom_id', $fc->id)->delete();
                }

                if (!empty($arrScale)) { 
                    $fo->whereNotIn('option_value', $arrScale)->delete();
                    if ($reqLinStart < 1) {
                        FormOption::updateOrCreate([
                            'form_custom_id' => $fc->id,
                            'option_value' => 0
                            ], [
                                'form_custom_id' => $fc->id,
                                'option_label' => $request->label_start,
                                'option_label_2' => $request->label_end,
                                'option_value' => 0,
                                'created_at' => Carbon::now(),
                            ]
                        );
                    }

                    if ($reqLinEnd > $linEnd->option_value) {
                        $arr = [];
                        $minRange = $linEnd->option_value + 1;

                        foreach (range($minRange, $reqLinEnd) as $n) {
                            $arr[] = [
                                'form_custom_id' => $fc->id,
                                'option_label' => $request->label_start,
                                'option_label_2' => $request->label_end,
                                'option_value' => $n,
                                'created_at' => Carbon::now(),
                            ];
                        }
                    }
                }
            }
            DB::commit();
        }  catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.quizioner.list-quizioner', $semId)->with('error_msg', 'Failed add item !');
        }

        return redirect()->route('backsite.quizioner.list-quizioner', $semId)->withSuccess('Success add item !');
    }

    public function getOptions(Request $request)
    {
        try {
            $this->success = true;
            $this->code = \Illuminate\Http\Response::HTTP_OK;
            $this->data = FormOption::where('form_custom_id', $request->form_custom_id)->get();
        } catch (\Exception $e) {
            $this->success = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        
        return $this->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semId, $id)
    {
        try {
            $fc = FormCustom::find($id);
            FormResponse::where('form_custom_id', $id)->delete();
            FormOption::where('form_custom_id', $id)->delete();
            $fc->delete();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.quizioner.list-quizioner', $semId)->with('error_msg', 'Failed add item !');
        }

        return redirect()->route('backsite.quizioner.list-quizioner', $semId)->withSuccess('Success add item !');
    }

    public function destroyOption(Request $request)
    {
        try {
            $this->success = true;
            $this->code = \Illuminate\Http\Response::HTTP_OK;
            FormResponse::whereJsonContains('id', ['id' => $request->id])->delete();
            FormOption::findOrFail($request->id)->delete();

        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            $this->success = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->json();
    }

    public function checkHasResponse(Request $request)
    {
        if ($request->check_type == 'option')
            $fr = FormResponse::whereJsonContains('value', ['id' => $request->id])->count();
        else
            $fr = FormResponse::where('form_custom_id', $request->id)->count();
        $this->success = true;
        $this->code = \Illuminate\Http\Response::HTTP_OK;
        $this->data = $fr > 0;

        return $this->json();
    }

    public function response($semesterId, $id)
    {
        $fc = FormCustom::find($id);
        $fr = (new FormResponse)->where('form_custom_id', $id);

        if ($fc->type == 'checkbox') {
            $fr = $fr->select('value')->pluck('value');

            $arrValues = [];
            foreach ($fr as $key => $f) {
                foreach (json_decode($f) as $k => $value) {
                    $fo = FormOption::optionValue($value)->first();
                    $arrValues[] = $fo->option_label;
                }
            }

            $fr = collect(array_count_values($arrValues));
        } else {
            $fr = $fr->select('value', DB::raw('count(*) as total'))
                ->groupBy('value')
                ->pluck('total', 'value');
        }

        $data['question'] = $fc;
        $data['stats'] = $fr;
        
        $view = '';
        if (in_array($fc->type, ['textarea', 'number', 'text'])) {
            $view = 'backsite.quizioner.response-text';
        } else {
            $data['options'] = FormOption::where('form_custom_id', $id)->get();
            $view = 'backsite.quizioner.response-stats';
        }

        return view($view, $data);
    }

    public function datatableResponse(Request $request)
    {
        $data = FormResponse::where([
            'form_custom_id' => $request->quizioner_id
        ])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('value', function($data) {
                $ret = $data->value;
                if (stripos($ret, "[") !== false)
                    $ret = implode(",", json_decode($data->value));

                return $ret;
            })
            ->rawColumns(['action', 'value'])
            ->make(true);
    }

    private function _isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function exportExcel($semesterId)
    {
        $semester = Semester::find($semesterId);
        $semesterFix = str_replace([' ', '/'], '_', $semester->semester);

        $fname =  time().'_DATA_KUESIONER_SEMESTER_'.$semesterFix.'.xlsx';
        return Excel::download(new QuizionerExport($semester), $fname);
    }
}
