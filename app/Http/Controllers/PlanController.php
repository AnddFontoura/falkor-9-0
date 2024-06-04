<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    protected string $viewFolder = 'system.plan.';
    protected string $saveRedirect = 'system/team/manage';

    public function select()
    {
        $plans = Plan::where('active', true)->get();

        return view($this->viewFolder . 'select', compact('plans'));
    }

    public function payment(int $paymentId)
    {
        $plan = Plan::where('id', $paymentId)
            ->where('active', true)
            ->first();

        $userAlreadyHasThePlan = UserPlan::where('user_id', Auth::id())
            ->where('plan_id', $paymentId)->first() != null ? true : false ;

        if ($plan && !$userAlreadyHasThePlan) {
            $startDate = Carbon::now()->format('Y-m-d');
            $finishDate = $plan->durations_months != 0 ?
                Carbon::now()->addMonths($plan->durations_months)->format('Y-m-d')
                : Carbon::now()->addDays($plan->durations_days)->format('Y-m-d');

            UserPlan::create([
               'plan_id' => $plan->id,
               'user_id' => Auth::id(),
               'start_date' => $startDate,
               'finish_date' => $finishDate,
               'price' => $plan->price,
               'features' => $plan->features,
            ]);

            return redirect('home')->withSuccess('Plano adquirido com sucesso');
        }

        return redirect()->route('system.plans.form')->with('error','Você já tem esse plano');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Plan $plan)
    {
        //
    }

    public function edit(Plan $plan)
    {
        //
    }

    public function update(Request $request, Plan $plan)
    {
        //
    }

    public function destroy(Plan $plan)
    {
        //
    }
}
