<!DOCTYPE html>
<html>
<head>
	<title>
		Ajax-Todo List
		

	</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body>
<br>
<div class="container">
<div class="row">
 <div class="col-lg-offset-3 col-lg-6">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Ajax ToDO List <a href="#" id="AddNewItem" class="pull-right" data-toggle="modal" data-target="#myModal" > <i class="fa fa-plus" aria-hidden ="true"> </i> </a> </h3>
    </div>
    <div class="panel-body" id="item">
     <ul class="list-group">
      @foreach ($items as $item)
  <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{ $item->item }}
    <input type="hidden" id="itemId" value="{{ $item->id }}">
  </li>
   @endforeach
   </ul>
    </div>
  </div>
 </div>
 <div class="col-lg-2">
  <input type="text" name="itemSearch" id="searchItem" class="form-control" placeholder="Search">
</div>

</div>
</div>



 {{ csrf_field()}}
{{-- Modal Starts --}}
    
    <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="title">Add Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body">
            <input type="hidden" id="id">
             <p><input type="text" placeholder="Write item here" class="form-control" id="addItem"></p>
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display:none">Delete</button>
            <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none">Save changes</button>
            <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal" >Add Item</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  
<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script >
    $(document).ready(function() {
       $(document).on('click', '.ourItem', function(event){
          var text = $(this).text();
          var id = $(this).find('#itemId').val();
          $('#title').text('Edit Item');
          var text =$.trim(text);
          $('#addItem').val(text);
          $('#delete').show('400');
          $('#saveChanges').show('400');
          $('#addButton').hide('400');
          $('#id').val(id);
          console.log(text);
        });
    
      
 
      
        $(document).on('click', '#AddNewItem', function(event){
          var text = $(this).text();
          $('#title').text('Add New Item ');
          $('#addItem').val(text);
          $('#delete').hide('400');
          $('#saveChanges').hide('400');
          $('#addButton').show('400');
          
        });
        $('#addButton').click(function(event){
          var text = $('#addItem').val();
          $.post('list', {'text':text, '_token':$('input[name=_token]').val()}, function(data){
            console.log(data);
          $('#item').load(location.href + ' #item');

          });
        });
          $('#delete').click(function(event){
            var id = $('#id').val();
            $.post('delete', {'id':id, '_token':$('input[name=_token]').val()}, function(data){
            $('#item').load(location.href + ' #item');
            console.log(data);
              
            });
          });

          $('#saveChanges').click(function(event){
            var id= $('#id').val();
            var value = $('#addItem').val();
            $.post('update', {'id':id, 'value':value, '_token':$('input[name=_token]').val()}, function(data){
              
               $('#item').load(location.href + ' #item');
             
              console.log(data);

            });

          });
        $( function() {
          
          $( "#searchItem" ).autocomplete({
            source: 'http://localhost:8000/search'
          });
        });
           });
  
</script>

</body>
</html>