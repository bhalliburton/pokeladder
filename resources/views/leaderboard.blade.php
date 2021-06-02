@extends('theme::layouts.app')


@section('content')


	<div class="flex flex-col px-8 mx-auto my-6 lg:flex-row max-w-7xl xl:px-5">
		<h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">The Leaderboard!</h1>
		<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
		<p>
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
				<tr>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PTCGO Name</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Score</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
			@foreach($leaders as  $data)
				<tr>
					<td class="px-6 py-4 whitespace-nowrap">
						{{ $loop->iteration }}
					</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->ptcgo_name }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->rating }}</td>
				</tr>
			@endforeach
			</tbody>
			</table>
	</p>
	</div>


@endsection
