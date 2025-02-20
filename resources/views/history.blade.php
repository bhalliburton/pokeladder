@extends('theme::layouts.app')


@section('content')


	<div class="flex flex-col px-8 mx-auto my-6 lg:flex-row max-w-7xl xl:px-5">
		<h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">History</h1>
		<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
		<p>
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
				<tr>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opponent</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outcome</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">

			@foreach($athing as $data)
				<tr>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data[0] }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data[1] }} ({{ round($data[2],0) }}&plusmn;{{ round($data[3],0) }})</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data[4] }} ({{ round($data[5],0) }}&plusmn;{{ round($data[6],0) }})</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data[7] }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data[8] }}</td>
				</tr>
			@endforeach
			</tbody>
			</table>
		</p>
		</div>
	</div>
@endsection
