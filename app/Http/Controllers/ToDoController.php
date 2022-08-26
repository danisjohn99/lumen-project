<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use Carbon\Carbon;

    //MODEL
    use  App\Models\User;
    use  App\Models\ToDo;



    /**
     * ToDoController
     * This controlleris used to interact with todo operations.
     *
     * @author      LearnPanda <danisjohn99@gmail.com>
     */

    class ToDoController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth:api');
        }


        /**
         * Create Note.
         *
         * @param  Request  $request
         * @return Response
         */
        public function createNote(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'content' => 'required|string',
            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();;
                return response()->json($responseArr);
            }

            $userId = Auth::user()->id;
            $content = $request->content;
            ToDo::create(['user_id'=>$userId,'content'=>$content]);
            return response()->json(['message' => 'Note Created Successfully']);
        }


        /**
         * Delete Note.
         *
         * @param  $id as noteid
         * @return Response
         */
        public function deleteNote($id)
        {
          
            //Validate note_id & user_id with DB
            $userId = Auth::user()->id;
            $verify = ToDo::where([ ['id',$id],['user_id',$userId] ])->first();
             
            if($verify){
                $verify->delete();
                return response()->json(['message' => 'Note Deleted Successfully']);
            }
                return response()->json(['message' => 'Cannot find note']);
        }


        /**
         * Mark Note Status(Complete or Incomplete)
         *
         * @param Request  $request
         * @return Response
         */
        public function markNoteStatus(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'note_id' => 'required',
                'status'=>'required',
            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();;
                return response()->json($responseArr);
            }
          
            //Validate note_id & user_id with DB
            $userId = Auth::user()->id;
            $id = $request->note_id;
            $verify = ToDo::where([ ['id',$id],['user_id',$userId] ])->first();
             
            if($verify){
                $status =$request->status;
                $mytime = Carbon::now();

                if($status == "complete"){
                    $verify->update(['completion_time'=>$mytime]);
                    return response()->json(['message' => 'Note Completed']);
                }elseif($status == "incomplete"){
                    $verify->update(['completion_time'=>null]);
                    return response()->json(['message' => 'Note Incompleted']);
                }
            }
                return response()->json(['message' => 'Cannot find note']);
        }


        /**
         * List of all notes via user_id.
         *
         * @param 
         * @return Response
         */
        public function userNoteList()
        {
            $userId   = Auth::user()->id;
            $noteList = ToDo::where('user_id',$userId)->get()->toArray();
            //$noteList = User::with(['todoNotes'])->where('id',$userId)->first();
            $response = [
                    'status' => 'success',
                    'data' => $noteList,
                ];
            return response()->json($response, 200); 
        }


        /**
         * List of all saved notes
         *
         * @param 
         * @return Response
         */
        public function allNotes()
        {
            $noteList = ToDo::select('id','user_id','content')->get()->toArray();
            $response = [
                    'status' => 'success',
                    'data' => $noteList,
                ];
            return response()->json($response, 200);  
        }

    }