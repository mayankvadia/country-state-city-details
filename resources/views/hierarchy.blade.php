@extends('layouts.app')
@section('content')
<ul class="tree">
	@if(!empty($data))
		@foreach($data as $country=>$statesData)
		<li>
			<a href="javascript:void(0)">{{$country}}</a>
			@if(!empty($statesData))
				<ul>
					@foreach($statesData as $stateName=>$citiesData)
						<li>
							{{$stateName}}
							@if(!empty($citiesData))
							<ul>
								@foreach($citiesData as $cityName=>$populationData)
									<li>
										{{$cityName}}
										@if(!empty($populationData))
											<ul>
												@foreach($populationData as $details)
												<li>
													@if(!empty($details) && (is_array($details) || is_object($details)))
														@foreach($details as $dataKey=>$data)
															@if(!empty($data))
															<p>
																{{$dataKey+1}}<br>
																{!!isset($data['year']) ? 'Year: '.$data['year'].'<br>' : ''!!}	
																{!!isset($data['value']) ? 'Population: '.$data['value'].'<br>' : ''!!}	
																{!!isset($data['sex']) ? 'Sex: '.$data['sex'].'<br>' : ''!!}	
																{!!isset($data['reliabilty']) ? 'Reliabilty: '.$data['reliabilty'].'<br>' : ''!!}	
															</p>
															@endif
														@endforeach
													@else
														<p>{{$details}}</p>	
													@endif
												</li>
												@endforeach
											</ul>
										@endif
									</li>
								@endforeach
							</ul>
							@endif
						</li>
					@endforeach
				</ul>
			@endif
		</li>
		@endforeach
	@endif
</ul>
@endsection