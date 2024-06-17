<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class studentController extends Controller
{
  public function index() 
  {
    
    $students = Student::all();

    if ($students -> isEmpty()) {
        $data=[
            'message'=>'no se encontraron estudiantes',
            'status' => 200
        ];
        return response()->json($students, 404);

    }

    return response()->json($students, 200);

  }

  public function store(Request $request)
  {
        $validator = validator::make($request -> all(),[
        'name' => 'required',
        'email' => 'required|email|unique:student',
        'phone' => 'required',
        'language' => 'required'
        ]);

        if ($validator->fails()) {
        $data=[
            'message'=>'error en los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data,400);
        }
        $student =Student::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'phone'=> $request->phone,
        'language'=> $request->language,
        ]);

        if (!$student){
        $data=[
            'message'=>'no se creo el estudiante',
            'status' => 500
        ];
        return response()->json($data,500);
        }
        $data=[
        'student'=>$student,
        'status' => 201
        ];
        return response()->json($data,201);

        
    }

    public function show( $id)
    {
      $student= Student::find($id);
      
      if (!$student) {
        $data=[
            'message'=>'estudiante no encontrado',
            'status' => 404
        ];
        return response()->json($data,404);
      }

      $data=[
        'student'=>$student,
        'status' => 200
        ];
        return response()->json($data,200);
      
    }

public function destroy( $id)
{
    $student= Student::find($id);
    
    if (!$student) {
      $data=[
          'message'=>'estudiante no encontrado',
          'status' => 404
      ];
      return response()->json($data,404);
    }

    $student->delete();
    $data=[
        'message'=>'estudiante eliminado',
        'status' => 200
    ];

  return response()->json($data,200);
    
}

public function update (Request $request, $id)
{
    $student= Student::find($id);
    
    if (!$student) {
      $data=[
          'message'=>'estudiante no encontrado',
          'status' => 404
      ];
      return response()->json($data,404);
    }

    $validator = validator::make($request -> all(),[
        'name' => 'required',
        'email' => 'required|email|unique:student',
        'phone' => 'required',
        'language' => 'required'
    ]);

    if ($validator->fails()) {
        $data=[
            'message'=>'error en los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data,400);
    }

    $student->name = $request->name;
    $student->email = $request->email;
    $student->phone = $request->phone;
    $student->language = $request->language;

    $student->save();

    $data=[
        'message'=>'estudiante actualizado',
        'student'=>$student,
        'status' => 200
    ];

  return response()->json($data,200);
}

public function updatePartial(Request $request, $id) {
    
    $student= Student::find($id);
    
    if (!$student) {
      $data=[
          'message'=>'estudiante no encontrado',
          'status' => 404
      ];
      return response()->json($data,404);
    }

    $validator = validator::make($request -> all(),[
        'name' => '',
        'email' => 'email|unique:student',
        'phone' => '',
        'language' => ''
    ]);

    if ($validator->fails()) {
        $data=[
            'message'=>'error en los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data,400);
    }

    if ($request->has('name')) {
        $student->name =$request->name;
    }
    if ($request->has('email')) {
        $student->email =$request->email;
    }
    if ($request->has('phone')) {
        $student->phone =$request->phone;
    }
    if ($request->has('language')) {
        $student->language =$request->language;
    }

    $student->save();

    $data=[
        'message'=>'estudiante actualizado',
        'student'=>$student,
        'status' => 200
    ];

  return response()->json($data,200);
}

}
