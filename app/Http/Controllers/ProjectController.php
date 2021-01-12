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
        return redirect()->intended('/listproject');
    }

    public function listproject() {
        $projects=Project::paginate(15);
        //dd($projects);
        return view('Projects.listproject', ['projects' => $projects]);
    }

    public function edit($id) {
        $project=Project::findOrFail($id);
        //dd($project);
        return view('Projects.edit', ['project'=>$project]);
    }

    public function update(Request $request, $id) {
        $project=Project::findOrFail($id);
        //dd($request->all());
        $project->name=$request->input('projectName');
        $project->description=$request->input('description');
        $project->save();
        return view('Projects.update');
    }

    public function delete($id) {
        $project=Project::findOrFail($id);
        $project->delete();
        return view('Projects.delete');
    }
}
