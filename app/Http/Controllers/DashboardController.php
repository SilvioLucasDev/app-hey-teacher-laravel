<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $filter    = $request->get('search', null);
        $questions = Question::query()
                        ->when($filter, function (Builder $query) use ($filter) {
                            $query->where('question', 'like', "%{$filter}%");
                        })
                        ->withSum('votes', 'like')
                        ->withSum('votes', 'unlike')
                        ->orderByRaw('
                            case when votes_sum_like is null then 0 else votes_sum_like end desc,
                            case when votes_sum_unlike is null then 0 else votes_sum_unlike end
                        ')->paginate(10);

        return view('dashboard', [
            'questions' => $questions,
        ]);
    }
}
