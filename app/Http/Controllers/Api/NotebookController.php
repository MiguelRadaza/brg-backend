<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notebook;
use Exception;

class NotebookController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'day' => 'required',
            'content' => 'required',
            'type' => 'required',
            'month' => 'required',
        ]);

        $note = Notebook::create([
            'day' => $request->day, 
            'content' => $request->content, 
            'type' => $request->type, 
            'month' => $request->month, 
        ]);
        
        if (!$note) {
            return $this->errorRes("An error occurred while creating Note");
        }

        return $this->successRes("Successfully created.", $note);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $note = Notebook::where('user_id', $user->id)->where('id', $request->id)->first();
            if (!$note) {
                return $this->errorRes("An error occurred while updating Note Id: " . $request->id);
            }

            $note->day = isset($request->day)? $note->day : $request->day;
            $note->month = isset($request->month)? $note->month : $request->month;
            $note->type = isset($request->type)? $note->type : $request->type;
            $note->content = isset($request->content)? $note->content : $request->content;
            $note->save();

            return $this->successRes("Successfully updated.", $note);

        } catch (\Throwable $th) {
            return $this->errorRes("An error occurred while updating Note id: " . $request->id, $th->getMessage());
        } catch (Exception $ex) {
            return $this->errorRes("An error occurred while updating Note id: " . $request->id, $ex->getMessage());
        }
    }
}
