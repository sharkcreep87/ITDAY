<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function index( Request $request )
	{
		$startDate = $request->input('startDate') ? $request->input('startDate') : '';
		$endDate = $request->input('endDate') ? $request->input('endDate') : '';
		if($startDate != '' && $endDate != ''){
			$startDate = new \DateTime(date('Y-m-d h:i:s',strtotime($startDate)));
			$endDate = new \DateTime(date('Y-m-d h:i:s',strtotime($endDate)));
			$period = Period::create($startDate, $endDate);
		}else{
			$period = Period::days(7);
		}

		$analytics = \Analytics::fetchTotalVisitorsAndPageViews($period);
		$users = \Analytics::performQuery($period,'ga:users',[]);
		$userTypes = \Analytics::performQuery($period,'ga:sessions',['dimensions'=>'ga:userType']);
		$country = \Analytics::performQuery($period,'ga:sessions',['dimensions'=>'ga:country']);
		$deviceOS = \Analytics::performQuery($period,'ga:sessions',['dimensions'=>'ga:operatingSystem,ga:operatingSystemVersion']);
		$mobile = \Analytics::performQuery($period,'ga:sessions',['dimensions'=>'ga:mobileDeviceInfo','sort'=>'ga:sessions']);
		$deviceLists = [];
		$deviceTotalSession = 0;
		foreach ($deviceOS->rows as $key => $value) {
			if(isset($deviceLists[$value[0].' '.$value[1]])){
				$deviceLists[$value[0].' '.$value[1]] += $value[2];
			}else{
				$deviceLists[$value[0].' '.$value[1]]['value'] = $value[2];
				$deviceLists[$value[0].' '.$value[1]]['color'] = $this->rand_color();
			}
			$deviceTotalSession += $value[2];
		}
		arsort($deviceLists);

		$mobileLists = [];
		$mobileTotalSession = 0;
		foreach ($mobile->rows as $key => $value) {
			if(isset($mobileLists[$value[0]])){
				$mobileLists[$value[0]] += $value[1];
			}else{
				$mobileLists[$value[0]] = $value[1];
			}
			$mobileTotalSession += $value[1];
		}
		arsort($mobileLists);

		$countryLists = [];
		$countryTotalSession = 0;
		foreach ($country->rows as $key => $value) {
			$countryTotalSession += $value[1];
			$countryLists[$value[0]] = $value[1];
		}
		arsort($countryLists);
		$data['analytics'] = $analytics;
		$data['userTypes'] = $userTypes->rows;
		$data['countryLists'] = $countryLists;
		$data['users'] = $users->rows;
		$data['deviceLists'] = $deviceLists;
		$data['mobileLists'] = $mobileLists;
		$data['deviceTotalSession'] = $deviceTotalSession;
		$data['countryTotalSession'] = $countryTotalSession;
		$data['mobileTotalSession'] = $mobileTotalSession;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		return view('dashboard',$data);
	}

	function rand_color() {
	    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}
}
