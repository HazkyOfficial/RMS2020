<?php

namespace App\Http\Controllers;
//==========================================================    USE PART    ===============================
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\clas;
use App\Models\student;
use App\Models\User;
use App\Models\users;
//=========================================================================================================
class MyController extends Controller
{
//==========================================================    Navigation parts    =======================
public function HomePage(){
        return view('Dashboard');
    }
    
public function Contact(){
        return view('Pages.contact');
    }

    public function ClassForm(){
        $class = DB::table('clas')->get();  //Get All class table contants from class table(DB)
        return view('Pages.Class',compact('class'));  //send all class details to class page(class.blad.php)
    }

    public function UsersForm(){
        $users = DB::table('users')->get();  //Get All class table contants from class table(DB)
        return view('Pages.Users',compact('users'));  //send all class details to class page(class.blad.php)
    }
    
    public function StudentForm(){
        $student = DB::table('students')->get();  //Get All student table contants from student table(DB)
        $cls = DB::table('clas')->where('class_status','Active')->orderBy('class_name','asc')->get();
        return view('Pages.Student',compact('student','cls'));  //send all student details to student page(student.blad.php)
    }


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
            'CStatus'=>'required',
            
        ],[
            //Class name Add
            'ECName.required'=>'Class Name is must',
            'ECName.min'=>'Class Name Minimum 4 letters must',

            //Class Type Add
            'ECType.required'=>'Please select Class Type',

            //Class Status Add
            'CStatus.required'=>'Please select Class Status',
        ]);

        DB::table('clas')->where('id' , $req->ECId)->update([
            'class_name' => $req->ECName,
            'class_type' => $req->ECType,
            'class_status' => $req->ECStatus,
        ]);

        $notification = array(
            'message' => 'Successfully Updated', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function delete($i)  //passing variable
    {
        DB::table('clas')->where('id',$i)->delete();
        
        $notification = array(
            'message' => 'Successfully Deleted', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

//==========================================================================================================

//=============================================     User Table Database Connections    ====================
    public function getusers(){
        $us = DB::table('users')->get();

        return view('viewusers',compact('us'));
    }

    public function adduser(Request $req)
    {

        $cnt = count(DB::table('users')->get());
        
        $use = new users;
        $use->name = $req->UName;
        $use->email = $req->UEmail;
        $use->password = $req->UPassword;
        $use->subject = $req->USubject;
        $use->role = $req->URole;
        $use->user_status = $req->UStatus;

        $use->save();

        $notification = array(
            'message' => 'Successfully Saved', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function edituser(Request $req) {

        DB::table('users')->where('id' , $req->EUID)->update([
            'name' => $req->EUName,
            'email' => $req->EUEmail,
            'password' => $req->EUPassword,
            'subject' => $req->EUSubject,
            'role' => $req->EURole,
        ]);

        $notification = array(
            'message' => 'Successfully Updated', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
//==========================================================================================================
//=============================================     Student Table Database Connections    ====================
    public function getstudent(){
        $st = DB::table('students')->get();

        return view('viewstudent',compact('st'));
    }

//==========================================================================================================

public function changestatus($id){
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

}
