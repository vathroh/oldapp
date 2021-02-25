<?php

namespace App\Http\Controllers\personnelEvaluation\beingAssessed;

use App\Http\Controllers\Controller;
use App\personnel_evaluation_value;
use Illuminate\Http\Request;

class ajaxInputAchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $data = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
        $totalScores = explode('%', $request->totalScores);
        for ($i = 1; $i < 4; $i++) {
            $score = "sumScores" . $i;
            $variabel = "sumVariabel" . $i;
            $data[$i]['userSumVariabel'] = $request->$variabel;
            $data[$i]['userSumScores'] = $request->$score;
        }

        $data[$request->criteria][$request->aspect]['variabel'] = $request->variabel;
        $data[$request->criteria][$request->aspect]['capaian']  = $request->capaian;
        $data[$request->criteria][$request->aspect]['userScore']    = $request->score;
        $data['userTotalVariabel']    = $request->totalVariabel;
        $data['userFinalResult']    = $request->kinerja;
        $data['userTotalScores']    = $totalScores[0];

        personnel_evaluation_value::where('id', $request->value)->update([
            'team'                => $request->team,
            'content'             => serialize($data),
            'userFinalResult'     => $request->kinerja,
            'userTotalScore'      => $totalScores[0]
        ]);

        $array = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
        return response($array);
    }

    public function check(Request $request)
    {
        $value = personnel_evaluation_value::find($request->value);
        $content = unserialize($value->content);
        $totalScore = explode('%', $request->totalScores)[0];

        if ($request->totalVariabel == $content['userTotalVariabel']) {
            if ($totalScore == $content['userTotalScores']) {
                if ($request->kinerja == $content['userFinalResult']) {
                    if ($request->sumScores1 == $content[1]['userSumScores']) {
                        if ($request->sumScores1 == $content[1]['userSumScores']) {
                            if ($request->sumScores2 == $content[2]['userSumScores']) {
                                if ($request->sumScores3 == $content[3]['userSumScores']) {
                                    if ($request->sumVariabel1 == $content[1]['userSumVariabel']) {
                                        if ($request->sumVariabel2 == $content[2]['userSumVariabel']) {
                                            if ($request->sumVariabel3 == $content[3]['userSumVariabel']) {
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
}
