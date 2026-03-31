<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnualDues;
use DB;

class AnnualDuesController extends Controller
{
    //
    public function annualDuesCreate()
    {
        return view('annual-dues.create-annual-dues');
    }

    public function annualDuesSave(Request $request)
    {

        $annualDuesCount = AnnualDues::where('tbl_annual_dues.is_active',true)
        ->where('tbl_annual_dues.year_dues',$request->year_dues)
        ->count();

        if($annualDuesCount >= 1)
        {
            return "exist";
        }
        else
        {
            $created_by = auth()->user()->name;
            $updated_by = auth()->user()->name;
            $description = $request->description;
            $amount = $request->amount;
            $year_dues = $request->year_dues;
            $created_by2 = auth()->user()->name;

            DB::select('CALL insert_annual_dues(?,?,?,?,?,?)',[$created_by,$updated_by,$description,$amount,$year_dues,$created_by2]);

            return Response()->json([
                "success" => true,
                "url"=>url('/listing-annual-dues')

          ]);
        }
    }

    public function annualDuesUpdate(Request $request)
    {

        $annualDuesList = AnnualDues::select('tbl_annual_dues.*')
        ->where('tbl_annual_dues.is_active',true)
        ->where('tbl_annual_dues.id',$request->id)
        ->first();

        $annualDuesList->updated_by =  auth()->user()->name;
        $annualDuesList->description = $request->description;
        $annualDuesList->amount = $request->amount;
        $annualDuesList->year_dues = $request->year_dues;

        $annualDuesList->save();

        return "updated";
    }



    public function annualDuesList()
    {
        $annualDuesList = AnnualDues::select('tbl_annual_dues.*')
                                            ->where('tbl_annual_dues.is_active',true)
                                            ->orderBy('tbl_annual_dues.id','ASC')
                                            ->get();


        return view('annual-dues.listing-annual-dues',compact('annualDuesList'));

    }

    public function annualDuesDelete(Request $request)
    {

        $annualDuesList = AnnualDues::select('tbl_annual_dues.*')
        ->where('tbl_annual_dues.is_active',true)
        ->where('tbl_annual_dues.id',$request->id)
        ->first();

        $annualDuesList->updated_by =  auth()->user()->name;
        $annualDuesList->is_active = false;

        $annualDuesList->save();


        return "success";
    }










}
