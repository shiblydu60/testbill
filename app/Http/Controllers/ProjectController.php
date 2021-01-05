<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function addproject() {
        return view('Projects.addproject');
    }

    public function storeproject(Request $request) {
                /*
        echo '<pre>';
        var_dump($request->all());
        echo '</pre>';
        */
        $validated = $request->validate([
            'projectName' => 'required',
            'description' => 'required',
        ]);
        $obj=new Project();
        $obj->name=$request->input('projectName');
        $obj->description=$request->input('description');        
        $obj->save();
        $request->session()->flash('message', 'Project saved successfully.');
        return view("Projects.storeproject");
    }
}
