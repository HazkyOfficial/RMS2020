<?php

namespace App\Http\Controllers;
//==========================================================    USE PART    ===============================
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\clas;
use App\Models\students;
use App\Models\subjects;
use App\Models\User;
use App\Models\users;
//=========================================================================================================
class MyController extends Controller
{
//==========================================================    Navigation parts    =======================
    // =============HOME PAGE FUNCTIONS================
        public function HomePage(){
                return view('HomePage');
            }
        public function Dashboard(){
                return view('Dashboard');
            }
        public function Results(){
                return view('Results');
            }
    //==========================================

    public function Contact(){
            return view('Pages.contact');
        }

    public function ClassForm(){
        $class = DB::table('clas')->get();  //Get All class table contants from class table(DB)
        return view('Pages.Class',compact('class'));  //send all class details to class page(class.blad.php)
    }

    public function Subjectform(){
        $subject = DB::table('subjects')->get();  //Get All class table contants from subject table(DB)
        return view('Pages.Subject',compact('subject'));  //send all class details to subject page(class.blad.php)
    }

    public function UsersForm(){
        $users = DB::table('users')->get();  //Get All class table contants from class table(DB)
        $subj = DB::table('subjects')->where('subjectstatus','Active')->orderBy('subjectname','asc')->get();
        return view('Pages.Users',compact('users','subj'));  //send all class details to class page(class.blad.php)
    }
    
    public function StudentForm(){
        $students = DB::table('students')->get();  //Get All student table contants from student table(DB)
        $cls = DB::table('clas')->where('class_status','Active')->orderBy('class_name','asc')->get();
        return view('Pages.Student',compact('students','cls'));  //send all student details to student page(student.blad.php)
    }

    public function EnterResults(){
        return view('Pages.EnterResults');
    }

    public function TeachersReport(){
        return view('Pages.TeachersReport');
    }

    public function TeachersProfile(){
        return view('Pages.TeachersProfile');
    }
//=========================================================================================================

//==========================================================================================================
//=============================================     Class Table Database Connections    ====================

    public function getclass(){
        $cs = DB::table('clas')->get();

        return view('viewclass',compact('cs'));
    }

    public function addclass(Request $req)
    {
        $req->validate([
            'CName'=>'required|min:4',
            'CType'=>'required',
            'CStatus'=>'required',
        ],[
            //Class name Add
            'CName.required'=>'Class Name is must',
            'CName.min'=>'Class Name Minimum 4 letters must',
            //Class Type Add
            'CType.required'=>'Please select Class Type',

             //Class Status Add
            'CStatus.required'=>'Please select Class Status',
        ]);

        $cnt = count(DB::table('clas')->get());
        
        $cls = new clas;
        $cls->class_name = $req->CName;
        $cls->class_type = $req->CType;
        $cls->class_status = $req->CStatus;
        

        $cls->save();

        $notification = array(
            'message' => 'Successfully Saved', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editclass(Request $req) {

        $req->validate([
            'ECName'=>'required|min:4',
            'ECType'=>'required',
            
        ],[
            //Class name Add
            'ECName.required'=>'Class Name is must',
            'ECName.min'=>'Class Name Minimum 4 letters must',

            //Class Type Add
            'ECType.required'=>'Please select Class Type',
        ]);

        DB::table('clas')->where('id' , $req->ECId)->update([
            'class_name' => $req->ECName,
            'class_type' => $req->ECType,
        ]);

        $notification = array(
            'message' => 'Successfully Updated', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteclass($i)  //passing variable
    {
        DB::table('clas')->where('id',$i)->delete();
        
        $notification = array(
            'message' => 'Successfully Deleted', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function changeclassstatus($id){  //STATUS BUTTON PART ================

        $status = DB::table('clas')->where('id',$id)->value('class_status');
        if($status ==  "Active"){
            DB::table('clas')->where('id',$id)->update([
                'class_status'=>'Deactive'
            ]);
        }else{
            DB::table('clas')->where('id',$id)->update([
                'class_status'=>'Active'
            ]);
        }
        return redirect()->back();
    }
//==========================================================================================================

//=============================================     Users Table Database Connections    ====================
    public function getusers(){
        $us = DB::table('users')->get();

        return view('viewusers',compact('us'));
    }

    public function adduser(Request $req)  //Daa USER ======================
    {

        $req->validate([
            'UName'=>'required|min:8',
            'UEmail'=>'required|min:12',
            'UPassword'=>'required|min:8',
            'USubject'=>'required', //Nullable
            'URole'=>'required',
            'UStatus'=>'required',
        ],[
            //User name Add
            'UName.required'=>'User Name is must',
            'UName.min'=>'User Name Minimum 8 letters must',
            //User Email Add
            'UEmail.required'=>'User E-mail is must',
            'UEmail.min'=>'User E-mail Minimum 12 letters must',
            //User Password Add
            'UPassword.required'=>'User Password is must',
            'UPassword.min'=>'User Name Password Minimum 8 letters must',
            //User Subject Add
            // 'USubject.required'=>'Please select a class', NULLable
            //User Role Add
            'URole.required'=>'Please select a role',
             //User Status Add
            'UStatus.required'=>'Please select a status',
        ]);

        $cnt = count(DB::table('users')->get());
        
        $use = new users;
        $use->name = $req->UName;
        $use->email = $req->UEmail;
        $use->password = $req->UPassword;
        $use->subjectname = $req->USubject;
        $use->role = $req->URole;
        $use->user_status = $req->UStatus;

        $use->save();

        $notification = array(
            'message' => 'Successfully Saved', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function edituser(Request $req) { //EDIT USER =======================

        $req->validate([
            'EUName'=>'required|min:8',
            'EUEmail'=>'required|min:12',
            'EUPassword'=>'required|min:8',
            'EUSubject'=>'required',
            'EURole'=>'required',
        ],[
            //User name Add
            'EUName.required'=>'User Name is must',
            'EUName.min'=>'User Name Minimum 8 letters must',
            //User Email Add
            'EUEmail.required'=>'User E-mail is must',
            'EUEmail.min'=>'User E-mail Minimum 12 letters must',
            //User Password Add
            'EUPassword.required'=>'User Password is must',
            'EUPassword.min'=>'User Name Password Minimum 8 letters must',
            //User Subject Add
            'EUSubject.required'=>'Please select a class',
            //User Role Add
            'EURole.required'=>'Please select a role',
        ]);

        DB::table('users')->where('id' , $req->EUID)->update([
            'name' => $req->EUName,
            'email' => $req->EUEmail,
            'password' => $req->EUPassword,
            'subjectname' => $req->EUSubject,
            'role' => $req->EURole,
        ]);

        $notification = array(
            'message' => 'Successfully Updated', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteuser($i)  //DELETE USER ==========================
    {
        DB::table('users')->where('id',$i)->delete();
        
        $notification = array(
            'message' => 'Successfully Deleted', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function changeusersstatus($id){  //STATUS BUTTON PART ================

        $status = DB::table('users')->where('id',$id)->value('user_status');
        if($status ==  "Active"){
            DB::table('users')->where('id',$id)->update([
                'user_status'=>'Deactive'
            ]);
        }else{
            DB::table('users')->where('id',$id)->update([
                'user_status'=>'Active'
            ]);
        }
        return redirect()->back();
    }
//==========================================================================================================
//=============================================     Student Table Database Connections    ====================
    public function getstudent(){
        $st = DB::table('students')->get();
        return view('viewstudent',compact('st'));
    }

    public function addstudent(Request $req)  //Daa USER ======================
    {
        $req->validate([
            'SIndexNo'=>'required|digits:5',
            'SName'=>'required|min:12',
            'SGender'=>'required',
            'SDOB'=>'required',
            'SStatus'=>'required',
            'SCName'=>'required',
        ],[
            //Student  name Add
            'SIndexNo.required'=>'Index Number is must',
            'SIndexNo.digits'=>'Index Number size 5',
            // 'SIndexNo.digits'=>'Enter numeric Index Number',
            'SIndexNo.unique'=>'Index Number not unique',
            
            //Student name Add
            'SName.required'=>'Student name is must',
            'SName.min'=>'Student name is minimum 12 leters',

             //Student gender Add
            'SGender.required'=>'Please select Student Gender',
             //Student DOB Add
            'SDOB.required'=>'Please select Student Date of birth',
             //Student Status Add
            'SStatus.required'=>'Please select Student Status',
             //Student Class name Add
            'SCName.required'=>'Please select Student Class name',
        ]);

        $cnt = count(DB::table('students')->get());
        
        $stu = new students;
        $stu->index_no = $req->SIndexNo;
        $stu->student_name = $req->SName;
        $stu->gender = $req->SGender;
        $stu->dob = $req->SDOB;
        $stu->student_status = $req->SStatus;
        $stu->class_name = $req->SCName;



        $stu->save();

        $notification = array(
            'message' => 'Successfully Saved', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editstudent(Request $req) { //EDIT USER =======================

        $req->validate([
            'ESIndexNo'=>'numeric|required|digits:5',
            'ESName'=>'required|min:12',
            'ESGender'=>'required',
            'ESDOB'=>'required',
            'ESCName'=>'required',
        ],[
            //Student  name Add
            'ESIndexNo.required'=>'Index Number is must',
            'ESIndexNo.digits:5'=>'Index Number size 5',
            //Student name Add
            'ESName.required'=>'Student name is must',
            'ESName.min'=>'Student name is minimum 12 leters',

             //Student gender Add
            'ESGender.required'=>'Please select Student Gender',
             //Student DOB Add
            'ESDOB.required'=>'Please select Student Date of birth',
             //Student Class name Add
            'ESCName.required'=>'Please select Student Class name',
        ]);

        DB::table('students')->where('index_no' , $req->ESIndexNo)->update([
            'student_name' => $req->ESName,
            'gender' => $req->ESGender,
            'dob' => $req->ESDOB,
            'class_name' => $req->ESCName,
            
        ]);

        $notification = array(
            'message' => 'Successfully Updated', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deletestudent($i)  //DELETE USER ==========================
    {
        DB::table('students')->where('index_no',$i)->delete();
        
        $notification = array(
            'message' => 'Successfully Deleted', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function changestudentstatus($index_no){  //STATUS BUTTON PART ================

        $status = DB::table('students')->where('index_no',$index_no)->value('student_status');
        if($status ==  "Active"){
            DB::table('students')->where('index_no',$index_no)->update([
                'student_status'=>'Deactive'
            ]);
        }else{
            DB::table('students')->where('index_no',$index_no)->update([
                'student_status'=>'Active'
            ]);
        }
        return redirect()->back();
    }
//==========================================================================================================
//=============================================     Subject Table Database Connections    ====================
    public function getSubject(){
        $su = DB::table('subjects')->get();

        return view('viewsubject',compact('su'));
    }

    public function addsubject(Request $req)
    {

        $req->validate([
            'SName'=>'required|min:3',
            'SStatus'=>'required',
        ],[
            //Student name Add
            'SName.required'=>'Subject name is must',
            'SName.min'=>'Subject name is minimum 3 leters',
             //Student Status Add
            'SStatus.required'=>'Please select Subject Status',
        ]);

        $cnt = count(DB::table('subjects')->get());
        
        $sub = new subjects;
        $sub->subjectname = $req->SName;
        $sub->subjectstatus = $req->SStatus;

        $sub->save();

        $notification = array(
            'message' => 'Successfully Saved', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editsubject(Request $req)
    {
    
        $req->validate([
            'ESName'=>'required|min:3',
        ],[
            //Student name Add
            'ESName.required'=>'Subject name is must',
            'ESName.min'=>'Subject name is minimum 3 leters',
        ]);
    
    DB::table('subjects')->where('id' , $req->ESId)->update([
        'subjectname' => $req->ESName,
        
    ]);

    $notification = array(
        'message' => 'Successfully Updated', 
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
    }

    public function deletesubject($i)  //passing variable
    {
        DB::table('subjects')->where('id',$i)->delete();
        
        $notification = array(
            'message' => 'Successfully Deleted', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function changesubjectsstatus($id){  //STATUS BUTTON PART ================

        $status = DB::table('subjects')->where('id',$id)->value('subjectstatus');
        if($status ==  "Active"){
            DB::table('subjects')->where('id',$id)->update([
                'subjectstatus'=>'Deactive'
            ]);
        }else{
            DB::table('subjects')->where('id',$id)->update([
                'subjectstatus'=>'Active'
            ]);
        }
        return redirect()->back();
    }
//==========================================================================================================

}
