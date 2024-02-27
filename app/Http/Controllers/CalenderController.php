<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class CalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->orderBy('user', 'ASC')
                ->get(['id', 'title', 'start', 'end', 'user', 'description', 'step']);

            $oldUser = "";
            $color = $this->colorPastel();
            $colorCount = 0;
            $colorOld = "";

            for($i = 0; $i < count($data); $i++) {

                $evn = $data[$i];
                
                if($evn->user != $oldUser) {
                    $colorOld = $color[$colorCount];
                    $data[$i]->color = $colorOld;
                    $oldUser = $evn->user;
                    $colorCount++;
                } else {
                    $data[$i]->color = $colorOld;
                }

            }


            return response()->json($data);
        }
        return view('calender');
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'user' => $request->user,
                    'description' => $request->desc,
                    'step' => $request->step
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }

    private function colorPastel() {
        $color[0] = "#FFAE92";
        $color[1] = "#E1EBF8";
        $color[2] = "#EFE5EE";

        return $color;
    }
}
?>