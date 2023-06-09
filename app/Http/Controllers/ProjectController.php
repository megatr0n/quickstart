<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project; 
use App\Repositories\ProjectRepository;
class ProjectController extends Controller
{
    /**
     * The Project repository instance.
     *
     * @var ProjectRepository
     */
    protected $projects; 

    /**
     * Create a new controller instance.
     *
     * @param  ProjectRepository  $projects
     * @return void
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->middleware('auth');

        $this->projects = $projects;
    }

    /**
     * Display a list of all of the user's projects.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    { 
	 //$projects = $this->populateProjects();
        return view('projects.index', [
            'projects' => $this->projects->forUser($request->user()),
        ]);
    }

    /**
     * Create a new project.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->projects()->create([
            'name' => $request->name, 'detail' => $request->detail,
        ]);

        return redirect('/projects');
    }

    /**
     * Destroy the given project.
     *
     * @param  Request  $request
     * @param  Project  $project
     * @return Response
     */
    public function destroy(Request $request, Project $project)
    {	
		$this->authorize('destroy', $project);
		$project->delete();
		return redirect('/projects');
    }


	public function saveUser(Request $rq)
	{
	$selectedUser = new SelectedUser;
	$selectedUser->name = $rq->user_selected;
	$selectedUser->save();

	return redirect()->back()->with('success', 'Selected Username added successfuly');
	}
	

	
}


