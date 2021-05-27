<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Veterinary_exam;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-exames');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam = '';
        if (!empty($_GET['exam'])) {
            $exam = addslashes($_GET['exam']);
        }
        $exams = Veterinary_exam::where('id_company', Auth::user()->id_company)
        ->where('name', 'LIKE', '%'.$exam.'%')
        ->where('inactive', 0)
        ->orderBy('name')
        ->paginate(10);

        return view('exam', [
            'exams' => $exams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'obs'
        ]);

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('exam.create')->withErrors($validator)->withInput();
        }

        $id_company = Auth::user()->id_company;

        $exam = new Veterinary_exam();
        $exam->name = $data['name'];
        $exam->obs = $data['obs'];
        $exam->id_company = $id_company;
        $exam->save();

        return redirect()->route('exam.index');
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
    public function edit($id)
    {
        $exam = Veterinary_exam::find($id);

        return view('exam_edit', [
            'exam' => $exam
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exam = Veterinary_exam::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $exam['id']) {

            $data = $request->only([
                'name',
                'obs'
            ]);

            $validator = Validator::make(
                $data,
                [
                    'name' => ['required', 'string', 'max:100'],
                ]
            );

            if ($validator->fails()) 
            {
                return redirect()->route('exam.create')->withErrors($validator)->withInput();
            }

            $exam->name = $data['name'];
            $exam->obs = $data['obs'];
            $exam->save();

            return redirect()->route('exam.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Veterinary_exam::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $client['id']) {
            Veterinary_exam::where('id', $id)->update(['inactive' => 1]);
            return redirect()->route('exam.index');
        }
        return redirect()->route('login');
    }
}
