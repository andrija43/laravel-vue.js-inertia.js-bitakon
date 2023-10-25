<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Generatedimage;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\User;
use Auth;
class GenerateController extends Controller
{

    /**
     * return the specified resource from api.
     */
    public function generate(Request $request)
    {
      
        $request->validate([
            'prompt' => 'required',
            'size' => 'required|in:256x256,512x512,1024x1024',
        ]);
        $credit_fee = get_option('image_generate_charge');
        $charge = $credit_fee * $request->input('quantity') ?? 1;

        if (Auth::user()->credits < $charge) {
            return response()->json(['message' => 'You dont have enough credits please purchase some credits'], 401);
        }


        $response = [];
        if ($request->filled('prompt')) {
            $response = OpenAI::images()->create([
                'prompt' => $request->input('prompt'),
                'n' => $request->input('quantity') ?? 1,
                'size' => $request->input('size') ?? '256x256',
                'response_format' => 'url',
            ]);
        }
        
        if ($response?->data && $response->created) {
            $images = [];
            foreach ($response->data as $data) {
                $url = $data->url;
                $image = file_get_contents($url);

                $filename = 'generated_image_' . uniqid() . '.jpg';

                $savePath = public_path('uploads/generated/');
                $saveImage = file_put_contents($savePath . $filename, $image);
                array_push($images, asset('uploads/generated/'.$filename));
            }
            Generatedimage::create([
                'user_id' => auth()->id(),
                'prompt' => $request->input('prompt'),
                'size' => $request->input('size') ?? '256x256',
                'images' => json_encode($images),
                'charge' =>  $charge
            ]);

            $user= User::where('id',auth()->id())->first();
            $user->credits = $user->credits - $charge;
            $user->save();
        }

        return response()->json($response);
    }
}
