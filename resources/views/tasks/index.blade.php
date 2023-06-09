@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
					
                    <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
							
							<br /><br />
                        <!-- Add Task Dropdownlist for Project -->	
						    @if(session('success'))
							  <h1>{{session('success')}}</h1>
						    @endif						
                            <label for="task-project" class="col-sm-3 control-label">Project</label>

                            <div class="col-sm-6">
								<select class="form-control" id="selectproject" name="project_selected" required focus>
									<option value="" disabled selected>Please select project</option>        
										@foreach($projects as $project)
										<option value="{{$project->id}}">{{ $project->name }}</option>
										@endforeach
							    </select>
							<label class="task-name"  id="displayproject">Show selected project here</label>								
                            </div>							
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
				@if (count($projects) > 0)
			        <h1>Many projects found.</h1>
				@endif	
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>			
                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody  class="list-group  connectedSortable" id="complete-item-drop">
								@if(!empty($completeItem) && $completeItem->count())
									@foreach ($completeItem as $key => $task)
										<tr item-id="{{ $task->id }}">
											<td class="table-text"><div>{{ $task->name }}</div></td>

											<!-- Task Delete Button -->
											<td>
												<form action="{{url('task/' . $task->id)}}" method="POST">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}

													<button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
														<i class="fa fa-btn fa-trash"></i>Delete
													</button>
												</form>
											</td>
										</tr>
									@endforeach
								@endif	
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>					
	<!-- custom scripts below-->
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	   // script for drag&drop below 
	  $( function() {
		$( "#complete-item-drop" ).sortable();
		
		$( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
			var accept = [];
			
			$("#complete-item-drop tr").each(function( index ) {
			  accept[index] = $(this).attr('item-id');
			});
			$.ajax({
				url: "{{ route('update.items') }}",
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {accept:accept},
				success: function(data) {
				  console.log('success');
				}
			});
			  
		});
	  });
	  
	  //script for dropdownlist below
	  var mytextbox = document.getElementById('displayproject');
	  var mydropdown = document.getElementById('selectproject');
	  mydropdown.onchange = function(){
		  //alert(this.value+'_'+mydropdown.innerText);
		  mytextbox.value = mytextbox.value  + this.value; //to appened
		  mytextbox.innerHTML = this.value;
		 }	  
	</script>	
	<!-- custom scripts above-->				
@endsection