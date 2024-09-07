<?php

namespace App\Http\Controllers;

use App\Models\DcbApplicationList;
use App\Models\DcbApplicationPermission;
use App\Models\Campuse;
use App\Models\User;


use Illuminate\Http\Request;


class ApplicationGrantController extends Controller
{
    public function afterUserSelection(Request $request)
    {
        // Get the selected category from the form
        $selectedUser = $request->input('userId');
        // Process the selected user (e.g., save to database or redirect)
        // Example: return a message with the selected user
        return redirect()->back()->with('selectedUser', $selectedUser);
    }
    public function index()
    {
        $applicationList = DcbApplicationList::all();
        $campuses = Campuse::all();
        $users = User::where('userType','!=', 1)->where('userType','!=', 2)->get();
        return view('application_grant.index', [
            'applicationList'=>$applicationList,
            'campuses'=>$campuses,
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = $request->get('userId');
        $checkUserCount = User::where('id',$userId)->count();

        if($checkUserCount!=0)
        {
            $permissionDeleted = DcbApplicationPermission::where('userId',$userId);
            $permissionDeleted->forceDelete();

            $applicationList = DcbApplicationList::all();
            $campuses = Campuse::all();
            $dataSaved = 0 ;
            foreach($applicationList as $appList){
                foreach($campuses as $campus){
                    $appCampusId = "app_$appList->id"."_campus_$campus->id";
                    if($request[$appCampusId]==1){
                        echo "appCampusId:$appCampusId = 1<br>";
                        $grant = new DcbApplicationPermission([
                            'userId' => $userId,
                            'appId' => $appList->id,
                            'campusId' => $campus->id,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]);
                        if ($grant->save()) 
                            $dataSaved++;
                        echo "dataSaved:$dataSaved<br>";
                    }
                }
            }
    
            if ($dataSaved > 0) {
               return redirect()->route('application-grant.index')->with('success', 'Application [GRANTED] successfully!');
            } else {
                return redirect()->route('application-grant.index')->with('error', 'Failed to [GRANT] application!');
            }
        }
        else{
            return redirect()->route('application-grant.index')->with('error', 'Error, no user found.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
