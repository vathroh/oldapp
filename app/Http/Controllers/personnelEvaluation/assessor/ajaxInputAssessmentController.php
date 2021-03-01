<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\Http\Controllers\Controller;
use App\personnel_evaluation_value;
use Illuminate\Http\Request;

class ajaxInputAssessmentController extends Controller
{
    public function data($request)
    {
        $data = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
        $totalScores = explode('%', $request->totalScores);
        for ($i = 1; $i < 4; $i++) {
            $score = "sumScores" . $i;
            $variabel = "sumVariabel" . $i;
            $data[$i]['sumVariabel'] = $request->$variabel;
            $data[$i]['sumScores'] = $request->$score;
        }

        $data[$request->criteria][$request->aspect]['variabel'] = $request->variabel;
        $data[$request->criteria][$request->aspect]['assessment']  = $request->assessment;
        $data[$request->criteria][$request->aspect]['score']    = $request->score;
        $data['totalVariabel']    = $request->totalVariabel;
        $data['finalResult']    = $request->kinerja;
        $data['totalScores']    = $totalScores[0];

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->data($request);
        personnel_evaluation_value::where('id', $request->value)->update([
            'team'            => $request->team,
            'content'         => serialize($data),
            'finalResult'     => $request->kinerja,
            'totalScore'      => $data['totalScores']
        ]);
        $array = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
        return response($data);
    }

    public function check(Request $request)
    {
        $value = personnel_evaluation_value::find($request->value);
        $content = unserialize($value->content);
        $totalScore = explode('%', $request->totalScores)[0];

        if ($request->totalVariabel == $content['totalVariabel']) {
            if ($totalScore == $content['totalScores']) {
                if ($request->kinerja == $content['finalResult']) {
                    if ($request->sumScores1 == $content[1]['sumScores']) {
                        if ($request->sumScores1 == $content[1]['sumScores']) {
                            if ($request->sumScores2 == $content[2]['sumScores']) {
                                if ($request->sumScores3 == $content[3]['sumScores']) {
                                    if ($request->sumVariabel1 == $content[1]['sumVariabel']) {
                                        if ($request->sumVariabel2 == $content[2]['sumVariabel']) {
                                            if ($request->sumVariabel3 == $content[3]['sumVariabel']) {
                                                $status = "ok";
                                            } else {
                                                $status = 'error';
                                            }
                                        } else {
                                            $status = 'error';
                                        }
                                    } else {
                                        $status = 'error';
                                    }
                                } else {
                                    $status = 'error';
                                }
                            } else {
                                $status = 'error';
                            }
                        } else {
                            $status = 'error';
                        }
                    } else {
                        $status = 'error';
                    }
                } else {
                    $status = 'error';
                }
            } else {
                $status = 'error';
            }
        } else {
            $status = 'error';
        }

        return response([$status, $request->value]);
    }

    public function textarea(Request $request)
    {
        personnel_evaluation_value::where('id', $request->value)->update([
            'issue'           => $request->issue,
            'recommendation'  => $request->recommendation
        ]);
    }

    public function team(Request $request)
    {
        personnel_evaluation_value::where('id', $request->value)->update([
            'team'           => $request->team
        ]);
    }
}
