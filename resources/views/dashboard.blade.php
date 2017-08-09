@extends('layouts.master')
@section('style')
<!-- JQVMap -->
<link href="{{ asset('apitoolz-assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet"/>
<!-- bootstrap-daterangepicker -->
<link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1 class="uppercase">Dashboard
                <small>Statistics</small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
        <div class="row">
	      <div class="col-md-12">
	        <div class="portlet light portlet-form bordered">
	          <div class="portlet-title">
		        <div class="caption">
                    <span class="caption-subject font-red bold">Visitors <small>Weekly progress</small></span>
                </div>
	            <div class="actions">
	              <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
	                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
	                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
	              </div>
	            </div>
	          </div>
	          <div class="portlet-body row">
                <div class="col-md-12">
                    @if (session('message'))
                        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ session('message') }}
                        </div>
                    @endif
                    @if(env('ANALYTICS_VIEW_ID') == '130414418')
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        NOTE: You need to change Google Analytics View ID with your. <a href="{{url('core/settings/general')}}" class="bold">Click here</a>
                    </div>
                    @endif
                </div>
	            <div class="col-md-8 col-sm-12 col-xs-12">
		            <div class="row margin-bottom-40">
		                <div class="col-md-4">
		                    <div class="easy-pie-chart">
		                        <div class="number transactions" data-percent="100">
		                            <span>100</span>% </div>
		                        	<b> Total Users: <span class="bold font-yellow-gold">{{$users[0][0]}}</span></b>
		                    </div>
		                </div>
		                <div class="margin-bottom-10 visible-sm"> </div>
		                <div class="col-md-4">
		                    <div class="easy-pie-chart">
		                        <div class="number visits" data-percent="{{round((@$userTypes[0][1]/(@$userTypes[0][1]+@$userTypes[0][1])) * 100)}}">
		                            <span>{{round((@$userTypes[0][1]/(@$userTypes[0][1]+@$userTypes[0][1])) * 100)}}</span>% </div>
		                        	<b> New Users: <span class="bold font-green">{{@$userTypes[0][1]}}</span></b>
		                    </div>
		                </div>
		                <div class="margin-bottom-10 visible-sm"> </div>
		                <div class="col-md-4">
		                    <div class="easy-pie-chart">
		                        <div class="number bounce" data-percent="{{round((@$userTypes[1][1]/(@$userTypes[0][1]+@$userTypes[1][1])) * 100)}}">
		                            <span>{{round((@$userTypes[1][1]/($userTypes[0][1]+@$userTypes[1][1])) * 100)}}%</span></div>
		                        	<b> Returning Users: <span class="bold font-red">{{@$userTypes[1][1]}}</span></b>
		                    </div>
		                </div>
		            </div>
					<div id="site_statistics_content">
                        <div id="site_statistics" class="chart"> </div>
                    </div>
	            </div>

	            <div class="col-md-4 col-sm-12 col-xs-12">
	                <div class="scroller" style="height: 400px; width: 100%;">
		                <table class="table table-hover table-light">
		    				<thead>
				                <tr>
				                  <th colspan="2">Devices Usage</th>
				                </tr>
			                </thead>
			                <tbody>
			                @foreach($mobileLists as $key => $value)
			                	<tr>
			                		<td>
			                          {{$key}}
			                        </td>
			                        <td align="right">{{round(($value/$mobileTotalSession) * 100)}}%</td>
			                	</tr>
			                @endforeach
			                </tbody>
			            </table>
	                </div>
	            </div>

	          </div>
	        </div>
	      </div>
    	</div>
    	<div class="row">
	        <div class="col-md-5 col-sm-12 col-xs-12">
	          	<div class="portlet light portlet-form bordered tile overflow_hidden">
		            <div class="portlet-title">
		            	<div class="caption">
		                    <span class="caption-subject font-red bold">Device OS Usage</span>
		                </div>
		            </div>
		            <div class="portlet-body">
		            	<div class="row">
		            		<div class="col-md-4">
		            			<canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
		            		</div>
		            		<div class="col-md-8">
		            			<div class="scroller" style="height: 400px; width: 100%;">
			            			<table class="table table-hover table-light">
			            				<thead>
							                <tr>
							                  <th>Device</th>
							                  <th class="text-right">Progress</th>
							                </tr>
						                </thead>
						                <tbody>
						                @foreach($deviceLists as $key => $row)
						                	<tr>
						                		<td>
						                          <i class="fa fa-square" style="color: {{$row['color']}};"></i> {{$key}}
						                        </td>
						                        <td align="right">{{round(($row['value']/$deviceTotalSession) * 100)}}%</td>
						                	</tr>
						                @endforeach
						                </tbody>
						            </table>
		            			</div>
		            		</div>
		            	</div>
		            </div>
	              
	            </div>
	        </div>
	        <div class="col-md-7 col-sm-12 col-xs-12">
	          <div class="row">
	            <div class="col-md-12 col-sm-12 col-xs-12">
	              <div class="portlet light portlet-form bordered">
	                <div class="portlet-title">
	                	<div class="caption">
		                    <span class="caption-subject font-red bold">Visitors location <small>geo-presentation</small></span>
		                </div>
	                </div>
	                <div class="portlet-body">
	                  <div class="row">
	                    <div class="col-md-4">
	                    	<div class="scroller" style="height: 400px; width: 100%;">
			                    <table class="table table-hover table-light">
		            				<thead>
						                <tr>
						                  <th colspan="2">{{$countryTotalSession}} views from {{count($countryLists)}} countries
						                  </th>
						                </tr>
					                </thead>
					                <tbody>
					               	@foreach($countryLists as $key => $value)
					                	<tr>
					                		<td>
					                          {{$key}}
					                        </td>
					                        <td align="right">{{round(($value/$countryTotalSession) * 100)}}%</td>
					                	</tr>
					                @endforeach
					                </tbody>
					            </table>
	                    	</div>
	                    </div>
	                    <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height: 400px;"></div>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	    </div>
    </div>
</div>
@endsection
@section('plugin')
<!-- Chart.js -->
<script src="{{ asset('apitoolz-assets/global/plugins/Chart.js/dist/Chart.min.js') }}"></script>
<!-- Flot -->
<script src="{{ asset('apitoolz-assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
<!-- DateJS -->
<script src="{{ asset('apitoolz-assets/global/plugins/datejs/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('apitoolz-assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js') }}"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('apitoolz-assets/global/plugins/moment.min.js') }}"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
@endsection
@section('script')
<script type="text/javascript">
<!-- Flot -->
$(document).ready(function() {

	var initCharts = function() {
        function e(e, t, a, i) {
            $('<div id="tooltip" class="chart-tooltip">'+i+"</div>").css( {
                position: "absolute", display: "none", top: t-40, left: e-40, border: "0px solid #ccc", padding: "2px 6px", "background-color": "#fff"
            }
            ).appendTo("body").fadeIn(200)
        }
        if(jQuery.plot) {
            var total_visiter = [];
            var total_pageViews = [];
            @foreach($analytics as $key => $row)
                item = {};
                item[0] = '{{date("d-m-y",strtotime($row["date"]))}}';
                item[1] = {{$row['visitors']}};
                item[2] = 'visitors';
                total_visiter.push(item);

                item = {};
                item[0] = '{{date("d-m-y",strtotime($row["date"]))}}';
                item[1] = {{$row['pageViews']}};
                item[2] = 'pageView';
                total_pageViews.push(item);
            @endforeach
            if(0!=$("#site_statistics").size()) {
                $("#site_statistics_loading").hide(),
                $("#site_statistics_content").show();
                var a=($.plot($("#site_statistics"), [ {
                    data:total_visiter, lines: {
                        fill: .6, lineWidth: 1
                    }
                    , color:["#f89f9f"]
                }
                , {
                    data:total_visiter, points: {
                        show: !0, fill: !0, radius: 5, fillColor: "#f89f9f", lineWidth: 3
                    }
                    , color:"#fff", shadowSize:0, title:'Visitors'
                }
                ], {
                    xaxis: {
                        tickLength:0, tickDecimals:0, mode:"categories", min:0, font: {
                            lineHeight: 14, style: "normal", variant: "small-caps", color: "#6F7B8A"
                        }
                    }
                    , yaxis: {
                        ticks:5, tickDecimals:0, tickColor:"#eee", font: {
                            lineHeight: 14, style: "normal", variant: "small-caps", color: "#6F7B8A"
                        }
                    }
                    , grid: {
                        hoverable: !0, clickable: !0, tickColor: "#eee", borderColor: "#eee", borderWidth: 1
                    }
                }
                ), null);
                $("#site_statistics").bind("plothover", function(t, i, l) {
                    if($("#x").text(i.x.toFixed(2)), $("#y").text(i.y.toFixed(2)), l) {
                        if(a!=l.dataIndex) {
                            a=l.dataIndex, $("#tooltip").remove();
                            l.datapoint[0].toFixed(2), l.datapoint[1].toFixed(2);
                            if(l.datapoint[2] == 'visitors')
                                e(l.pageX, l.pageY, l.datapoint[0], l.datapoint[1]+" visits")
                            else
                                e(l.pageX, l.pageY, l.datapoint[0], l.datapoint[1]+" "+l.series.title)
                        }
                    }
                    else $("#tooltip").remove(), a=null
                }
                )
            }
           
        }
    }
    initCharts();

    var initEasyPieCharts = function() {
        jQuery().easyPieChart&&($(".easy-pie-chart .number.transactions").easyPieChart( {
            animate: 1e3, size: 75, lineWidth: 3, barColor: "#dd7c03"
        }
        ), $(".easy-pie-chart .number.visits").easyPieChart( {
            animate: 1e3, size: 75, lineWidth: 3, barColor: "#26c281"
        }
        ), $(".easy-pie-chart .number.bounce").easyPieChart( {
            animate: 1e3, size: 75, lineWidth: 3, barColor: "#e43a45"
        }
        ), $(".easy-pie-chart-reload").click(function() {
            $(".easy-pie-chart .number").each(function() {
                var e=Math.floor(100*Math.random());
                $(this).data("easyPieChart").update(e), $("span", this).text(e)
            }
            )
        }
        ))
    }

    initEasyPieCharts();

    var initJQVMAP =function() {
        if(jQuery().vectorMap) {
            t=function(e) {
                var t=jQuery("#world-map-gdp");
                if(1===t.size()) {
                    var country = [
                                    {"name":"Afghanistan","code":"AF"},
                                    {"name":"Aland Islands","code":"AX"},
                                    {"name":"Albania","code":"AL"},
                                    {"name":"Algeria","code":"DZ"},
                                    {"name":"American Samoa","code":"AS"},
                                    {"name":"Andorra","code":"AD"},
                                    {"name":"Angola","code":"AO"},
                                    {"name":"Anguilla","code":"AI"},
                                    {"name":"Antarctica","code":"AQ"},
                                    {"name":"Antigua and Barbuda","code":"AG"},
                                    {"name":"Argentina","code":"AR"},
                                    {"name":"Armenia","code":"AM"},
                                    {"name":"Aruba","code":"AW"},
                                    {"name":"Australia","code":"AU"},
                                    {"name":"Austria","code":"AT"},
                                    {"name":"Azerbaijan","code":"AZ"},
                                    {"name":"Bahamas","code":"BS"},
                                    {"name":"Bahrain","code":"BH"},
                                    {"name":"Bangladesh","code":"BD"},
                                    {"name":"Barbados","code":"BB"},
                                    {"name":"Belarus","code":"BY"},
                                    {"name":"Belgium","code":"BE"},
                                    {"name":"Belize","code":"BZ"},
                                    {"name":"Benin","code":"BJ"},
                                    {"name":"Bermuda","code":"BM"},
                                    {"name":"Bhutan","code":"BT"},
                                    {"name":"Bolivia","code":"BO"},
                                    {"name":"Bosnia and Herzegovina","code":"BA"},
                                    {"name":"Botswana","code":"BW"},
                                    {"name":"Bouvet Island","code":"BV"},
                                    {"name":"Brazil","code":"BR"},
                                    {"name":"British Virgin Islands","code":"VG"},
                                    {"name":"British Indian Ocean Territory","code":"IO"},
                                    {"name":"Brunei Darussalam","code":"BN"},
                                    {"name":"Bulgaria","code":"BG"},
                                    {"name":"Burkina Faso","code":"BF"},
                                    {"name":"Burundi","code":"BI"},
                                    {"name":"Cambodia","code":"KH"},
                                    {"name":"Cameroon","code":"CM"},
                                    {"name":"Canada","code":"CA"},
                                    {"name":"Cape Verde","code":"CV"},
                                    {"name":"Cayman Islands","code":"KY"},
                                    {"name":"Central African Republic","code":"CF"},
                                    {"name":"Chad","code":"TD"},
                                    {"name":"Chile","code":"CL"},
                                    {"name":"China","code":"CN"},
                                    {"name":"Hong Kong, Special Administrative Region of China","code":"HK"},
                                    {"name":"Macao, Special Administrative Region of China","code":"MO"},
                                    {"name":"Christmas Island","code":"CX"},
                                    {"name":"Cocos (Keeling) Islands","code":"CC"},
                                    {"name":"Colombia","code":"CO"},
                                    {"name":"Comoros","code":"KM"},
                                    {"name":"Congo (Brazzaville)","code":"CG"},
                                    {"name":"Congo, Democratic Republic of the","code":"CD"},
                                    {"name":"Cook Islands","code":"CK"},
                                    {"name":"Costa Rica","code":"CR"},
                                    {"name":"Côte d'Ivoire","code":"CI"},
                                    {"name":"Croatia","code":"HI"},
                                    {"name":"Cuba","code":"CU"},
                                    {"name":"Cyprus","code":"CY"},
                                    {"name":"Czech Republic","code":"CZ"},
                                    {"name":"Denmark","code":"DK"},
                                    {"name":"Djibouti","code":"DJ"},
                                    {"name":"Dominica","code":"DM"},
                                    {"name":"Dominican Republic","code":"DO"},
                                    {"name":"Ecuador","code":"EC"},
                                    {"name":"Egypt","code":"EG"},
                                    {"name":"El Salvador","code":"SV"},
                                    {"name":"Equatorial Guinea","code":"GQ"},
                                    {"name":"Eritrea","code":"ER"},
                                    {"name":"Estonia","code":"EE"},
                                    {"name":"Ethiopia","code":"ET"},
                                    {"name":"Falkland Islands (Malvinas)","code":"FK"},
                                    {"name":"Faroe Islands","code":"FO"},
                                    {"name":"Fiji","code":"FJ"},
                                    {"name":"Finland","code":"FI"},
                                    {"name":"France","code":"FR"},
                                    {"name":"French Guiana","code":"GF"},
                                    {"name":"French Polynesia","code":"PF"},
                                    {"name":"French Southern Territories","code":"TF"},
                                    {"name":"Gabon","code":"GA"},
                                    {"name":"Gambia","code":"GM"},
                                    {"name":"Georgia","code":"GE"},
                                    {"name":"Germany","code":"DE"},
                                    {"name":"Ghana","code":"GH"},
                                    {"name":"Gibraltar","code":"GI"},
                                    {"name":"Greece","code":"GR"},
                                    {"name":"Greenland","code":"GL"},
                                    {"name":"Grenada","code":"GD"},
                                    {"name":"Guadeloupe","code":"GP"},
                                    {"name":"Guam","code":"GU"},
                                    {"name":"Guatemala","code":"GT"},
                                    {"name":"Guernsey","code":"GG"},
                                    {"name":"Guinea","code":"GN"},
                                    {"name":"Guinea-Bissau","code":"BW"},
                                    {"name":"Guyana","code":"GY"},
                                    {"name":"Haiti","code":"HT"},
                                    {"name":"Heard Island and Mcdonald Islands","code":"HM"},
                                    {"name":"Holy See (Vatican City State)","code":"VA"},
                                    {"name":"Honduras","code":"HN"},
                                    {"name":"Hungary","code":"HU"},
                                    {"name":"Iceland","code":"IS"},
                                    {"name":"India","code":"IN"},
                                    {"name":"Indonesia","code":"ID"},
                                    {"name":"Iran","code":"IR"},
                                    {"name":"Iraq","code":"IQ"},
                                    {"name":"Ireland","code":"IE"},
                                    {"name":"Isle of Man","code":"IM"},
                                    {"name":"Israel","code":"IL"},
                                    {"name":"Italy","code":"IT"},
                                    {"name":"Jamaica","code":"JM"},
                                    {"name":"Japan","code":"JP"},
                                    {"name":"Jersey","code":"JE"},
                                    {"name":"Jordan","code":"JO"},
                                    {"name":"Kazakhstan","code":"KZ"},
                                    {"name":"Kenya","code":"KE"},
                                    {"name":"Kiribati","code":"KI"},
                                    {"name":"Korea","code":"KP"},
                                    {"name":"Korea, Republic of","code":"KR"},
                                    {"name":"Kuwait","code":"KW"},
                                    {"name":"Kyrgyzstan","code":"KG"},
                                    {"name":"Lao PDR","code":"LA"},
                                    {"name":"Latvia","code":"LV"},
                                    {"name":"Lebanon","code":"LB"},
                                    {"name":"Lesotho","code":"LS"},
                                    {"name":"Liberia","code":"LR"},
                                    {"name":"Libya","code":"LY"},
                                    {"name":"Liechtenstein","code":"LI"},
                                    {"name":"Lithuania","code":"LT"},
                                    {"name":"Luxembourg","code":"LU"},
                                    {"name":"Macedonia, Republic of","code":"MK"},
                                    {"name":"Madagascar","code":"MG"},
                                    {"name":"Malawi","code":"MW"},
                                    {"name":"Malaysia","code":"MY"},
                                    {"name":"Maldives","code":"MV"},
                                    {"name":"Mali","code":"ML"},
                                    {"name":"Malta","code":"MT"},
                                    {"name":"Marshall Islands","code":"MH"},
                                    {"name":"Martinique","code":"MQ"},
                                    {"name":"Mauritania","code":"MR"},
                                    {"name":"Mauritius","code":"MU"},
                                    {"name":"Mayotte","code":"YT"},
                                    {"name":"Mexico","code":"MX"},
                                    {"name":"Micronesia, Federated States of","code":"FM"},
                                    {"name":"Moldova","code":"MD"},
                                    {"name":"Monaco","code":"MC"},
                                    {"name":"Mongolia","code":"MN"},
                                    {"name":"Montenegro","code":"ME"},
                                    {"name":"Montserrat","code":"MS"},
                                    {"name":"Morocco","code":"MA"},
                                    {"name":"Mozambique","code":"MZ"},
                                    {"name":"Myanmar (Burma)","code":"MM"},
                                    {"name":"Namibia","code":"NA"},
                                    {"name":"Nauru","code":"NR"},
                                    {"name":"Nepal","code":"NP"},
                                    {"name":"Netherlands","code":"NL"},
                                    {"name":"Netherlands Antilles","code":"AN"},
                                    {"name":"New Caledonia","code":"NC"},
                                    {"name":"New Zealand","code":"NZ"},
                                    {"name":"Nicaragua","code":"NI"},
                                    {"name":"Niger","code":"NE"},
                                    {"name":"Nigeria","code":"NG"},
                                    {"name":"Niue","code":"NU"},
                                    {"name":"Norfolk Island","code":"NF"},
                                    {"name":"Northern Mariana Islands","code":"MP"},
                                    {"name":"Norway","code":"NO"},
                                    {"name":"Oman","code":"OM"},
                                    {"name":"Pakistan","code":"PK"},
                                    {"name":"Palau","code":"PW"},
                                    {"name":"Palestinian Territory, Occupied","code":"PS"},
                                    {"name":"Panama","code":"PA"},
                                    {"name":"Papua New Guinea","code":"PG"},
                                    {"name":"Paraguay","code":"PY"},
                                    {"name":"Peru","code":"PE"},
                                    {"name":"Philippines","code":"PH"},
                                    {"name":"Pitcairn","code":"PN"},
                                    {"name":"Poland","code":"PL"},
                                    {"name":"Portugal","code":"PT"},
                                    {"name":"Puerto Rico","code":"PR"},
                                    {"name":"Qatar","code":"QA"},
                                    {"name":"Réunion","code":"RE"},
                                    {"name":"Romania","code":"RO"},
                                    {"name":"Russian Federation","code":"RU"},
                                    {"name":"Rwanda","code":"RW"},
                                    {"name":"Saint-Barthélemy","code":"BL"},
                                    {"name":"Saint Helena","code":"SH"},
                                    {"name":"Saint Kitts and Nevis","code":"KN"},
                                    {"name":"Saint Lucia","code":"LC"},
                                    {"name":"Saint-Martin (French part)","code":"MF"},
                                    {"name":"Saint Pierre and Miquelon","code":"PM"},
                                    {"name":"Saint Vincent and Grenadines","code":"VC"},
                                    {"name":"Samoa","code":"WS"},
                                    {"name":"San Marino","code":"SM"},
                                    {"name":"Sao Tome and Principe","code":"ST"},
                                    {"name":"Saudi Arabia","code":"SA"},
                                    {"name":"Senegal","code":"SN"},
                                    {"name":"Serbia","code":"RS"},
                                    {"name":"Seychelles","code":"SC"},
                                    {"name":"Sierra Leone","code":"SL"},
                                    {"name":"Singapore","code":"SG"},
                                    {"name":"Slovakia","code":"SK"},
                                    {"name":"Slovenia","code":"SI"},
                                    {"name":"Solomon Islands","code":"SB"},
                                    {"name":"Somalia","code":"SO"},
                                    {"name":"South Africa","code":"ZA"},
                                    {"name":"South Georgia","code":"GS"},
                                    {"name":"South Sudan","code":"SS"},
                                    {"name":"Spain","code":"ES"},
                                    {"name":"Sri Lanka","code":"LK"},
                                    {"name":"Sudan","code":"SD"},
                                    {"name":"Suriname *","code":"SR"},
                                    {"name":"Svalbard","code":"SJ"},
                                    {"name":"Swaziland","code":"SZ"},
                                    {"name":"Sweden","code":"SE"},
                                    {"name":"Switzerland","code":"CH"},
                                    {"name":"Syrian Arab","code":"SY"},
                                    {"name":"Taiwan","code":"TW"},
                                    {"name":"Tajikistan","code":"TJ"},
                                    {"name":"Tanzania","code":"TZ"},
                                    {"name":"Thailand","code":"TH"},
                                    {"name":"Timor-Leste","code":"TL"},
                                    {"name":"Togo","code":"TG"},
                                    {"name":"Tokelau","code":"TK"},
                                    {"name":"Tonga","code":"TO"},
                                    {"name":"Trinidad and Tobago","code":"TT"},
                                    {"name":"Tunisia","code":"TN"},
                                    {"name":"Turkey","code":"TR"},
                                    {"name":"Turkmenistan","code":"TM"},
                                    {"name":"Turks","code":"TC"},
                                    {"name":"Tuvalu","code":"TV"},
                                    {"name":"Uganda","code":"UG"},
                                    {"name":"Ukraine","code":"UA"},
                                    {"name":"United Arab Emirates","code":"AE"},
                                    {"name":"United Kingdom","code":"GB"},
                                    {"name":"United States","code":"US"},
                                    {"name":"United States Minor Outlying Islands","code":"UM"},
                                    {"name":"Uruguay","code":"UY"},
                                    {"name":"Uzbekistan","code":"UZ"},
                                    {"name":"Vanuatu","code":"VU"},
                                    {"name":"Venezuela","code":"VE"},
                                    {"name":"Viet Nam","code":"VN"},
                                    {"name":"Virgin","code":"VI"},
                                    {"name":"Wallis and Futuna Islands","code":"WF"},
                                    {"name":"Western Sahara","code":"EH"},
                                    {"name":"Yemen","code":"YE"},
                                    {"name":"Zambia","code":"ZM"},
                                    {"name":"Zimbabwe","code":"ZW"}
                                    ];
                    var selected = [];
                    @foreach($countryLists as $key => $value)
                        for (var i = 0; i < country.length; i++) {
                            if(country[i].name == '{{$key}}'){
                                selected.push(country[i].code);
                            }
                        }
                        
                    @endforeach
                    var a= {
                        map:"world_en",
                        backgroundColor:null,
                        borderColor:"#333333",
                        borderOpacity:.5,
                        borderWidth:1,
                        color:"#c6c6c6",
                        enableZoom:!0,
                        hoverColor:"#069059",
                        hoverOpacity:null,
                        values:sample_data,
                        normalizeFunction:"linear",
                        scaleColors:["#b6da93","#909cae"],
                        selectedColor:"#e7505a",
                        selectedRegions:selected,
                        multiSelectRegion:!1,
                        showTooltip:!0,
                        onLabelShow:function(e, t, a) {
                            @foreach($countryLists as $key => $value)
                            var state = '{{$key}}';
                            if (state.indexOf(t[0].innerHTML) >= 0 || t[0].innerHTML.indexOf(state) >= 0) {
                                t[0].innerHTML = t[0].innerHTML + " - {{$value}}";
                            }
                            @endforeach
                        },
                        onRegionOver:function(e, t) {
                            "ca"==t&&e.preventDefault()
                        },
                        onRegionClick:function(e, t, a) {
                           return false;
                        }
                    }
                    ;
                    a.map=e+"_en",
                    t.vectorMap(a)
                }
            }
            ;
            t("world")
            
        }
    }

    initJQVMAP();
   
  });
</script>
<!-- /Flot -->

<!-- Doughnut Chart -->
<script>
  $(document).ready(function(){
    var options = {
      legend: false,
      responsive: false
    };

    var lb = [];
    var dt = [];
    var cr = [];
    @foreach($deviceLists as $key => $row)
    lb.push('{{$key}}');
    dt.push('{{$row['value']}}');
    cr.push('{{$row['color']}}');
    @endforeach

    new Chart(document.getElementById("canvas1"), {
      type: 'doughnut',
      tooltipFillColor: "rgba(51, 51, 51, 0.55)",
      data: {
        labels: lb,
        datasets: [{
          data: dt,
          backgroundColor: cr,
          hoverBackgroundColor: cr
        }]
      },
      options: options
    });
 });

</script>
<!-- /Doughnut Chart -->

<!-- bootstrap-daterangepicker -->
<script type="text/javascript">
  $(document).ready(function() {

    var cb = function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    };
    var optionSet1 = {
      startDate: moment().subtract(8, 'days'),
      endDate: moment(),
      minDate: moment().subtract(1, 'years'),
      maxDate: moment(),
      dateLimit: {
        days: 60
      },
      showDropdowns: true,
      showWeekNumbers: true,
      timePicker: false,
      timePickerIncrement: 1,
      timePicker12Hour: true,
      ranges: {
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      opens: 'left',
      buttonClasses: ['btn btn-default'],
      applyClass: 'btn-small btn-primary',
      cancelClass: 'btn-small',
      format: 'MM/DD/YYYY',
      separator: ' to ',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Clear',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
      }
    };
    $('#reportrange span').html(moment().subtract(8, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker(optionSet1, cb);
    $('#reportrange').on('show.daterangepicker', function() {
      console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function() {
      console.log("hide event fired");
    });
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
     	var days = (picker.endDate - picker.startDate) / (1000 * 60 * 60 * 24);
     	if(days <= 2){
     		alert('Please choose more than 1 days');
     		return false;
     	}
     	window.location.href="{{url('dashboard')}}"+"?startDate="+picker.startDate.format('MMMM D, YYYY')+"&endDate="+picker.endDate.format('MMMM D, YYYY');
    });
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
      console.log("cancel event fired");
    });
    $('#options1').click(function() {
      $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function() {
      $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function() {
      $('#reportrange').data('daterangepicker').remove();
    });
  });
</script>
@endsection