<?php

namespace App\Http\Controllers;

use App\Models\DataGrant;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;
use App\Models\Section;
use App\Models\GradeLevel;
use App\Models\User;
use App\Models\GeneralSetting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DataGrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Fetch Campus Permission
        $applicationListURL = 'data-grants'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        $settingData = GeneralSetting::orderBy('id','desc')->first();
        $academicYear = $settingData->academicYear;
        // $dataGrants = DataGrant::all();
        $gradeLevels =  GradeLevel::whereIn('campusId', $campusPermissions)->get();
        $sections =  Section::whereIn('campusId', $campusPermissions)->get();
        $appLists = DcbApplicationList::where('url','publish-messages')
        ->orWhere('url','publish-calendars')
        ->orWhere('url','publish-survey')
        ->get();
        $users = User::where('userType','!=', 1)->where('userType','!=', 2)->get();

        return view('data_grants.index', [
            // 'dataGrants'=>$dataGrants,
            'campuses'=>$campuses,
            'gradeLevels'=>$gradeLevels,
            'sections'=>$sections,
            'users'=>$users,
            'appLists'=>$appLists,
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
        $settingData = GeneralSetting::orderBy('id','desc')->first();
        $academicYear = $settingData->academicYear;
        $request->validate([
            'dataGrantUserId' => 'required',
            'dataGrantCampusId' => 'nullable|string',
            'dataGrantAppId' => 'required',
            'gradeLevelIdSectionId' => 'required',
        ]);
        $dataGrantUserId = $request->get('dataGrantUserId');
        $dataGrantCampusId = $request->get('dataGrantCampusId');
        $dataGrantAppId = $request->get('dataGrantAppId');
        $gradeLevelIdSectionId = $request->get('gradeLevelIdSectionId');

        // echo "dataGrantUserId:$dataGrantUserId<br>";
        // echo "dataGrantCampusId:$dataGrantCampusId<br>";
        // echo "dataGrantAppId:$dataGrantAppId<br>";
        // return $gradeLevelIdSectionId;
        // clear all grants for the selected user, campus and app id,
        $clear = DataGrant::where('userId',$dataGrantUserId)
        ->where('campusId',  $dataGrantCampusId)
        ->where('appId',  $dataGrantAppId)
        ->where('academicYear',  $academicYear)
        ->forceDelete();
        // return $clear;
        $saveCounter=0;
        for($i=0;$i<sizeof($gradeLevelIdSectionId);$i++){
            $gradeLevelSection= $gradeLevelIdSectionId[$i];
            $gradeLevelSectionArray= explode('-',$gradeLevelSection);
            $gradeLevelId = $gradeLevelSectionArray[0];
            $sectionId = $gradeLevelSectionArray[1];
            $checkUniqueCount = DataGrant::where('userId',$dataGrantUserId)
            ->where('campusId',  $dataGrantCampusId)
            ->where('appId',  $dataGrantAppId)
            ->where('gradeLevelId',  $gradeLevelId)
            ->where('sectionId',  $sectionId)
            ->where('academicYear',  $academicYear)
            ->count();
            if($checkUniqueCount==0){
                $grant = new DataGrant([
                    'userId' => $dataGrantUserId,
                    'appId' => $dataGrantAppId,
                    'campusId' => $dataGrantCampusId,
                    'gradeLevelId' => $gradeLevelId,
                    'sectionId' => $sectionId,
                    'academicYear' => $academicYear,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
                if ($grant->save()) {
                    $saveCounter++;
                }
            }
        }
        if ($saveCounter!=0) {
            return redirect()->route('data-grants.index')->with('success', 'Data [GRANTED] successfully!');
        } else {
            return redirect()->route('data-grants.index')->with('error', 'Failed to [GRANT] Data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DataGrant $dataGrant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataGrant $dataGrant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataGrant $dataGrant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataGrant $dataGrant)
    {
        //
    }
}
