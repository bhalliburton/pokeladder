@extends('theme::layouts.app')


@section('content')


	<div class="flex flex-col px-8 mx-auto my-6 lg:flex-row max-w-7xl xl:px-5">
		<h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">No Winner</h1>
		<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
		<p>
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
				<tr>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Match ID</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User_I</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opponent</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accepted</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported Winner</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Winner File</th>
				</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
			@foreach ($matches as $data)
				<tr>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->match_id }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->created_at }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->user_id }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->opponent }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->accepted }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->reported_winner }}</td>
					<td class="px-6 py-4 whitespace-nowrap">{{ $data->winner_file }}</td>
				</tr>
			@endforeach
			</tbody>
			</table>

		</p>
	</div>
	</div>
@endsection