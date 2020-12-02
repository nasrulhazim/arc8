<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12 w-full">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
			
			{{-- Should be move to right hand side --}}
			<span class="relative z-0 inline-flex shadow-sm rounded-md mb-4 float-right w-full pb-4">
				<form method="POST" action="{{ route('notifications.mark-all-as-read') }}">
                    @csrf @method('PUT')
                    <a type="button" class="cursor-pointer relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" onclick="event.preventDefault();this.closest('form').submit();">
				    {{ __('Mark All as Read') }}
				  	</a>
				</form>
			  	<form method="POST" action="{{ route('notifications.mark-all-as-unread') }}">
                    @csrf @method('PUT')
					<a type="button" class="cursor-pointer -ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" onclick="event.preventDefault();this.closest('form').submit();">
					{{ __('Mark All as Unread') }}
					</a>
				</form>
			</span>
			
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-full">
	    		<div class="flex flex-col bg-white overflow-hidden sm:rounded-lg w-full">
					<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
						<div class="py-2 align-middle inline-block sm:px-6 lg:px-8 w-full">
							<div class="overflow-hidden sm:rounded-lg  w-full">
								<table class="table-fixed divide-y divide-gray-200 w-full">
									<thead>
										<tr style="text-align: left !important">
											<th class="w-1/4 px-6 py-3 border-b border-gray-300 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
											{{ __('Subject') }}
											</th>
											<th class="w-1/2 px-6 py-3 border-b border-gray-300 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
											{{ __('Message') }}
											</th>
											<th class="w-1/4 px-6 py-3 border-b border-gray-300 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
											{{ __('Link') }}
											</th>
											<th class="w-1/4 px-6 py-3 border-b border-gray-300 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
											{{ __('Actions') }}
											</th>
										</tr>
									</thead>
									<tbody>
							        	@forelse($notifications as $notification)
							        		<tr class="bg-white">
								              <td class="w-1/4 px-6 py-4 whitespace-no-wrap text-sm leading-5">
								                {{ $notification->data['subject'] ?? '' }}
								              </td>
								              <td class="w-1/2 px-6 py-4 whitespace-no-wrap text-sm leading-5">
								                {{ $notification->data['message'] ?? '' }}
								              </td>
								              <td class="w-1/4 px-6 py-4 whitespace-no-wrap text-sm leading-5">
								                @if(!empty($notification->data['url']))
								                	<a href="{{ $notification->data['url'] }}" class="text-indigo-500">{{ __('Link') }}</a>
								                @endif
								              </td>
								              <td class="w-1/4 px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 text-center">
								                @if(empty($notification->read_at))
									                <form method="POST" action="{{ route('notifications.mark-as-read', ['id' => $notification->id]) }}">
							                            @csrf @method('PUT')
							                            <a href="#" onclick="event.preventDefault();this.closest('form').submit();">
							                                {{ __('Mark as Read') }}
							                            </a>
							                        </form>
								                @else
								                	<form method="POST" action="{{ route('notifications.mark-as-unread', ['id' => $notification->id]) }}">
							                            @csrf @method('PUT')
							                            <a href="#" onclick="event.preventDefault();this.closest('form').submit();">
							                                {{ __('Mark as Unread') }}
							                            </a>
							                        </form>
								                @endif
								              </td>
								            </tr>
							        	@empty
							        		<tr>
							        			<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-indigo-500 text-center" colspan="4">
							        				{{ __('You have no notifications at the moment') }}
							        			</td>
							        		</tr>
							        	@endforelse
			    					</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
</x-app-layout>