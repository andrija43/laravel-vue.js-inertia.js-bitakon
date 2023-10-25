<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:200|string',
            'prompt_id' => 'required|exists:prompts,id',
        ]);
        $report = Report::where('user_id', auth()->user()->id)->where('prompt_id', $request->prompt_id)->exists();
        if ($report) {
            return throw ValidationException::withMessages(['exists' => 'You have already reported this prompt']);
        }
        Report::create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'prompt_id' => $request->prompt_id,
        ]);

        return back();
    }
}
