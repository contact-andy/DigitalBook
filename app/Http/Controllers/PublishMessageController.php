<?php

namespace App\Http\Controllers;

use App\Models\AcademicCalendar;
use App\Models\EventCategory;
use App\Models\GeneralSetting;


use App\Models\PublishMessage;
use App\Models\PublishMessageDetail;
use App\Models\DataGrant;


use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\MessageTemplate;
use App\Models\Student;

use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PublishMessageController extends Controller
{
    public function afterCampusSelection(Request $request)
    {
        // Get the selected category from the form
        $selectedCampus = $request->input('campusId');
        // Process the selected user (e.g., save to database or redirect)
        return redirect()->back()->with('selectedCampus', $selectedCampus);
    }
    public function afterGradeLevelSelection(Request $request)
    {
        // Get the selected category from the form
        $selectedCampus = $request->input('campusId');
        $selectedGradeLevel = $request->input('gradeLevelId');
        // Process the selected user (e.g., save to database or redirect)
        return redirect()->back()->with([
            'selectedCampus'=>$selectedCampus,
            'selectedGradeLevel'=>$selectedGradeLevel,
        ]);
    }
    public function afterSectionSelection(Request $request)
    {
        // Get the selected category from the form
        $selectedCampus = $request->input('campusId');
        $selectedGradeLevel = $request->input('gradeLevelId');
        $selectedSection = $request->input('sectionId');
        // Process the selected user (e.g., save to database or redirect)
        return redirect()->back()->with([
            'selectedCampus'=>$selectedCampus,
            'selectedGradeLevel'=>$selectedGradeLevel,
            'selectedSection'=> $selectedSection
        ]);
    }
    public function afterTemplateSelection(Request $request)
    {
        // Get the selected category from the form
        $selectedCampus = $request->input('campusId');
        $selectedGradeLevel = $request->input('gradeLevelId');
        $selectedSection = $request->input('sectionId');
        $selectedTemplate = $request->input('messageTemplateId');
        // Process the selected user (e.g., save to database or redirect)
        return redirect()->back()->with([
            'selectedCampus'=>$selectedCampus,
            'selectedGradeLevel'=>$selectedGradeLevel,
            'selectedSection'=> $selectedSection,
            'selectedTemplate'=>$selectedTemplate,
        ]);
    }
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'publish-messages'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        $settingData = GeneralSetting::orderBy('id','desc')->first();
        $academicYear = $settingData->academicYear;
        
        $gradeLevels  = GradeLevel::whereIn('campusId', $campusPermissions)->get();
        $sections  = Section::whereIn('campusId', $campusPermissions)->get();
        $messageTemplates = MessageTemplate::select('message_templates.*', 'message_categories.title','message_categories.id as catId','campuses.name',)
        ->join('message_categories', 'message_categories.id', '=', 'message_templates.messageCategoryId')
        ->join('campuses', 'campuses.id', '=', 'message_categories.campusId')
        ->whereIn('message_templates.campusId', $campusPermissions)
        ->where('message_templates.created_by', Auth::id())
        ->get();


        // $dataGrants = DataGrant::whereIn('campusId', $campusPermissions)
        // ->where('academicYear ', $academicYear)
        // ->where('userId  ', Auth::id())
        // ->get();


        return view('publish_messages.index', [
            'campuses'=>$campuses,
            'gradeLevels'=>$gradeLevels,
            'sections'=>$sections,
            'messageTemplates'=>$messageTemplates,
            'academicYear'=>$academicYear,
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
        /*
        'campusId',
        'gradeLevelId',
        'sectionId',  
        'messageTemplateId',
        'status',
        'comment',
        'approved_by',
        'created_by',
        'updated_by',
        'academicYear',
        */
        $settingData = GeneralSetting::orderBy('id','desc')->first();
        $academicYear = $settingData->academicYear;
        $campusId = $request->campusId;
        $gradeLevelId = $request->gradeLevelId;
        $sectionId = $request->sectionId;
        $messageTemplateId = $request->templateId;
        $studentIdCollection = $request->studentIdCollection;
        $studentIdArray = explode(',',$studentIdCollection);

        $publishedMessage = new PublishMessage([
            'campusId' => $campusId,
            'gradeLevelId' => $gradeLevelId,
            'sectionId' => $sectionId,
            'messageTemplateId' => $messageTemplateId,
            'academicYear' => $academicYear,
            'created_by' => auth()->id(),
        ]);
        // return $publishedMessage;
        if ($publishedMessage->save()) {
            $publishId = $publishedMessage->id;
            /*
            'publishId',
            'studentId',
            'message',
            'created_by',
            'updated_by',
            */
            $counter=0;
            for($i=0;$i<sizeof($studentIdArray)-1;$i++){
                $studentId = $studentIdArray[$i];
                $publishedMessageDetail = new PublishMessageDetail([
                    'publishId' => $publishId,
                    'studentId' => $studentId,
                    'created_by' => auth()->id(),
                ]);
                if ($publishedMessageDetail->save()) 
                    $counter++;
            }
            if($counter!=0){
                return redirect()->route('publish-messages.index')->with('success', 'Message has been [PUBLISHED] successfully!');
            }else{
                return redirect()->route('publish-messages.index')->with('error', 'Failed to [PUBLISHED] message!');
            }
        }
        else{
            return redirect()->route('publish-messages.index')->with('error', 'Failed to [PUBLISHED] message!');
        }


        
        // FOR MOBILE API

        /*
            #NAME#      :   First name and Middle Name
            #HESHE#     :   sex == 'Female'? she : he
            #FHESHE#    :   sex == 'Female'? She : He
            #HIMHER#    :   sex == 'Female'? her : him
            #HISHER#    :   sex == 'Female'? her : his
            #FHISHER#   :   sex == 'Female'? Her : His
            #HIMHERSELF#:   sex == 'Female'? herself : himself
            #AYEAR#     :   Current academic year
            #TODAYDATE# :   Today's date DD-MM-YYYY (GC)            
        */
        // $studentIdArray = explode(',',$studentIdCollection);
        // for($i=0;$i<sizeof($studentIdArray)-1;$i++){
        //     $studId = $studentIdArray[$i];
        //     $data = Student::select('students.id','students.studentId','students.firstName',
        //     'students.middleName','students.lastName','students.sex','students.dob',
        //     'students.SMSMobile1')->where('id', '=' , $studId)
        //     ->first();
        //     echo "Student Id: $studId ";
        //     echo "firstName: $data->firstName \n";
        //     echo "sex: $data->sex \n";
        // }
        // $replacedStr='#NAME#';
        // $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        // $comment=preg_replace($replacedStr,$fullName, $comment);
        
        // if(strcmp(strtolower($sex),'female') ==0)
        // {
        //     $replacedStr='#HESHE#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'she', $comment);
            
        //     $replacedStr='#FHESHE#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'She', $comment);
            
        //     $replacedStr='#HIMHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'her', $comment);
            
        //     $replacedStr='#HISHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'her', $comment);
            
        //     $replacedStr='#FHISHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'Her', $comment);
            
        //     $replacedStr='#HIMHERSELF#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'herself', $comment);
                                                            
        // }
        // else
        // {
        //     $replacedStr='#HESHE#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'he', $comment);
            
        //     $replacedStr='#FHESHE#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'He', $comment);
            
        //     $replacedStr='#HIMHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'him', $comment);
            
        //     $replacedStr='#HISHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'his', $comment);
            
        //     $replacedStr='#FHISHER#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'His', $comment);
            
            
        //     $replacedStr='#HIMHERSELF#';
        //     $replacedStr = '/'.preg_quote($replacedStr, '/').'/';
        //     $comment=preg_replace($replacedStr,'himself', $comment);
            
        // }
        // return $campusId;
        // $saveCounter =1;
        // if ($saveCounter!=0) {
        //     return redirect()->route('publish-messages.index')->with('success', 'Message has been [PUBLISHED] successfully!');
        // }
        // else{
        //     return redirect()->route('publish-messages.index')->with('error', 'Failed to [PUBLISHED] message!');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(PublishMessage $publishMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublishMessage $publishMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublishMessage $publishMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublishMessage $publishMessage)
    {
        //
    }
}
