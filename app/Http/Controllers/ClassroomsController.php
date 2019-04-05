<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use Auth;
use Redirect;
use App\Classroom;
use App\Students;
use App\User;
use Intervention\Image\Facades\Image;

class ClassroomsController extends Controller
{
    //
    public function handleAddClassroom ()
    {
    	$data=Input::all();

    	$rules = [

          

            'title' => 'required|min:5',

            'computers' => 'required',

        ];



        $messages = [

            'title.required' => 'Votre titre est obligatoire',

            'title.min' => 'Votre titre doit dépasser 5 caractères',

          

            'computers.required' => 'Le champ computers est obligatoire'

        ];



        $validation = Validator::make($data, $rules, $messages);



        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation->errors());

        }
    	//dd($data);
    	$cl=Classroom::create(['tables'=>$data['tables'],
    		'computers'=>$data['computers'],
    		'title'=>$data['title']]);
    	return back();

    	//dd($cl->id);
    	//dd($cl->created_at);
    	//dd(now()->addDays(5));
    	//BD::table('classroom')->insert([]);
    }

    public function handleDeleteClassroom ($id)
    {
    	//dd($id);
    	//$cl=Classroom::find($id);
    	//dd($cl);
    	//return $cl;
    	//return $cl ?
    	//$cl->delete()
    	//:
    	//'Erreur';

    	//if ($cl)
    		//$cl->delete();
    	//else
    	//{
    	 //echo 'Erreur';
    	//}
    	Classroom::whereId($id)->delete();
    	//return back();
    	//redirect(route('showClassrooms'));

    	//return back()->withErrors(['La suppression a été effectuée']
    	
    	//return back()->with('message','Delete this msg');
    	Session::flash('message', "Special message goes here");
    	Session::flush();
		return back();

		




    }


 	public function showClassrooms()
 	{
 		//$cl=Classroom::all();
        if ($data = @file_get_contents("http://api.apixu.com/v1/current.json?key=fc8ed0be1ed24dcb885144051190404&q=Tunis"))
   {
       $json = json_decode($data, true);
       $latitude = $json['current']['condition']['icon'];
   }
   //dd( $latitude);

   //dd($longitude, $latitude);

        $cl=Classroom::withCount('students')->get();

 		return view('list',[
 			'cl'=>$cl,
            'latitude'=>$latitude
 		]);



 	}

 	public function showClassroom($id)
 	{
 		$cl=Classroom::find($id);
        //dd($cl->students);

       
        //dd(Students::whereId($id)->with('classroom')->first());
 		
    	return view('show',[
 			'cl'=>$cl
 		]);

       

 	}

 	public function handleUpdateClassroom($id)
 	{
 		$cl=Classroom::find($id);

 		$data=Input::all();
 	
 		$cl->tables=$data['tables'];
    	$cl->computers=$data['computers'];
    	$cl->title=$data['title'];
		$cl->save();
		redirect(route('handleAddClassroom'));


 		//$cl=Classroom::where('tables','>',10)->update(['computers'=>100]);

 		
    	

 	}

    public function showRegister()
    {

        return view('register');

    }

    public function handleRegister()
    {

    $data=Input::all();

    $cl=User::create(['name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])
        ]);
    //dd(bcrypt($data['password']));


    }

    

    public function showLogin ()
    {
        return view('login');
    }


    public function handleLogin()

    {
        $data=Input::all();
        $credentials = [
           'email' => $data['email'],
           'password' => $data['password'],
       ];

       if (Auth::attempt($credentials)) 
       {
           //return Auth::user();          
             //dd($user);
       } 

       else
        { 
            return 'error';
         }
    }

    public function  Logout ()
    {
       Auth::logout();  
       return Redirect::route('showLogin');
       

    }


    public function  ShowStudents($id)
    {
        $cl=Classroom::find($id);

        if($cl and $cl->students()->exists())
        {

           return view('showStudents',[
                'cl'=>$cl
            ]);
       }
       else
       {
            Session::flash('message', "La classe ne contient aucun élève");
            redirect(route('showClassrooms'));
       }
       
    }



    public function  handleDeleteStudent($id)
    {
        $cl=Students::find($id);

        $user=Auth::user();
        
        if ($cl && $user)
        {
            
        Students::whereId($id)->forcedelete();  
        } 

        return back();
   
        
       
  }

public function  handleAddStudent($id)
    {
        $data=Input::all();
        

        $photo = 'photo-' . str_random(5) . time() . '.' . $data['photo']->getClientOriginalExtension();
           $fullImagePath = public_path('storage/' . $photo);
           Image::make($data['photo']->getRealPath())->save($fullImagePath);
           $photoPath = 'storage/' . $photo;

           Students::create(['name'=>$data['name'],
            'age'=>$data['age'],
            'photo'=>$photoPath,
            'classroom_id' =>$id

        ]);
   
        
       
  }



   



 	 



    	
   
}
