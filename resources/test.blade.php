<?php

namespace App\Http\Controllers\API;

use App\Models\Exam;
use App\Models\Role;
use App\Models\Cloth;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Iman\Streamer\VideoStreamer;


class GameController extends ResponseController
{
    public function getQuestions(Request $request)
    {
        $category_names = Category::pluck('name', 'id');

        $all_exams = Exam::get()->mapToGroups(function ($item, $key) use ($category_names) {

            return [
                $item->category_id => ['id' => $item->id, 'title' => $item->title, 'cat_name' => $category_names[$item->category_id]]
            ];
        })->map(function ($item, $key) {
            $exam_info = $item->random();
            $exam_info['questions'] = Question::where('exam_id', $exam_info['id'])->get();
            return $exam_info;
        })->values();

        return $this->sendResponse('با موفقیت انجام شد.', ['exams' => $all_exams]);
    }

    public function getQuestion15(Request $request)
    {
        $category_names = Category::where('id', 15)->pluck('name', 'id');

        $all_exams = Exam::get()->mapToGroups(function ($item, $key) use ($category_names) {

            return [
                $item->category_id => ['id' => $item->id, 'title' => $item->title, 'cat_name' => $category_names[$item->category_id]]
            ];
        })->map(function ($item, $key) {
            $exam_info = $item->random();
            $exam_info['questions'] = Question::where('exam_id', $exam_info['id'])->get();
            return $exam_info;
        })->values();

        return $this->sendResponse('با موفقیت انجام شد.', ['exams' => $all_exams]);
    }

    public function getBundles(Request $request, $type, $platform, $name)
    {
        $path = "bundles/" . $type . "/" . $platform . "/" . $name;
        if ($exists = Storage::exists($path))
            return Storage::download($path);
        else
            return $this->sendError(
                [
                    '_' => 'Not found'
                ],
                'فایلی با این مشخصات یافت نشد.',
                422
            );
    }

    public function getVideo(Request $request, $name)
    {
        $path = "videos/" . $name;

        // $start = 0;
        // $size  = Storage::size($path);
        // $end   = $size - 1;

        // $headers = [
        //     'Content-Type' => 'video/mp4',
        //     // 'Content-Type' => 'video/mpeg',
        //     'Content-disposition' => 'inline',
        //     'Content-Transfer-Encoding' => 'binary',
        //     "Accept-Ranges" => "0-" . $end
        // ];

        // $headers["Content-Length"] = $size;

        if ($exists = Storage::exists($path))
            VideoStreamer::streamFile(storage_path('app/' . $path));
        //     return response()->file(storage_path('app/'.$path), $headers);
        // // return response()->streamDownload(function () use ($path) {
        // //     return Storage::get($path);
        // // }, $name, $headers);
        else
            return $this->sendError(
                [
                    '_' => 'Not found'
                ],
                'فایلی با این مشخصات یافت نشد.',
                422
            );
    }

    // public function getAssets(Request $request, $name)
    // {
    //     $path = "assets/" . $name;

    //     if ($exists = Storage::exists($path))
    //         return Storage::download($path);
    //     else
    //         return $this->sendError(
    //             [
    //                 '_' => 'Not found'
    //             ],
    //             'فایلی با این مشخصات یافت نشد.',
    //             422
    //         );
    // }

    public function setScores(Request $request)
    {
        $input = $request->only(['scores']);

        $validator = Validator::make($input, [
            // 'scores' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->sendError($errors, $errors->first());
        }

        $user = Auth::user();
        $user->scores = $input['scores'];
        $user->save();

        return $this->sendResponse('با موفقیت انجام شد.');
    }

    public function getScores(Request $request)
    {
        $scores = Auth::user()->scores;
        return $this->sendResponse('با موفقیت انجام شد.', ['scores' => $scores]);
    }

    public function getUserCloth(Request $request)
    {
        $cloth = Auth::user()->cloth->map(function ($item, $key) {
            return [
                'code' => $item['code'],
                'details' => $item['details'],
                'score' => $item->pivot->score,
            ];
        });


        return $this->sendResponse('با موفقیت انجام شد.', ['cloth' => $cloth]);
    }

    public function setUserCloth(Request $request)
    {
        $input = $request->only(['code']);

        $code = $input['code'];
        // $validator = Validator::make($input, [
        //     'user_name' => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     $errors = $validator->errors();
        //     return $this->sendError($errors, $errors->first());
        // }

        $cloth = Cloth::where('code', $code)->first();

        if (!$cloth)
            return $this->sendError(
                [
                    '_' => 'cloth not found'
                ],
                'ترکیبی با این مشخصات یافت نشد.',
                422
            );


        Auth::user()->cloth()->attach($cloth->id, ['score' => 0.1]);

        return $this->sendResponse('با موفقیت انجام شد.');
    }

    public function getCloth(Request $request)
    {
        $input = $request->only(['code']);

        if (isset($input['code'])) {
            $cloth = Cloth::where('code', $input['code'])->first();
            if ($cloth)
                return $this->sendResponse('با موفقیت انجام شد.');
        }

        return $this->sendError(
            [
                '_' => 'cloth not found'
            ],
            'ترکیبی با این مشخصات یافت نشد.',
            422
        );
    }

    public function addCloth(Request $request)
    {
        $input = $request->only(['image', 'code', 'details']);

        $validator = Validator::make($input, [
            'image' => ['required', 'file'],
            'code' => ['required', 'unique:cloth,code'],
            'details' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->sendError($errors, $errors->first());
        }

        $cloth_path = 'cloth';

        $path = $request->file('image')->store('cloth');

        $cloth = Cloth::firstOrNew(
            ['code' => $input['code']],
            ['details' => $input['details'], 'image_path' => $path]
        );

        $cloth->save();

        return $this->sendResponse('با موفقیت انجام شد.');
    }
}
