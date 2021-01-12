<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Session;

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
        $projects=Project::with(['bills'])->paginate(15);
        //$projects=Project::with(['bills'])->get()->first()->bills->sum('amount');
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
        $request->session()->flash('message', 'Project updated successfully.');
        return redirect()->intended('/listproject');
        //return view('Projects.update');
    }

    public function delete(Request $request, $id) {
        $project=Project::findOrFail($id);
        $project->delete();
        $request->session()->flash('message', 'Project deleted successfully.');
        //Session::flash('message', 'Project deleted successfully.');
        return redirect()->intended('/listproject');
        //return view('Projects.delete');
    }
}
